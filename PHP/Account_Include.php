<?php
if(file_exists('Helpers/security.php'))
{
  require_once('Helpers/security.php'); 
}

if(file_exists('../Helpers/security.php'))
{
  require_once('../Helpers/security.php'); 
}

if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "1";
$MM_donotCheckaccess = "true";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, access may be restricted to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, access can be restricted to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && true) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "Index.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) 
  $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>
<?php

$colname_User = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_User = $_SESSION['MM_Username'];
}

$query_User = sprintf("SELECT * FROM users WHERE email = %s", GetSQLValueString($colname_User, "text"));
$User = mysqli_query( $WebCatalogue, $query_User) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
$row_User = mysqli_fetch_assoc($User);
$totalRows_User = mysqli_num_rows($User);

$query_ManageUsers = "SELECT * FROM users ORDER BY registration DESC";
$ManageUsers = mysqli_query( $WebCatalogue, $query_ManageUsers) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
$row_ManageUsers = mysqli_fetch_assoc($ManageUsers);
$totalRows_ManageUsers = mysqli_num_rows($ManageUsers);
?>

<div id="PageHeading">
    	  <h1>Welcome,  <?php echo $row_User['first_name']; ?> <?php echo $row_User['last_name']; ?>!</h1>
      </div>
    	<div id="contentLeft">
    	  <h2>Account links</h2><br>
          <?php if ($_SESSION['lvl'] == 2) { ?>
          <h2><a href="AdminManageUsers.php">Manage Users</a></h2><br>
          <?php } ?>
    	  <h2><a href="Update.php">Update Account</a></h2><br>
    	  <h2><a href="LogOut.php">Log Out</a></h2>
    	</div>
    <div id="contentRight">
      <table class="width-670 center WidthAuto">
        <tr>
          <td align="center">Account: <?php echo $row_User['email']; ?></td>
        </tr>
        <tr>
          <td><table class="width-500 TableStyle center WidthAuto">
            <tr>
              <td><?php echo ($row_User['approval'] == "0000-00-00 00:00:00") ? "Awaiting Approval" : "Approved" ?></td>
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
        			  <img src="<?php echo $row_User['preview_thumb']; ?>" alt="Preview Thumb" height="140px" width="140px" class="img-thumbnail">
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
    </div>


<?php
if(isset($User)) {
((mysqli_free_result($User) || (is_object($User) && (get_class($User) == "mysqli_result"))) ? true : false); }

if(isset($ManageUsers)) {
((mysqli_free_result($ManageUsers) || (is_object($ManageUsers) && (get_class($ManageUsers) == "mysqli_result"))) ? true : false); }
?>
