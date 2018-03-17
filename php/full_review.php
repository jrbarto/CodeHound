<?php
require 'app_config.php';
require 'db_config.php';

$repo_path = $_GET['repo_path'];
$repo_url = $_GET['repo_url'];
$user_id = $_SESSION['id']; // id of the account
$sql = "SELECT * FROM ch_scripts WHERE user_id=$user_id";
$result = $mysqli->query($sql) or die($mysqli->error);

while ($row = $result->fetch_assoc()) {
  $script_path = $row['script_path'];
  $comment = $row['comment'];
  $command = "java -jar " . $ch_jar ." ". $script_path ." ". $repo_path 
    ." ". $_SESSION['github_auth'] ." ". "'$comment'" ." true";
  $output .= shell_exec($command);
}
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
    <h1 class="header teal-text"><?= 'Success'; ?></h1>                                                                 
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
