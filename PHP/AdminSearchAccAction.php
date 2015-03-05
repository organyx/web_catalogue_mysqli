<?php require_once('../Helpers/security.php'); ?>
<?php require_once('../Connections/WebCatalogue.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST['DeleteUserHiddenField2'])) && ($_POST['DeleteUserHiddenField2'] != "")) {
  $deleteSQL = sprintf("DELETE FROM `users` WHERE userID=%s",
                       GetSQLValueString($_POST['DeleteUserHiddenField2'], "int"));

  $Result1 = mysqli_query( $WebCatalogue, $deleteSQL) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));

  echo "User Deleted";
}

if ((isset($_POST["MM_update2"])) && ($_POST["MM_update2"] == "ApproveUserForm2")) {
  $updateSQL = sprintf("UPDATE `users` SET approval=CURRENT_TIMESTAMP() WHERE userID=%s",
                       GetSQLValueString($_POST['ApproveIDhiddenField2'], "int"));

  $Result1 = mysqli_query( $WebCatalogue, $updateSQL) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));

  echo "User Approved";
}

if ((isset($_POST["MM_update2"])) && ($_POST["MM_update2"] == "MakeAdminForm2")) {
  $updateSQL = sprintf("UPDATE users SET Userlevel=%s WHERE userID=%s",
                       GetSQLValueString($_POST['MakeUserAdminHiddenField2'], "int"),
                       GetSQLValueString($_POST['MakeUserAdminIDhiddenField2'], "int"));

  $Result1 = mysqli_query( $WebCatalogue, $updateSQL) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));

  echo "User is new Admin";
}

if(isset($_POST['name']))
{
  if(($_POST['name'] != "")){
    $colname_User = "-1";
    if (isset($_SESSION['MM_Username'])) {
      $colname_User = $_POST['name'];
    }

    $query_User = sprintf("SELECT * FROM users WHERE email = %s", GetSQLValueString($colname_User, "text"));
    $User = mysqli_query( $WebCatalogue, $query_User) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    $row_User = mysqli_fetch_assoc($User);
    $totalRows_User = mysqli_num_rows($User);
  }
  else {
    echo "User not specified.";
  }
}

?>

<?php if(isset($_POST['name']) && ($_POST['name'] != "")) { ?>
  <?php if($totalRows_User > 0 ) { ?>
  
    <div id="contentRight">
     
      <table class="TableWidth670 center WidthAuto">
        <tr>
          <td align="center">Account: <?php echo $row_User['email']; ?></td>
        </tr>
        <tr>
          <td><table class="TableWidth500 TableStyle center WidthAuto">
            <tr>
              <td valign="top">&nbsp;</td>
              <td align="right" valign="top">Registration date : </td>
            </tr>
            <tr>
              <td>Title: <?php echo $row_User['title']; ?></td>
              <td><?php echo $row_User['registration']; ?></td>
            </tr>
            <tr>
              <td>URL: <a target="_blank" href="<?php echo $row_User['url']; ?>"> <?php echo $row_User['url']; ?></a></td>
              <td width="145" height="145" rowspan="3" class="TableStyleBorderLeft">
        <a class="fancybox"  href="<?php echo $row_User['preview_thumb']; ?>">
        <img src="<?php echo $row_User['preview_thumb']; ?>" alt="" height="140px" width="140px" class="img-thumbnail">
              </td>
            </tr>
            <tr>
              <td>Languages: <?php echo $row_User['language']; ?></td>
              </tr>
            <tr>
              <td>Description:</td>
              </tr>
            <tr>
              <td colspan="2"><?php echo $row_User['description']; ?></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
      </table>
      
                    <table class="center">
                      <tr>
                        <td><form action="<?php echo $editFormAction; ?>" id="DeleteUserForm2" class="DeleteUserForm2" name="DeleteUserForm2" method="POST">
                          <input name="DeleteUserHiddenField2" type="hidden" id="DeleteUserHiddenField2" class="DeleteUserHiddenField2" value="<?php echo $row_User['userID']; ?>">
                          <input type="submit" name="DeleteUserButton2" id="DeleteUserButton2" class="DeleteUserButton2" value="Delete User">
                        </form></td>
                        <td><form action="<?php echo $editFormAction; ?>" id="ApproveUserForm2" class="ApproveUserForm2" name="ApproveUserForm2" method="POST">
                          <input name="ApproveUserHiddenField2" type="hidden" id="ApproveUserHiddenField2" class="ApproveUserHiddenField2" value="<?php echo "CURRENT_TIMESTAMP()"; ?>">
                          <input name="ApproveIDhiddenField2" type="hidden" id="ApproveIDhiddenField2" class="ApproveIDhiddenField2" value="<?php echo $row_User['userID']; ?>">
                          <input type="submit" name="ApproveUserButton2" id="ApproveUserButton2" class="ApproveUserButton2" value="Approve User">
                          <input type="hidden" name="MM_update2" class="MM_update2" value="ApproveUserForm2">
                        </form></td>
                        <td><form action="<?php echo $editFormAction; ?>" id="MakeAdminForm2" class="MakeAdminForm2" name="MakeAdminForm2" method="POST">
                        <input name="MakeUserAdminHiddenField2" type="hidden" id="ApproveUserHiddenField2" class="ApproveUserHiddenField2" value="<?php echo "2"; ?>">
                          <input type="submit" name="MakeAdminButton2" id="MakeAdminButton2" class="MakeAdminButton2" value="Give Admin Rights">
                          <input name="MakeUserAdminIDhiddenField2" type="hidden" id="ApproveIDhiddenField2" class="ApproveIDhiddenField2" value="<?php echo $row_User['userID']; ?>">
                          <input type="hidden" name="MM_update2" class="MM_update2" value="MakeAdminForm2">
                        </form></td>
                      </tr>
                    </table>
                    
    </div>
    <?php } else { ?>
    <div><p>User not found.</p></div>
    <?php } } ?>