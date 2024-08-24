<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

date_default_timezone_set('Asia/Kolkata');

$cus_id = $_POST['cus_id'];
// $current_date = date('Y-m-d H:i:s');
$current_date = $_POST['current_date'];
$address_id = $_POST['address_id'];
$delivery_status = "Order placed";
$order_no = 0;

function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
}
$ran_str = generateRandomString();

include "config.php";
$q = "SELECT * FROM cart WHERE cus_id = {$cus_id};";
$cartData = mysqli_query($conn, $q);
if (mysqli_num_rows($cartData) > 0) {
    while ($row = mysqli_fetch_assoc($cartData)) {
        $query = "INSERT INTO orders(cus_id, pro_id, quantity, order_date, address_id, delivery_status, selected_color_id, selected_size_id, order_no) 
                  VALUES('{$row['cus_id']}', '{$row['pro_id']}', '{$row['quantity']}', '{$current_date}', '{$address_id}', '{$delivery_status}', '{$row['selected_color_id']}', '{$row['selected_size_id']}', '{$order_no}');";
        $res = mysqli_query($conn, $query);
        
        if ($res) {
            $orderQue = "SELECT order_no FROM orders WHERE cus_id = '{$row['cus_id']}' AND pro_id = '{$row['pro_id']}' AND quantity = {$row['quantity']} AND order_date = '{$current_date}' AND address_id = '{$address_id}' AND delivery_status = '{$delivery_status}' AND selected_color_id = '{$row['selected_color_id']}' AND selected_size_id = '{$row['selected_size_id']}'";
            $res1 = mysqli_query($conn, $orderQue);
            
            if (mysqli_num_rows($res1) > 0) {
                $row1 = mysqli_fetch_assoc($res1);
                if ($row1['order_no'] == $ran_str) {
                    $ran_str = generateRandomString();
                }
                $orderQue1 = "UPDATE orders 
                              SET order_no = '{$ran_str}' 
                              WHERE cus_id = '{$row['cus_id']}' 
                              AND pro_id = '{$row['pro_id']}' 
                              AND quantity = {$row['quantity']} 
                              AND order_date = '{$current_date}' 
                              AND address_id = '{$address_id}' 
                              AND delivery_status = '{$delivery_status}' 
                              AND selected_color_id = '{$row['selected_color_id']}' 
                              AND selected_size_id = '{$row['selected_size_id']}'";
                $res2 = mysqli_query($conn, $orderQue1);
            } else {
                $orderQue1 = "UPDATE orders 
                              SET order_no = '{$ran_str}' 
                              WHERE cus_id = '{$row['cus_id']}' 
                              AND pro_id = '{$row['pro_id']}' 
                              AND quantity = {$row['quantity']} 
                              AND order_date = '{$current_date}' 
                              AND address_id = '{$address_id}' 
                              AND delivery_status = '{$delivery_status}' 
                              AND selected_color_id = '{$row['selected_color_id']}' 
                              AND selected_size_id = '{$row['selected_size_id']}'";
                $res2 = mysqli_query($conn, $orderQue1);
            }
        }
    }
    $sq = "DELETE FROM cart WHERE cus_id = '{$cus_id}';";
    $result12 = mysqli_query($conn, $sq);
    echo json_encode(array('message' => 'Order placed successfully', 'status' => 200));
} else {
    echo json_encode(array('message' => 'Cart is empty', 'status' => false));
}
mysqli_close($conn);
?>
