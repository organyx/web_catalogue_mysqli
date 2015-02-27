<?php require_once('../Connections/WebCatalogue.php'); 
      require_once('../Helpers/security.php');
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

//echo "<pre>" . print_r($_POST) . "</pre>";

$passCheck = false;
$passwordToConfirm = $_POST['password'];
$passwordConfirm = $_POST['passwordwc'];
if(isset($_POST["MM_update"]) && isset($passwordToConfirm) &&(isset($passwordConfirm)))
{
	if($passwordToConfirm !== $passwordConfirm) 
  {
    echo "Passwords don't match. ";
    $passCheck = false;
  }
  else
  {
    $passwordConfirm = $_POST['password'];
    $cleansedstring = preg_replace('#\W#', '', $passwordConfirm);
    //$secure_password = aes_encrypt($passwordConfirm);
    //$secure_password = base64_encode($secure_password);
    $secure_password = aes_encrypt($cleansedstring);
    $secure_password = base64_encode($secure_password);
    $passCheck = true;
    //echo $passwordConfirm . "<br/>";
    //echo aes_encrypt($passwordConfirm) . "<br/>";
    //echo $secure_password . "<br/>";
  }
}


if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "UpdateForm") && ($passCheck == true)) {
  $updateSQL = sprintf("UPDATE users SET password=%s, language=%s, url=%s, title=%s, `description`=%s WHERE userID=%s",
                       GetSQLValueString($secure_password, "text"),
					             GetSQLValueString($_POST['lang'], "text"),
                       GetSQLValueString($_POST['url'], "text"),
                       GetSQLValueString($_POST['title'], "text"),
                       GetSQLValueString($_POST['descr'], "text"),
                       GetSQLValueString($_POST['UserIDhiddenField'], "int"));

  ((bool)mysqli_query( $WebCatalogue, "USE $database_WebCatalogue"));
  $Result1 = mysqli_query( $WebCatalogue, $updateSQL) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
/*
  $updateGoTo = "Account.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));*/
  //echo $_POST['password1'] . " " . $_POST['lang1'] . " " . $_POST['url1'] . " " . $_POST['title1'] . " " . $_POST['descr1'] . " " . $_POST['userID1'];
  echo "Record Updated";
}
else {
  echo "Update Failed";
}


?>
