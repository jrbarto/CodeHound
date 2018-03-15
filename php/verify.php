<?php 
/* Verifies the registered user by setting them to active */

require 'db_config.php';
session_start();

if(isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['hash']) && !empty($_GET['hash'])) {
  $email = $mysqli->escape_string($_GET['email']); 
  $hash = $mysqli->escape_string($_GET['hash']); 
    
  // Select unactivated users matching the email and hash
  $result = $mysqli->query("SELECT * FROM ch_users WHERE email='$email' AND hash='$hash' AND active='0'");

  if ($result->num_rows == 0) { 
    $_SESSION['message'] = "This account has already been activated.";
      header("location: error_page.php");
  }
  else {
    $_SESSION['message'] = "You have successfully activated your account.";
        
    // Set the user status to active (active = 1)
    $mysqli->query("UPDATE ch_users SET active='1' WHERE email='$email'") or die($mysqli->error);
    $_SESSION['active'] = 1;
        
    header("location: success_page.php");
  }
}
else {
  $_SESSION['message'] = "Account verification was unsuccessful.";
  header("location: error_page.php");
}     
?>
