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

include "config.php";

$q = "SELECT * FROM address WHERE cus_id = {$cus_id};";
$check = mysqli_query($conn, $q);
if (mysqli_num_rows($check) > 0) {
    while ($row = mysqli_fetch_assoc($check)) {
        // echo json_encode($row);
        if ($cus_id == $row['cus_id'] && $fullname == $row['name'] && $address == $row['address'] && $city == $row['city'] && $state == $row['state'] && $pin_code == $row['pin_code'] && $country == $row['country']) {
            echo json_encode(array('message' => 'Same address already exists', 'status' => false));
        } else {
            $que1 = "INSERT INTO address(name, address, city, state, pin_code, country, cus_id) VALUES('{$fullname}','{$address}','{$city}','{$state}','{$pin_code}','{$country}','{$cus_id}')";
            $res1 = mysqli_query($conn, $que1) or die("Query error");
            echo json_encode(array('message' => 'New address added successfully', 'status' => 200));
        }
    }
} else {
    $que = "INSERT INTO address(name, address, city, state, pin_code, country, cus_id) VALUES('{$fullname}','{$address}','{$city}','{$state}','{$pin_code}','{$country}','{$cus_id}')";
    $res = mysqli_query($conn, $que) or die("Query error");
    echo json_encode(array('message' => 'New address added successfully', 'status' => 200));
}

mysqli_close($conn);
?>
