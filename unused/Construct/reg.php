<?php include('Top.php'); ?>
<?php require_once('../Connections/WebCatalogue.php'); ?>
<?php

if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

// *** Redirect if username exists
$MM_flag="MM_insert";
if (isset($_POST[$MM_flag])) {
  $MM_dupKeyRedirect="reg.php";
  $loginUsername = $_POST['Email'];
  $LoginRS__query = sprintf("SELECT email FROM `users` WHERE email=%s", GetSQLValueString($loginUsername, "text"));
  mysql_select_db($database_WebCatalogue, $WebCatalogue);
  $LoginRS=mysql_query($LoginRS__query, $WebCatalogue) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);

  //if there is a row in the database, the username was found - can not add the requested username
  if($loginFoundUser){
    $MM_qsChar = "?";
    //append the username to the redirect page
    if (substr_count($MM_dupKeyRedirect,"?") >=1) $MM_qsChar = "&";
    $MM_dupKeyRedirect = $MM_dupKeyRedirect . $MM_qsChar ."requsername=".$loginUsername;
    header ("Location: $MM_dupKeyRedirect");
    exit;
	
  }
  
  $passwordToConfirm = $_POST['Password'];
  $passwordConfirm = $_POST['PasswordConfirm'];
  if($passwordToConfirm != $passwordConfirm)
  {
	  echo "Passwords don't match";
    header ("Location: $MM_dupKeyRedirect");
    exit;
  }
  else
  {
	  $secure_password = aes_encrypt($passwordConfirm);
	  $secure_password = base64_encode($secure_password);
  }
  
  $default_picture = "../Assets/img/default.png/";
  $user_folder_path = "../Assets/img/" . basename($_POST['Email']) . "/";

 	if (!file_exists($user_folder_path)) 
 	{
	   $dir = mkdir($user_folder_path, 0777, true);
	}
	
	if(($_FILES["PreviewPicture"]["size"] == 0))
	{
		copy("../Assets/img/default.png", "../Assets/img/" . basename($_POST['Email']) . "/default.png");
	}
	
 	$target_dir = "../Assets/img/" . basename($_POST['Email']) . "/";
	$target_file = $target_dir . basename($_FILES["PreviewPicture"]["name"]);
	$uploadOk = 1;
	$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
	// Check if image file is a actual image or fake image
	if(isset($_POST["submit"])) {
	    $check = getimagesize($_FILES["PreviewPicture"]["tmp_name"]);
	    if($check !== false) {
	        echo "File is an image - " . $check["mime"] . ".";
	        $uploadOk = 1;
	    } else {
	        echo "File is not an image.";
	        $uploadOk = 0;
	        echo "File is not an image.";
	    }
	}
	// Check file size
	if ($_FILES["PreviewPicture"]["size"] > 2000000) {
	    echo "Sorry, your file is too large.";
	    $uploadOk = 0;
	}
	// Check if file already exists
	if (file_exists($target_file)) {
	     echo "Sorry, file already exists.";
	    $uploadOk = 0;
	} 
	// Allow certain file formats
	if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
	&& $imageFileType != "gif" ) {
		echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
	    $uploadOk = 0;
	} 
	// Check if $uploadOk is set to 0 by an error
	if ($uploadOk == 0) {
	    echo "Sorry, your file was not uploaded.";
	// if everything is ok, try to upload file
	} else {
	    if (move_uploaded_file($_FILES["PreviewPicture"]["tmp_name"], $target_file)) {
	        echo "The file ". basename( $_FILES["PreviewPicture"]["name"]). " has been uploaded.";
	    } else {
	         echo "Sorry, your file was not uploaded.";
	    }
	}

	if(($_FILES["PreviewPicture"]["size"] == 0))
	{
		$user_printscreen_location = $user_folder_path . "default.png";
	}
	else
	{
		$user_printscreen_location = $target_file;
	}
	
}





