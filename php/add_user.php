<?php
/* Insert new user into the database and send confirmation email */

require 'db_config.php'; // Start session and assign DB config
require 'app_config.php'; // CodeHound specific application settings

/* Variables to use later in the session */
$_SESSION['email'] = $_POST['email'];
// Base 64 encoded username:password Github authentication credentials
$_SESSION['github_auth'] = base64_encode($_POST['github_user'].":".$_POST['github_pass']);

// Escape SQL keywords
$email = $mysqli->escape_string($_POST['email']);
$username = $mysqli->escape_string($_POST['username']);
$password = $mysqli->escape_string(password_hash($_POST['password'], PASSWORD_BCRYPT));
$github_auth = $mysqli->escape_string($_SESSION['github_auth']);
// Check if email is already in system
$sql = "SELECT * FROM ch_users WHERE email='$email'";
$result = $mysqli->query($sql) or die($mysqli->error);

// More than 0 rows means email is already in the system and we should fail 
if ($result->num_rows > 0) {
  $_SESSION['error'] = 'User with the specified email address already exists.';
  header("location: /CodeHound/php/error_page.php");
}
else {
  // active is 0 by DEFAULT (no need to include it here)
  $sql = "INSERT INTO ch_users (email, password, github_auth) "
    . "VALUES ('$email', '$password', '$github_auth')";

  // Add user to the database
  if ($mysqli->query($sql)) {
    $_SESSION['active'] = 0; //0 until user activates their account with verify.php
    $_SESSION['logged_in'] = true; // So we know the user has logged in
    $sql = "SELECT id FROM ch_users WHERE email='$email'";
    $result = $mysqli->query($sql) or die($mysqli->error);
    $user_id = $result->fetch_assoc()['id'];

    foreach ($default_scripts as $script) {
      $path = $script[0];
      $comment = $script[1];
      $sql = "INSERT INTO ch_scripts (user_id, script_path, comment) "
        . "VALUES ('$user_id', '$path', '$comment')";
      $mysqli->query($sql) or die($mysqli->error);
    }
    // Send confirmation email
    $to = $email;
    $subject = "Verify Your Account on CodeHound";
    $email_body = "Hi {$email},\nThank you for signing up for CodeHound!\nClick the link below to activate your account:\n"
      . "http://tusk.pronow.net/CodeHound/php/verify.php?email={$email}";  

    mail($to, $subject, $email_body);
    header("location: /CodeHound/php/verify_page.php"); 
  }

}

if ($mysqli->errno) {
  $_SESSION['error'] = "SQL error returned: " . $mysqli->error;
  header("location: /CodeHound/php/error_page.php");
}
?>
