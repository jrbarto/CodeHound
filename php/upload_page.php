<?php
/* Log out process, unsets and destroys session variables */
require 'db_config.php';
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>CodeHound Upload</title>
    <!-- CSS  --> 
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"> 
    <link href="/CodeHound/css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection"/> 
    <link href="/CodeHound/css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/> 
  </head>

  <body class ="teal"> 
    <div class="container">
      <div class="section">
        <h5 class="center teal-text">Your Current Groovy Scripts:</h5>
        <div class="row">
          <div class="row">
          </div>
          <div class="row center">
          </div>
        </div>
      </div>
    </div>
    <div class="collection center teal darken-4 center"> 
      <h1 class="header teal-text">Upload a groovy script</h1> 
      <h5 class="white-text">
        <?php 
        if (isset($_SESSION['message']) && !empty($_SESSION['message'])) {
          echo $_SESSION['message'];
        }
        else {
          echo "Your script will be used in future automated code reviews.";
        }
        ?>
      </h5>
      <br><br> 

      <div class="row center">
        <form class="col s12" action="/CodeHound/php/upload.php" method="post" enctype="multipart/form-data">
          <div class="row center">
            <div class="file-field input-field">
              <div class="btn">
                <span>Choose a File</span>
                <input name="groovy_file" id="groovy_file" type="file">
              </div>
              <div class="file-path-wrapper">
                <input class="file-path validate center teal-text" type="text" placeholder="Choose a groovy file">
              </div>
            </div>
          </div>
          <div class="row center">
            <button class="btn waves-effect waves-light" type="submit">Upload
              <i class="material-icons right">send</i>
            </button>
          </div>
        </form>
      </div>
      <br><br> 
    </div> 

    <div class="row center">
      <a href="/CodeHound/php/repo_page.php"> 
        <button class="btn-large waves-effect waves-light teal lighten-1"/>Back to My Repos</button>
      </a> 
    </div>

    <!--  Scripts-->                                                                                                      
    <script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>                                                   
    <script src="/CodeHound/js/materialize.js"></script>                                                                             
  </body>
</html>