$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "RegisterForm")) {
  $insertSQL = sprintf("INSERT INTO users (email, password, first_name, last_name, `language`, url, title, `description`, preview, preview_thumb) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['Email'], "text"),
                       GetSQLValueString($secure_password, "text"),
                       GetSQLValueString($_POST['FirstName'], "text"),
                       GetSQLValueString($_POST['LastName'], "text"),
                       GetSQLValueString($_POST['Language'], "text"),
                       GetSQLValueString($_POST['Url'], "text"),
                       GetSQLValueString($_POST['Title'], "text"),
                       GetSQLValueString($_POST['Description'], "text"),
                       GetSQLValueString($user_printscreen_location, "text"),
                       GetSQLValueString($user_printscreen_location, "text"));

  mysql_select_db($database_WebCatalogue, $WebCatalogue);
  $Result1 = mysql_query($insertSQL, $WebCatalogue) or die(mysql_error());

  $insertGoTo = "index.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_WebCatalogue, $WebCatalogue);
$query_Registration = "SELECT * FROM `users`";
$Registration = mysql_query($query_Registration, $WebCatalogue) or die(mysql_error());
$row_Registration = mysql_fetch_assoc($Registration);
$totalRows_Registration = mysql_num_rows($Registration);
$query_Registration = "SELECT * FROM users";
$Registration = mysql_query($query_Registration, $WebCatalogue) or die(mysql_error());
$row_Registration = mysql_fetch_assoc($Registration);
$totalRows_Registration = mysql_num_rows($Registration);
?>
<?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['Email'])) {
  $loginUsername=$_POST['Email'];
  $password=$_POST['Password'];
$enc_pass = aes_encrypt($_POST['Password']);
  $password=base64_encode($enc_pass);
  $MM_fldUserAuthorization = "userID";
  $MM_redirectLoginSuccess = "Account.php";
  $MM_redirectLoginFailed = "Index.php";
  $MM_redirecttoReferrer = true;
  mysql_select_db($database_WebCatalogue, $WebCatalogue);
  	
  $LoginRS__query=sprintf("SELECT email, password, userID FROM users WHERE email=%s AND password=%s",
  GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text")); 
   
  $LoginRS = mysql_query($LoginRS__query, $WebCatalogue) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
    
    $loginStrGroup  = mysql_result($LoginRS,0,'userID');
    
	if (PHP_VERSION >= 5.1) {session_regenerate_id(true);} else {session_regenerate_id();}
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;	      

    if (isset($_SESSION['PrevUrl']) && true) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
    header("Location: ". $MM_redirectLoginFailed );
  }
}
?>

   <?php if(!isset($_SESSION['MM_Username'])) {?>
                  <form ACTION="<?php echo $loginFormAction; ?>" id="LoginForm" name="LoginForm" method="POST">
                  <table width="300" align="right">
                    <tr>
                      <td align="right"><label for="Email">Email:</label>
                      <input type="text" name="Email" id="Email"></td>
                      <td width="50" rowspan="2"><input type="submit" name="submit" id="submit" value="Submit"></td>
                    </tr>
                    <tr>
                      <td style="text-align: right"><label for="Password" style="text-align: left">Password:</label>
                      <input type="password" name="Password" id="Password"></td>
                    </tr>
                  </table>
                  </form>
                  <?php } else { ?>
                  <table width="300" align="right">
                    <tr>
                      <td align="right"><label>User: <?php echo $_SESSION['MM_Username']; ?></label></td>
                      <td align="right"><a class="link" href="LogOut.php">LogOut</a></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td align="right"><a class="link" href="Account.php">My Account</a></td>
                    </tr>
                  </table>
                  
                  <?php }  ?>
	<div id="PageHeading">
    	  <h1>Sign Up</h1>
   	  </div>
    	<div id="contentLeft">
    	  <h2>Please fill in your information.</h2><br>
    	  <h6><span class="required">*</span> fields are required</h6>
    	</div>
    <div id="contentRight">
      <form action="<?php echo $editFormAction; ?>" method="POST" enctype="multipart/form-data" name="RegisterForm" id="RegisterForm">
        <table class="TableStyleBig center WidthAuto">
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><table class="TableStyleRegUp center WidthAuto">
              <tr>
                <td><table >
                  <tr class="updateLayout">
                    <td><label for="FirstName">
                      <h6>First Name <span class="required">*</span> :</h6>
                      <br>
                      </label>
                      <input name="FirstName" type="text" required="required" class="styletxtfield" id="FirstName"></td>
                    <td><label for="LastName">
                      <h6>Last Name:</h6>
                      <br>
                      </label>
                      <input name="LastName" type="text" class="styletxtfield" id="LastName"></td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td><label for="Email">
                  <h6>Email <span class="required">*</span> :</h6>
                  <br>
                  </label>
                  <input name="Email" type="email" required="required" class="styletxtfield" id="Email"></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td><table border="0">
                  <tr class="updateLayout">
                    <td><label for="Password">
                      <h6>Password <span class="required">*</span> :</h6>
                      </label>
                      <input name="Password" type="password" required="required" class="styletxtfield" id="Password"></td>
                    <td><label for="PasswordConfirm">
                      <h6>Confirm Password <span class="required">*</span> :</h6>
                      </label>
                      <input name="PasswordConfirm" type="password" required="required" class="styletxtfield" id="PasswordConfirm"></td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td><label for="Language">
                  <h6>Language <span class="required">*</span> :</h6>
                  <br>
                  </label>
                  <input name="Language" type="text" required="required" class="styletxtfield" id="Language"></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td><label for="Url">
                  <h6>URL <span class="required">*</span> :</h6>
                  <br>
                  </label>
                  <input name="Url" type="text" required="required" class="styletxtfield" id="Url"></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td><label for="Title">
                  <h6>Title <span class="required">*</span> :</h6>
                  <br>
                  </label>
                  <input name="Title" type="text" required="required" class="styletxtfield" id="Title"></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td><label for="Description">
                  <h6>Description <span class="required">*</span> :</h6>
                  <br>
                  </label>
                  <textarea name="Description" required class="styletxtarea" id="Description"></textarea></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td><label for="PreviewPicture">
                  <h6>Preview Picture :</h6>
                  <br>
                  </label>
                  <input name="PreviewPicture" type="file" id="PreviewPicture" title="PreviewPicture"></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td><input type="submit" name="RegisterButton" id="RegisterButton" value="Register"></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
        </table>
        <input type="hidden" name="MM_insert" value="RegisterForm">
      </form>
    </div>
<?php include('Bottom.php'); ?>