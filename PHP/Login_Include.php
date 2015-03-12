<?php @session_start(); ?>
<?php 
if(file_exists('Connections/WebCatalogue.php'))
{
  require_once('Connections/WebCatalogue.php'); 
}

if(file_exists('../Connections/WebCatalogue.php'))
{
   require_once('../Connections/WebCatalogue.php'); 
} ?>

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

function getUserLevel() {
  Global $WebCatalogue;
  $query = sprintf("SELECT `Userlevel` FROM `users` WHERE `email` = %s", GetSQLValueString($_POST['Email'], "text"));
  $result = mysqli_query($WebCatalogue, $query);
  $row2 = mysqli_fetch_assoc($result);
  return $row2['Userlevel'];
}

$query_Login = "SELECT * FROM users";
$Login = mysqli_query( $WebCatalogue, $query_Login) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
$row_Login = mysqli_fetch_assoc($Login);
$totalRows_Login = mysqli_num_rows($Login);
?>

<?php

if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['Email'])) {
  $loginUsername=$_POST['Email'];
  // $enc_pass = aes_encrypt($_POST['Password']);
  // $password=base64_encode($enc_pass);
  $password = $_POST['Password'];
  $MM_fldUserAuthorization = "Userlevel";
  $MM_redirectLoginSuccess = "Account.php";
  $MM_redirectLoginFailed = "Index.php";
  $MM_redirecttoReferrer = true;
  	
  $LoginRS__query=sprintf("SELECT email, password, Userlevel FROM users WHERE email=%s",
  GetSQLValueString($loginUsername, "text")); 
   
  $LoginRS = mysqli_query( $WebCatalogue, $LoginRS__query) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
  
  $row_LoginRS = mysqli_fetch_assoc($LoginRS);

  echo $row_LoginRS['password'];
  if(password_verify($password, $row_LoginRS['password']))
  {
    $loginFoundUser = mysqli_num_rows($LoginRS);
  }
  else
  {
    $loginFoundUser = false;
  }

  if ($loginFoundUser) {
	 
    //$loginStrGroup  = mysqli_result($LoginRS,0,'Userlevel');
	$loginStrGroup  = getUserLevel();
  
 
	 if(isset($_SESSION['lvl'])){
         $_SESSION['lvl']=$loginStrGroup;
    }else{
         $_SESSION['lvl']=$loginStrGroup;
    }
    
	if (PHP_VERSION >= 5.1) {session_regenerate_id(true);} else {session_regenerate_id();}
    
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
 <?php if(!isset($_SESSION['MM_Username'])) {?>
      <form ACTION="<?php echo $loginFormAction; ?>" id="LoginForm" name="LoginForm" method="POST">
      <table id="login">
        <tr>
          <td><label for="Email">Email:</label>
          <input type="text" name="Email" id="Email"></td>
          <td class="width-50" rowspan="2"><input type="submit" name="submit" id="submit" value="Submit"></td>
        </tr>
        <tr>
          <td><label for="Password" style="text-align: left">Password:</label>
          <input type="password" name="Password" id="Password"></td>
        </tr>
      </table>
      </form>
      <?php } else { ?>
      <table id="logged" class="width-300">
        <tr>
          <td><label><?php echo $_SESSION['MM_Username']; ?></label></td>
          <td><a class="link" href="LogOut.php">LogOut</a></td>
        </tr>
        <tr>
          <td><?php echo $_SESSION['lvl'] ?></td>
          <td><a class="link" href="Account.php">My Account</a></td>
        </tr>
      </table>
      
      <?php }  
if(isset($Login)) {
((mysqli_free_result($Login) || (is_object($Login) && (get_class($Login) == "mysqli_result"))) ? true : false);}

if(isset($LoginRS)) {
((mysqli_free_result($LoginRS) || (is_object($LoginRS) && (get_class($LoginRS) == "mysqli_result"))) ? true : false);}
?>