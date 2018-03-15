<?php
/* Insert new user into the database and send confirmation email */

require 'db_config.php';
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
  $_SESSION['message'] = 'User with the specified email address already exists.';
  header("location: error_page.php");
}
else {
  // active is 0 by DEFAULT (no need to include it here)
  $sql = "INSERT INTO ch_users (email, password, github_user, github_pass, github_org, hash, github_hash) " 
    . "VALUES ('$email', '$password', '$github_user', '$github_pass', '$github_org', '$hash', '$github_hash')";

  // Add user to the database
  if ( $mysqli->query($sql) ){
    $_SESSION['active'] = 0; //0 until user activates their account with verify.php
    $_SESSION['logged_in'] = true; // So we know the user has logged in
    $_SESSION['message'] = "Confirmation link has been sent to $email, please verify
      your account by clicking on the link in the message!";

    // Send confirmation email
    $to = $email;
    $subject = "Verify Your Account on CodeHound";
    $message_body = "Hi {$email},\nThank you for signing up for CodeHound!\nClick the link below to activate your account:\n"
      . "http://tusk.pronow.net/CodeHound/php/verify.php?email={$email}&hash={$hash}";  

    mail($to, $subject, $message_body);
    $_SESSION['message'] = "You will receive an email shortly with instructions to verify your account.";
    header("location: verify_page.php"); 
  }
  else {
    $_SESSION['message'] = "SQL error returned: " . $mysqli->error;
    header("location: error_page.php");
  }

}
?>
