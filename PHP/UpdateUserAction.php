<?php require_once('../Connections/WebCatalogue.php'); 
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


if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "UpdateForm") && ($passCheck == true)) {
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
else {
  echo "Update Failed";
}


?>
