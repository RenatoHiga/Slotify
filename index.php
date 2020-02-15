<?php 

    include('includes/config.php');

    session_destroy(); //LOGOUT

    if (isset($_SESSION['userLoggedIn'])) {
        $userLoggedIn = $_SESSION['userLoggedIn'];
    } else {
        header("Location: register.php");
    }

?>

<!DOCTYPE html>
<html>
    <header>
        <title>Welcome to Slotify!</title>
        <link rel="stylesheet" href="assets/css/style.css">
    </header>

    <body>
        
        <div id="mainContainer">

            <div id="topContainer">
                
                <div id="navbarContainer">

                    <nav class="navBar">

                        <a href="index.php" class="logo">
                            <img src="assets/images/icons/logo-dog.png">
                        </a>

                        <div class="group">

                            <div class="navItem">

                                <a href="search.php" class="navItemLink">Search</a>

                            </div>

                        </div>

                        <div class="group">

                            <div class="navItem">

                                <a href="browse.php" class="navItemLink">Browse</a>

                            </div>
                            
                            <div class="navItem">

                                <a href="yourMusic.php" class="navItemLink">Your music</a>

                            </div>

                            <div class="navItem">

                                <a href="profile.php" class="navItemLink">Renato Higa Higuti</a>

                            </div>

                        </div>

                    </nav>

                </div>
            
            </div>

            <div id="nowPlayingBarContainer">
                
                <div id="nowPlayingBar">

                    <div id="nowPlayingLeft">
                        <div class="content">
                            <span class="albumLink">
                                <img src="https://2.bp.blogspot.com/-LXZbBfnP-Po/Tt35Leob0yI/AAAAAAAAAB4/uP3yuE-xdzg/s1600/square_smaller_orange3.png" alt="" srcset="" class="albumArtwork">
                            </span>

                            <div class="trackInfo">

                                <span class="trackName">
                                    <span>Happy Birthday</span>
                                </span>

                                <span class="artistName">
                                    <span>Reece Kenney</span>
                                </span>

                            </div>
                        </div>
                    </div>

                    <div id="nowPlayingCenter">
                        
                        <div class="content playerControls">
                        
                            <div class="buttons">

                                <button class="controlButton shuffle" title="Shuffle Button">
                                    <img src="assets/images/icons/shuffle.png" alt="shuffle">
                                </button>

                                <button class="controlButton previous" title="Previous Button">
                                    <img src="assets/images/icons/previous.png" alt="previous">
                                </button>

                                <button class="controlButton play" title="Play Button">
                                    <img src="assets/images/icons/play.png" alt="play">
                                </button>

                                <button class="controlButton pause" title="Pause Button" style="display:none;">
                                    <img src="assets/images/icons/pause.png" alt="pause">
                                </button>

                                <button class="controlButton next" title="Next Button">
                                    <img src="assets/images/icons/next.png" alt="Next">
                                </button>

                                <button class="controlButton repeat" title="Repeat Button">
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

                            <button class="controlButton volume" title="Volume button">
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

        </div>

    </body>
</html>