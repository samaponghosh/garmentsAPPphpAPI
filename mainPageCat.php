<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

include "config.php";
$que = "SELECT DISTINCT sub_category, sub_cat_description, sub_cat_id FROM sub_categories LIMIT 6;";
//SELECT * FROM studentinfo JOIN classinfo WHERE studentinfo.sclass = classinfo.cid;
$res = mysqli_query($conn,$que) or die("Query error");

if (mysqli_num_rows($res)>0)
{
    $output = mysqli_fetch_all($res, MYSQLI_ASSOC);
    echo json_encode($output);
}
else
{
    echo json_encode(array('message' => 'No sub categories found', 'status' => false));
}
mysqli_close($conn);
?>