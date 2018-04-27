<?php
require 'app_config.php';
require 'db_config.php';

$json = file_get_contents("php://input");
$_POST = json_decode($json, true);
$repository = $_POST['repository'];
$repo_path = $repository['full_name'];
$org = $_POST['organization'];
$org_name = $org['login'];
$sender = $_POST['sender'];
$sql = "SELECT user_id FROM ch_orgs WHERE org_name = '$org_name'";
$result = $mysqli->query($sql) or die($mysqli->error);

if ($result->num_rows == 0) {
  echo $org_name . " does not exist in the database.";
  exit(1);
}

$org_row = $result->fetch_assoc();
$user_id = $org_row['user_id'];

$sql = "SELECT * FROM ch_users WHERE id = $user_id";
$result = $mysqli->query($sql) or die($mysqli->error);

if ($result->num_rows == 0) {
  echo $org_name . " does not exist in the database.";
  exit(1);
}

$account = $result->fetch_assoc();
$github_auth = $account['github_auth'];
$user_id = $account['id'];
echo "USER ID IS " .$user_id;
$sql = "SELECT * FROM ch_scripts WHERE user_id='$user_id'";
$result = $mysqli->query($sql) or die($mysqli->error);
while ($row = $result->fetch_assoc()) {
  $active = $row['active'];
  if ($active) {
    $script_path = $row['script_path'];
    $comment = $row['comment'];
    /* Process must not wait for output as to hold up the webhook or it may timeout */
    $command = "java -jar " . $ch_jar ." ". $script_path ." ". $repo_path 
      ." ". $github_auth ." ". "'$comment'" ." false > /dev/null 2>/dev/null &";
    shell_exec($command);
  }
}
