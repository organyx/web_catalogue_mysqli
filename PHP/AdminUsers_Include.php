<?php  

if(file_exists('Helpers/security.php') || file_exists('Connections/WebCatalogue.php'))
{
  require_once('Helpers/security.php'); 
  require_once('Connections/WebCatalogue.php'); 
}


if(file_exists('../Helpers/security.php') || file_exists('../Connections/WebCatalogue.php'))
{
  require_once('../Helpers/security.php'); 
   require_once('../Connections/WebCatalogue.php'); 
}

?>


<?php

if(!function_exists("GetUserByID"))
{
  function GetUserByID($id)
  {
    Global $WebCatalogue;

    $query_User = sprintf("SELECT * FROM `users` WHERE userID = %s", GetSQLValueString($id, "text"));
    $User = mysqli_query( $WebCatalogue, $query_User) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    $row_User = mysqli_fetch_assoc($User);
    return $row_User['email'];
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

  $Result1 = mysqli_query( $WebCatalogue, $deleteSQL) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));

  echo "User " . GetUserByID($_POST['DeleteUserHiddenField']) . " has been Deleted";
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "ApproveUserForm")) {
  $updateSQL = sprintf("UPDATE `users` SET approval=CURRENT_TIMESTAMP() WHERE userID=%s",
                       GetSQLValueString($_POST['ApproveIDhiddenField'], "int"));

  $Result1 = mysqli_query( $WebCatalogue, $updateSQL) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));

  echo "User " . GetUserByID($_POST['ApproveIDhiddenField']) . " is Approved";
}

// if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "MakeAdminForm")) {
//   $updateSQL = sprintf("UPDATE users SET Userlevel=%s WHERE userID=%s",
//                        GetSQLValueString($_POST['MakeUserAdminHiddenField'], "int"),
//                        GetSQLValueString($_POST['MakeUserAdminIDhiddenField'], "int"));

//   $Result1 = mysqli_query( $WebCatalogue, $updateSQL) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));

//   echo "User " . GetUserByID($_POST['MakeUserAdminIDhiddenField']) . " is new Admin";
// }

$colname_User = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_User = $_SESSION['MM_Username'];
}

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


$query_ManageUsers = "SELECT * FROM users WHERE NOT `Userlevel` = '2' ORDER BY registration DESC";
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

<table class="width-670 center WidthAuto">
        <tr>
          <td align="right" valign="top">Showing:&nbsp;<?php echo ($startRow_ManageUsers + 1) ?> to <?php echo min($startRow_ManageUsers + $maxRows_ManageUsers, $totalRows_ManageUsers) ?> of <?php echo $totalRows_ManageUsers ?></td>
        </tr>
        <tr>
          <td align="center" valign="top"><?php if ($totalRows_ManageUsers > 0) { // Show if recordset not empty ?>
            <?php do { ?>
                <table class="width-500 TableStyle center WidthAuto">
                  <tr>
                    <td>Registration Date: <?php echo $row_ManageUsers['registration']; ?></td>
                  </tr>
                  <tr>
                    <td 

                    <?php if($row_ManageUsers['approval'] == "0000-00-00 00:00:00") {?> 
                      style="color:red;"
                    <?php } else { ?>
                      style="color:green;"
                     <?php } ?>

                    >Approval Date: <?php echo $row_ManageUsers['approval']; ?></td>
                  </tr>
                  <tr>
                    <td>User: <?php echo $row_ManageUsers['first_name']; ?> <?php echo $row_ManageUsers['last_name']; ?> | Account: <?php echo $row_ManageUsers['email']; ?></td>
                  </tr>
                  <tr>
                  	<td>Status: <?php echo ($row_ManageUsers['approval'] !== "0000-00-00 00:00:00" ? "Approved" : "Awaiting Approval"); ?></td>     
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
                        <!--
                        <td><form action="<?php echo $editFormAction; ?>" id="MakeAdminForm" name="MakeAdminForm" method="POST">
                        <input name="MakeUserAdminHiddenField" type="hidden" id="ApproveUserHiddenField" value="<?php echo "2"; ?>">
                          <input type="submit" name="MakeAdminButton" id="MakeAdminButton" value="Give Admin Rights">
                          <input name="MakeUserAdminIDhiddenField" type="hidden" id="ApproveIDhiddenField" value="<?php echo $row_ManageUsers['userID']; ?>">
                          <input type="hidden" name="MM_update" value="MakeAdminForm">
                        </form></td>
                        -->
                      </tr>
                    </table></td>
                  </tr>
                  
                </table>
                <br>
                <?php } while ($row_ManageUsers = mysqli_fetch_assoc($ManageUsers)); ?>
          <?php } // Show if recordset not empty ?></td>
        </tr>
        <tr>
          <td align="right" valign="top">
              <?php if ($pageNum_ManageUsers < $totalPages_ManageUsers) { // Show if not last page ?>
              <a href="<?php printf("%s?pageNum_ManageUsers=%d%s", $currentPage, min($totalPages_ManageUsers, $pageNum_ManageUsers + 1), $queryString_ManageUsers); ?>">Next</a>
              <?php } // Show if not last page ?>
              |
              <?php if ($pageNum_ManageUsers > 0) { // Show if not first page ?>
                <a href="<?php printf("%s?pageNum_ManageUsers=%d%s", $currentPage, max(0, $pageNum_ManageUsers - 1), $queryString_ManageUsers); ?>">Previous</a>
              <?php } // Show if not first page ?>
          </td>
        </tr>
      </table>
<?php
if(isset($User)){
((mysqli_free_result($User) || (is_object($User) && (get_class($User) == "mysqli_result"))) ? true : false);}
if(isset($ManageUsers)){
((mysqli_free_result($ManageUsers) || (is_object($ManageUsers) && (get_class($ManageUsers) == "mysqli_result"))) ? true : false);}
?>

