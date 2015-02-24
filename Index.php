<?php @session_start(); ?>
<?php require_once('Connections/WebCatalogue.php'); ?>
<?php require_once('Helpers/security.php'); ?>


<!doctype html>
<html>
<head>
<link href="CSS/Layout.css" rel="stylesheet" type="text/css">
<link href="CSS/Menu.css" rel="stylesheet" type="text/css">
<link href="font-awesome-4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">

<script src="Javascript/jquery-2.1.3.min.js" type="text/javascript"></script>


<!-- Add fancyBox -->
<link rel="stylesheet" href="Javascript/fancybox/source/jquery.fancybox.css?v=2.1.5" type="text/css" media="screen" />
<script type="text/javascript" src="Javascript/fancybox/source/jquery.fancybox.pack.js?v=2.1.5"></script>

<!-- Optionally add helpers - button, thumbnail and/or media -->
<link rel="stylesheet" href="Javascript/fancybox/source/helpers/jquery.fancybox-buttons.css?v=1.0.5" type="text/css" media="screen" />
<script type="text/javascript" src="Javascript/fancybox/source/helpers/jquery.fancybox-buttons.js?v=1.0.5"></script>
<script type="text/javascript" src="Javascript/fancybox/source/helpers/jquery.fancybox-media.js?v=1.0.6"></script>
<link rel="stylesheet" href="Javascript/fancybox/source/helpers/jquery.fancybox-thumbs.css?v=1.0.7" type="text/css" media="screen" />
<script type="text/javascript" src="Javascript/fancybox/source/helpers/jquery.fancybox-thumbs.js?v=1.0.7"></script>
<!-- Pop Up -->
<script type="text/javascript">
	$(document).ready(function() {
		$(".fancybox").fancybox();
	});
</script>
<meta charset="utf-8">
<title>Main</title>
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
      <h1>Main</h1>
    </div>
    <div id="contentLeft">
      <h2>Links</h2><br>
      <h2><a href="Account.php">Account</a></h2>
      <br>
      <h6>&nbsp;</h6>
    </div>
    <div id="contentRight">
      <?php include "PHP/list.php" ?>
    </div>
  </div>
  <div id="Footer">
    
    <div class="social">
    	<a href="#"><i class="fa fa-facebook fa-2x""></i></a>
        <a href="#"><i class="fa fa-twitter fa-2x""></i></a>
        <a href="#"><i class="fa fa-google-plus fa-2x""></i></a>
    </div>
  </div>
</div>
</body>
</html>
<?php


if(isset($User)) {
((mysqli_free_result($User) || (is_object($User) && (get_class($User) == "mysqli_result"))) ? true : false); }

if(isset($Registration)) {
((mysqli_free_result($Registration) || (is_object($Registration) && (get_class($Registration) == "mysqli_result"))) ? true : false); }

if(isset($ManageUsers)) {
((mysqli_free_result($ManageUsers) || (is_object($ManageUsers) && (get_class($ManageUsers) == "mysqli_result"))) ? true : false); }

if(isset($LogOut)) {
((mysqli_free_result($LogOut) || (is_object($LogOut) && (get_class($LogOut) == "mysqli_result"))) ? true : false); }

?>
