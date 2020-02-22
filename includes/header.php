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
    </head>

    <body>
        
        <div id="mainContainer">

            <div id="topContainer">
                
                <?php include("includes/navbarContainer.php") ?>
            
                <div id="mainViewContainer">

                    <div id="mainContent">