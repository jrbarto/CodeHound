<?php
/* User login process, checks if user exists and password is correct */

require 'db_config.php'; // Start session and assign DB config 

// Escape email to protect against SQL injections
$user_id = $_SESSION['id'];
$orgs = $_POST['orgs'];
$mysqli->query("UPDATE ch_users SET orgs='$orgs' WHERE id=$user_id") or die($mysqli->error);
?>
