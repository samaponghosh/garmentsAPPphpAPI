<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

// $data = json_decode(file_get_contents("php://input"), true);
$cus_id = $_POST['cus_id'];

include "config.php";

$query = "SELECT p.pro_name, p.price, p.pro_image, c.selected_color_id, c.selected_size_id, c.quantity, ps.size, pc.color FROM cart c
          LEFT JOIN product p ON c.pro_id = p.pro_id
          LEFT JOIN pro_colors pc ON c.pro_id = pc.pro_id
          LEFT JOIN pro_sizes ps ON c.pro_id = ps.pro_id
          WHERE c.cus_id = '{$cus_id}' 
          GROUP BY p.pro_id;";
$res = mysqli_query($conn, $query);
if(mysqli_num_rows($res) >0)
{
    $output = mysqli_fetch_all($res, MYSQLI_ASSOC);
    echo json_encode($output);

    $q = "SELECT SUM(p.price), COUNT(p.pro_id) FROM cart c
          LEFT JOIN product p ON c.pro_id = p.pro_id
          WHERE c.cus_id = '{$cus_id}';";
    $res1 = mysqli_query($conn, $q);
    $output1 = mysqli_fetch_all($res1, MYSQLI_ASSOC);
    echo json_encode($output1);
}
else
{
    echo json_encode(array('message' => 'No data found', 'status' => false));
}

mysqli_close($conn);
?>