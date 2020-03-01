var currentPlaylist = [];
var shufflePlaylist = [];
var tempPlaylist = [];
var audioElement;
var mouseDown = false;
var currentIndex = 0;
var repeat = false;
var shuffle = false;
var userLoggedIn;
var timer;

$(document).click(function(click) {

    var target = $(click.target);

    if (!target.hasClass("item") && !target.hasClass("optionsButton")) {
        hideMenuOptionsMenu();
    }

});

$(window).scroll(function() {
    hideMenuOptionsMenu();
});

$(document).on("change", "select.playlist", function() {
    var select = $(this);
    var playlistId = select.val();
    var songId = select.prev(".songId").val();

    $.post("includes/handlers/ajax/addToPlaylist.php", {playlistId: playlistId, songId: songId})
    .done(function(error) {

        if (error != "") {
            alert(error);
            return;
        }

        hideMenuOptionsMenu();
        select.val("");
    });

});

function openPage(url) {

    if (timer != null) {
        clearInterval(timer);
    }

    if (url.indexOf("?") == -1) {
        url = url + "?";
    }
    var encodeUrl = encodeURI(url + "&userLoggedIn=" + userLoggedIn);
    
    $("#mainContent").load(encodeUrl);
    $("body").scrollTop(0);
    history.pushState(null, null, url);
}


function removeFromPlaylist(button, playlistId) {

    var songId = $(button).prevAll(".songId").val();

    $.post("includes/handlers/ajax/removeFromPlaylist.php", {playlistId: playlistId, songId: songId})
    .done(function(error) {
        console.log("Aqui");
        if (error != "") {
            alert(error);
            return;
        }

        //Do something when AJAX returns
        openPage("playlist.php?id="+playlistId);
    });


}

function createPlaylist() {
    console.log(userLoggedIn);
    
    var popup = prompt("Please enter the name of your playlist: ");

    if (popup != null) {
        
        $.post("includes/handlers/ajax/createPlaylist.php", {name: popup, username: userLoggedIn}).done(function(error) {
            
            if (error != "") {
                alert(error);
                return;
            }

            //Do something when AJAX returns
            openPage("yourMusic.php");
        });

    }

}

function deletePlaylistId(playlistId) {
    var prompt = confirm("Are you sure want to delete this playlist?");

    if (prompt == true) {
        $.post("includes/handlers/ajax/deletePlaylist.php", {playlistId: playlistId}).done(function(error) {
            
            if (error != "") {
                alert(error);
                return;
            }

            //Do something when AJAX returns
            openPage("yourMusic.php");
        });
    }
}

function hideMenuOptionsMenu() {
    var menu = $(".optionsMenu");
    if (menu.css.display != "none") {
        menu.css("display", "none");
    }
}

function showOptionsMenu(button) {

    var songId = $(button).prevAll(".songId").val();
    var menu = $(".optionsMenu");
    var menuWidth = menu.width();
    menu.find(".songId").val(songId);

    var scrollTop = $(window).scrollTop(); //Distance from top of window to top of document
    var elementOffset = $(button).offset().top; //Distance from top of document

    var top = elementOffset - scrollTop;
    var left = $(button).position().left;

    menu.css({"top": top + "px", "left": left - menuWidth + "px", "display": "inline"});

}

function formatTime(seconds) {
    var time = Math.round(seconds);
    var minutes = Math.floor(time / 60);
    var seconds = time - (minutes * 60);

    var extraZero = (seconds < 10) ? "0" : "";

    return minutes + ":" + extraZero + seconds;
}

function updateTimeProgressBar(audio) {
    $(".progressTime.current").text(formatTime(audio.currentTime));
    $(".progressTime.remaining").text(formatTime(audio.duration - audio.currentTime));

    var progress = audio.currentTime / audio.duration * 100;
    $(".playbackBar .progress").css('width', progress + "%");
}

function updateVolumeProgressBar(audio) {
    var volume = audio.volume * 100;
    $(".volumeBar .progress").css("width", volume + "%");
}

function playFirstSong() {
    setTrack(tempPlaylist[0], tempPlaylist, true);
}

function Audio() {

    this.currentPlaying;
    this.audio = document.createElement("audio");

    this.audio.addEventListener("canplay", function() {
        var duration = formatTime(this.duration);
        $(".progressTime.remaining").text(duration);
    });

    this.audio.addEventListener("ended", function() {
        nextSong();
    })

    this.audio.addEventListener("timeupdate", function() {
        if (this.duration) {
            updateTimeProgressBar(this);
        }
    });

    this.audio.addEventListener("volumechange", function() {
        updateVolumeProgressBar(this);
    });

    this.setTrack = function(track) {
        this.currentPlaying = track;
        this.audio.src = track.path;
    }

    this.play = function() {
        this.audio.play();
    }

    this.pause = function() {
        this.audio.pause();
    }

    this.setTime = function(seconds) {
        this.audio.currentTime = seconds;
    }

}