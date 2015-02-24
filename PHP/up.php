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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if(isset($_POST["MM_update"]))
{
	$passwordConfirm = $_POST['Password'];
	$secure_password = aes_encrypt($passwordConfirm);
	$secure_password = base64_encode($secure_password);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "UpdateForm")) {
  $updateSQL = sprintf("UPDATE users SET password=%s, language=%s, url=%s, title=%s, `description`=%s WHERE userID=%s",
                       GetSQLValueString($secure_password, "text"),
					   GetSQLValueString($_POST['Language'], "text"),
                       GetSQLValueString($_POST['URL'], "text"),
                       GetSQLValueString($_POST['Title'], "text"),
                       GetSQLValueString($_POST['Description'], "text"),
                       GetSQLValueString($_POST['UserIDhiddenField'], "int"));

  ((bool)mysqli_query( $WebCatalogue, "USE $database_WebCatalogue"));
  $Result1 = mysqli_query( $WebCatalogue, $updateSQL) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));

  $updateGoTo = "Account.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_User = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_User = $_SESSION['MM_Username'];
}
((bool)mysqli_query( $WebCatalogue, "USE $database_WebCatalogue"));
$query_User = sprintf("SELECT * FROM users WHERE email = %s", GetSQLValueString($colname_User, "text"));
$User = mysqli_query( $WebCatalogue, $query_User) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
$row_User = mysqli_fetch_assoc($User);
$totalRows_User = mysqli_num_rows($User);

((bool)mysqli_query( $WebCatalogue, "USE $database_WebCatalogue"));
$query_ManageUsers = "SELECT * FROM users ORDER BY registration DESC";
$ManageUsers = mysqli_query( $WebCatalogue, $query_ManageUsers) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
$row_ManageUsers = mysqli_fetch_assoc($ManageUsers);
$totalRows_ManageUsers = mysqli_num_rows($ManageUsers);
?>

<div id="PageHeading">
    	  <h1>Welcome,  <?php echo $row_User['first_name']; ?> <?php echo $row_User['last_name']; ?>!</h1>
      </div>
    	<div id="contentLeft">
    	  <h2>Update Your Account</h2><br>
          <h2><a href="Account.php">My Account</a></h2><br>
    	  <h2><a href="LogOut.php">Log Out</a></h2><br>
    	  <br>
    	  <h6>&nbsp;</h6>
    	</div>
    <div id="contentRight">
      <table class="TableStyleBig center WidthAuto">
        <tr>
          <td align="center">Account: <?php echo $row_User['email']; ?></td>
        </tr>
        <tr>
          <td><form action="<?php echo $editFormAction; ?>" id="UpdateForm" name="UpdateForm" method="POST"><table class="TableStyleRegUp WidthAuto" align="center">
            <tr>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td><table>
                <tr class="updateLayout">
                  <td><label for="Password">Password:</label><br><br>
                    <input name="Password" type="password" class="styletxtfield" id="Password" value="<?php $dec_pass = base64_decode($row_User['password']); echo aes_decrypt($dec_pass);  ?>"></td>
                  <td><label for="PasswordConfirm">Confirm Password:</label><br><br>
                    <input name="PasswordConfirm" type="password" class="styletxtfield" id="PasswordConfirm" value="<?php $dec_pass = base64_decode($row_User['password']); echo aes_decrypt($dec_pass);  ?>"></td>
                </tr>
              </table></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td><label for="Language">Language:</label><br><br>
                <input name="Language" type="text" class="styletxtfield" id="Language" value="<?php echo $row_User['language']; ?>"></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td><label for="URL">Url:</label><br><br>
                <input name="URL" type="text" class="styletxtfield" id="URL" value="<?php echo $row_User['url']; ?>"></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td><label for="Title">Title:</label><br><br>
                <input name="Title" type="text" class="styletxtfield" id="Title" value="<?php echo $row_User['title']; ?>"></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td><label for="Description">Description:</label><br><br>
                <input name="Description" type="text" class="styletxtarea" id="Description" value="<?php echo $row_User['description']; ?>"></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td><input name="UserIDhiddenField" type="hidden" id="UserIDhiddenField" value="<?php echo $row_User['userID']; ?>">                <input type="submit" name="UpdateButton" id="UpdateButton" value="Update Account"></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
            </tr>
          </table>
              <input type="hidden" name="MM_update" value="UpdateForm">
          </form>
            
          </td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
      </table>
    </div>