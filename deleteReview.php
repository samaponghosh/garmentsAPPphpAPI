<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

// $data = json_decode(file_get_contents("php://input"), true);
$pro_id = $_POST['pro_id'];
$cus_id = $_POST['cus_id'];

include "config.php";

$q1 = "SELECT review_id FROM pro_reviews WHERE cus_id = {$cus_id} AND pro_id = {$pro_id};";
$check = mysqli_query($conn, $q1);
if (mysqli_num_rows($check) > 0)
{
    while ($row = mysqli_fetch_assoc($check))
    {
        $review_id = $row['review_id'];
        $q = "DELETE FROM pro_reviews WHERE review_id = {$review_id};";
        $delQue = mysqli_query($conn, $q);
        echo json_encode(array('message' => 'Review deleted successfully', 'status' => 200));
    }
}
else
{
    echo json_encode(array('message' => 'Review doesnot exists', 'status' => false));
}

mysqli_close($conn);
?>
