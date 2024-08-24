<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

if (!isset($_POST['pro_id']) || !isset($_POST['cus_id']) || !isset($_POST['rating']) || !isset($_POST['current_date'])) {
    echo json_encode(array('message' => 'Required fields are missing', 'status' => false));
    exit();
}

$pro_id = $_POST['pro_id'];
$cus_id = $_POST['cus_id'];
$review = isset($_POST['review']) ? $_POST['review'] : null;
$rating = $_POST['rating'];
$current_date = $_POST['current_date'];

$review_image = null;
if (isset($_FILES['review_image']) && $_FILES['review_image']['error'] == 0) {
    $allowed_extensions = array('jpg', 'jpeg', 'png', 'gif');
    $file_name = $_FILES['review_image']['name'];
    $file_tmp = $_FILES['review_image']['tmp_name'];
    $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

    if (in_array($file_ext, $allowed_extensions)) {
        $unique_fileName = uniqid() . '.' . $file_ext;
        $upload_dir = 'review_images/';
        $file_path = $upload_dir . $unique_fileName;

        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        if (move_uploaded_file($file_tmp, $file_path)) {
            $review_image = $file_path;
        } else {
            echo json_encode(array('message' => 'Failed to upload image', 'status' => false));
            exit();
        }
    } else {
        echo json_encode(array('message' => 'Invalid image file type', 'status' => false));
        exit();
    }
}

include "config.php";

$q = "SELECT name FROM profile WHERE cus_id = '{$cus_id}';";
$CusName = mysqli_query($conn, $q);
if (mysqli_num_rows($CusName) > 0) {
    $row = mysqli_fetch_assoc($CusName);
    $name = $row['name'];
} else {
    echo json_encode(array('message' => 'Customer not found', 'status' => false));
    exit();
}

$q1 = "SELECT review_id FROM pro_reviews WHERE cus_id = '{$cus_id}' AND pro_id = '{$pro_id}';";
$check = mysqli_query($conn, $q1);
if (mysqli_num_rows($check) == 0) {
    $que = "INSERT INTO pro_reviews (pro_id, name, cus_id, created_at, review, rating, review_image) 
            VALUES ('{$pro_id}', '{$name}', '{$cus_id}', '{$current_date}', '{$review}', '{$rating}', '{$review_image}')";
    $res = mysqli_query($conn, $que) or die("Query error");
    echo json_encode(array('message' => 'New review added successfully', 'status' => 200));
} else {
    echo json_encode(array('message' => 'Review already exists, cannot create new review', 'status' => false));
}

mysqli_close($conn);
?>
