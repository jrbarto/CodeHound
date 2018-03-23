<?php
require 'db_config.php';

$script_path = $_POST['scriptPath'];
unlink($script_path);
$sql = "SELECT id FROM ch_scripts WHERE script_path='$script_path'";
$result = $mysqli->query($sql) or die($mysqli->error);
$script_id = $result->fetch_assoc()['id'];
console_log("SCRIPT ID " . $script_id);

$sql = "DELETE FROM ch_scripts where id='$script_id'";
$result = $mysqli->query($sql);

if (!$result) {
  $_SESSION['error'] = "Failed to remove script with SQL error " .$mysqli->error;
  header("location: /CodeHound/php/error_page.php");
}
?>
