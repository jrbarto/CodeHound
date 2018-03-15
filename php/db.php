<?php
/* Database connection settings */
$host = 'data.pronow.net';
$user = 'elephant';
$pass = 'csuohio.edu';
$db = 'accounts';
$mysqli = new mysqli($host,$user,$pass,$db) or die($mysqli->error);
?>
