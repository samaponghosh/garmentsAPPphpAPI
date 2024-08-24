<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

// $data = json_decode(file_get_contents("php://input"),true);
$cus_id = $_POST['cus_id'];
include "config.php";
$que ="SELECT DISTINCT o.order_no, o.tracking_number, SUM(o.quantity), o.order_date, SUM(p.price), COUNT(o.pro_id), o.delivery_status FROM orders o
        LEFT JOIN product p ON o.pro_id = p.pro_id
        WHERE cus_id = {$cus_id}
        GROUP BY order_no, tracking_number, order_date;";
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