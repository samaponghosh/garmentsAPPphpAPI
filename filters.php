<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

// $data = json_decode(file_get_contents("php://input"),true);
// $pro_id = $data['pro_id'];
include "config.php";
$que = "SELECT color_id, color FROM pro_colors;";
//SELECT * FROM studentinfo JOIN classinfo WHERE studentinfo.sclass = classinfo.cid;
$res = mysqli_query($conn,$que) or die("Query error");

$que1 = "SELECT size_id, size FROM pro_sizes;";
$res1 = mysqli_query($conn,$que1) or die("Query error");

$que2 = "SELECT * FROM categories;";
$res2 = mysqli_query($conn,$que2) or die("Query error");

if (mysqli_num_rows($res)>0)
{
    $output = mysqli_fetch_all($res, MYSQLI_ASSOC);
    echo json_encode($output);
    $output1 = mysqli_fetch_all($res1, MYSQLI_ASSOC);
    echo json_encode($output1);
    $output2 = mysqli_fetch_all($res2, MYSQLI_ASSOC);
    echo json_encode($output2);
}
else
{
    echo json_encode(array('message' => 'No data found', 'status' => false));
}
mysqli_close($conn);
?>