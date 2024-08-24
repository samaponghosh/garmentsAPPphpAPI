<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

// $data = json_decode(file_get_contents("php://input"), true);
$cat_id = isset($_POST['cat_id']) ? $_POST['cat_id'] : null;
$color_id = isset($_POST['color_id']) ? $_POST['color_id'] : null;
$size_id = isset($_POST['size_id']) ? $_POST['size_id'] : null;
$brand_name = isset($_POST['brand_name']) ? $_POST['brand_name'] : null;
$sub_cat_id = isset($_POST['sub_cat_id']) ? $_POST['sub_cat_id'] : null;
$under_cat_id = isset($_POST['under_cat_id']) ? $_POST['under_cat_id'] : null;
$down_cat_id = isset($_POST['down_cat_id']) ? $_POST['down_cat_id'] : null;
$min_price = isset($_POST['min_price']) ? $_POST['min_price'] : 0;
$max_price = isset($_POST['max_price']) ? $_POST['max_price'] : 100000;

include "config.php";

$query = "SELECT DISTINCT p.pro_id, p.pro_image, p.pro_name, p.price, p.discount FROM product p
          LEFT JOIN pro_colors pc ON p.pro_id = pc.pro_id
          LEFT JOIN pro_sizes ps ON p.pro_id = ps.pro_id
          WHERE 1=1";

if ($cat_id !== null) {
    $query .= " AND p.cat_id = " . intval($cat_id);
}
if ($color_id !== null) {
    $query .= " AND pc.color_id = " . intval($color_id);
}
if ($size_id !== null) {
    $query .= " AND ps.size_id = " . intval($size_id);
}
if ($brand_name !== null) {
    $query .= " AND p.brand_name = '" . $conn->real_escape_string($brand_name) . "'";
}
if ($sub_cat_id !== null) {
    $query .= " AND p.sub_cat_id = " . intval($sub_cat_id);
}
if ($under_cat_id !== null) {
    $query .= " AND p.under_cat_id = " . intval($under_cat_id);
}
if ($down_cat_id !== null) {
    $query .= " AND p.down_cat_id = " . intval($down_cat_id);
}
if ($min_price !== null and $max_price !== null) 
{
    $query .= " AND p.price BETWEEN " . intval($min_price) ." AND ". intval($max_price);
}
$result = $conn->query($query);

$products = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
}

echo json_encode($products);

mysqli_close($conn);
?>
