<?php
/* User login process, checks if user exists and password is correct */
require 'db.php';                                                                                                       
session_start();

// Escape email to protect against SQL injections
$email = $mysqli->escape_string($_POST['email']);
$result = $mysqli->query("SELECT * FROM ch_users WHERE email='$email'");

// Fail if user doesn't exist
if ( $result->num_rows == 0 ) {
  $_SESSION['message'] = "User with email does not exist.";
  header("location: error.php");
}
else {
  // Fetch result row as array
  $account = $result->fetch_assoc();

  // Check that the hash stored in the database matches the password
  if (password_verify($_POST['password'], $account['password'])) {
    $_SESSION['email'] = $user['email'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['github_user'] = $user['github_user'];
    $_SESSION['github_pass'] = $user['github_pass'];
    $_SESSION['github_org'] = $user['github_org'];
    $_SESSION['active'] = $user['active'];
      
    // This is how we'll know the user is logged in
    $_SESSION['logged_in'] = true;
      
    if ( !$_SESSION['page_view'] ) {
      header("location: /CodeHound/repos.html");
    } 
    else {
      header("location: " . $_SESSION['page_view']);
    }
  }
  else {
    $_SESSION['message'] = "You have entered wrong password, try again!";
    header("location: error.php");
  }
}
?>
