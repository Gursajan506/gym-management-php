<?php
include_once '../cors.php';
// include database and object files
include_once '../config/database.php';
include_once '../objects/admin.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();

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




// prepare user object
$admin = new Admin($db);
// set ID property of admin to be edited
$admin->username = isset($_POST['username']) ? $_POST['username'] : die();
$admin->password = base64_encode(isset($_POST['password']) ? $_POST['password'] : die());
// read the details of user to be edited
$stmt = $admin->adminLogin();
if($stmt->rowCount() > 0){
    // get retrieved row
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    // create array
    $_SESSION['username'] = $_POST['username'];
    $_SESSION['is_admin'] = true;
    $admin_arr=array(
        "status" => true,
        "message" => "Successfully Login!",
        "id" => $row['id'],
        "username" => $row['username']
    );
}
else{
    http_response_code(400);
    $admin_arr=array(
        "status" => false,
        "message" => "Invalid Admin name or Password!",
    );
}

header('Content-Type: application/json');
echo json_encode($admin_arr);
