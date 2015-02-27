<?php 
	@session_start();
	$_SESSION['EMPW'] = $_POST['email'];
	require_once('security.php');
 ?>
<?php require_once('../Connections/WebCatalogue.php'); ?>
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

$colname_EmailPassword = "-1";
if (isset($_SESSION['EMPW'])) {
  $colname_EmailPassword = $_SESSION['EMPW'];
}
((bool)mysqli_query( $WebCatalogue, "USE $database_WebCatalogue"));
$query_EmailPassword = sprintf("SELECT * FROM `users` WHERE email = %s", GetSQLValueString($colname_EmailPassword, "text"));
$EmailPassword = mysqli_query( $WebCatalogue, $query_EmailPassword) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
$row_EmailPassword = mysqli_fetch_assoc($EmailPassword);
$totalRows_EmailPassword = mysqli_num_rows($EmailPassword);

((mysqli_free_result($EmailPassword) || (is_object($EmailPassword) && (get_class($EmailPassword) == "mysqli_result"))) ? true : false);
?>
<?php 

if($totalRows_EmailPassword > 0)
{
	$dec_pass = aes_decrypt(base64_decode($row_EmailPassword['password']));
	$from = "noreply@domain.com";
	$email = $_SESSION['EMPW'];
	$subject = "Domain - Email Password";
	$message = "Your password is: " .$dec_pass;
	
	mail($email, $subject,$message, "From: ".$from);

  echo "Check your email.";
}

else
{
	echo "Wrong Email";
}


?>