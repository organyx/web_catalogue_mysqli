<?php 
  if(file_exists('Connections/WebCatalogue.php'))
  {
    require_once('Connections/WebCatalogue.php'); 
  }

  if(file_exists('../Connections/WebCatalogue.php'))
  {
    require_once('../Connections/WebCatalogue.php'); 
  }

  if(file_exists('Helpers/security.php'))
  {
    require_once('Helpers/security.php'); 
  }

  if(file_exists('../Helpers/security.php'))
  {
    require_once('../Helpers/security.php'); 
  }

 ?>


<?php

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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

$colname_User = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_User = $_SESSION['MM_Username'];
}

$query_User = sprintf("SELECT * FROM users WHERE email = %s", GetSQLValueString($colname_User, "text"));
$User = mysqli_query( $WebCatalogue, $query_User) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
$row_User = mysqli_fetch_assoc($User);
$totalRows_User = mysqli_num_rows($User);

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
      <form method="POST" id="updateForm" action="javascript:void(null);" >
      <div class="ui-form ui-600">
        <div class="ui-page">
          <div class="ui-field">
                <label></label>
                <div>
                    <p id="returnmessage"></p>
                </div>
            </div>
            <div class="ui-field">
                <label>New Password:</label>
                <div>
                    <input name="password" id="password" type="password" maxlength="100" size="51"/>
                </div>
            </div>
            <div class="ui-field">
                <label>Confirm Password:</label>
                <div>
                    <input name="passwordwc" id="passwordwc" type="password" maxlength="100" size="51" />
                </div>
            </div>
            <div class="ui-field">
                <label>Language:</label>
                <div>
                    <input name="lang" id="lang" type="text" maxlength="100" size="51" value="<?php echo $row_User['language']; ?>"/>
                </div>
            </div>
            <div class="ui-field">
                <label>Url:</label>
                <div>
                    <input name="url" id="url" type="text" maxlength="100" size="51" value="<?php echo $row_User['url']; ?>"/>
                </div>
            </div>
            <div class="ui-field">
                <label>Title:</label>
                <div>
                    <input name="title" id="title" type="text" maxlength="100" size="51" value="<?php echo $row_User['title']; ?>"/>
                </div>
            </div>
            <div class="ui-field">
                <label>Description:</label>
                <div>
                    <textarea name="descr" id="descr" style="width: 385px; height: 80px;"><?php echo $row_User['description']; ?></textarea>
                </div>
            </div>
            <div class="ui-field">
                <div class="up_pic center">
                    <a class="fancybox"  href="<?php echo $row_User['preview_thumb']; ?>"> <img src="<?php echo $row_User['preview_thumb']; ?>" alt="Preview Thumb" height="140px" width="140px" class="img-thumbnail"/></a>
                </div>
            </div>
            <div class="ui-field">
                <label>Picture:</label>
                <div>
                    <input name="file" id="file" type="file" title="file" style="width: 385px; height: 30px;"/>
                </div>
            </div>
            <input name="UserIDhiddenField" type="hidden" id="UserIDhiddenField"  value="<?php echo $row_User['userID']; ?>">  
            <input name="MM_update" type="hidden" id="MM_update" value="UpdateForm">
        </div>
        <div class="ui-buttons">
            <input type="submit" value="Update" name="update" id="update" class="btn">
        </div>
        </div>
    </form>
  
    </div>


<?php
((mysqli_free_result($User) || (is_object($User) && (get_class($User) == "mysqli_result"))) ? true : false);

?>
