<?php @session_start(); 
	require_once('Helpers/security.php');
	?>

<!doctype html>
<html>
<head>

<link href="CSS/Layout.css" rel="stylesheet" type="text/css">
<link href="CSS/Menu.css" rel="stylesheet" type="text/css">

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
            <?php include "log.php" ?>
            </div>
        </nav>
  </div>
  <div id="Content">
    	<?php include "PHP/up.php"  ?>
  </div>
  <div id="Footer">

  </div>
</div>
</body>
</html>
<?php
mysql_free_result($User);

mysql_free_result($ManageUsers);
?>
