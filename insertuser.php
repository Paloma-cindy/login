<?php
if(isset($_POST['username']) && isset($_POST['user_email']) && isset($_POST['Phone_Number']) && isset($_POST['user_password'])){
    $Db_connection = mysqli_connect("localhost","root","","loginregistration");
// CHECK IF FIELDS ARE NOT EMPTY
    if(!empty(trim($_POST['username'])) && !empty(trim($_POST['user_email'])) && !empty(trim($_POST['Phone_Number'])) && !empty($_POST['user_password'])){

// Escape special characters.
        $username = mysqli_real_escape_string($Db_connection, htmlspecialchars($_POST['username']));
        $user_email = mysqli_real_escape_string($Db_connection, htmlspecialchars($_POST['user_email']));
        $PhoneNumber= mysqli_real_escape_string($Db_connection, htmlspecialchars($_POST['Phone_Number']));

//IF EMAIL IS VALID
        if (filter_var($user_email, FILTER_VALIDATE_EMAIL)) {

// CHECK IF EMAIL IS ALREADY REGISTERED
            $check_email = mysqli_query($Db_connection, "SELECT `user_email` FROM `users` WHERE user_email = '$user_email'");

            if(mysqli_num_rows($check_email) > 0){
                $error_message = "This Email Address is already registered. Please Try another.";
            }
            else{
// IF EMAIL IS NOT REGISTERED
                /* --

                ENCRYPT USER PASSWORD USING PHP password_hash function
                LEARN ABOUT PHP password_hash - http://php.net/manual/en/function.password-hash.php

                -- */

                $user_hash_password = password_hash($_POST['user_password'], PASSWORD_DEFAULT);

// INSERT USER INTO THE DATABASE
                $insert_user = mysqli_query($Db_connection, "INSERT INTO `users` (username, user_email, PhoneNumber, user_password,) VALUES ('$username', '$user_email', '$PhoneNumber', '$user_hash_password')");

                if($insert_user === TRUE){
                    $success_message = "Thanks! You have successfully signed up.";
                }
                else{
                    $error_message = "Oops! something wrong.";
                }
            }
        }
        else {
// IF EMAIL IS INVALID
            $error_message = "Invalid email address";
        }
    }
    else{
// IF FIELDS ARE EMPTY
        $error_message = "Please fill in all the required fields.";
    }
}
?>
