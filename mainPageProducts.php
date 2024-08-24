<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

$cat_id = isset($_POST['cat_id']) ? $_POST['cat_id'] : 2;
include "config.php";

// Fetch the last 8 subcategories
$que = "SELECT * FROM sub_categories WHERE cat_id = {$cat_id} ORDER BY sub_cat_id DESC LIMIT 8;";
$res = mysqli_query($conn, $que) or die("Query error");

if (mysqli_num_rows($res) > 0)
{
    $subcategories = mysqli_fetch_all($res, MYSQLI_ASSOC);
    $final_output = [];

    foreach ($subcategories as $subcategory) 
    {
        $sub_cat_id = $subcategory['sub_cat_id'];

        $que1 = "SELECT p.pro_id, p.pro_name, p.price, p.discount, p.pro_image FROM product p WHERE p.sub_cat_id = {$sub_cat_id} LIMIT 6;";
        $res1 = mysqli_query($conn, $que1) or die("Query error");

        if (mysqli_num_rows($res1) > 0) 
        {
            $products = mysqli_fetch_all($res1, MYSQLI_ASSOC);

            foreach ($products as &$product) 
            {
                $que2 = "SELECT COUNT(review_id) as review_count, AVG(rating) as avg_rating FROM pro_reviews WHERE pro_id = '{$product['pro_id']}'";
                $res2 = mysqli_query($conn, $que2) or die("Query error");
                $reviews = mysqli_fetch_assoc($res2);

                $product['review_count'] = $reviews['review_count'];
                $product['avg_rating'] = $reviews['avg_rating'];
            }

            $subcategory['products'] = $products;
        } 
        else 
        {
            $subcategory['products'] = [];
        }

        $final_output[] = $subcategory;
    }

    echo json_encode($final_output);
}
else 
{
    echo json_encode(array('message' => 'No record found', 'status' => false));
}

mysqli_close($conn);
?>
