<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

// $data = json_decode(file_get_contents("php://input"), true);
$email = $_POST['email'];
$old_pass = $_POST['old_password'];
$new_pass = $_POST['new_password'];
$confirm_pass = $_POST['confirm_password'];
$old_pass = md5($old_pass);
$new_pass = md5($new_pass);
$confirm_pass = md5($confirm_pass);
include "config.php";

$que = "SELECT cus_id FROM profile WHERE email = '{$email}' AND password = '{$old_pass}';";
$res = mysqli_query($conn, $que);
if(mysqli_num_rows($res)>0)
{
    // $output = mysqli_fetch_all($res, MYSQLI_ASSOC);
    // echo json_encode($output);
    if ($new_pass == $confirm_pass)
    {
        $que1 = "UPDATE profile SET password = '{$new_pass}' WHERE password = '{$old_pass}';";
        $res1 = mysqli_query($conn, $que1);
        echo json_encode(array('message' => 'Password update successfully', 'status' => 200));
    }
    else
    {
        echo json_encode(array('message' => 'Passwords did not matched', 'status' => false));
    }
}
else
{
    echo json_encode(array('message' => 'Wrong password', 'status' => false));
}

?>