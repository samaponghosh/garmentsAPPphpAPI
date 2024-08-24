<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

// $data = json_decode(file_get_contents("php://input"),true);
$cus_id = $_POST['cus_id'];
include "config.php";
$que = "SELECT p.name, p.email, COUNT(o.order_id), COUNT(ad.address_id), COUNT(pm.payment_method_id), COUNT(pr.review_id) FROM profile p
           LEFT JOIN orders o ON p.cus_id = o.cus_id
           LEFT JOIN address ad ON p.cus_id = ad.cus_id
           LEFT JOIN payment_method pm ON p.cus_id = pm.cus_id
           LEFT JOIN pro_reviews pr ON p.cus_id = pr.cus_id
          WHERE p.cus_id = {$cus_id};";
$res = mysqli_query($conn,$que) or die("Query error");

// $que1 = "SELECT name, email, COUNT(o.order_id), COUNT(ad.address_id), COUNT(pm.payment_method), COUNT(pr.review_id) FROM profile p
//            LEFT JOIN orders o ON p.cus_id = o.cus_id
//            LEFT JOIN address ad ON p.cus_id = ad.cus_id
//            LEFT JOIN payment_methods pm ON p.cus_id = pm.cus_id
//            LEFT JOIN pro_reviews pr ON p.cus_id = pr.cus_id
//           WHERE p.cus_id = {$cus_id};";
if (mysqli_num_rows($res)>0)
{
    $output = mysqli_fetch_all($res, MYSQLI_ASSOC);
    echo json_encode($output);
}
else
{
    echo json_encode(array('message' => 'No record found', 'status' => false));
}
?>