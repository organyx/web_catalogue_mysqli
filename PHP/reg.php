<?php require_once('Connections/WebCatalogue.php'); ?>
<?php

	


if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "")
{
/*Global variable $con is necessary, because it is not known inside the function and you need it for mysqli_real_escape_string($con, $theValue); the Variable $con ist defined as mysqli_connect("localhost","user","password", "database") with an include-script.
*/
  Global $WebCatalogue;

  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }
  $theValue = mysqli_real_escape_string($WebCatalogue, $theValue);
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
  $MM_dupKeyRedirect="Register.php";
  $loginUsername = $_POST['Email'];
  $LoginRS__query = sprintf("SELECT email FROM `users` WHERE email=%s", GetSQLValueString($loginUsername, "text"));
  ((bool)mysqli_query( $WebCatalogue, "USE $database_WebCatalogue"));
  $LoginRS=mysqli_query( $WebCatalogue, $LoginRS__query) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
  $loginFoundUser = mysqli_num_rows($LoginRS);

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
  
  $default_picture = "Assets/img/default.png/";
  $user_folder_path = "Assets/img/" . basename($_POST['Email']) . "/";

 	if (!file_exists($user_folder_path)) 
 	{
	   $dir = mkdir($user_folder_path, 0777, true);
	}
	
	if(($_FILES["PreviewPicture"]["size"] == 0))
	{
		copy("Assets/img/default.png", "Assets/img/" . basename($_POST['Email']) . "/default.png");
	}
	
 	$target_dir = "Assets/img/" . basename($_POST['Email']) . "/";
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

  ((bool)mysqli_query( $WebCatalogue, "USE $database_WebCatalogue"));
  $Result1 = mysqli_query( $WebCatalogue, $insertSQL) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));

  $insertGoTo = "Register.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

((bool)mysqli_query( $WebCatalogue, "USE $database_WebCatalogue"));
$query_Registration = "SELECT * FROM `users`";
$Registration = mysqli_query( $WebCatalogue, $query_Registration) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
$row_Registration = mysqli_fetch_assoc($Registration);
$totalRows_Registration = mysqli_num_rows($Registration);

?>

<div id="returnmessage"><p></p></div>
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
                    <td ><label for="FirstName">
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
<?php
((mysqli_free_result($Registration) || (is_object($Registration) && (get_class($Registration) == "mysqli_result"))) ? true : false);
?>
