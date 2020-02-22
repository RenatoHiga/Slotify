<?php 

    include('includes/config.php');
    include('includes/classes/Artist.php');
    include('includes/classes/Album.php');
    include('includes/classes/Song.php');
    // Changes
    session_destroy(); //LOGOUT

    if (isset($_SESSION['userLoggedIn'])) {
        $userLoggedIn = $_SESSION['userLoggedIn'];
    } else {
        // header("Location: register.php");
    }

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Welcome to Slotify!</title>
        <link rel="stylesheet" href="assets/css/style.css">
        <script src="assets/js/script.js"></script>
    </head>

    <body>
        <script>
            var audioElement = new Audio();

            audioElement.setTrack("assets/music/bensound-acousticbreeze.mp3");
            //audioElement.audio.play();

        </script>
        <div id="mainContainer">

            <div id="topContainer">
                
                <?php include("includes/navbarContainer.php") ?>
            
                <div id="mainViewContainer">

                    <div id="mainContent">