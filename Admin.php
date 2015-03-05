<?php @session_start(); ?>
<?php require_once('Connections/WebCatalogue.php'); ?>
<?php require_once('Helpers/security.php'); ?>
<?php include "PHP/adminAccess.php" ?>
<!doctype html>
<html>
<head>

<link href="CSS/Layout.css" rel="stylesheet" type="text/css">
<link href="CSS/Menu.css" rel="stylesheet" type="text/css">

<meta charset="utf-8">
<title>Admin Control Panel</title>
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
            
             <div id="log">
            <?php include "PHP/Login_Include.php" ?>
            </div>
        </nav>
  </div>
  <div id="Content">
    	<div id="PageHeading">
    	  <h1>Admin CP</h1>
   	  </div>
    	<div id="contentLeft">
    	  <h2>Admin links</h2><br>
    	  <h2><a href="Account.php">My Account</a></h2><br>
          <h2><a href="AdminManageUsers.php" >Manage Users</a></h2>
    	  <p>&nbsp;</p>
    	  <br>
    	  <h6>links</h6>
    	</div>
    <div id="contentRight"></div>
  </div>
  <div id="Footer">

    	<p><a href="Admin.php">Admin</a></p>

  </div>
</div>
</body>
</html>
<?php
((mysqli_free_result($User) || (is_object($User) && (get_class($User) == "mysqli_result"))) ? true : false);
?>
