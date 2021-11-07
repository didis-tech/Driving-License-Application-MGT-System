<?php
session_start();
require "db_connect.php";
$email = isset($_POST['email']) ? $_POST['email'] : "";
$password = isset($_POST['password']) ? $_POST['password'] : "";

if (!isset($message)) {
  $query = "SELECT * FROM `admins` where adm_email  = '$email'";
  $resultLogin = mysqli_query($conn, $query);

  if ($resultLogin->num_rows === 0) {
    $responses = array(
      'message' => 'Email is invalid please check your credentials..',
      'type' => 'warning',
      'icon' => 'fa-bell',
      'title' => 'Sorry'
    );
  } else {
    $value = $resultLogin->fetch_assoc();
    $stored_password = $value['adm_password'];
    if (password_verify($password, $stored_password)) {
      $_SESSION['adm_login'] = true;
      $_SESSION['adm_id'] = $value['adm_id'];
      $responses = array(
        'message' => 'Login successfully.',
        'type' => 'success',
        'icon' => 'fa-check-circle',
        'title' => 'Thank you'
      );
    } else {
      $responses = array(
        'message' => 'Sorry! - Invalid password. ',
        'type' => 'danger',
        'icon' => 'fa-bell',
        'title' => 'Sorry'
      );
    }
  }
}
echo json_encode($responses);
