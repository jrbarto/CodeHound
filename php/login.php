<?php
/* User login process, checks if user exists and password is correct */
require 'db_config.php';                                                                                                       
session_start();

// Escape email to protect against SQL injections
$email = $mysqli->escape_string($_POST['email']);
$result = $mysqli->query("SELECT * FROM ch_users WHERE email='$email'");

// Fail if user doesn't exist
if ( $result->num_rows == 0 ) {
  $_SESSION['message'] = "No account matching the specified  email address exists.";
  header("location: error_page.php");
}
else {
  // Fetch result row as array
  $account = $result->fetch_assoc();
  // Check that the hashed password stored in the database matches the password
  if (password_verify($_POST['password'], $account['password'])) {
    $_SESSION['email'] = $account['email'];
    $_SESSION['github_user'] = $account['github_user'];
    $_SESSION['github_pass'] = $account['github_pass'];
    $_SESSION['github_org'] = $account['github_org'];
    $_SESSION['active'] = $account['active'];
    console_log($account['github_user']);  
    // User only allowed into certain pages if they are logged in
    $_SESSION['logged_in'] = true;
      
    if ( !$_SESSION['page_view'] ) {
      header("location: /CodeHound/php/repo_page.php");
    } 
    else {
      header("location: " . $_SESSION['page_view']);
    }
  }
  else {
    $_SESSION['message'] = "The password entered is incorrect.";
    header("location: error_page.php");
  }
}
?>
