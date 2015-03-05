<?php @session_start(); 
	require_once('Helpers/security.php');
	?>

<!doctype html>
<html>
<head>

<link href="CSS/Layout.css" rel="stylesheet" type="text/css">
<link href="CSS/Menu.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="Javascript/jquery-2.1.3.min.js"></script>
<script type="text/javascript" src="Javascript/up.js"></script>

<meta charset="utf-8">
<title>Update Account</title>
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
            <?php include "Login_Include.php" ?>
            </div>
        </nav>
  </div>
  <div id="Content">
    	<?php include "PHP/Update_include.php"  ?>
  </div>
  <div id="Footer">

  </div>
</div>
</body>
</html>
<?php
((mysqli_free_result($User) || (is_object($User) && (get_class($User) == "mysqli_result"))) ? true : false);

?>
