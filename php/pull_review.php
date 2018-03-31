<?php
require 'app_config.php';
require 'db_config.php';

$json = file_get_contents("php://input");
$_POST = json_decode($json, true);
$repository = $_POST['repository'];
$repo_path = $repository['full_name'];
$sender = $_POST['sender'];
$github_user = $sender['login'];
//$sql = "SELECT * FROM ch_users WHERE github_user='$github_user'";
$result = $mysqli->query("SELECT * FROM ch_users WHERE github_user='codehounduser'") or die($mysqli->error);
if ($result->num_rows == 0) {
  echo $github_user . " does not exist in the database.";
  exit(1);
}
$account = $result->fetch_assoc();
$user_id = $account['user_id'];
$github_auth = $account['github_auth'];
$user_id = $account['id'];

$json_data['groovyHome'] = $groovy_path;                                                                                
$json_data['repoPath'] = $repo_path;                                                                                    
$json_data['fullReview'] = false;                                                                                        
$json_data['authHeader'] = $github_auth;

$json_file = tmpfile(); // Returns a file handler for a temporary file                                                  
$meta_data = stream_get_meta_data($json_file);                                                                          
$file_path = $meta_data['uri'];

echo "USER ID IS " .$user_id;
echo "REPO IS " .$repo_path;
$sql = "SELECT * FROM ch_scripts WHERE user_id='$user_id'";
$result = $mysqli->query($sql) or die($mysqli->error);

$scripts = array();

while ($row = $result->fetch_assoc()) {
  $active = $row['active'];
  if ($active) {
    $script_path = $row['script_path'];
    $comment = $row['comment'];
    $script['path'] = $script_path;                                                                                     
    $script['comment'] = $comment;                                                                                      
    array_push($scripts, $script);
  }
}

$json_data['scripts'] = $scripts;                                                                                       
fwrite($json_file, json_encode($json_data));

/* Process must not wait for output as to hold up the webhook or it may timeout */
$command = "java -jar " . $ch_jar ." ". $file_path ." > /dev/null 2>/dev/null &";
echo "COMMAND IS " .$command;
echo "JSON IS " .json_encode($json_data);
shell_exec($command);
