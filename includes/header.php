<?php 

    include('includes/config.php');

    session_destroy(); //LOGOUT

    if (isset($_SESSION['userLoggedIn'])) {
        $userLoggedIn = $_SESSION['userLoggedIn'];
    } else {
        // header("Location: register.php");
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
                
                <?php include("includes/navbarContainer.php") ?>
            
                <div id="mainViewContainer">

                    <div id="mainContent">