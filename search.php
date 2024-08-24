<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

$search_keyword = $_POST['search_keyword'];
include "config.php";

$que = "SELECT pro_id, pro_name, price, discount, pro_image FROM product 
          WHERE pro_name LIKE '%$search_keyword%' 
          OR pro_description LIKE '%$search_keyword%'
          OR brand_name LIKE '%$search_keyword%'";
$res = mysqli_query($conn, $que) or die("Query error");

if (mysqli_num_rows($res) > 0)
{
    $products = mysqli_fetch_all($res, MYSQLI_ASSOC);
    $final_output = [];

    foreach ($products as $product) 
    {
        $pro_id = $product['pro_id'];
        $q = "SELECT COUNT(review_id) as review_count, AVG(rating) as avg_rating FROM pro_reviews WHERE pro_id = '{$pro_id}'";
        $r = mysqli_query($conn, $q) or die(json_encode(["error" => "Query error: " . mysqli_error($conn)]));
        $rating = mysqli_fetch_assoc($r);
        $product['review_count'] = $rating['review_count'];
        $product['avg_rating'] = $rating['avg_rating'];
        $final_output[] = $product;
    }
    echo json_encode($final_output);
    }
else
{
    $que1 = "SELECT cat_id FROM categories WHERE category LIKE '%$search_keyword%'";
    $res1 = mysqli_query($conn, $que1) or die(json_encode(["error" => "Query error: " . mysqli_error($conn)]));
    if (mysqli_num_rows($res1) > 0)
    {
        $output1 = mysqli_fetch_all($res1, MYSQLI_ASSOC);
        $final_output = [];

        foreach ($output1 as $category) 
        {
            $cat_id = $category['cat_id'];
            $q1 = "SELECT pro_id, pro_name, price, discount, pro_image FROM product WHERE cat_id = '{$cat_id}'";
            $r1 = mysqli_query($conn, $q1) or die(json_encode(["error" => "Query error: " . mysqli_error($conn)]));
            $pro = mysqli_fetch_all($r1, MYSQLI_ASSOC);

            foreach ($pro as $product) 
            {
                $pro_id = $product['pro_id'];
                $q2 = "SELECT COUNT(review_id) as review_count, AVG(rating) as avg_rating FROM pro_reviews WHERE pro_id = '{$pro_id}'";
                $r2 = mysqli_query($conn, $q2) or die(json_encode(["error" => "Query error: " . mysqli_error($conn)]));
                $rating = mysqli_fetch_assoc($r2);
                
                $product['review_count'] = $rating['review_count'];
                $product['avg_rating'] = $rating['avg_rating'];
                $final_output[] = $product;
            }
        }
        echo json_encode($final_output);
    }
    else
    {
        $que2 = "SELECT sub_cat_id FROM sub_categories WHERE sub_category LIKE '%$search_keyword%' OR sub_cat_description LIKE '%$search_keyword%'";
        $res2 = mysqli_query($conn, $que2) or die("Query error");
        if (mysqli_num_rows($res2) > 0)
        {
            $output = mysqli_fetch_all($res2, MYSQLI_ASSOC);
            $final_output = [];
    
            foreach ($output as $subcategory) 
            {
                $sub_cat_id = $subcategory['sub_cat_id'];
                $q1 = "SELECT pro_id, pro_name, price, discount, pro_image FROM product WHERE sub_cat_id = '{$sub_cat_id}'";
                $r1 = mysqli_query($conn, $q1) or die(json_encode(["error" => "Query error: " . mysqli_error($conn)]));
                $pro = mysqli_fetch_all($r1, MYSQLI_ASSOC);
    
                foreach ($pro as $product) 
                {
                    $pro_id = $product['pro_id'];
                    $q2 = "SELECT COUNT(review_id) as review_count, AVG(rating) as avg_rating FROM pro_reviews WHERE pro_id = '{$pro_id}'";
                    $r2 = mysqli_query($conn, $q2) or die(json_encode(["error" => "Query error: " . mysqli_error($conn)]));
                    $rating = mysqli_fetch_assoc($r2);
                    
                    $product['review_count'] = $rating['review_count'];
                    $product['avg_rating'] = $rating['avg_rating'];
                    $final_output[] = $product;
                }
            }
            echo json_encode($final_output);
        }
        else
        {
            $que3 = "SELECT under_cat_id, under_category FROM under_categories WHERE under_category LIKE '%$search_keyword%'";
            $res3 = mysqli_query($conn, $que3) or die("Query error");
            if (mysqli_num_rows($res3) > 0)
            {
                $output1 = mysqli_fetch_all($res3, MYSQLI_ASSOC);
                $final_output = [];
                foreach ($output1 as $product) 
                {
                    $under_cat_id = $product['under_cat_id'];
                    $q1 = "SELECT pro_id, pro_name, price, discount, pro_image FROM product WHERE under_cat_id = '{$under_cat_id}'";
                    $r1 = mysqli_query($conn, $q1) or die(json_encode(["error" => "Query error: " . mysqli_error($conn)]));
                    $pro = mysqli_fetch_all($r1, MYSQLI_ASSOC);

                    foreach ($pro as $product) 
                    {
                        $pro_id = $product['pro_id'];
                        $q2 = "SELECT COUNT(review_id) as review_count, AVG(rating) as avg_rating FROM pro_reviews WHERE pro_id = '{$pro_id}'";
                        $r2 = mysqli_query($conn, $q2) or die(json_encode(["error" => "Query error: " . mysqli_error($conn)]));
                        $rating = mysqli_fetch_assoc($r2);
                        
                        $product['review_count'] = $rating['review_count'];
                        $product['avg_rating'] = $rating['avg_rating'];
                        $final_output[] = $product;
                    }
                }
                echo json_encode($final_output);
            }
            else
            {
                echo json_encode(array('message' => 'No record found', 'status' => false));
            }
        }
    }
}
mysqli_close($conn);
?>
