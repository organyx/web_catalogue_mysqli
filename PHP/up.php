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
/*
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
}*/

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
    

     
      <div id="upForm" style="width: 680px">
        <div class="w2ui-page page-0">
          <div class="w2ui-field">
                <label></label>
                <div>
                    <p id="returnmessage"></p>
                </div>
            </div>
            <div class="w2ui-field">
                <label>Password:</label>
                <div>
                    <input name="password" id="password" type="text" maxlength="100" size="60" value="<?php $dec_pass = base64_decode($row_User['password']); echo aes_decrypt($dec_pass);  ?>"/>
                </div>
            </div>
            <div class="w2ui-field">
                <label>Confirm Password:</label>
                <div>
                    <input name="passwordwc" id="passwordwc" type="text" maxlength="100" size="60" value="<?php $dec_pass = base64_decode($row_User['password']); echo aes_decrypt($dec_pass);  ?>"/>
                </div>
            </div>
            <div class="w2ui-field">
                <label>Language:</label>
                <div>
                    <input name="lang" id="lang" maxlength="100" size="60" value="<?php echo $row_User['language']; ?>"/>
                </div>
            </div>
            <div class="w2ui-field">
                <label>Url:</label>
                <div>
                    <input name="url" id="url" maxlength="100" size="60" value="<?php echo $row_User['url']; ?>"/>
                </div>
            </div>
            <div class="w2ui-field">
                <label>Title:</label>
                <div>
                    <input name="title" id="title" maxlength="100" size="60" value="<?php echo $row_User['title']; ?>"/>
                </div>
            </div>
            <div class="w2ui-field">
                <label>Description:</label>
                <div>
                    <textarea name="descr" id="descr" style="width: 385px; height: 80px;"><?php echo $row_User['description']; ?></textarea>
                </div>
            </div>
            <input name="UserIDhiddenField" type="hidden" id="UserIDhiddenField" value="<?php echo $row_User['userID']; ?>">  
            <input name="MM_update" type="hidden" id="MM_update" value="UpdateForm">
        </div>
        <div class="w2ui-buttons">
            <input type="button" value="Reset" name="reset"/>
            <input type="button" value="Update" name="update"/>
        </div>
    </div>
  
    </div>