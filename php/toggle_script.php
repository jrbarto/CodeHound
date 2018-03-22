<?php
require 'db_config.php';

$script_id = $_POST['scriptId'];
$active = $_POST['active'];

/* Deactivate if activated, activate if deactivated */
if (strcmp($active, 'true') == 0) {
  $sql = "UPDATE ch_scripts SET active=0 where id=$script_id";
}
else {
  $sql = "UPDATE ch_scripts SET active=1 where id=$script_id";
}

$result = $mysqli->query($sql);

if (!$result) {
  $_SESSION['error'] = "Failed to update script with SQL error " .$mysqli->error;
  header("location: /CodeHound/php/error_page.php");
}
?>
