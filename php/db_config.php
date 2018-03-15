<?php
/* Database connection settings */
$host = 'data.pronow.net';
$user = 'elephant';
$pass = 'csuohio.edu';
$db = 'accounts';
$mysqli = new mysqli($host,$user,$pass,$db) or die($mysqli->error);

/* Used solely for debugging php code */
function console_log($data){
  echo '<script>';
  echo 'console.log('. json_encode($data) .')';
  echo '</script>';
}
?>
