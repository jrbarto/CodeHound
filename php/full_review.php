<?php
require 'app_config.php';
require 'db_config.php';

$repo_path = $_GET['repo_path'];
$repo_url = $_GET['repo_url'];

$json_data['groovyHome'] = $groovy_path;
$json_data['repoPath'] = $repo_path;
$json_data['fullReview'] = true;
$json_data['authHeader'] = $_SESSION['github_auth'];

$user_id = $_SESSION['id']; // id of the account
$sql = "SELECT * FROM ch_scripts WHERE user_id=$user_id";
$result = $mysqli->query($sql) or die($mysqli->error);
$json_file = tmpfile(); // Returns a file handler for a temporary file
$meta_data = stream_get_meta_data($json_file);
$file_path = $meta_data['uri'];

$scripts = array(); // All json script objects

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

$command = "java -jar " . $ch_jar ." ". $file_path;
$output = shell_exec($command);
?>
<!DOCTYPE html>                                                                                                         
<html>                                                                                                                  
<head>                                                                                                                  
  <title>CodeHound Review Completed</title>                                                                                      
    <!-- CSS  -->                                                                                                       
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">                              
    <link href="/CodeHound/css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection"/>            
    <link href="/CodeHound/css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>                  
</head>                                                                                                                 
<body class="teal">                                                                                                     
  <div class="collection center teal darken-4">                                                                         
    <h1 class="header teal-text">Code Review Complete</h1>                                                                 
    <h5 class="white-text">                                                                                             
      <?php echo nl2br($output) ?>                                                           
    </h5>                                                                                                               
    <br><br>                                                                                                            
    <div class="row">
      <a href="/CodeHound/php/repo_page.php" class="space-right">
        <button class="btn-large waves-effect waves-light teal lighten-1"/>Back to My Repos</button>
      </a> 
      <a href="<?php echo $repo_url ?>" class="space-left">
        <button class="btn-large waves-effect waves-light teal lighten-1"/>View the Repo</button>
      </a>
      <br><br>
    </div>
  </div>
</body>
</html>
