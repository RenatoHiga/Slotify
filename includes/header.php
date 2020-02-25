<?php 

    include('includes/config.php');
    include('includes/classes/Artist.php');
    include('includes/classes/Album.php');
    include('includes/classes/Song.php');
    // Changes
    //session_destroy(); LOGOUT
    
    if (isset($_SESSION['userLoggedIn'])) {
        $userLoggedIn = $_SESSION['userLoggedIn'];
        echo "<script>userLoggedIn = '$userLoggedIn'</script>";
    } else {
        session_destroy();
        header("Location: register.php");
    }

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Welcome to Slotify!</title>
        <link rel="stylesheet" href="assets/css/style.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="assets/js/script.js"></script>
    </head>

    <body>
        <div id="mainContainer">

            <div id="topContainer">
                
                <?php include("includes/navbarContainer.php") ?>
            
                <div id="mainViewContainer">

                    <div id="mainContent">