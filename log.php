<?php @session_start(); ?>
<?php require_once('Connections/WebCatalogue.php'); ?>

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

function mysqli_result1() {

  //$a = mysqli_query($WebCatalogue, "SELECT userID FROM users WHERE 'email' = '". $_SESSION['MM_Username']."'");
  //$b = mysqli_fetch_assoc($a);

  //((bool)mysqli_query( $WebCatalogue, "USE $database_WebCatalogue"));
  $con=mysqli_connect("localhost","root","","web_catalogue");
  $query = "SELECT `Userlevel` FROM `users` WHERE `email` = '". $_POST['Email'] ."'";
  $result = mysqli_query($con, $query);
  $row2 = mysqli_fetch_assoc($result);

  //$res->data_seek($row);
  //mysqli_data_seek($res, $row);
 // $datarow = $res->fetch_array();
  //$datarow = mysql_fetch_array($d);
  return $row2['Userlevel'];
}

function mysqli_result2() {

  //$a = mysqli_query($WebCatalogue, "SELECT userID FROM users WHERE 'email' = '". $_SESSION['MM_Username']."'");
  //$b = mysqli_fetch_assoc($a);

  //((bool)mysqli_query( $WebCatalogue, "USE $database_WebCatalogue"));
  $con=mysqli_connect("localhost","root","","web_catalogue");
  $query = "SELECT `userID` FROM `users` WHERE `email` = '". $_POST['Email'] ."'";
  $result = mysqli_query($con, $query);
  $row2 = mysqli_fetch_assoc($result);

  //$res->data_seek($row);
  //mysqli_data_seek($res, $row);
 // $datarow = $res->fetch_array();
  //$datarow = mysql_fetch_array($d);
  return $row2['userID'];
}

((bool)mysqli_query( $WebCatalogue, "USE $database_WebCatalogue"));
$query_Login = "SELECT * FROM users";
$Login = mysqli_query( $WebCatalogue, $query_Login) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
$row_Login = mysqli_fetch_assoc($Login);
$totalRows_Login = mysqli_num_rows($Login);
$query_Login = "SELECT * FROM users";
$Login = mysqli_query( $WebCatalogue, $query_Login) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
$row_Login = mysqli_fetch_assoc($Login);
$totalRows_Login = mysqli_num_rows($Login);
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
  $enc_pass = aes_encrypt($_POST['Password']);
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
 <?php if(!isset($_SESSION['MM_Username'])) {?>
      <form ACTION="<?php echo $loginFormAction; ?>" id="LoginForm" name="LoginForm" method="POST">
      <table width="300" align="right">
        <tr>
          <td align="right"><label for="Email">Email:</label>
          <input type="text" name="Email" id="Email"></td>
          <td width="50" rowspan="2"><input type="submit" name="submit" id="submit" value="Submit"></td>
        </tr>
        <tr>
          <td align="right"><label for="Password" style="text-align: left">Password:</label>
          <input type="password" name="Password" id="Password"></td>
        </tr>
      </table>
      </form>
      <?php } else { ?>
      <table width="300" align="right">
        <tr>
          <td align="right"><label>User: <?php echo $_SESSION['MM_Username']; ?></label></td>
          <td align="right"><a class="link" href="LogOut.php">LogOut</a></td>
        </tr>
        <tr>
          <td><?php echo $_SESSION['lvl'] ?></td>
          <td align="right"><a class="link" href="Account.php">My Account</a></td>
        </tr>
      </table>
      
      <?php }  
((mysqli_free_result($Login) || (is_object($Login) && (get_class($Login) == "mysqli_result"))) ? true : false);

?>