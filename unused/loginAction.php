
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
/*
function mysqli_result1() {
  $con=mysqli_connect("localhost","root","","web_catalogue");
  $query = "SELECT `Userlevel` FROM `users` WHERE `email` = '". $_POST['email1'] ."'";
  $result = mysqli_query($con, $query);
  $row2 = mysqli_fetch_assoc($result);


  return $row2['Userlevel'];
}

function mysqli_result2() {
  $con=mysqli_connect("localhost","root","","web_catalogue");
  $query = "SELECT `userID` FROM `users` WHERE `email` = '". $_POST['email1'] ."'";
  $result = mysqli_query($con, $query);
  $row2 = mysqli_fetch_assoc($result);

  return $row2['userID'];
}
*/

if (isset($_POST['email1'])) {
  $loginUsername=$_POST['email1'];
  $password=$_POST['password1'];
  $MM_fldUserAuthorization = "userID";
  $MM_redirectLoginSuccess = "Account.php";
  $MM_redirectLoginFailed = "Index.php";
  $MM_redirecttoReferrer = true;
  ((bool)mysqli_query( $WebCatalogue, "USE $database_WebCatalogue"));
  	
  $LoginRS__query=sprintf("SELECT userID, email, userID FROM users WHERE userID=%s AND email=%s",
  GetSQLValueString($loginUsername, "int"), GetSQLValueString($password, "text")); 
   
  $LoginRS = mysqli_query( $WebCatalogue, $LoginRS__query) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
  $loginFoundUser = mysqli_num_rows($LoginRS);
  if ($loginFoundUser) {
    
   // $loginStrGroup  = mysqli_result($LoginRS,0,'userID');
    $loginStrGroup  = mysqli_result2();
  
    
	if (PHP_VERSION >= 5.1) {session_regenerate_id(true);} else {session_regenerate_id();}
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;	      

    if (isset($_SESSION['PrevUrl']) && true) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
    header("Location: ". $MM_redirectLoginFailed );
  }
}

if (isset($_POST['email1'])) {
  $loginUsername=$_POST['email1'];
  $enc_pass = aes_encrypt($_POST['password1']);
  $password=base64_encode($enc_pass);
  $MM_fldUserAuthorization = "Userlevel";
  $MM_redirectLoginSuccess = "Account.php";
  $MM_redirectLoginFailed = "Index.php";
  $MM_redirecttoReferrer = true;
  ((bool)mysqli_query( $WebCatalogue, "USE $database_WebCatalogue"));
  	
  $LoginRS__query=sprintf("SELECT email, password, Userlevel FROM users WHERE email=%s AND password=%s",
  GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text")); 
   
  $LoginRS = mysqli_query( $WebCatalogue, $LoginRS__query) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
  $loginFoundUser = mysqli_num_rows($LoginRS);
  if ($loginFoundUser) {
	 
   
    //$loginStrGroup  = mysqli_result($LoginRS,0,'Userlevel');
	$loginStrGroup  = mysqli_result1();
  
 
	 if(isset($_SESSION['lvl'])){
         $_SESSION['lvl']=$loginStrGroup;
    }else{
         $_SESSION['lvl']=$loginStrGroup;
    }
    
	if (PHP_VERSION >= 5.1) {session_regenerate_id(true);} else {session_regenerate_id();}
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;	      

    if (isset($_SESSION['PrevUrl']) && true) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
    header("Location: ". $MM_redirectLoginFailed );
  }
}
?>