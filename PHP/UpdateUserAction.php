<?php 
      session_start();
      require_once('../Connections/WebCatalogue.php'); 
      require_once('../Helpers/security.php');

$passCheck = false;
$passwordToConfirm = $_POST['password'];
$passwordConfirm = $_POST['passwordwc'];
if(isset($_POST["MM_update"]) && isset($passwordToConfirm) &&(isset($passwordConfirm)))
{
	if($passwordToConfirm !== $passwordConfirm) 
  {
    echo "Passwords don't match. ";
    $passCheck = false;
  }
  else
  {
    $passwordConfirm = $_POST['password'];
    $cleansedstring = preg_replace('#\W#', '', $passwordConfirm);
    //$secure_password = aes_encrypt($passwordConfirm);
    //$secure_password = base64_encode($secure_password);
    $secure_password = aes_encrypt($cleansedstring);
    $secure_password = base64_encode($secure_password);
    $passCheck = true;
    //echo $passwordConfirm . "<br/>";
    //echo aes_encrypt($passwordConfirm) . "<br/>";
    //echo $secure_password . "<br/>";
  }
}

$flag = false;
//echo "<pre>" . print_r($_SESSION) . "</pre>";
$user_folder_path = "Assets/img/" . basename($_SESSION['MM_Username']) . "/";

if(isset($_FILES['file']) && $_FILES['file']['size'] != 0) {
    $target_dir = "Assets/img/" . basename($_SESSION['MM_Username']) . "/";
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
            //echo "The file ". basename($_FILES['file']["name"]). " has been uploaded.<br/>";
            $flag = true;
        } else {
            // echo "Sorry, your file was not uploaded. Failed to move. <br/>" . "<br/> Move to: ". "Assets/img/" . basename($_SESSION['MM_Username']) . "/" . basename($_FILES["file"]["name"]) ."<br/>";
             $flag = false;
        }
    }
  }


 $user_printscreen_location = $user_folder_path . basename($_FILES['file']['name']);


if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "UpdateForm") && ($passCheck == true) && ($flag == false)) {
  $updateSQL = sprintf("UPDATE users SET password=%s, language=%s, url=%s, title=%s, `description`=%s WHERE userID=%s",
                       GetSQLValueString($secure_password, "text"),
					             GetSQLValueString($_POST['lang'], "text"),
                       GetSQLValueString($_POST['url'], "text"),
                       GetSQLValueString($_POST['title'], "text"),
                       GetSQLValueString($_POST['descr'], "text"),
                       GetSQLValueString($_POST['UserIDhiddenField'], "int"));

  $Result1 = mysqli_query( $WebCatalogue, $updateSQL) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));

  echo "Record Updated";
}
elseif ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "UpdateForm") && ($passCheck == true) && ($flag == true)) {
  $updateSQL = sprintf("UPDATE users SET password=%s, language=%s, url=%s, title=%s, `description`=%s, `preview`=%s, `preview_thumb`=%s  WHERE userID=%s",
                       GetSQLValueString($secure_password, "text"),
                       GetSQLValueString($_POST['lang'], "text"),
                       GetSQLValueString($_POST['url'], "text"),
                       GetSQLValueString($_POST['title'], "text"),
                       GetSQLValueString($_POST['descr'], "text"),
                       GetSQLValueString($user_printscreen_location, "text"),
                       GetSQLValueString($user_printscreen_location, "text"),
                       GetSQLValueString($_POST['UserIDhiddenField'], "int"));

  $Result1 = mysqli_query( $WebCatalogue, $updateSQL) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));

  echo "Record Updated";
}
else {
  echo "Update Failed";
}


?>
