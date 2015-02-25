<?php require_once('../Connections/WebCatalogue.php'); 
      require_once('../Helpers/security.php');
      
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
$MM_flag="mm_in";
if (isset($_POST[$MM_flag])) {

  $flag = false;
  $MM_dupKeyRedirect="Register.php";
  $loginUsername = $_POST['email1'];
  $LoginRS__query = sprintf("SELECT email FROM `users` WHERE email=%s", GetSQLValueString($loginUsername, "text"));
  ((bool)mysqli_query( $WebCatalogue, "USE $database_WebCatalogue"));
  $LoginRS=mysqli_query( $WebCatalogue, $LoginRS__query) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
  $loginFoundUser = mysqli_num_rows($LoginRS);

  //if there is a row in the database, the username was found - can not add the requested username
  if($loginFoundUser){
    $MM_qsChar = "?";
    //append the username to the redirect page
    /*
    if (substr_count($MM_dupKeyRedirect,"?") >=1) $MM_qsChar = "&";
    $MM_dupKeyRedirect = $MM_dupKeyRedirect . $MM_qsChar ."requsername=".$loginUsername;
    header ("Location: $MM_dupKeyRedirect");
    exit;
  */
  }
  
  if(isset($_FILES)){
    echo "<pre>" . print_r($_FILES) . "</pre>";
  }

  //echo "PIC <pre>" . print_r($_POST['picture1']) . "</pre>";
  $passwordToConfirm = $_POST['password1'];
  $passwordConfirm = $_POST['passwordwc1'];
  if($passwordToConfirm != $passwordConfirm)
  {
    echo "Passwords don't match";
    //header ("Location: $MM_dupKeyRedirect");
    $flag = false;
    exit;
  }
  else
  {
    $secure_password = aes_encrypt($passwordConfirm);
    $secure_password = base64_encode($secure_password);
    $flag = true;
  }
  
  $default_picture = "Assets/img/default.png/";
  $user_folder_path = "Assets/img/" . basename($_POST['email1']) . "/";

  if (!file_exists($user_folder_path)) 
  {
     $dir = mkdir("../Assets/img/" . basename($_POST['email1']), 0777, true);
  }
  
  if(($_FILES["file"]["size"] == 0))
  {
    copy("../Assets/img/default.png", "../Assets/img/" . basename($_POST['email1']) . "/default.png");
  }
  

  $target_dir = "Assets/img/" . basename($_POST['email1']) . "/";
  $target_file = $target_dir . basename($_FILES["file"]["name"]);
  $uploadOk = 1;
  $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
  // Check if image file is a actual image or fake image
  if(isset($_POST["submit"]) && $flag != false) {
      $check = getimagesize($_FILES["file"]["tmp_name"]);
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
  if ($_FILES["file"]["size"] > 2000000 && $uploadOk == 1) {
      echo "Sorry, your file is too large.";
      $uploadOk = 0;
  }
  // Check if file already exists
  if (file_exists($target_file) && $uploadOk == 1) {
       echo "Sorry, file already exists.";
      $uploadOk = 0;
  } 
  // Allow certain file formats
  if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
  && $imageFileType != "gif" && $uploadOk == 1) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
      $uploadOk = 0;
  } 
  // Check if $uploadOk is set to 0 by an error
  if ($uploadOk == 0) {
      echo "Sorry, your file was not uploaded.";
  // if everything is ok, try to upload file
  } else {
      if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
          echo "The file ". basename( $_FILES["file"]["name"]). " has been uploaded.";
          $flag = true;
      } else {
           echo "Sorry, your file was not uploaded.";
      }
  }

  if(($_FILES["file"]["size"] == 0))
  {
    $user_printscreen_location = $user_folder_path . "default.png";
  }
  else
  {
    $user_printscreen_location = $target_file;
    $result = $uploader->handleUpload($user_printscreen_location);
  }
  
}


$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["mm_in"])) && ($_POST["mm_in"] == "RegisterForm") && $flag == true) {
  $insertSQL = sprintf("INSERT INTO users (email, password, first_name, last_name, `language`, url, title, `description`, preview, preview_thumb) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['email1'], "text"),
                       GetSQLValueString($secure_password, "text"),
                       GetSQLValueString($_POST['first_name1'], "text"),
                       GetSQLValueString($_POST['last_name1'], "text"),
                       GetSQLValueString($_POST['lang1'], "text"),
                       GetSQLValueString($_POST['url1'], "text"),
                       GetSQLValueString($_POST['title1'], "text"),
                       GetSQLValueString($_POST['descr1'], "text"),
                       GetSQLValueString($user_printscreen_location, "text"),
                       GetSQLValueString($user_printscreen_location, "text"));

  ((bool)mysqli_query( $WebCatalogue, "USE $database_WebCatalogue"));
  $Result1 = mysqli_query( $WebCatalogue, $insertSQL) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
/*
  $insertGoTo = "Register.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
  */
}

((bool)mysqli_query( $WebCatalogue, "USE $database_WebCatalogue"));
$query_Registration = "SELECT * FROM `users`";
$Registration = mysqli_query( $WebCatalogue, $query_Registration) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
$row_Registration = mysqli_fetch_assoc($Registration);
$totalRows_Registration = mysqli_num_rows($Registration);

?>

<?php
((mysqli_free_result($Registration) || (is_object($Registration) && (get_class($Registration) == "mysqli_result"))) ? true : false);
?>
