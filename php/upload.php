<?php
require 'db_config.php';
$target_dir = "/var/www/html/CodeHound/application/scripts/" . $_SESSION['email'] . "/";
$target_file = $target_dir . basename($_FILES["groovy_file"]["name"]);
$comment = $_POST['comment'];
$valid = 1;
$file_type = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

if ($file_type != "groovy") {
  $_SESSION['error'] = "This is not a valid groovy file.";
  $valid = 0;
}
if (file_exists($target_file)) {
  $_SESSION['error'] = "This groovy file already exists.";
  $valid = 0;
}

if (!is_dir($target_dir)) {
  mkdir($target_dir);
}

if ($valid ==0) {
  header("location: /CodeHound/php/error_page.php"); 
}
else {
  if (move_uploaded_file($_FILES["groovy_file"]["tmp_name"], $target_file)) {
    $email = $_SESSION['email'];
    $sql = "SELECT id FROM ch_users WHERE email='$email'";                                                              
    $result = $mysqli->query($sql) or die($mysqli->error);                                                              
    $user_id = $result->fetch_assoc()['id'];

    $path = $target_file;                                                                                               
    $sql = "INSERT INTO ch_scripts (user_id, script_path, comment) "                                                  
        . "VALUES ('$user_id', '$path', '$comment')";                                                                   
    $mysqli->query($sql) or die($mysqli->error);

    $_SESSION['message'] =  "The file " . basename($_FILES["groovy_file"]["name"]) . " has been uploaded.";
    header("location: /CodeHound/php/upload_page.php");
  }
  else {
    $_SESSION['error'] = "File upload has failed.";
    console_log(error_get_last());
    //header("location: /CodeHound/php/error_page.php");
  }
}
?>
