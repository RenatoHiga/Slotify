<?php
    if (isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
        include('includes/config.php');
        include('includes/classes/Artist.php');
        include('includes/classes/Album.php');
        include('includes/classes/Song.php');
    } else {
        include("includes/header.php");
        include("includes/footer.php");

        // Tratar URL do REQUEST_URI;
        $url = $_SERVER['REQUEST_URI'];
        $url = explode("/", $url);
        $start = array_search("Slotify-1", $url) + 1;
        
        $new_url = "";
        for ($index = $start; $index < sizeof($url); $index++) {
            $new_url = $url[$index];
        }
        echo "<script>openPage('$new_url');</script>";
        exit();
    }
?>