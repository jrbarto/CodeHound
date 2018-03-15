<?php
/* Displays all successful messages */
session_start();
?>
<!DOCTYPE html>
<html>
<head>
  <title>Success</title>
    <!-- CSS  -->                                                                                                       
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">                              
    <link href="/CodeHound/css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection"/>            
    <link href="/CodeHound/css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>
</head>
<body>
  <h1 class="header teal-text"><?= 'Success'; ?></h1>
  <h5 class="strong">
  <?php 
  if( isset($_SESSION['message']) AND !empty($_SESSION['message']) ):
    echo $_SESSION['message'];    
  else:
    header( "location: /CodeHound/index.php" );
  endif;
  ?>
  </h5>
  <br><br>
  <a href="/CodeHound/index.html"><button class="btn-large waves-effect waves-light teal lighten-1"/>Home</button></a>
</body>
</html>
