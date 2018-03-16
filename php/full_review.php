<?php
session_start();
$user_id = $_SESSION['id'];
$sql = "SELECT * FROM ch_scripts WHERE user_id='$user_id'";
$result = $mysqli->query(sql) or die($mysqli->error);
while ($row = $result->fetch_assoc()) {
  $script_path = $result['script_path'];
  $comment = $rsult['comment'];
  $output = shell_exec("java -jar " . $ch_jar ." ". $script_path ." ". $_SESSION);
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>CodeHound Success</title>
    <!-- CSS  -->                                                                                                       
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">                              
    <link href="/CodeHound/css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection"/>            
    <link href="/CodeHound/css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>
</head>
<body class="teal">
  <div class="collection center teal darken-4">
    <h1 class="header teal-text"><?= 'Success'; ?></h1>
    <h5 class="white-text">
      You have successfully activated your account.
    </h5>
    <br><br>
    <a href="/CodeHound/index.html">
      <button class="btn-large waves-effect waves-light teal lighten-1"/>Home</button>
    </a>
    <br><br>
  </div>
</body>
</html>
