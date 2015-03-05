<?php require_once('Connections/WebCatalogue.php'); ?>
<?php
// *** Logout the current user.
$logoutGoTo = "Index.php";
if (!isset($_SESSION)) {
  session_start();
}
$_SESSION['MM_Username'] = NULL;
$_SESSION['MM_UserGroup'] = NULL;
unset($_SESSION['MM_Username']);
unset($_SESSION['MM_UserGroup']);
if ($logoutGoTo != "") {header("Location: $logoutGoTo");
exit;
}
?>

<!doctype html>
<html>
<head>

<link href="CSS/Layout.css" rel="stylesheet" type="text/css">
<link href="CSS/Menu.css" rel="stylesheet" type="text/css">

<meta charset="utf-8">
<title>Untitled Document</title>
</head>

<body>
<div id="Holder">
  <div id="Header"></div>
  <div id="NavBar">
    	<nav>
        	<ul>
            	<li><a href="Index.php">Main</a></li>
                <li><a href="Register.php">Register</a></li>
                <li><a href="ForgotPassword.php">Forgot Password</a></li>
                
            </ul>
        </nav>
  </div>
  <div id="Content">
    	<div id="PageHeading">
    	  <h1>Page Heading</h1>
   	  </div>
    	<div id="contentLeft">
    	  <h2>Your Message</h2><br>
    	  <h6>Your message</h6>
    	</div>
    <div id="contentRight"></div>
  </div>
  <div id="Footer"><p><a href="Admin.php">Admin</a></p></div>
</div>
</body>
</html>

