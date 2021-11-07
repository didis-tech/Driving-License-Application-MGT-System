<?php
if (isset($_GET['adm_id'])) {
  $id = $_GET['adm_id'];
} else {
  $id = $_SESSION['adm_id'];
}
$sql = "SELECT * FROM `admins` where adm_id = '$id'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
  // output data of each row
  while ($row = $result->fetch_assoc()) {
    $adm_firstname = $row['adm_firstname'];
    $adm_lastname = $row['adm_lastname'];
    $adm_email = $row['adm_email'];
    $phone = $row['adm_tel'];
    $stored_password = $row['adm_password'];
  }
}
