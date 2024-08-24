<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

// $data = json_decode(file_get_contents("php://input"), true);
$pro_id = $_POST['pro_id'];
$cus_id = $_POST['cus_id'];

include "config.php";
$q = "SELECT * FROM favourites WHERE cus_id = {$cus_id} AND pro_id = {$pro_id};";
$check = mysqli_query($conn, $q);
if (mysqli_num_rows($check) == 0)
{
    $que = "INSERT INTO favourites(cus_id, pro_id) VALUES('{$cus_id}','{$pro_id}');";
    $res = mysqli_query($conn, $que);
    echo json_encode(array('message' => 'Added to favourites', 'status' => 200));
}
else
{
    echo json_encode(array('message' => 'Alreday exists in favourites', 'status' => false));
}
mysqli_close($conn);
?>
