<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$config = parse_ini_file('config.ini');
$host = $config['user_host'];
$database = $config['user_dbname'];
$username = $config['user_username'];
$password = $config['user_password'];


$hostname_WebCatalogue = $host;
$database_WebCatalogue = $database;
$username_WebCatalogue = $username;
$password_WebCatalogue = $password;

$WebCatalogue = ($GLOBALS["___mysqli_ston"] = mysqli_connect($hostname_WebCatalogue,  $username_WebCatalogue,  $password_WebCatalogue, $database_WebCatalogue)) or trigger_error(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)),E_USER_ERROR); 
?>