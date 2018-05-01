<?php
/* User login process, checks if user exists and password is correct */

require 'db_config.php'; // Start session and assign DB config 

// Escape email to protect against SQL injections
$user_id = $_SESSION['id'];
$orgs = $_POST['orgs'];

/* Split orgs into array. GitHub doesn't allow commas in org names, so this is okay */
$org_arr = explode(',', $orgs);

/* Query for existing ch_orgs table */
$check = "SHOW TABLES LIKE 'ch_orgs'";
$result = $mysqli->query($check);

/* Create ch_orgs table if it doesn't exist */
if ($result->num_rows == 0) {
  /* Create tickets table if it doesn't exist */
  $sql = "CREATE TABLE ch_orgs (
    org_name VARCHAR(100) NOT NULL,
    user_id INT UNSIGNED NOT NULL,
    FOREIGN KEY (user_id) REFERENCES ch_users (id),
    PRIMARY KEY (org_name, user_id)
  )";

  if ($mysqli->query($sql) !== TRUE) {
    $message = "Failed to create table: $mysqli->error";
    header("location: /CodeHound/php/error_page.php");
  }
}

foreach ($org_arr as $org_name) {
  echo "INERTING ORG " . $org_name;
  $sql = "INSERT IGNORE INTO ch_orgs (org_name, user_id)
          VALUES('$org_name', $user_id)";                                                                   

  $result = $mysqli->query($sql) or die($mysqli->error);                                                                  
                                                                                                                          
  if ($result->num_rows > 0) {                                                                                            
    $_SESSION['error'] = "Failed to insert $org_name into the ch_orgs table.";                                         
    header("location: /CodeHound/php/error_page.php");                                                                    
  } 
}
?>
