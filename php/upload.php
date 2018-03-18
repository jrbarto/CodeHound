<?php
require 'db_config.php';
$target_dir = "/CodeHound/application/scripts/";
$target_file = $target_dir . basename($_FILES["groovy_file"]["name"]);
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

if ($valid ==0) {
  header("location: /CodeHound/php/error_page.php"); 
}
else {
  if (move_uploaded_file($_FILES["groovy_file"]["tmp_name"], $target_file)) {
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
