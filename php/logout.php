<?php
/* Log out process, unsets and destroys session variables */
session_start();
session_unset();
session_destroy(); 
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Goodbye</title>
    <!-- CSS  -->                                                                                                       
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">                              
    <link href="/CodeHound/css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection"/>            
    <link href="/CodeHound/css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/> 
  </head>

  <body>
    <h1 class="header teal-text">Thanks for using CodeHound</h1>
    <h5><?= 'You have been logged out!'; ?></h5>
    <br><br>
    <a href="/CodeHound/index.html"><button class="btn-large waves-effect waves-light teal lighten-1"/>Home</button></a>
  </body>
</html>
