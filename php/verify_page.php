<?php
  session_start();
?>
<!DOCTYPE html>
<html>
  <head>
    <title>CodeHound Verify</title>
    <!-- CSS  -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="/CodeHound/css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection"/>
    <link href="/CodeHound/css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>
  </head>
  <body class ="teal">
    <div class="collection center teal darken-4">
      <h1 class="header teal-text">Verify Your Account</h1>
      <h5 class="white-text">
        You will receive an email at <?php echo $_SESSION['email']?> shortly with instructions to verify your account.
      </h5>
      <br><br>
      <a href="/CodeHound/index.html">
        <button class="btn-large waves-effect waves-light teal lighten-1"/>Home</button>
      </a>
      <br><br>
    </div>
  </body>
</html>
