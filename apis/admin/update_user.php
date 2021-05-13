<?php
 
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

if(!isset($_POST['id']) ||empty($_POST['id'])){
    http_response_code(404);
    header('Content-Type: application/json');
    echo json_encode(array(
        "message" => "Id is required",
    ));
    return;
}




 
$user = new User($db);
 
// set user property values

$user->username = isset($_POST['username']) ? $_POST['username'] : die();
$user->password = base64_encode(isset($_POST['password']) ? $_POST['password'] : die());
$user->created = date('Y-m-d H:i:s');
$user->id = number_format(isset($_POST['id'])? $_POST['id']: die());
$stmt = $user->updateUser();
// create the user
if($stmt->rowCount() > 0){
    // get retrieved row
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    // create array
    $_SESSION['username'] = $_POST['username'];
    $user_arr=array(
        "status" => true,
        "message" => "Updated Successfully",
    );
}
else{
    http_response_code(400);
    $user_arr=array(
        "status" => false,
        "message" => "user does not Exist",
    );
}

header('Content-Type: application/json');
echo json_encode($user_arr);
?>