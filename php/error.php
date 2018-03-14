<?php
/* Displays all error messages */
session_start();
?>
<!DOCTYPE html>
<html>
<head>
  <title>Error</title>
  <?php include 'css/materialize.css'; ?>
</head>
<body>
<div class="form">
    <h1>Error</h1>
    <p>
    <?php 
    if(isset($_SESSION['message']) AND !empty($_SESSION['message'])): 
        echo $_SESSION['message'];    
    else:
        header("location: /CodeHound/index.html");
    endif;
    ?>
    </p>     
    <a href="/CodeHound/index.html"><button class="button button-block"/>Home</button></a>
</div>
</body>
</html>
