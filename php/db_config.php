<?php
/* Database connection settings */
$host = 'data.pronow.net';
$user = 'elephant';
$pass = 'csuohio.edu';
$db = 'accounts';
$mysqli = new mysqli($host,$user,$pass,$db) or die($mysqli->error);

/* Code Hound application config */
$app_dir = "/var/www/html/CodeHound/application";
$ch_jar = $app_dir . "/CodeSniffer.jar";
$default_scripts = 
  array(
  array($app_dir . "/scripts/MethodTooManyArgs.groovy",
  "This method has more than the recommended number arguments. We recommend no 
  more than 3 arguments."),
  array($app_dir . "/scripts/LongMethodSniffer.groovy", 
  "This method is too long. Methods that are too long should be split into 
  separate functions.")
  );

session_start();

if ($mysqli->connect_errno) {
  $_SESSION['error'] = "Connection to database failed: " . $mysqli->connect_error;
  header("location: /CodeHound/php/error_page.php"); 
}

/* Used solely for debugging php code */
function console_log($data){
  echo '<script>';
  echo 'console.log('. json_encode($data) .')';
  echo '</script>';
}
?>
