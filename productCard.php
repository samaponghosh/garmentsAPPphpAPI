<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

$pro_id = $_POST['pro_id'];

include "config.php";

$query = "SELECT * FROM product WHERE pro_id = {$pro_id};";

$result = $conn->query($query);
if ($result->num_rows > 0) {
    $products = $result->fetch_all(MYSQLI_ASSOC);
    $final_output = [];
    $size_output = [];
    $color_output = [];

    foreach ($products as $product) {
        $pro_id = $product['pro_id'];
        
        $que1 = "SELECT COUNT(review_id) as review_count, AVG(rating) as avg_rating FROM pro_reviews WHERE pro_id = '{$pro_id}'";
        $res1 = $conn->query($que1);
        
        if ($res1) {
            $rating = $res1->fetch_assoc();
            $product['review_count'] = $rating['review_count'];
            $product['avg_rating'] = $rating['avg_rating'];
        } else {
            $product['review_count'] = 0;
            $product['avg_rating'] = 0;
        }
        
        $final_output[] = $product;
    }
    
    $que2 = "SELECT size_id, size FROM pro_sizes WHERE pro_id = '{$pro_id}'";
    $res2 = $conn->query($que2);
    
    if ($res2) {
        $sizes = $res2->fetch_all(MYSQLI_ASSOC);
        $size_output['sizes'] = $sizes;
    } else {
        $size_output['sizes'] = [];
    }
    
    $que3 = "SELECT color_id, color FROM pro_colors WHERE pro_id = '{$pro_id}'";
    $res3 = $conn->query($que3);
    
    if ($res3) {
        $colors = $res3->fetch_all(MYSQLI_ASSOC);
        $color_output['colors'] = $colors;
    } else {
        $color_output['colors'] = [];
    }
    
    echo json_encode([
        'products' => $final_output,
        'sizes' => $size_output['sizes'],
        'colors' => $color_output['colors']
    ]);
} 

mysqli_close($conn);
?>
