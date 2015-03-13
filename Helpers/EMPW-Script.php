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

function randomPassword() {
    $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 8; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
}

$colname_EmailPassword = "-1";
if (isset($_SESSION['EMPW']) && filter_var($_SESSION['EMPW'], FILTER_VALIDATE_EMAIL)) {
  $colname_EmailPassword = $_SESSION['EMPW'];
}

$new_password = randomPassword();
$new_hashed_password = password_hash($new_password, PASSWORD_BCRYPT);

$query_EmailPassword = sprintf(
  "UPDATE users SET password=%s WHERE email=%s",
                       GetSQLValueString($new_hashed_password, "text"),
                       GetSQLValueString($_SESSION['EMPW'], "text")
  );
$EmailPassword = mysqli_query( $WebCatalogue, $query_EmailPassword) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));


$query_EmailPassword2 = sprintf("SELECT * FROM `users` WHERE email = %s", GetSQLValueString($colname_EmailPassword, "text"));
$EmailPassword2 = mysqli_query( $WebCatalogue, $query_EmailPassword2) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
$row_EmailPassword2 = mysqli_fetch_assoc($EmailPassword2);
$totalRows_EmailPassword2 = mysqli_num_rows($EmailPassword2);
?>
<?php 

if($totalRows_EmailPassword2 > 0)
{
	$from = "noreply@domain.com";
	$email = $_SESSION['EMPW'];
	$subject = "Domain - Email Password";
	$message = "Your password is: " .$new_password;
	
	mail($email, $subject,$message, "From: ".$from);

  echo "Check your email. " . $new_password;
}

else
{
	if(filter_var($_SESSION['EMPW'], FILTER_VALIDATE_EMAIL))
  {
    echo "Email not Found.";
  }
  elseif (empty($_SESSION['EMPW'])) 
  {
    echo "Email field is empty.";
  }
  else
  {
    echo "Invalid email format.";
  }
}

((mysqli_free_result($EmailPassword2) || (is_object($EmailPassword2) && (get_class($EmailPassword2) == "mysqli_result"))) ? true : false);
?>