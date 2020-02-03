<?php
    class Account {
        private $con;
        private $errorArray;

        public function __construct($con) {
            $this->con = $con;
            $this->errorArray = [];
        }

        public function login($username, $password) {
            $query = mysqli_query($this->con, "SELECT * FROM users WHERE username='$username' AND password='$password'");
        
            if (mysqli_num_rows($query) == 1) {
                return true;
            } else {
                array_push($this->errorArray, Constants::$loginFailed);
                return false;
            }
        }

        public function register($username, $firstName, $lastName, $email, $email2, $password, $password2) {
            $this->validateUsername($username);
            $this->validateFirstName($firstName);
            $this->validateLastName($lastName);
            $this->validateEmails($email, $email2);
            $this->validatePasswords($password, $password2);

            if (empty($this->errorArray)) {
                // Insert into db
                return $this->insertUserDetails($username, $firstName, $lastName, $email, $password);
            } else {
                return false;
            }
        }

        public function getError($error) {
            if (!in_array($error, $this->errorArray)) {
                $error = "";
            }
            
            return "<span class='errorMessage'>$error</span>";
        }

        private function insertUserDetails($username, $firstName, $lastName, $email, $password) {
            $encryptedPassword = md5($password);
            $profilePic = "assets/images/profile-pics/imagem.jpg";
            $date = date("Y-m-d");

            $result = mysqli_query($this->con, "INSERT INTO users VALUES ('', '$username', '$firstName', '$lastName', '$email', '$encryptedPassword', '$date', '$profilePic')");
        
            return $result;
        }

        private function validateUsername($username) {
            if (strlen($username) > 25 || strlen($username) < 5) {
                array_push($this->errorArray, Constants::$usernameCharacters);
                return;
            }

            $checkUsernameQuery = mysqli_query($this->con, "SELECT username FROM users WHERE username='$username'");
            if (mysqli_num_rows($checkUsernameQuery) != 0) {
                array_push($this->errorArray, Constants::$usernameTaken);
                return;
            }
        }
    
        private function validateFirstName($firstName) {
            if (strlen($firstName) > 25 || strlen($firstName) < 2) {
                array_push($this->errorArray, "Your first name must be between 2 and 25 characters");
                return;
            }
        }
    
        private function validateLastName($lastName) {
            if (strlen($lastName) > 25 || strlen($lastName) < 2) {
                array_push($this->errorArray, "Your last name must be between 2 and 25 characters");
                return;
            }
        }
    
        private function validateEmails($email1, $email2) {
            if ($email1 != $email2) {
                array_push($this->errorArray, "Your emails doesn't match!");
                return;
            }

            if (!filter_var($email1, FILTER_VALIDATE_EMAIL)) {
                array_push($this->errorArray, "Email isn't valid!");
                return;
            }

            $checkEmailQuery = mysqli_query($this->con, "SELECT email FROM users WHERE email='$email1'");
            if (mysqli_num_rows($checkEmailQuery) != 0) {
                array_push($this->errorArray, Constants::$emailTaken);
                return;
            }
        }
    
        private function validatePasswords($password1, $password2) {
            if ($password1 != $password2) {
                array_push($this->errorArray, "Your passwords doesn't match!");
                return;
            }

            if (preg_match('/[^A-Za-z0-9]/', $password1)) {
                array_push($this->errorArray, "The password can only contain numbers and letters");    
                return;
            }

            if (strlen($password1) > 25 || strlen($password1) < 6) {
                array_push($this->errorArray, "Your password must be between 6 and 25 characters");
                return;
            }
        }
    }
?>