<?php require_once('Helpers/security.php'); ?>


<!doctype html>
<html>
<head>

<link href="CSS/Layout.css" rel="stylesheet" type="text/css">
<link href="CSS/Menu.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="Javascript/jquery-2.1.3.min.js"></script>
<script type="text/javascript" src="Javascript/reg.js"></script>


<meta charset="utf-8" content="text/html">
<title>Registration Page</title>
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
    	  <h1>Sign Up</h1>
   	  </div>
    	<div id="contentLeft">
    	  <h2>Please fill in your information.</h2><br>
    	  <h6><span class="required">*</span> fields are required</h6>
    	</div>
    <div id="contentRight">
      <?php include "PHP/Register_Include.php" ?>
    </div>
  </div>
  <div id="Footer">
  </div>
</div>
</body>
</html>

