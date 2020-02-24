<?php
    $songQuery = mysqli_query($con, "SELECT id FROM songs ORDER BY RAND() LIMIT 10");

    $resultArray = [];
    while($row = mysqli_fetch_array($songQuery)) {
        array_push($resultArray, $row['id']);
    }

    $jsonArray = json_encode($resultArray);
?>

<script>
    
    $(document).ready(function() {
        currentPlaylist = <?php echo $jsonArray ?>;
        audioElement = new Audio();
        setTrack(currentPlaylist[0], currentPlaylist, false);
        updateVolumeProgressBar(audioElement.audio);

        $("#nowPlayingBarContainer").on("mousedown touchstart mousemove touchmove", function(event) {
            event.preventDefault();
        });

        $(".playbackBar .progressBar").mousedown(function() {
            mouseDown = true;
        });

        $(".playbackBar .progressBar").mousemove(function(event) {
            if (mouseDown == true) {
                timeFromOffset(event, this);
            }
            
        });

        $(".playbackBar .progressBar").mouseup(function(event) {
            timeFromOffset(event, this);
        });

        $(document).mouseup(function() {
            mouseDown = false;
        });

        $(".volumeBar .progressBar").mousedown(function() {
            mouseDown = true;
        });

        $(".volumeBar .progressBar").mousemove(function(event) {
            if (mouseDown == true) {
                
                var percentage = event.offsetX / $(this).width();
                if (percentage >= 0 && percentage <= 1) {
                    audioElement.audio.volume = percentage;
                }
            }
            
        });

        $(".volumeBar .progressBar").mouseup(function(event) {
            var percentage = event.offsetX / $(this).width();
            audioElement.audio.volume = percentage;
        });

    });

    function timeFromOffset(mouse, progressBar) {
        var percentage = mouse.offsetX / progressBar.clientWidth * 100;
        var seconds = audioElement.audio.duration * (percentage / 100);
        
        audioElement.setTime(seconds);
    }

    function prevSong() {
        if (audioElement.audio.currentTime >= 3 || currentIndex == 0) {
            audioElement.setTime(0);
        } else {
            currentIndex = currentIndex - 1;
            setTrack(currentPlaylist[currentIndex], currentPlaylist, true);
        }
    }

    function nextSong() {
        if (repeat == true) {
            audioElement.setTime(0);
            playSong();
            return;
        }

        if (currentIndex == currentPlaylist.length - 1) {
            currentIndex = 0;
        } else {
            currentIndex = currentIndex + 1;
        }

        var trackToPlay = currentPlaylist[currentIndex];
        setTrack(trackToPlay, currentPlaylist, true);
    }

    function setRepeat() {
        repeat = !repeat;
        var imageName = repeat ? "repeat-active.png" : "repeat.png";
        $(".controlButton.repeat img").attr("src", "assets/images/icons/" + imageName);
    }

    function setMute() {
        audioElement.audio.muted = !audioElement.audio.muted;
        var imageName = audioElement.audio.muted ? "volume-mute.png" : "volume.png";
        $(".controlButton.volume img").attr("src", "assets/images/icons/" + imageName);
    }

    function setShuffle() {
        shuffle = !shuffle;
        var imageName = shuffle ? "shuffle-active.png" : "shuffle.png";
        $(".controlButton.shuffle img").attr("src", "assets/images/icons/" + imageName);
    }

    function setTrack(trackId, newPlaylist, play) {

        currentIndex = currentPlaylist.indexOf(trackId);
        pauseSong();

        $.post("includes/handlers/ajax/getSongJson.php", { songId: trackId }, function(data) {
            var track = JSON.parse(data);
            $(".trackName span").text(track.title);

            $.post("includes/handlers/ajax/getArtistJson.php", {artistId: track.artist }, function(data) {
                var artist = JSON.parse(data);
                $(".artistName span").text(artist.name);
            });

            $.post("includes/handlers/ajax/getAlbumJson.php", {albumId: track.album }, function(data) {
                var album = JSON.parse(data);
                $(".albumLink img").attr("src", album.artworkPath);
            });

            audioElement.setTrack(track);
            playSong();
        });

        if (play) {
            audioElement.play();
        }
        
    }

    function playSong() {
        
        if (audioElement.audio.currentTime == 0) {
            $.post("includes/handlers/ajax/updatePlays.php", {songId: audioElement.currentPlaying.id});
        }

        $(".controlButton.play").hide();
        $(".controlButton.pause").show();
        audioElement.play();
    }

    function pauseSong() {
        $(".controlButton.play").show();
        $(".controlButton.pause").hide();
        audioElement.pause();
    }

</script>

<div id="nowPlayingBarContainer">
                
    <div id="nowPlayingBar">

        <div id="nowPlayingLeft">
            <div class="content">
                <span class="albumLink">
                    <img src="" alt="" srcset="" class="albumArtwork">
                </span>

                <div class="trackInfo">

                    <span class="trackName">
                        <span></span>
                    </span>

                    <span class="artistName">
                        <span></span>
                    </span>

                </div>
            </div>
        </div>

        <div id="nowPlayingCenter">
            
            <div class="content playerControls">
            
                <div class="buttons">

                    <button class="controlButton shuffle" title="Shuffle Button" onclick="setShuffle()">
                        <img src="assets/images/icons/shuffle.png" alt="shuffle">
                    </button>

                    <button class="controlButton previous" title="Previous Button" onclick="prevSong()">
                        <img src="assets/images/icons/previous.png" alt="previous">
                    </button>

                    <button class="controlButton play" title="Play Button" onclick="playSong()">
                        <img src="assets/images/icons/play.png" alt="play">
                    </button>

                    <button class="controlButton pause" title="Pause Button" style="display:none;" onclick="pauseSong()">
                        <img src="assets/images/icons/pause.png" alt="pause">
                    </button>

                    <button class="controlButton next" title="Next Button" onclick="nextSong()">
                        <img src="assets/images/icons/next.png" alt="Next">
                    </button>

                    <button class="controlButton repeat" title="Repeat Button" onclick="setRepeat()">
                        <img src="assets/images/icons/repeat.png" alt="repeat">
                    </button>

                </div>

                <div class="playbackBar">

                    <span class="progressTime current">0.00</span>

                    <div class="progressBar">
                        <div class="progressBarBg">
                            <div class="progress"></div>    
                        </div>
                    </div>
                    
                    <span class="progressTime remaining">0.00</span>

                </div>

            </div>
        
        </div>

        <div id="nowPlayingRight">
            <div class="volumeBar">

                <button class="controlButton volume" title="Volume button" onclick="setMute()">
                    <img src="assets/images/icons/volume.png" alt="volume">
                </button>

                <div class="progressBar">
                    <div class="progressBarBg">
                        <div class="progress"></div>
                    </div>
                </div>

            </div>
        </div>

    </div>

    </div>