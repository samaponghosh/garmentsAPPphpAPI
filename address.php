<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

// $data = json_decode(file_get_contents("php://input"),true);
$cus_id = $_POST['cus_id'];
include "config.php";
$que = "SELECT * FROM address WHERE cus_id = {$cus_id};";
$res = mysqli_query($conn,$que) or die("Query error");

if (mysqli_num_rows($res)>0)
{
    $output = mysqli_fetch_all($res, MYSQLI_ASSOC);
    echo json_encode($output);
}
else
{
    echo json_encode(array('message' => 'No record found', 'status' => false));
}
mysqli_close($conn);
?>