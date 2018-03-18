<?php
/* User login process, checks if user exists and password is correct */

require 'db_config.php'; // Start session and assign DB config 

// Escape email to protect against SQL injections
$email = $mysqli->escape_string($_POST['email']);
$result = $mysqli->query("SELECT * FROM ch_users WHERE email='$email'");

// Fail if user doesn't exist
if ( $result->num_rows == 0 ) {
  $_SESSION['error'] = "No account matching the specified email address exists.";
  header("location: /CodeHound/php/error_page.php");
}
else {
  // Fetch result row as array
  $account = $result->fetch_assoc();

  // Check that the hashed password stored in the database matches the password
  if (password_verify($_POST['password'], $account['password'])) {
    $_SESSION['email'] = $account['email'];
    $_SESSION['github_auth'] = $account['github_auth'];
    $_SESSION['id'] = $account['id'];
    $_SESSION['active'] = $account['active'];

    // User only allowed into certain pages if they are logged in
    $_SESSION['logged_in'] = true;
      
    header("location: /CodeHound/php/repo_page.php");
  }
  else {
    $_SESSION['error'] = "The password entered is incorrect.";
    header("location: /CodeHound/php/error_page.php");
  }
}
?>
