



<!doctype html>
<html>
<head>

<link href="CSS/Layout.css" rel="stylesheet" type="text/css">
<link href="CSS/Menu.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="Javascript/jquery-2.1.3.min.js"></script>
<script type="text/javascript" src="Javascript/w2ui-1.4.2.min.js"></script>
<link rel="stylesheet" type="text/css" href="Javascript/w2ui-1.4.2.min.css" />
<script type="text/javascript" src="Javascript/reg.js"></script>

<meta charset="utf-8">
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
                 <?php include "log.php" ?>
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
    
      <div><p id="returnmessage"></p></div>
      <div id="form" style="width: 680px;">
        <div class="w2ui-page page-0">
            <div class="w2ui-field">
                <label>First Name:</label>
                <div>
                    <input id="first_name" name="first_name" type="text" maxlength="100" size="60"/>
                </div>
            </div>
            <div class="w2ui-field">
                <label>Last Name:</label>
                <div>
                    <input id="last_name" name="last_name" type="text" maxlength="100" size="60"/>
                </div>
            </div>
            <div class="w2ui-field">
                <label>Email:</label>
                <div>
                    <input id="email" name="email" type="email" maxlength="100" size="60"/>
                </div>
            </div>
            <div class="w2ui-field">
                <label>Password:</label>
                <div>
                    <input id="password" name="password" type="password" maxlength="100" size="60"/>
                </div>
            </div>
            <div class="w2ui-field">
                <label>Confirm Password:</label>
                <div>
                    <input id="password_confirm" name="password_confirm" type="password" maxlength="100" size="60"/>
                </div>
            </div>
            <div class="w2ui-field">
                <label>Title:</label>
                <div>
                    <input id="title" name="title" type="text" maxlength="100" size="60"/>
                </div>
            </div>
            <div class="w2ui-field">
                <label>Language:</label>
                <div>
                    <input id="language" name="language" type="text" maxlength="100" size="60"/>
                </div>
            </div>
            <div class="w2ui-field">
                <label>Url:</label>
                <div>
                    <input id="url" name="url" type="text" maxlength="100" size="60"/>
                </div>
            </div>
            <div class="w2ui-field">
                <label>Description:</label>
                <div>
                    <textarea id="description" name="description" type="text" style="width: 385px; height: 80px; resize: none"></textarea>
                </div>
            </div>
            <div class="w2ui-field">
                <label>Preview Picture:</label>
                <div>
                    <input id="picture" name="picture" type="file" style="width: 385px; height: 25px; resize: none">
                </div>
            </div>
            <input id="hidden" type="hidden" name="MM_insert" value="RegisterForm">
        </div>
    
        <div class="w2ui-buttons">
            <button class="btn" name="reset">Reset</button>
            <button class="btn" name="register" id="submit">Register</button>
        </div>
    </div>
    </div>
  </div>
  <div id="Footer">
  </div>
</div>
</body>
</html>

