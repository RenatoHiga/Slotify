<?php
    if (isset($_POST["loginButton"])) {
        //The login button was pressed
        $username = $_POST["loginUsername"];
        $password = md5($_POST["loginPassword"]);

        $result = $account->login($username, $password);

        if ($result == true) {
            $_SESSION['userLoggedIn'] = $username;
            header("Location: index.php");
        }
    }
?>