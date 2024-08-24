<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

// $data = json_decode(file_get_contents("php://input"),true);
$fullname = $_POST['name']; 
$email = $_POST['email'];
$passw = $_POST['password'];
// session_start();

if (empty($email) or empty($passw) or empty($fullname))
{
    echo json_encode(array('message' => 'Input parameters empty', 'status' => false));
    exit;
}
else
{
    $passw = md5($passw);
    include "config.php";
    $q = "SELECT cus_id FROM profile WHERE email = '{$email}';";
    $check = mysqli_query($conn,$q);
    $ch = mysqli_num_rows($check);
    
    if ($ch == 0 )
    {
        $que = "INSERT INTO profile(name, email, password) VALUES('{$fullname}','{$email}','{$passw}');";
        $res = mysqli_query($conn,$que) or die("Query error");
        // $_SESSION['user_email']=$email;
        
        $que1 = "SELECT cus_id, name, email FROM profile WHERE email = '{$email}' AND password = '{$passw}';";
        $res1 = mysqli_query($conn,$que1) or die("Query error");
        $output = mysqli_fetch_all($res1, MYSQLI_ASSOC);
        echo json_encode($output);
        echo json_encode(array('message' => 'New account created successfully', 'status' => 200));
        // if (mysqli_num_rows($res)>0)
        // {
        //     $output = mysqli_fetch_all($res, MYSQLI_ASSOC);
        //     $_SESSION['user_email']=$email;
        //     // $_SESSION['userName']=$output['name'];
        //     echo json_encode($output);
        // }
        // else
        // {
        //     echo json_encode(array('message' => 'Authentication failed', 'status' => false));
        // }
    }
    else
    {
        echo json_encode(array('message' => 'Email already exists', 'status' => false));
    }
}
mysqli_close($conn);
?>