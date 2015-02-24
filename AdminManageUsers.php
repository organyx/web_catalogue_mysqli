<?php @session_start(); 
	require_once('Helpers/deleteUser.php');				?>
<?php require_once('Helpers/security.php'); ?>
<?php require_once('Connections/WebCatalogue.php'); ?>

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
            <?php include "log.php" ?>
            </div>
        </nav>
  </div>
  <div id="Content">
    	<div id="PageHeading">
    	  <h1>Admin CP</h1>
   	  </div>
    	<div id="contentLeft">
    	  <h2>Admin links</h2>
    	  <br>
    	  <h2><a href="Account.php">My Account</a></h2><br>
          <h2><a href="LogOut.php">Log Out</a></h2>
    	</div>
    <div id="contentRight">
      <?php include "PHP/adminUsers.php" ?>
    </div>
  </div>
  <div id="Footer">

    	<p><a href="Admin.php">Admin</a></p>

  </div>
</div>
</body>
</html>
