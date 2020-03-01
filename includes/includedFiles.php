<?php
    if (isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
        include('includes/config.php');
        include('includes/classes/User.php');
        include('includes/classes/Artist.php');
        include('includes/classes/Album.php');
        include('includes/classes/Song.php');
        include('includes/classes/Playlist.php');
        

        if (isset($_GET['userLoggedIn'])) {
            $userLoggedIn = new User($con, $_GET['userLoggedIn']);
        } else {
            echo "username variable was not passed into page. Check the openPage javascript function";
            exit();
        }

    } else {
        include("includes/header.php");
        include("includes/footer.php");

        // Tratar URL do REQUEST_URI;
        $url = $_SERVER['REQUEST_URI'];
        
        $url = str_replace(substr($url, 0, 62), "", $url);
        
        echo "<script>openPage('$url');</script>";
        exit();
    }
?>