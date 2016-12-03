<?php
//Database configuration

define('HOST', 'localhost');
define('USERNAME', 'root');
define('PASSWORD', 'ur48x');
define('DATABASE_NAME', 'rating');

//Connect with the database
$db = new mysqli(HOST, USERNAME, PASSWORD, DATABASE_NAME);
if($db->connect_errno):
    die('Connect error:'.$db->connect_error);
endif;
?>