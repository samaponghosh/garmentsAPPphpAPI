<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

// $data = json_decode(file_get_contents("php://input"), true);
$pro_id = $_POST['pro_id'];
$cus_id = $_POST['cus_id'];
$color_id = $_POST['color_id'];
$size_id = $_POST['size_id'];

if (empty($color_id) or empty($size_id))
{
    echo json_encode(array('message' => 'Color id and size id is empty', 'status' => False));
}
else
{
include "config.php";
$q = "SELECT pro_id FROM cart WHERE cus_id = {$cus_id};";
$check = mysqli_query($conn, $q);
$checkRes = mysqli_fetch_assoc($check);

if (mysqli_num_rows($check) == 0) 
{
    $query = "INSERT INTO cart(cus_id, pro_id, selected_color_id, selected_size_id) VALUES('{$cus_id}','{$pro_id}','{$color_id}','{$size_id}');";
    $result = mysqli_query($conn, $query);
    echo json_encode(array('message' => 'Added to cart successfully', 'status' => 200));
} 
else 
{
    $productExists = false;
    while ($checkRes = mysqli_fetch_assoc($check)) 
    {
        if ($checkRes['pro_id'] == $pro_id) 
        {
            $productExists = true;
            break;
        }
    }
    if ($productExists) 
    {
        echo json_encode(array('message' => 'Already in cart', 'status' => false));
    } 
    else 
    {
        $query = "INSERT INTO cart(cus_id, pro_id, selected_color_id, selected_size_id) VALUES('{$cus_id}','{$pro_id}','{$color_id}','{$size_id}');";
        $result = mysqli_query($conn, $query);
        echo json_encode(array('message' => 'Added to cart successfully', 'status' => 200));
    }
}

mysqli_close($conn);
}
?>
