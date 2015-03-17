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

$currentPage = $_SERVER["PHP_SELF"];

$colname_User = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_User = $_SESSION['MM_Username'];
}

$maxRows_ManageUsers = 10;
$pageNum_ManageUsers = 0;
if (isset($_GET['pageNum_ManageUsers'])) {
  $pageNum_ManageUsers = $_GET['pageNum_ManageUsers'];
}
$startRow_ManageUsers = $pageNum_ManageUsers * $maxRows_ManageUsers;

$query_ManageUsers = "SELECT * FROM `users` WHERE NOT `approval` = '0000-00-00 00:00:00' AND NOT `Userlevel` = '2' ORDER BY registration DESC";
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
$i = 0;
?>

    <div id="PageHeading">
      <h1>Main</h1>
    </div>
    <?php if(isset($_SESSION['MM_Username'])) { ?>
    <div id="contentLeft">
      <h2>Links</h2><br>
      <h2><a href="Account.php">Account</a></h2>
    </div>
     <?php } ?>

    <div id="contentRight">
      <table class="width-670 center WidthAuto">
              <tr>
                <td align="right" valign="top">Showing:&nbsp;<?php echo ($startRow_ManageUsers + 1) ?> to <?php echo min($startRow_ManageUsers + $maxRows_ManageUsers, $totalRows_ManageUsers) ?> of <?php echo $totalRows_ManageUsers ?></td>
              </tr>
              <tr>
                <td align="center" valign="top"><?php if ($totalRows_ManageUsers > 0) { // Show if recordset not empty ?>
                    <?php do { ?>
                      <table border="1" class="width-630 TableStyle center WidthAuto">
                        
                        <tr>
                          <td><?php echo ($startRow_ManageUsers + 1) + $i . "." ?></td>
                          <td width="400" height="50" align="center" ><h2><a href="UserWeb.php?a=<?php echo urlencode($row_ManageUsers['userID']); ?>"><?php echo $row_ManageUsers['title']; ?></a></h2></td>
                          <td width="200" rowspan="2" align="center" ><a class="fancybox"  href="<?php echo $row_ManageUsers['preview_thumb']; ?>"> <img src="<?php echo $row_ManageUsers['preview_thumb']; ?>" alt="Preview Thumb" height="140px" width="140px" class="img-thumbnail"/></a></td>
                        </tr>
                        <tr>
                          <td></td>
                          <td height="50" align="center" ><a href="<?php echo $row_ManageUsers['url']; ?>"><?php echo $row_ManageUsers['url']; ?></a></td>
                        </tr>
                      </table>
                      <br>
                      <?php $i++;} while ($row_ManageUsers = mysqli_fetch_assoc($ManageUsers)); ?>
                <?php } // Show if recordset not empty ?></td>
              </tr>
              <tr>
                <td align="right" valign="top"><?php if ($pageNum_ManageUsers < $totalPages_ManageUsers) { // Show if not last page ?>
                    <a href="<?php printf("%s?pageNum_ManageUsers=%d%s", $currentPage, min($totalPages_ManageUsers, $pageNum_ManageUsers + 1), $queryString_ManageUsers); ?>">Next</a>
                    <?php } // Show if not last page ?>
                  |
                  <?php if ($pageNum_ManageUsers > 0) { // Show if not first page ?>
                    <a href="<?php printf("%s?pageNum_ManageUsers=%d%s", $currentPage, max(0, $pageNum_ManageUsers - 1), $queryString_ManageUsers); ?>">Previous</a>
                    <?php } // Show if not first page ?></td>
              </tr>
            </table>

<?php

if(isset($ManageUsers)) {
((mysqli_free_result($ManageUsers) || (is_object($ManageUsers) && (get_class($ManageUsers) == "mysqli_result"))) ? true : false); }

?>

