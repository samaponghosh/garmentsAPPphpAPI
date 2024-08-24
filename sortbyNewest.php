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

include "config.php";

$query = "SELECT p.pro_image, p.pro_id, p.pro_name, p.price, p.discount, p.brand_name FROM product p
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
$query .= " ORDER BY added_time DESC";
$result = $conn->query($query);

// $products = [];
if (mysqli_num_rows($result) > 0) 
    {
        // while ($row = mysqli_fetch_assoc($result)) 
        // {
        //     $products[] = $row;
        // }
        $products = mysqli_fetch_all($result, MYSQLI_ASSOC);
        $final_output = [];

        foreach ($products as $product) 
        {
            $pro_id = $product['pro_id'];
            $que1 = "SELECT COUNT(review_id) as review_count, AVG(rating) as avg_rating FROM pro_reviews WHERE pro_id = '{$pro_id}'";
            $res1 = mysqli_query($conn, $que1) or die("Query error");
            $rating = mysqli_fetch_assoc($res1);
            
            $product['review_count'] = $rating['review_count'];
            $product['avg_rating'] = $rating['avg_rating'];
            $final_output[] = $product;
        }

        echo json_encode($final_output);
    }

mysqli_close($conn);
?>
