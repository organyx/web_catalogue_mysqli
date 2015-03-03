<?php include('Top.php'); ?>
<?php require_once('../Connections/WebCatalogue.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysqli_real_escape_string") ? ((isset($GLOBALS["___mysqli_ston"]) && is_object($GLOBALS["___mysqli_ston"])) ? mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $theValue) : ((trigger_error("[MySQLConverterToo] Fix the mysql_escape_string() call! This code does not work.", E_USER_ERROR)) ? "" : "")) : ((isset($GLOBALS["___mysqli_ston"]) && is_object($GLOBALS["___mysqli_ston"])) ? mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $theValue) : ((trigger_error("[MySQLConverterToo] Fix the mysql_escape_string() call! This code does not work.", E_USER_ERROR)) ? "" : ""));

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
?>
<?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['Email'])) {
  $loginUsername=$_POST['Email'];
  $password=$_POST['Password'];
  $enc_pass = aes_encrypt($_POST['Password']);
  $password=base64_encode($enc_pass);
  $MM_fldUserAuthorization = "";
  $MM_redirectLoginSuccess = "acc.php";
  $MM_redirectLoginFailed = "index.php";
  $MM_redirecttoReferrer = false;
  ((bool)mysqli_query( $WebCatalogue, "USE $database_WebCatalogue"));
  
  $LoginRS__query=sprintf("SELECT email, password FROM users WHERE email=%s AND password=%s",
    GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text")); 
   
  $LoginRS = mysqli_query( $WebCatalogue, $LoginRS__query) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
  $loginFoundUser = mysqli_num_rows($LoginRS);
  if ($loginFoundUser) {
     $loginStrGroup = "";
    
	if (PHP_VERSION >= 5.1) {session_regenerate_id(true);} else {session_regenerate_id();}
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;	      

    if (isset($_SESSION['PrevUrl']) && false) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
    header("Location: ". $MM_redirectLoginFailed );
  }
} ?>
   <?php
                if(!isset($_SESSION['MM_Username'])) {?>

                  <form ACTION="<?php echo $loginFormAction; ?>" id="LoginForm" name="LoginForm" method="POST">
                  <table width="300" align="right">
                    <tr>
                      <td align="right"><label for="Email">Email:</label>
                      <input type="text" name="Email" id="Email"></td>
                      <td width="50" rowspan="2"><input type="submit" name="submit" id="submit" value="Submit"></td>
                    </tr>
                    <tr>
                      <td style="text-align: right"><label for="Password" style="text-align: left">Password:</label>
                      <input type="password" name="Password" id="Password"></td>
                    </tr>
                  </table>
                  </form>
                  <?php } else { ?>
                  <table width="300" align="right">
                    <tr>
                      <td align="right"><label>User: <?php echo $_SESSION['MM_Username']; ?></label></td>
                      <td align="right"><a class="link" href="logout.php">LogOut</a></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td align="right"><a class="link" href="Account.php">My Account</a></td>
                    </tr>
                  </table>
                  
                  <?php }  ?>


    	<div id="PageHeading">
    	  <h1>Forgot Password</h1>
   	  </div>
    	<div id="contentLeft">
    	  
    	  <h6>Type in your email <br>to recieve your password</h6>
    	</div>
    <div id="contentRight">
      <form action="../Helpers/EMPW-Script.php" method="post" name="EMPWForm" id="EMPWForm"> 
      <table class="center TableWidth500 WidthAuto">
      <tr><td>&nbsp;</td></tr>
        <tr>
          <td> <label for="EMPWEmail"><h6>Email:</h6><br></label>
        		<input name="EMPWEmail" type="text" class="styletxtfield" id="EMPWEmail"></td>
        </tr>
        <tr>
          <td><input type="submit" name="EMPWButton" id="EMPWButton" value="Email Password"></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
      </table>
      </form>
    </div>
<?php include('Bottom.php'); ?>