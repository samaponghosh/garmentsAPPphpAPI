<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

// $data = json_decode(file_get_contents("php://input"), true);
$cus_id = $_POST['cus_id'];
$dob = $_POST['dob'];

include "config.php";

$que = "UPDATE profile SET dob = '{$dob}' WHERE cus_id = {$cus_id};";
$res1 = mysqli_query($conn, $que); 
echo json_encode(array('message' => 'DOB updated', 'status' => 200));

?>
