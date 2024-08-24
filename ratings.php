<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

// $data = json_decode(file_get_contents("php://input"), true);
$pro_id = $_POST['pro_id'];

include "config.php";

$query = "SELECT * FROM pro_reviews WHERE pro_id = {$pro_id};";

// "SELECT p.*, pr.*, COUNT(pr.review_id) FROM product p
//           LEFT JOIN pro_reviews pr ON p.pro_id = pr.pro_id
//           WHERE p.pro_id = {$pro_id} AND pr.review_image IS NOT NULL
// GROUP BY p.pro_id, pr.review_id;";

$res = mysqli_query($conn, $query);
if (mysqli_num_rows($res) > 0) {
    $output = mysqli_fetch_all($res, MYSQLI_ASSOC);
    echo json_encode($output);
} else {
    echo json_encode(array('message' => 'No review available', 'status' => false));
}

$query1 = "SELECT COUNT(review_id), AVG(rating) FROM pro_reviews WHERE pro_id = {$pro_id};";
$res1 = mysqli_query($conn, $query1);
if (mysqli_num_rows($res1) > 0) {
    $output1 = mysqli_fetch_all($res1, MYSQLI_ASSOC);
    echo json_encode($output1);
}

// echo json_encode($products);

mysqli_close($conn);
