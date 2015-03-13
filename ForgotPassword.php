<?php require_once('Connections/WebCatalogue.php'); ?>
<?php require_once('Helpers/security.php'); ?>

<!doctype html>
<html>
<head>
<link href="CSS/Layout.css" rel="stylesheet" type="text/css">
<link href="CSS/Menu.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="Javascript/jquery-2.1.3.min.js"></script>

<script type="text/javascript" src="Javascript/newpass.js"></script>

<meta charset="utf-8">
<title>Forgot Password</title>
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
    	  <h1>Forgot Password</h1>
   	  </div>
    	<div id="contentLeft">
    	  
    	  <h6>Enter your email <br>to recieve new password</h6>
    	</div>
    <div id="contentRight">

        <form method="POST" id="sendPassForm" action="javascript:void(null);" >
       
        <div class="ui-form ui-200">
          <div class="ui-page">
               <div class="ui-field">
                  <div>
                      <p id="returnmessage"></p>
                  </div>
              </div>
              <div class="ui-field">
                  <div class="ui-table">
                      <label>Email:</label>
                      <input name="email" type="email" id="email" maxlength="100" size="51"/>
                  </div>
              </div>
          </div>
      
          <div class="ui-buttons">
              <button type="submit" id="sendPass" class="btn" name="send" >Send</button>
              <button type="button" id="reset" class="btn" name="reset" >Reset</button>
          </div>
        </div>
    </form>

    </div>
  </div>
  <div id="Footer">
  </div>
</div>
</body>
</html>
