<?php
require "db_connect.php";

if (isset($_POST['register'])) {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $gender = $_POST['gender'];
    $occupation = $_POST['occupation'];
    $password = $_POST['password'];
    $hash_password=password_hash($password, PASSWORD_BCRYPT);
    /* Email Validation */
if(!isset($message)) {
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $responses = array(
        'message' => 'Invalid Email, Please put a valid E-mail address',
        'type' => 'warning',
        'icon' => 'fa-bell',
        'title' => 'Sorry'
    );
    echo "<script>alert('Invalid Email, Please put a valid E-mail address'); window.location='../report.php'</script>";
    }}
    if(!isset($message)) {
        $query = "SELECT * FROM `users` where user_email  = '$email'";
      $result = mysqli_query($conn, $query);
    
      if ($result->num_rows > 0) {
          echo "<script>alert('User Email is already in use'); window.location='../report.php'</script>";
      }else {
          $insert_user=$conn->query("INSERT INTO `users`(`user_firstname`, `user_lastname`, `user_email`, `user_gender`, `user_occupation`, `user_password`) 
          VALUES ('$firstname','$lastname','$email','$gender','$occupation','$hash_password')");
          if ($insert_user === TRUE) {
            $last_user_id = $conn->insert_id;
            
        }
      }
}} elseif (isset($_POST['report-type'])) {
    $report_type=$_POST['report-type'];
    $user_id=isset($_SESSION['user_id']) ? $_SESSION['user_id'] : $last_user_id;
    $sql = "INSERT INTO `report`(`user_id`, `report_type`) VALUES ('$user_id','$report_id')";

if ($conn->query($sql) === TRUE) {
    $report_id = $conn->insert_id;
}
    $question[1] = $_POST['question1'];
    $question[2] = $_POST['question2'];
    $question3 = $_POST['question3'];
    $question[4] = $_POST['question4'];
    $question[5] = $_POST['question5'];
    $question[6] = $_POST['question6'];
    $question[7] = $_POST['question7'];
    $question[8] = $_POST['question8'];
    $question[9] = $_POST['question9'];

    $answer[1] = $_POST['answer1'];
    $answer[2] = $_POST['answer2'];

    for ($i=1; $i < 3; $i++) { 
        $que=$question[$i];
        $ans=$answer[$i];
        $conn->query("INSERT INTO `reportdetails`(`report_ques`, `report_ans`, `report_id`) VALUES ('$que','$ans','$report_id')");
    }
    $answer3 = array();
    $answer3[] = $_POST['answer3'];
    foreach ($answer3 as $key => $ans3) {
        $conn->query("INSERT INTO `reportdetails`(`report_ques`, `report_ans`, `report_id`) VALUES ('$question3','$ans3','$report_id')");
    }
    $answer[4] = $_POST['answer4'];
    $answer[5] = $_POST['answer5'];
    $answer[6] = $_POST['answer6'];
    $answer[7] = $_POST['answer7'];
    $answer[8] = $_POST['answer8'];
    $answer[9] = $_POST['answer9'];
    for ($i=4; $i <= 9; $i++) { 
        $que=$question[$i];
        $ans=$answer[$i];
        $conn->query("INSERT INTO `reportdetails`(`report_ques`, `report_ans`, `report_id`) VALUES ('$que','$ans','$report_id')");
    }
    echo "<script>window.location='../users'</script>";
} else {
    echo "<script>window.location='../'</script>";
}


?>