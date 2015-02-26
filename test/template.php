<!doctype html>
<html>
<head>

<link href="../CSS/Layout.css" rel="stylesheet" type="text/css">
<link href="../CSS/Menu.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../Javascript/jquery-2.1.3.min.js"></script>
<script type="text/javascript" src="../Javascript/w2ui-1.4.2.min.js"></script>
<link rel="stylesheet" type="text/css" href="../Javascript/w2ui-1.4.2.min.css" />
<script type="text/javascript" src="test.js"></script>

<meta charset="utf-8">
<title>Template</title>
</head>

<body>
<div id="Holder">
  <div id="Header"></div>
  <div id="NavBar">
    	<nav>
        	<ul>
            	<li><a href="#">Login</a></li>
                <li><a href="#">Register</a></li>
                <li><a href="#">Forgot Password</a></li>
                
            </ul>
            <?php include "../log.php" ?>
        </nav>
  </div>
  <div id="Content">
      <div id="layout" style="width: 100%; height: 800px;"></div>
  </div>
  <div id="Footer"></div>
</div>
</body>
</html>