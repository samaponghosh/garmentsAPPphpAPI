<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

// $data = json_decode(file_get_contents("php://input"), true);
$pro_id = $_POST['pro_id'];

include "config.php";

$query = "SELECT *, COUNT(review_id), AVG(rating) FROM pro_reviews WHERE pro_id = {$pro_id} AND review_image IS NOT NULL;";

// "SELECT p.*, pr.*, COUNT(pr.review_id) FROM product p
//           LEFT JOIN pro_reviews pr ON p.pro_id = pr.pro_id
//           WHERE p.pro_id = {$pro_id} AND pr.review_image IS NOT NULL
// GROUP BY p.pro_id, pr.review_id;";

$result = $conn->query($query);

$products = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
}

echo json_encode($products);

mysqli_close($conn);
?>
