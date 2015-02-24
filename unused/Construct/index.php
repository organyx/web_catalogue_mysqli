<?php include('Top.php'); ?>
<?php require_once('../Connections/WebCatalogue.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

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

$colname_User = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_User = $_SESSION['MM_Username'];
}
mysql_select_db($database_WebCatalogue, $WebCatalogue);
$query_User = sprintf("SELECT * FROM `users` WHERE email = %s", GetSQLValueString($colname_User, "text"));
$User = mysql_query($query_User, $WebCatalogue) or die(mysql_error());
$row_User = mysql_fetch_assoc($User);
$totalRows_User = mysql_num_rows($User);

$maxRows_ManageUsers = 10;
$pageNum_ManageUsers = 0;
if (isset($_GET['pageNum_ManageUsers'])) {
  $pageNum_ManageUsers = $_GET['pageNum_ManageUsers'];
}
$startRow_ManageUsers = $pageNum_ManageUsers * $maxRows_ManageUsers;

mysql_select_db($database_WebCatalogue, $WebCatalogue);
$query_ManageUsers = "SELECT * FROM `users` WHERE NOT `approval` = '0000-00-00 00:00:00' ORDER BY registration DESC";
$query_limit_ManageUsers = sprintf("%s LIMIT %d, %d", $query_ManageUsers, $startRow_ManageUsers, $maxRows_ManageUsers);
$ManageUsers = mysql_query($query_limit_ManageUsers, $WebCatalogue) or die(mysql_error());
$row_ManageUsers = mysql_fetch_assoc($ManageUsers);

if (isset($_GET['totalRows_ManageUsers'])) {
  $totalRows_ManageUsers = $_GET['totalRows_ManageUsers'];
} else {
  $all_ManageUsers = mysql_query($query_ManageUsers);
  $totalRows_ManageUsers = mysql_num_rows($all_ManageUsers);
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
  $MM_fldUserAuthorization = "userID";
  $MM_redirectLoginSuccess = "acc.php";
  $MM_redirectLoginFailed = "index.php";
  $MM_redirecttoReferrer = true;
  mysql_select_db($database_WebCatalogue, $WebCatalogue);
  	
  $LoginRS__query=sprintf("SELECT email, password, userID FROM users WHERE email=%s AND password=%s",
  GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text")); 
   
  $LoginRS = mysql_query($LoginRS__query, $WebCatalogue) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
    
    $loginStrGroup  = mysql_result($LoginRS,0,'userID');
    
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
          <td align="right"><a class="link" href="acc.php">My Account</a></td>
        </tr>
      </table>
      
      <?php }  ?>
<div id="PageHeading">
      <h1>Main</h1>
    </div>
    <div id="contentLeft">
      <h2>Links</h2><br>
      <h2><a href="acc.php">Account</a></h2>
      <br>
      <h6>&nbsp;</h6>
    </div>
    <div id="contentRight">
      <table class="TableStyleBig center WidthAuto">
        <tr>
          <td align="right" valign="top">Showing:&nbsp;<?php echo ($startRow_ManageUsers + 1) ?> to <?php echo min($startRow_ManageUsers + $maxRows_ManageUsers, $totalRows_ManageUsers) ?> of <?php echo $totalRows_ManageUsers ?></td>
        </tr>
        <tr>
          <td align="center" valign="top"><?php if ($totalRows_ManageUsers > 0) { // Show if recordset not empty ?>
              <?php do { ?>
                <table class="TableStyleIndex TableStyle center WidthAuto">
                  <tr>
                    <td width="400" height="33" align="center" ><?php echo $row_ManageUsers['title']; ?></td>
                    <td width="150" height="50" rowspan="3" class="TableStyleBorderLeft"><a class="fancybox"  href="<?php echo $row_ManageUsers['preview_thumb']; ?>"> <img src="<?php echo $row_ManageUsers['preview_thumb']; ?>" alt="" height="140px" width="140px" class="img-thumbnail"/></a></td>
                  </tr>
                  <tr>
                    <td width="400" height="33"><table>
                        <tr>
                          <td width="210" height="30" align="center"><a target="_blank" href="<?php echo $row_ManageUsers['url']; ?>"><?php echo $row_ManageUsers['url']; ?></a></td>
                          <td width="210" height="30" align="center">Language: <?php echo $row_ManageUsers['language']; ?></td>
                        </tr>
                      </table>
                      <a href="<?php echo $row_ManageUsers['url']; ?>"></a></td>
                  </tr>
                  <tr>
                    <td width="400" height="64" valign="top"><?php echo $row_ManageUsers['description']; ?></td>
                  </tr>
                </table>
                <br>
                <?php } while ($row_ManageUsers = mysql_fetch_assoc($ManageUsers)); ?>
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
    </div>
<?php include('Bottom.php'); ?>