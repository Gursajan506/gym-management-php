<?php
include_once '../cors.php';
// get database connection
include_once '../config/database.php';
 
// instantiate user object
include_once '../objects/user.php';

include_once 'AdminSession.php';
 
$database = new Database();
$db = $database->getConnection();



$admin_session=new AdminSession();
if(!$admin_session->isAdminLoggedIn()){
    http_response_code(401);
    header('Content-Type: application/json');
    return;
}


if(!isset($_POST['username']) ||empty($_POST['username'])){
    http_response_code(404);
    header('Content-Type: application/json');
    echo json_encode(array(
        "message" => "User name is required",
    ));
    return;
}
if(!isset($_POST['password']) ||empty($_POST['password'])){
    http_response_code(404);
    header('Content-Type: application/json');
    echo json_encode(array(
        "message" => "Password is required",
    ));
    return;
}


$user = new User($db);
 
// set user property values
$user->username = $_POST['username'];
$user->password = base64_encode($_POST['password']);
$user->created = date('Y-m-d H:i:s');
 
// create the user
if($user->adminCreateUser()){
    $user_arr=array(
        "status" => true,
        "message" => "user Created Successfully!",
        "id" => $user->id,
        "username" => $user->username
    );
}
else{
    $user_arr=array(
        "status" => false,
        "message" => "Username already exists!"
    );
}
print_r(json_encode($user_arr));
?>