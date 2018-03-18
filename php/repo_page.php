<?php
require 'db_config.php'; // Start session and assign DB config
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <title>Code Hound Repos</title>

  <!-- CSS  -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link href="/CodeHound/css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection"/>
  <link href="/CodeHound/css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>
</head>
<body>
  <nav class="white" role="navigation">
    <div class="nav-wrapper container">
      <ul class="right hide-on-med-and-down">
        <li><a href="/CodeHound/php/logout_page.php">Logout</a></li>
      </ul>
      <ul id="nav-mobile" class="side-nav">                                                                             
        <li><a href="/CodeHound/php/logout_page.php">Logout</a></li> 
      </ul>                                                                                                             
      <ul class="right hide-on-med-and-down">                                                                           
        <li><a href="/CodeHound/php/upload_page.php">Upload</a></li>                                                    
      </ul>                                                                                                             
      <ul id="nav-mobile" class="side-nav">                                                                             
        <li><a href="/CodeHound/php/upload_page.php">Upload</a></li>                                                    
      </ul>
      <a href="#" data-activates="nav-mobile" class="button-collapse"><i class="material-icons">menu</i></a>
    </div>
  </nav>

  <div class="container" id="repos">
    <div class="section">
      <h5 class="center teal-text">Loading Organizations...</h5>
      <div class="row">                                                                                                 
        <div class="toast"></div>                                                                                                          
      </div>                                                                                                            
      <div class="card-panel teal">                                                                                     
        <div class="card teal">                                                                                         
          <div class="card-content center">                                                                             
            <span class="white-text card-title">                                                                        
              Please be patient while we query for your organizations and repositories...                               
            </span>                                                                                                     
          </div>                                                                                                        
        </div>                                                                                                          
      </div>
    </div>
  </div>
  <br><br>

  <footer class="page-footer teal">
    <div class="container">                                                                                             
      <div class="row">                                                                                                 
        <div class="col l6 s12">                                                                                        
          <h5 class="white-text">Contact Us</h5>                                                                        
          <ul>                                                                                                          
            <li><a class="white-text" href="mailto:bartorobjeff@gmail.com">Jeffrey Barto - bartorobjeff@gmail.com</a></li>
            <li><a class="white-text" href="mailto:b.m.green41@vikes.csuohio.edu">Brian Green - b.m.green41@vikes.csuohio.edu</a></li>
            <li><a class="white-text" href="mailto:dillon.purvis@gmail.com">Dillon Purvis - dillon.purvis@gmail.com</a></li>
            <li><a class="white-text" href="mailto:michael.artman@pronow.org">Michael Artman - michael.artman@pronow.org</a></li>
          </ul>                                                                                                         
        </div>                                                                                                          
        <div class="col l6 s12">                                                                                        
          <h5 class="white-text">Contribute to Our Github Projects</h5>                                                 
          <ul>                                                                                                          
            <li><a class="white-text" href="https://github.com/jrbarto/Code-Smell-Detector">Code-Smell-Detector</a></li>
            <li><a class="white-text" href="https://github.com/jrbarto/Code-Parser">Code-Parser</a></li>                
            <li><a class="white-text" href="https://github.com/jrbarto/CodeHound">CodeHound</a></li>                    
          </ul>                                                                                                         
        </div>                                                                                                          
      </div>                                                                                                            
    </div> 
    <div class="footer-copyright">
      <div class="container">
      Made with <a class="brown-text text-lighten-3" href="http://materializecss.com">Materialize</a>
      </div>
    </div>
  </footer>

  <!--  Scripts-->
  <script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
  <script src="/CodeHound/js/materialize.js"></script>
  <script src="/CodeHound/js/repos.js" github_auth="<?php echo $_SESSION['github_auth']?>">
  </script>

  </body>
</html>
