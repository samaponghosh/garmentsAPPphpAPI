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
$card_name = $_POST['card_name'];
$card_no = $_POST['card_no'];
$exp_date = $_POST['exp_date'];
$cvv = $_POST['cvv'];

include "config.php";
$q = "SELECT card_name, card_no, cvv, exp_date, cus_id FROM payment_method;";
$check = mysqli_query($conn, $q);
if(mysqli_num_rows($check) == 0)
{
    $query = "INSERT INTO payment_method(cus_id, card_name, card_no, exp_date, cvv) VALUES('{$cus_id}','{$card_name}','{$card_no}','{$exp_date}','{$cvv}');";
    $res = mysqli_query($conn, $query);
    echo json_encode(array('message' => 'New card added', 'status' => 200));
}
else if (mysqli_num_rows($check) > 0)
{
    while($row = mysqli_fetch_assoc($check))
    {
        if ($row['cus_id'] == $cus_id && $row['card_name'] == $card_name && $row['card_no'] == $card_no && $row['cvv'] == $cvv)
        {
            $existsCard = true;
            echo json_encode(array('message' => 'Card already exists', 'status' => false));
            break;
        }
        else
        {
            $existsCard = false;
        }
    }
    if($existsCard == false)
    {
        $query1 = "INSERT INTO payment_method(cus_id, card_name, card_no, exp_date, cvv) VALUES('{$cus_id}','{$card_name}','{$card_no}','{$exp_date}','{$cvv}');";
        $res1 = mysqli_query($conn, $query1);
        echo json_encode(array('message' => 'New card added', 'status' => 200));
    }
}
mysqli_close($conn);
?>