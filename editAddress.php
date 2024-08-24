<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

// $data = json_decode(file_get_contents("php://input"), true);
$fullname = $_POST['name'];
$address = $_POST['address'];
$city = $_POST['city'];
$state = $_POST['state'];
$pin_code = $_POST['pin_code'];
$country = $_POST['country'];
$cus_id = $_POST['cus_id'];

if (empty($fullname) or empty($address) or empty($city) or empty($state) or empty($pin_code) or empty($country) or empty($cus_id))
{
    echo json_encode(array('message' => 'Input field empty', 'status' => false));
    exit;
}
else
{
    include "config.php";
    
    $q = "SELECT * FROM address WHERE cus_id = {$cus_id};";
    $check = mysqli_query($conn, $q); 
    if (mysqli_num_rows($check) > 0)
    {
        $que = "UPDATE address SET name = '{$fullname}', address = '{$address}', city = '{$city}', state = '{$state}', pin_code = '{$pin_code}', country = '{$country}' WHERE cus_id = {$cus_id};";
        $res = mysqli_query($conn, $que) or die("Query error");
        echo json_encode(array('message' => 'Address updated successful', 'status' => 200));
    }
    else
    {
        echo json_encode(array('message' => 'No address found for this user', 'status' => false));
    }
    
    mysqli_close($conn);
}
?>
