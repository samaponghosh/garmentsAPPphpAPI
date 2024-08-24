<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

$cat_id = $_POST['cat_id']; 
$sub_cat_id = $_POST['sub_cat_id'];

if (empty($cat_id) || empty($sub_cat_id)) {
    echo json_encode(array('message' => 'Input parameters wrong', 'status' => false));
} else {
    include "config.php";
    $que = "SELECT p.pro_id, p.pro_name, p.price, p.discount, p.pro_image FROM product p WHERE p.cat_id = {$cat_id} AND p.sub_cat_id = {$sub_cat_id} AND p.stock_quantity != 0;";
    $res = mysqli_query($conn, $que) or die("Query error");

    if (mysqli_num_rows($res) > 0) {
        $products = mysqli_fetch_all($res, MYSQLI_ASSOC);
        $final_output = [];

        foreach ($products as $product) {
            $pro_id = $product['pro_id'];
            $que1 = "SELECT COUNT(review_id) as review_count, AVG(rating) as avg_rating FROM pro_reviews WHERE pro_id = '{$pro_id}'";
            $res1 = mysqli_query($conn, $que1) or die("Query error");
            $rating = mysqli_fetch_assoc($res1);
            
            $product['review_count'] = $reviews['review_count'];
            $product['avg_rating'] = $rating['avg_rating'];
            $final_output[] = $product;
        }

        echo json_encode($final_output);
    } else {
        echo json_encode(array('message' => 'No record found', 'status' => false));
    }

    mysqli_close($conn);
}
?>
