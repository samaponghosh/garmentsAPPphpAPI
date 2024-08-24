<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

// $data = json_decode(file_get_contents("php://input"),true);
$cus_id = $_POST['cus_id']; 
include "config.php";
// $que = "SELECT pro_id FROM favourites WHERE cus_id = {$cus_id};";
$que = "SELECT p.pro_id, p.pro_name, p.price, p.discount, p.pro_image, p.stock_quantity FROM product p
          LEFT JOIN favourites f ON p.pro_id = f.pro_id
          WHERE f.cus_id = {$cus_id};";
//SELECT * FROM studentinfo JOIN classinfo WHERE studentinfo.sclass = classinfo.cid;
$res = mysqli_query($conn,$que) or die("Query error");

if (mysqli_num_rows($res)>0)
{
    $output = mysqli_fetch_all($res, MYSQLI_ASSOC);
    echo json_encode($output);
    // while($row = mysqli_fetch_assoc($res))
    // {
    //     echo $pro_id = $row['pro_id']; 
    // }
    // $que1 = "SELECT COUNT(pr.review_id), AVG(pr.rating) FROM product p LEFT JOIN pro_reviews pr ON p.pro_id = pr.pro_id WHERE p.pro_id = {$pro_id};";
    // $res1 = mysqli_query($conn,$que1) or die("Query error");
    // $output1 = mysqli_fetch_all($res1, MYSQLI_ASSOC);
    // echo json_encode($output1);
}
else
{
    echo json_encode(array('message' => 'No record found', 'status' => false));
}

mysqli_close($conn);
?>