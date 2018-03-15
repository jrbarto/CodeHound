<?php
  session_start();
?>
<!DOCTYPE html>
<html>
  <head>
    <title>CodeHound Error</title>
    <!-- CSS  -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="/CodeHound/css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection"/>
    <link href="/CodeHound/css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>
  </head>
  <body>
    <h1 class="header teal-text">Error</h1>
    <h5>
    <?php
    if(isset($_SESSION['message']) AND !empty($_SESSION['message'])): 
      echo $_SESSION['message'];    
    else:
      header("location: /CodeHound/index.html");
    endif;
    ?>
    </h5>
    <br><br>
    <a href="/CodeHound/index.html"><button class="btn-large waves-effect waves-light teal lighten-1"/>Home</button></a>
  </body>
</html>
