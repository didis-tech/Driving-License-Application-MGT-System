<?php
session_start();
header('Content-Type: application/json');
require './db_connect.php';

$firstname = isset($_POST['firstname']) ? $_POST['firstname'] : "";
$middlename = isset($_POST['middlename']) ? $_POST['middlename'] : "";
$lastname = isset($_POST['lastname']) ? $_POST['lastname'] : "";
$DoB = isset($_POST['DoB']) ? $_POST['DoB'] : "";
$email = isset($_POST['email']) ? $_POST['email'] : "";
/* Email Validation */
if (!isset($message)) {
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

    $message = "Invalid Email, Please put a valid E-mail address";
    $type = "red";
  }
}

if (!isset($message)) {
  $query = "SELECT * FROM `user` where email  = '$email'";
  $result = mysqli_query($conn, $query);

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if ($row['status'] === 'pending') {
      $responses = array(
        'message' => 'Your application is still pending please go for your driving test',
        'type' => 'red',
        'icon' => 'fa-bell',
        'title' => 'Sorry',
        'status' => $row['status'],
        'level' => $row['level']
      );
    } elseif ($row['status'] === 'licenced') {
      $responses = array(
        'message' => 'Your application is still pending please go for your driving test',
        'type' => 'green',
        'icon' => 'fa-bell',
        'title' => 'Sorry',
        'status' => $row['status'],
        'level' => $row['level']
      );
    } else {
      $_SESSION['userId'] = $row['user_id'];
      if ($row['level'] === 'level 2') {
        $_SESSION['level'] = true;
      }
      $responses = array(
        'message' => 'Your application is in progress',
        'type' => 'purple',
        'icon' => 'fa-bell',
        'title' => 'Sorry',
        'status' => $row['status'],
        'level' => $row['level']
      );
    }
  } else {
    $query = "INSERT INTO `user`(`firstname`, `middlename`, `lastname`, `email`, `dob`) VALUES ('$firstname','$middlename','$lastname','$email','$DoB')";

    if ($conn->query($query) === TRUE) {
      $message = "Data Inserted";
      $type = "green";
    } else {
      $message = "Customer Data Not Inserted. Try Again!";
      $type = "dark";
    }
  }
}
if (isset($message)) {
  $responses = array(
    'message' => $message,
    'type' => $type,
    'icon' => 'fa-bell-o',
    'title' => 'Hello',
    'status' => 'status',
    'level' => 'level'
  );
}
echo json_encode($responses);
