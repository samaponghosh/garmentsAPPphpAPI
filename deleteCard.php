<?php
header('Content-Type: application/json;  charset=UTF-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

// header("Access-Control-Allow-Origin: *");
// header("Content-Type: application/json; charset=UTF-8");
// header("Access-Control-Allow-Methods: POST");
// date_default_timezone_set('Asia/Kolkata');

// $data = json_decode(file_get_contents("php://input"), true);
$cus_id = $_POST['cus_id'];
$payment_method_id = $_POST['payment_method_id'];

include "config.php";
$q = "SELECT payment_method_id FROM payment_method WHERE cus_id = '{$cus_id}';";
$check = mysqli_query($conn, $q);
if(mysqli_num_rows($check) > 0)
{
    while($row = mysqli_fetch_assoc($check))
    {
        if ($row['payment_method_id'] == $payment_method_id)
        {
            $query = "DELETE FROM payment_method WHERE payment_method_id = '{$payment_method_id}';";
            $res = mysqli_query($conn, $query);
            echo json_encode(array('message' => 'Card deleted', 'status' => 200));
            break;
        }
    }
}
else
{
    echo json_encode(array('message' => 'No card found', 'status' => false));
}
mysqli_close($conn);
?>