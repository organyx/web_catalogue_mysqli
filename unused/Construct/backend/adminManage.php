<?php include('../Top.php'); ?>
<?php require_once('../../Helpers/deleteUser.php');	?>
<?php require_once('../../Connections/WebCatalogue.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "2";
$MM_donotCheckaccess = "false";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && false) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "../index.php";
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

$currentPage = $_SERVER["PHP_SELF"];

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST['DeleteUserHiddenField'])) && ($_POST['DeleteUserHiddenField'] != "")) {
  $deleteSQL = sprintf("DELETE FROM `users` WHERE userID=%s",
                       GetSQLValueString($_POST['DeleteUserHiddenField'], "int"));

  ((bool)mysqli_query( $WebCatalogue, "USE $database_WebCatalogue"));
  $Result1 = mysqli_query( $WebCatalogue, $deleteSQL) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));

  $deleteGoTo = "adminManage.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
    $deleteGoTo .= $_SERVER['QUERY_STRING'];
  }

  header(sprintf("Location: %s", $deleteGoTo));
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "ApproveUserForm")) {
  $updateSQL = sprintf("UPDATE `users` SET approval=CURRENT_TIMESTAMP() WHERE userID=%s",
                       GetSQLValueString($_POST['ApproveIDhiddenField'], "int"));

  ((bool)mysqli_query( $WebCatalogue, "USE $database_WebCatalogue"));
  $Result1 = mysqli_query( $WebCatalogue, $updateSQL) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "MakeAdminForm")) {
  $updateSQL = sprintf("UPDATE users SET Userlevel=%s WHERE userID=%s",
                       GetSQLValueString($_POST['MakeUserAdminHiddenField'], "int"),
                       GetSQLValueString($_POST['MakeUserAdminIDhiddenField'], "int"));

  ((bool)mysqli_query( $WebCatalogue, "USE $database_WebCatalogue"));
  $Result1 = mysqli_query( $WebCatalogue, $updateSQL) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
}

$colname_User = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_User = $_SESSION['MM_Username'];
}
((bool)mysqli_query( $WebCatalogue, "USE $database_WebCatalogue"));
$query_User = sprintf("SELECT * FROM `users` WHERE email = %s", GetSQLValueString($colname_User, "text"));
$User = mysqli_query( $WebCatalogue, $query_User) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
$row_User = mysqli_fetch_assoc($User);
$totalRows_User = mysqli_num_rows($User);

$maxRows_ManageUsers = 10;
$pageNum_ManageUsers = 0;
if (isset($_GET['pageNum_ManageUsers'])) {
  $pageNum_ManageUsers = $_GET['pageNum_ManageUsers'];
}
$startRow_ManageUsers = $pageNum_ManageUsers * $maxRows_ManageUsers;

((bool)mysqli_query( $WebCatalogue, "USE $database_WebCatalogue"));
$query_ManageUsers = "SELECT * FROM users ORDER BY registration DESC";
$query_limit_ManageUsers = sprintf("%s LIMIT %d, %d", $query_ManageUsers, $startRow_ManageUsers, $maxRows_ManageUsers);
$ManageUsers = mysqli_query( $WebCatalogue, $query_limit_ManageUsers) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
$row_ManageUsers = mysqli_fetch_assoc($ManageUsers);

if (isset($_GET['totalRows_ManageUsers'])) {
  $totalRows_ManageUsers = $_GET['totalRows_ManageUsers'];
} else {
  $all_ManageUsers = mysqli_query($GLOBALS["___mysqli_ston"], $query_ManageUsers);
  $totalRows_ManageUsers = mysqli_num_rows($all_ManageUsers);
}
$totalPages_ManageUsers = ceil($totalRows_ManageUsers/$maxRows_ManageUsers)-1;

$queryString_ManageUsers = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_ManageUsers") == false && 
        stristr($param, "totalRows_ManageUsers") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_ManageUsers = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_ManageUsers = sprintf("&totalRows_ManageUsers=%d%s", $totalRows_ManageUsers, $queryString_ManageUsers);
?>
<?php if(isset($_SESSION['MM_Username'])) { ?>
              <table width="300" align="right">
                <tr>
                  <td align="right"><label>User: <?php echo $_SESSION['MM_Username']; ?></label></td>
                  <td align="right"><a class="link" href="../logout.php">LogOut</a></td>
                </tr>
                <tr>
               		<td></td>
                	<td align="right"><a class="link" href="../acc.php">My Account</a></td>
                </tr>
              </table>
              
              <?php }  ?>
