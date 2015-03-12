<?php require_once('../Connections/WebCatalogue.php'); 
      require_once('../Helpers/security.php');

// *** Check if username exists
$MM_flag="MM_insert";
if (isset($_POST[$MM_flag])) {

  $flag = false;
  $MM_dupKeyRedirect="Register.php";
  $loginUsername = $_POST['email'];

 if(empty($_POST['first_name']))
  {
    echo "Please enter your name.";
    $flag = false;
    exit;
  }

  if(filter_var($loginUsername, FILTER_VALIDATE_EMAIL)) {
    
  }
  else {
    echo "Invalid email format.";
    $flag = false;
    exit;
  }
  if(ctype_alpha($_POST['first_name']) && ctype_alpha($_POST['last_name'])) {
    
  }
  else {
    echo "Personal fields contain invalid data.";
    $flag = false;
    exit;
  }


  $LoginRS__query = sprintf("SELECT email FROM `users` WHERE email=%s", GetSQLValueString($loginUsername, "text"));
  $LoginRS=mysqli_query( $WebCatalogue, $LoginRS__query) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
  $loginFoundUser = mysqli_num_rows($LoginRS);

  //if there is a row in the database, the username was found - can not add the requested username
  if($loginFoundUser){
    $MM_qsChar = "?";
    echo "Username Already Exists.";
    $flag = false;
    exit;
  }


  if(empty($_POST['password'])) 
  {
    echo "Password field cannot be empty.";
    $flag = false;
    exit;
  }

  if(empty($_POST['passwordwc']))
  {
    echo "Please confirm your password.";
    $flag = false;
    exit;
  }

  if(filter_var($_POST['url'], FILTER_VALIDATE_URL)) {
    
  }
  else {
    echo "Url is broken.";
    $flag = false;
    exit;
  }

  if(empty($_POST['title']))
  {
    echo "Please enter website title.";
    $flag = false;
    exit;
  }

  $passwordToConfirm = $_POST['password'];
  $passwordConfirm = $_POST['passwordwc'];
  if($passwordToConfirm != $passwordConfirm)
  {
    echo "Passwords don't match.";
    $flag = false;
    exit;
  }
  else
  {
    // $secure_password = aes_encrypt($passwordConfirm);
    // $secure_password = base64_encode($secure_password);
    $secure_password = password_hash($passwordToConfirm, PASSWORD_BCRYPT);
    $flag = true;
  }


  $default_picture = "Assets/img/default.png/";
  $user_folder_path = "Assets/img/" . basename($_POST['email']) . "/";
  $user_folder_path_check = "../Assets/img/" . basename($_POST['email']) . "/";


  if (!file_exists($user_folder_path_check) && !is_dir($user_folder_path_check) && !is_writable($user_folder_path_check)) 
  {
     $dir = mkdir("../Assets/img/" . basename($_POST['email']), 0777, true);
  }
  
  

  if(isset($_FILES['file']) && $_FILES['file']['size'] != 0) {
    $target_dir = "Assets/img/" . basename($_POST['email']) . "/";
    $target_file = $target_dir . basename($_FILES['file']["name"]);
    $uploadOk = 1;
    
    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
    // Check if image file is a actual image or fake image
    if(isset($_POST["submit"]) && $flag != false) {
        $check = getimagesize($_FILES['file']["tmp_name"]);
        if($check !== false) {
            echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }
    }
    // Check file size
    if ($_FILES['file']["size"] > 2000000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }
    // Check if file already exists
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    } 
    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {

      echo "Sorry, only JPG, JPEG & PNG files are allowed.";
      $uploadOk = 0;
    } 
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
    } else {
      //Change absolute to relative when moving
        if (move_uploaded_file($_FILES['file']['tmp_name'], $_SERVER["DOCUMENT_ROOT"] . "/web_catalogue_mysqli/" . $target_file)) {
            echo "The file ". basename($_FILES['file']["name"]). " has been uploaded.<br/>";
            $flag = true;
        } else {
             echo "Sorry, your file was not uploaded. Failed to move. <br/>" . "<br/> Move to: ". "Assets/img/" . basename($_POST['email']) . "/" . basename($_FILES["file"]["name"]) ."<br/>";
             $flag = false;
        }
    }
  }
  else
  {
     copy("../Assets/img/default.png", "../Assets/img/" . basename($_POST['email']) . "/default.png");
  }

  if(!isset($_FILES["file"]) || ($_FILES['file']["size"] == 0))
  {
    $user_printscreen_location = $user_folder_path . "default.png";
  }
  else
  {
    $user_printscreen_location = $user_folder_path . basename($_FILES['file']['name']);
  }
  
}


if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "RegisterForm") && $flag == true) {
  $insertSQL = sprintf("INSERT INTO users (email, password, first_name, last_name, `language`, url, title, `description`, preview, preview_thumb) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($secure_password, "text"),
                       GetSQLValueString($_POST['first_name'], "text"),
                       GetSQLValueString($_POST['last_name'], "text"),
                       GetSQLValueString($_POST['lang'], "text"),
                       GetSQLValueString($_POST['url'], "text"),
                       GetSQLValueString($_POST['title'], "text"),
                       GetSQLValueString($_POST['descr'], "text"),
                       GetSQLValueString($user_printscreen_location, "text"),
                       GetSQLValueString($user_printscreen_location, "text"));

  $Result1 = mysqli_query( $WebCatalogue, $insertSQL) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
  echo "Registration Succesful.";
} else {
  echo "Registration Failed.";
}

?>
