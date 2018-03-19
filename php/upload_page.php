<?php
/* Log out process, unsets and destroys session variables */
require 'db_config.php';

$json = new stdClass();
$json->scripts = array();

$user_id = $_SESSION['id']; // id of the account                                                                        
$sql = "SELECT * FROM ch_scripts WHERE user_id=$user_id";                                                               
$result = $mysqli->query($sql) or die($mysqli->error);                                                                  
                                                                                                                        
while ($row = $result->fetch_assoc()) {                                                                                 
  $active = ($row['active'] == '1');                                                                                            
  $script_path = $row['script_path'];                                                                                 
  $script_id = $row['id'];
  $script = new stdClass();
  $script->path=$script_path;
  $script->active=$active;
  $script->id=$script_id;
  array_push($json->scripts, $script);
}

$json_string = json_encode($json);
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
    <div class="collection teal darken-4 center">
      <div class="container" id="scripts">
          <h3 class="teal-text">Your Current Groovy Scripts:</h3>
      </div>
      <br><br>
    </div>
    <div class="collection teal darken-4 center"> 
      <h3 class="header teal-text">Upload a groovy script</h3> 
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
            <div class="input-field col s12 white-text">                                                                            
              <input name="comment" type="text" class="validate">                                                         
              <label class="center" for="comment">Automated Comment</label>                                                                          
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
    <!-- Executed after php code completes so json string is set -->
    <?php echo '<script src="/CodeHound/js/scripts.js" scripts='.$json_string.'></script>'?>
  </body>
</html>
