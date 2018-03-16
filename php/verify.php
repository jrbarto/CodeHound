<?php 
/* Verifies the registered user by setting them to active */

require 'db_config.php'; // Start session and assign DB config

if(isset($_GET['email']) && !empty($_GET['email'])) {
  $email = $mysqli->escape_string($_GET['email']); 
    
  // Select unactivated users matching the email and hash
  $result = $mysqli->query("SELECT * FROM ch_users WHERE email='$email' AND active='0'");

  if ($result->num_rows == 0) { 
    $_SESSION['error'] = "This account has already been activated.";
    header("location: /CodeHound/php/error_page.php");
  }
  else {
    // Set the user status to active (active = 1)
    $mysqli->query("UPDATE ch_users SET active='1' WHERE email='$email'") or die($mysqli->error);
    $_SESSION['active'] = 1;
        
    header("location: success_page.php");
  }
}
else {
  $_SESSION['error'] = "Account verification was unsuccessful.";
  header("location: error_page.php");
}     
?>
