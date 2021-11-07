<?php
if (isset($_GET['user_id'])) {
	$id = $_GET['user_id'];
}else {
	$id = $_SESSION['user_id'];
}
$sql = "SELECT * FROM `users` where user_id = '$id'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    // output data of each row
  while($row = $result->fetch_assoc()) {
  $firstname = $row['user_firstname'];
  $lastname = $row['user_lastname'];
  $email = $row['user_email'];
//   $phone = $row['user_tel'];
  $gender = $row['user_gender'];
  $occupation = $row['user_occupation'];
  $address = $row['user_password'];
$date = $row['user_reg_time'];
$stored_password=$row['user_password'];
}}

 ?>
