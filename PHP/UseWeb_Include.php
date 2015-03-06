<?php 
if(isset($_GET['a'])){
    $_SESSION['link']=$_GET['a'];
 }

?>
<?php
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

$colname_User = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_User = $_SESSION['MM_Username'];
}

$query_User = sprintf("SELECT * FROM users WHERE email = %s", GetSQLValueString($colname_User, "text"));
$User = mysqli_query( $WebCatalogue, $query_User) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
$row_User = mysqli_fetch_assoc($User);
$totalRows_User = mysqli_num_rows($User);

$colname_SelectedUser = "-1";
if (isset($_SESSION['link'])) {
  $colname_SelectedUser = $_SESSION['link'];
}

$query_SelectedUser = sprintf("SELECT * FROM users WHERE userID = %s ORDER BY userID DESC", GetSQLValueString($colname_SelectedUser, "int"));
$SelectedUser = mysqli_query( $WebCatalogue, $query_SelectedUser) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
$row_SelectedUser = mysqli_fetch_assoc($SelectedUser);
$totalRows_SelectedUser = mysqli_num_rows($SelectedUser);
?>


<div id="PageHeading">
    	  <h1><?php echo $row_User['first_name']; ?> <?php echo $row_User['last_name']; ?></h1>
      </div>
    	<div id="contentLeft">
    	  <h2>Account info</h2><br>
        
    	  <h2><a href="Account.php">Account</a></h2><br>
    	  <br>
    	</div>
    <div id="contentRight">
      <table  class="TableWidth670 center WidthAuto">
        <tr>
          <td align="center">&nbsp;</td>
        </tr>
        <tr>
          <td><table id="selectedUser" class="TableStyle center WidthAuto">
            <tr>
              <td align="left" valign="top">Email: <?php echo $row_SelectedUser['email']; ?></td>
              <td align="right" valign="top">Registration date : </td>
            </tr>
            <tr>
              <td>Title: <?php echo $row_SelectedUser['title']; ?></td>
              <td><?php echo $row_SelectedUser['registration']; ?></td>
            </tr>
            <tr>
              <td>URL: <a target="_blank" href="<?php echo $row_SelectedUser['url']; ?>"> <?php echo $row_SelectedUser['url']; ?></a></td>
              <td width="140" height="140" rowspan="3" class="TableStyleBorderLeft">
			  <a class="fancybox"  href="<?php echo $row_SelectedUser['preview_thumb']; ?>">
			  <img src="<?php echo $row_SelectedUser['preview_thumb']; ?>" alt="Preview Thumb" height="140px" width="140px" class="img-thumbnail">
              </td>
            </tr>
            <tr>
              <td>Languages: <?php echo $row_SelectedUser['language']; ?></td>
              </tr>
            <tr>
              <td align="left" valign="bottom">Description:</td>
              </tr>
            <tr>
              <td colspan="2" align="center"><?php echo $row_SelectedUser['description']; ?></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
      </table>
    </div>
    <?php
((mysqli_free_result($User) || (is_object($User) && (get_class($User) == "mysqli_result"))) ? true : false);

((mysqli_free_result($SelectedUser) || (is_object($SelectedUser) && (get_class($SelectedUser) == "mysqli_result"))) ? true : false);
?>