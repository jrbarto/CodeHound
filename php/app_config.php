<?php
/* Code Hound application config */
$groovy_path = "/usr/bin/groovy";
$app_version = "1.0";
$app_dir = "/var/www/html/CodeHound/application";
$ch_jar = $app_dir . "/CodeSniffer-" . $app_version . ".jar";
$default_scripts = 
  array(
  array($app_dir . "/scripts/MethodTooManyArgs.groovy",
  "This method has more than the recommended number arguments. We recommend no 
  more than 3 arguments."),
  array($app_dir . "/scripts/LongMethodSniffer.groovy", 
  "This method is too long. Methods that are too long should be split into 
  separate functions.")
  );
?>
