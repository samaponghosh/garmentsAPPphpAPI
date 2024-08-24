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
$pro_id = $_POST['pro_id'];

include "config.php";
$q = "SELECT pro_id FROM cart WHERE cus_id = '{$cus_id}';";
$check = mysqli_query($conn, $q);
if (mysqli_num_rows($check) > 0) {
    while ($row = mysqli_fetch_assoc($check)) {
        if ($row['pro_id'] == $pro_id) {
            $query = "DELETE FROM cart WHERE cus_id = '{$cus_id}' AND pro_id = '{$pro_id}';";
            $res = mysqli_query($conn, $query);
            $q1 = "SELECT * FROM cart WHERE cus_id = '{$cus_id}';";
            $showCart = mysqli_query($conn, $q1);
            $output = mysqli_fetch_all($showCart, MYSQLI_ASSOC);
            echo json_encode(array('message' => 'Cart item deleted', 'status' => 200));
            echo json_encode($output);
            break;
        } else {
            echo json_encode(array('message' => 'Product is not present in cart', 'status' => 200));
            $q1 = "SELECT * FROM cart WHERE cus_id = '{$cus_id}';";
            $showCart = mysqli_query($conn, $q1);
            $output = mysqli_fetch_all($showCart, MYSQLI_ASSOC);
            echo json_encode($output);
        }
    }
} else {
    $q1 = "SELECT * FROM cart WHERE cus_id = '{$cus_id}';";
    $showCart = mysqli_query($conn, $q1);
    $output = mysqli_fetch_all($showCart, MYSQLI_ASSOC);
    echo json_encode($output);
    echo json_encode(array('message' => 'Cart empty', 'status' => false));
}
mysqli_close($conn);
