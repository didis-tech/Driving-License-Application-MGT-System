<?php
session_start();
header('Content-Type: application/json');
require './db_connect.php';

$license = isset($_POST['license']) ? $_POST['license'] : "";

if (!isset($message)) {
    $query = "SELECT * FROM `license`,`user` WHERE license.user_id=user.user_id and license.license_number='$license'";
    $result = mysqli_query($conn, $query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $status = $row['license_status'];
        if ($row['license_status'] === 'expired') {
            $responses = array(
                'message' => 'check detail details and pay for your renewal',
                'type' => 'green',
                'icon' => 'fa-bell',
                'title' => 'Sorry',
                'license' => $license,
                'name' => $row['firstname'] . ' ' . $row['lastname'],
                'expired' => true
            );
        } else {
            $responses = array(
                'message' => 'Your license is still ' . $status,
                'type' => 'green',
                'icon' => 'fa-bell',
                'title' => 'Sorry',
                'license' => $license,
                'expired' => false
            );
        }
    } else {
        $responses = array(
            'message' => 'License number does not exist.',
            'type' => 'purple',
            'icon' => 'fa-bell',
            'title' => 'Sorry',
            'license' => $license,
            'found' => false
        );
    }
}


echo json_encode($responses);
