<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

// $data = json_decode(file_get_contents("php://input"),true);
$email = $_POST['email'];
$passw = $_POST['password'];

if (empty($email) or empty($passw))
{
    echo json_encode(array('message' => 'Input parameters empty', 'status' => false));
    exit;
}
else
{
    $passw = md5($passw);
    include "config.php";
    // session_start();
    
    $q = "SELECT cus_id FROM profile WHERE email = '{$email}';";
    $check = mysqli_query($conn,$q);
    $ch = mysqli_num_rows($check);
    
    if ($ch > 0 )
    {
        $que = "SELECT cus_id, name, email FROM profile WHERE email = '{$email}' AND password = '{$passw}';";
        $res = mysqli_query($conn,$que) or die("Query error");
        
        if (mysqli_num_rows($res)>0)
        {
            $output = mysqli_fetch_all($res, MYSQLI_ASSOC);
            // $_SESSION['user_email']=$email;
            // $_SESSION['userName']=$output['name'];
            echo json_encode(array('message' => 'Authentication successfull', 'status' => 200));
            echo json_encode($output);
        }
        else
        {
            echo json_encode(array('message' => 'Authentication failed', 'status' => false));
        }
    }
    else
    {
        echo json_encode(array('message' => 'Email doesnot exists, Authentication failed', 'status' => false));
    }
    mysqli_close($conn);
}

?>