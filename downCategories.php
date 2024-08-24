<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

// $data = json_decode(file_get_contents("php://input"),true);
$cat_id = $_POST['cat_id']; 
$sub_cat_id = $_POST['sub_cat_id'];
$under_cat_id = $_POST['under_cat_id'];

include "config.php";
$que = "SELECT * FROM down_categories WHERE cat_id = {$cat_id} AND sub_cat_id = {$sub_cat_id} AND under_cat_id = {$under_cat_id};";
//SELECT * FROM studentinfo JOIN classinfo WHERE studentinfo.sclass = classinfo.cid;
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