<div id="PageHeading">
    	  <h1>Admin CP</h1>
   	  </div>
    	<div id="contentLeft">
    	  <h2>Admin links</h2>
    	  <p><?php echo $row_User['email']; ?></p>
    	  <br>
    	  <h2><a href="../acc.php">My Account</a></h2><br>
          <h2><a href="../logout.php">Log Out</a></h2>
    	</div>
    <div id="contentRight">
      <table class="TableWidth670 center WidthAuto">
        <tr>
          <td align="right" valign="top">Showing:&nbsp;<?php echo ($startRow_ManageUsers + 1) ?> to <?php echo min($startRow_ManageUsers + $maxRows_ManageUsers, $totalRows_ManageUsers) ?> of <?php echo $totalRows_ManageUsers ?></td>
        </tr>
        <tr>
          <td align="center" valign="top"><?php if ($totalRows_ManageUsers > 0) { // Show if recordset not empty ?>
            <?php do { ?>
                <table class="TableWidth500 TableStyle center WidthAuto">
                  <tr>
                    <td>Registration Date: <?php echo $row_ManageUsers['registration']; ?></td>
                  </tr>
                  <tr>
                    <td>Approval Date: <?php echo $row_ManageUsers['approval']; ?></td>
                  </tr>
                  <tr>
                    <td>User: <?php echo $row_ManageUsers['first_name']; ?> <?php echo $row_ManageUsers['last_name']; ?> | Account: <?php echo $row_ManageUsers['email']; ?></td>
                  </tr>
                  <tr>
                  	<td>Status: <?php echo ($row_ManageUsers['Userlevel'] == 1 ? "User" : "Admin"); ?></td>     
                  </tr>
                  <tr>
                    <td><table class="center">
                      <tr>
                        <td><form id="DeleteUserForm" name="DeleteUserForm" method="POST">
                          <input name="DeleteUserHiddenField" type="hidden" id="DeleteUserHiddenField" value="<?php echo $row_ManageUsers['userID']; ?>">
                          <input type="submit" name="DeleteUserButton" id="DeleteUserButton" value="Delete User">
                        </form></td>
                        <td><form action="<?php echo $editFormAction; ?>" id="ApproveUserForm" name="ApproveUserForm" method="POST">
                          <input name="ApproveUserHiddenField" type="hidden" id="ApproveUserHiddenField" value="<?php echo "CURRENT_TIMESTAMP()"; ?>">
                          <input name="ApproveIDhiddenField" type="hidden" id="ApproveIDhiddenField" value="<?php echo $row_ManageUsers['userID']; ?>">
                          <input type="submit" name="ApproveUserButton" id="ApproveUserButton" value="Approve User">
                          <input type="hidden" name="MM_update" value="ApproveUserForm">
                        </form></td>
                        <td><form action="<?php echo $editFormAction; ?>" id="MakeAdminForm" name="MakeAdminForm" method="POST">
                        <input name="MakeUserAdminHiddenField" type="hidden" id="ApproveUserHiddenField" value="<?php echo "2"; ?>">
                          <input type="submit" name="MakeAdminButton" id="MakeAdminButton" value="Give Admin Rights">
                          <input name="MakeUserAdminIDhiddenField" type="hidden" id="ApproveIDhiddenField" value="<?php echo $row_ManageUsers['userID']; ?>">
                          <input type="hidden" name="MM_update" value="MakeAdminForm">
                        </form></td>
                      </tr>
                    </table></td>
                  </tr>
                  
                </table>
                <br>
                <?php } while ($row_ManageUsers = mysqli_fetch_assoc($ManageUsers)); ?>
          <?php } // Show if recordset not empty ?></td>
        </tr>
        <tr>
          <td align="right" valign="top"><?php if ($pageNum_ManageUsers < $totalPages_ManageUsers) { // Show if not last page ?>
              <a href="<?php printf("%s?pageNum_ManageUsers=%d%s", $currentPage, min($totalPages_ManageUsers, $pageNum_ManageUsers + 1), $queryString_ManageUsers); ?>">Next</a>
              <?php } // Show if not last page ?>
|
<?php if ($pageNum_ManageUsers > 0) { // Show if not first page ?>
  <a href="<?php printf("%s?pageNum_ManageUsers=%d%s", $currentPage, max(0, $pageNum_ManageUsers - 1), $queryString_ManageUsers); ?>">Previous</a>
  <?php } // Show if not first page ?>          </td>
        </tr>
      </table>
    </div>
<?php include('../Bottom.php'); ?>