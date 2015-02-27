<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$config = parse_ini_file('config.ini');
$host = $config['host'];
$database = $config['dbname'];
$username = $config['username'];
$password = $config['password'];


$hostname_WebCatalogue = $host;
$database_WebCatalogue = $database;
$username_WebCatalogue = $username;
$password_WebCatalogue = $password;

/*
$hostname_WebCatalogue = "localhost";
$database_WebCatalogue = "web_catalogue";
$username_WebCatalogue = "root";
$password_WebCatalogue = "";
*/
$WebCatalogue = mysql_pconnect($hostname_WebCatalogue, $username_WebCatalogue, $password_WebCatalogue) or trigger_error(mysql_error(),E_USER_ERROR); 
?>