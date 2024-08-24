<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

include "config.php";
$que = "SELECT * FROM categories;";
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