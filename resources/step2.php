<?php
session_start();
header('Content-Type: application/json');
require './db_connect.php';

$mother_maiden_name = isset($_POST['mother_maiden_name']) ? $_POST['mother_maiden_name'] : "";
$phone = isset($_POST['phone']) ? $_POST['phone'] : "";
$state = isset($_POST['state']) ? $_POST['state'] : "";
$image = isset($_POST['image']) ? $_POST['image'] : "";
$lga = isset($_POST['lga']) ? $_POST['lga'] : "";
$address = isset($_POST['address']) ? $_POST['address'] : "";
$lga = isset($_POST['lga']) ? $_POST['lga'] : "";
$user_id = $_SESSION['userId'];
$imgData = $image;


$image_array_1 = explode(";", $imgData);
$image_array_2 = explode(",", $image_array_1[1]);



$imgData = base64_decode($image_array_2[1]);
$imageName = time() . '.png';
file_put_contents('../assets/passports/' . $imageName, $imgData);

$query = $conn->query("UPDATE `user` SET 
`mother_maiden_name`='$mother_maiden_name',
`phone`='$phone',
`state`='$state',
`lga`='$lga',
`address`='$address',
`passport`='$imageName',
`level`='level 2' WHERE `user_id`='$user_id'");
if ($query) {
	$responses = array(
		'message' => 'Application updated successfully.',
		'type' => 'green',
		'icon' => 'fa-check-circle',
		'title' => 'Thank you'
	);
} else {
	$responses = array(
		'message' => 'Error occured.',
		'type' => 'red',
		'icon' => 'fa-bell',
		'title' => 'Sorry'
	);
}
echo json_encode($responses);
