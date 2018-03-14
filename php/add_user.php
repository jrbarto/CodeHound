<?php
/* Registration process, inserts user info into the database 
   and sends account confirmation email message
 */

require 'db.php';
session_start();
$_SESSION['email'] = $_POST['email'];
$_SESSION['username'] = $_POST['username'];
$_SESSION['github_user'] = $_POST['github_user'];
$_SESSION['github_pass'] = $_POST['github_pass'];
$_SESSION['github_org'] = $_POST['github_org'];

// Escape SQL keywords
$email = $mysqli->escape_string($_POST['email']);
$username = $mysqli->escape_string($_POST['username']);
$password = $mysqli->escape_string(password_hash($_POST['password'], PASSWORD_BCRYPT));
$github_user = $mysqli->escape_string($_POST['github_user']);
$github_pass = $mysqli->escape_string(password_hash($POST['github_pass'], PASSWORD_BCRYPT));
$hash = $mysqli->escape_string(md5(rand(0,1000)));
$github_hash = $mysqli->escape_string(md5(rand(0,1000)));
$github_org = $mysqli->escape_string($_POST['github_org']);
      
// Check if email is already in system
$result = $mysqli->query("SELECT * FROM ch_users WHERE email='$email'") or die($mysqli->error());

// More than 0 rows means email is already in the system and we should fail 
if ( $result->num_rows > 0 ) {
    
    $_SESSION['message'] = 'User with this email already exists!';
    header("location: error.php");
    
}
else {
    echo 'I MADE IT HERE';
    // active is 0 by DEFAULT (no need to include it here)
    $sql = "INSERT INTO ch_users (email, username, password, github_user, github_pass, github_org, hash, github_hash) " 
            . "VALUES ('$email','$username','$password','$github_user', '$github_pass', '$github_org', '$hash', '$github_hash')";

    // Add user to the database
    if ( $mysqli->query($sql) ){

        $_SESSION['active'] = 0; //0 until user activates their account with verify.php
        $_SESSION['logged_in'] = true; // So we know the user has logged in
        $_SESSION['message'] =
                
                 "Confirmation link has been sent to $email, please verify
                 your account by clicking on the link in the message!";

        // Send registration confirmation link (verify.php)
        $to      = $email;
        $subject = 'Account Verification (CodeHound)';
        $message_body = '
        Hello '.$first_name.',

        Thank you for signing up!

        Please click this link to activate your account:

        http://tusk.pronow.net/CodeHound/php/verify.php?email='.$email.'&hash='.$hash;  

        mail( $to, $subject, $message_body );

        header("location: /CodeHound/index.html"); 

    }

    else {
        $_SESSION['message'] = $mysqli->error;
        header("location: error.php");
    }

}
