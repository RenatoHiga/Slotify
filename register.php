<?php
    include('includes/config.php');
    include('includes/classes/Account.php');
    include('includes/classes/Constants.php');

    $account = new Account($con);
    
    include('includes/handlers/register-handler.php');
    include('includes/handlers/login-handler.php');

    function getInputValue($name) {
        if (isset($_POST[$name])) {
            echo $_POST[$name];
        }
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Welcome to Slotify!</title>
        
        <link rel="stylesheet" href="assets/css/register.css">
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="assets/js/register.js"></script>
    </head>

    <body>
        <?php if (isset($_POST['registerButton'])) {
            echo '<script>
                $(document).ready(function() {

                $("#loginForm").hide();
                $("#registerForm").show();
                
            });
            </script>';
        } else {
            echo '<script>
                $(document).ready(function() {

                $("#loginForm").show();
                $("#registerForm").hide();
                
            });
            </script>'; 
        }
        ?>
        

        <div id="background">

            <div id="loginContainer">

                <div id="inputContainer">
                    <form action="register.php" id="loginForm" method="POST">

                        <h2>Login to your Account!</h2>
                        <p>
                            <?php echo $account->getError(Constants::$loginFailed); ?>
                            <label for="loginUsername">Username</label>
                            <input type="text" name="loginUsername" id="loginUsername" placeholder="e.g. bartSimpson" value="<?php getInputValue('loginUsername') ?>" required>
                        </p>
                        
                        <p>
                            <label for="passwordUsername">Password</label>
                            <input type="password" name="loginPassword" id="loginPassword" placeholder="Your password" required>
                        </p>
                        
                        <button type="submit" name="loginButton">LOG IN</button>

                        <div class="hasAccountText">
                            <a href="#">
                                <span id="hideLogin">Don't have an account yet? Sign up here</span>
                            </a>
                        </div>

                    </form>

                    <form action="register.php" id="registerForm" method="POST">

                        <h2>Create your free Account!</h2>
                        <p>
                            <?php echo $account->getError(Constants::$usernameCharacters); ?>
                            <?php echo $account->getError(Constants::$usernameTaken); ?>
                            <label for="username">Username</label>
                            <input type="text" name="username" id="username" value="<?php getInputValue('username')?>" placeholder="e.g. bartSimpson" required>
                        </p>

                        <p>
                            <?php echo $account->getError(Constants::$firstNameCharacters); ?>
                            <label for="firstName">First Name</label>
                            <input type="text" name="firstName" id="firstName" value="<?php getInputValue('firstName')?>" placeholder="e.g. Bart" required>
                        </p>

                        <p>
                            <?php echo $account->getError(Constants::$lastNameCharacters); ?>
                            <label for="lastName">Last Name</label>
                            <input type="text" name="lastName" id="lastName" value="<?php getInputValue('lastName')?>" placeholder="e.g. Simpson" required>
                        </p>

                        <p>
                            <?php echo $account->getError(Constants::$emailsDoNotMatch); ?>
                            <?php echo $account->getError(Constants::$emailInvalid); ?>
                            <?php echo $account->getError(Constants::$emailTaken); ?>
                            <label for="email">E-mail</label>
                            <input type="email" name="email" id="email" value="<?php getInputValue('email')?>" placeholder="e.g. bart@gmail.com" required>
                        </p>
                        
                        <p>
                            <label for="email2">Confirm E-mail</label>
                            <input type="email" name="email2" id="email2" value="<?php getInputValue('email2')?>" placeholder="e.g. bart@gmail.com" required>
                        </p>

                        <p>
                            <?php echo $account->getError(Constants::$passwordDoNotMatch); ?>
                            <?php echo $account->getError(Constants::$passwordNotAlphanumeric); ?>
                            <?php echo $account->getError(Constants::$passwordCharacters); ?>
                            <label for="password">Password</label>
                            <input type="password" name="password" id="password" placeholder="Your password" required>
                        </p>
                        
                        <p>
                            <label for="password2">Confirm Password</label>
                            <input type="password" name="password2" id="password2" placeholder="Your password" required>
                        </p>

                        <button type="submit" name="registerButton">SIGN UP</button>

                        <div class="hasAccountText">
                            <a href="#">
                                <span id="hideRegister">Already have an account yet? Log in here</span>
                            </a>
                        </div>

                    </form>

                </div>

                <div id="loginText">
                    <h1>Get great music, right now</h1>
                    <h2>Listen to loads of songs for free.</h2>
                    <ul>
                        <li>Discover music you'll fall in love with</li>
                        <li>Create your own playlists</li>
                        <li>Follow artists to keep up to date</li>
                    </ul>
                </div>

            </div>

        </div>

    </body>

</html>