<?php
session_start();
require "db_connect.php";
$email = isset($_POST['loginUsername']) ? $_POST['loginUsername'] : "";
$password = isset($_POST['loginPassword']) ? $_POST['loginPassword'] : "";

 if(!isset($message)) {
	$query = "SELECT * FROM `admins` where adm_username  = '$email'";
  $resultLogin = mysqli_query($conn, $query);

  if ($resultLogin->num_rows === 0) {
    
      echo "<script>alert('Email is invalid please check your credentials.'); window.location='../users/'</script>";
  }else {
    $value = $resultLogin->fetch_assoc();
    $stored_password = $value['adm_password'];
			if (password_verify($password,$stored_password)) {
					 $_SESSION['admin_login'] = true;
					 $_SESSION['admin_id'] = $value['adm_id'];
           echo "<script>window.location='../admin/'</script>";
  				   }else{
               echo "<script>alert('Sorry! - Invalid password. '); window.location='../admin/'</script>";
  				   }
    }


  }


?>
