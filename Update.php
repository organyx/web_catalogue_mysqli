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
((mysqli_free_result($User) || (is_object($User) && (get_class($User) == "mysqli_result"))) ? true : false);

((mysqli_free_result($ManageUsers) || (is_object($ManageUsers) && (get_class($ManageUsers) == "mysqli_result"))) ? true : false);
?>
