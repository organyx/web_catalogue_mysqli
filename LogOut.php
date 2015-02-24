<?php require_once('Connections/WebCatalogue.php'); ?>
<?php
// *** Logout the current user.
$logoutGoTo = "Index.php";
if (!isset($_SESSION)) {
  session_start();
}
$_SESSION['MM_Username'] = NULL;
$_SESSION['MM_UserGroup'] = NULL;
unset($_SESSION['MM_Username']);
unset($_SESSION['MM_UserGroup']);
if ($logoutGoTo != "") {header("Location: $logoutGoTo");
exit;
}
?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "")
{
/*Global variable $con is necessary, because it is not known inside the function and you need it for mysqli_real_escape_string($con, $theValue); the Variable $con ist defined as mysqli_connect("localhost","user","password", "database") with an include-script.
*/
  Global $WebCatalogue;

  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }
  $theValue = mysqli_real_escape_string($WebCatalogue, $theValue);
  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;   
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
   return $theValue;
}
}

$colname_LogOut = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_LogOut = $_SESSION['MM_Username'];
}
((bool)mysqli_query( $WebCatalogue, "USE $database_WebCatalogue"));
$query_LogOut = sprintf("SELECT * FROM `users` WHERE email = %s", GetSQLValueString($colname_LogOut, "text"));
$LogOut = mysqli_query( $WebCatalogue, $query_LogOut) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
$row_LogOut = mysqli_fetch_assoc($LogOut);
$totalRows_LogOut = mysqli_num_rows($LogOut);
?>
<!doctype html>
<html>
<head>

<link href="CSS/Layout.css" rel="stylesheet" type="text/css">
<link href="CSS/Menu.css" rel="stylesheet" type="text/css">

<meta charset="utf-8">
<title>Untitled Document</title>
</head>

<body>
<div id="Holder">
  <div id="Header"></div>
  <div id="NavBar">
    	<nav>
        	<ul>
            	<li><a href="Index.php">Main</a></li>
                <li><a href="Register.php">Register</a></li>
                <li><a href="ForgotPassword.php">Forgot Password</a></li>
                
            </ul>
        </nav>
  </div>
  <div id="Content">
    	<div id="PageHeading">
    	  <h1>Page Heading</h1>
   	  </div>
    	<div id="contentLeft">
    	  <h2>Your Message</h2><br>
    	  <h6>Your message</h6>
    	</div>
    <div id="contentRight"></div>
  </div>
  <div id="Footer"><p><a href="Admin.php">Admin</a></p></div>
</div>
</body>
</html>
<?php
((mysqli_free_result($LogOut) || (is_object($LogOut) && (get_class($LogOut) == "mysqli_result"))) ? true : false);
?>
