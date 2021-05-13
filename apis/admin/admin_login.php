<?php
// include database and object files
include_once '../config/database.php';
include_once '../objects/admin.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare user object
$admin = new Admin($db);
// set ID property of admin to be edited
$admin->adminname = isset($_POST['adminname']) ? $_POST['adminname'] : die();
$admin->password = base64_encode(isset($_POST['password']) ? $_POST['password'] : die());
// read the details of user to be edited
$stmt = $admin->adminLogin();
if($stmt->rowCount() > 0){
    // get retrieved row
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    // create array
    $_SESSION['adminname'] = $_POST['adminname'];
    $admin_arr=array(
        "status" => true,
        "message" => "Successfully Login!",
        "id" => $row['id'],
        "adminname" => $row['adminname']
    );
}
else{
    http_response_code(400);
    $admin_arr=array(
        "status" => false,
        "message" => "Invalid Adminname or Password!",
    );
}

header('Content-Type: application/json');
echo json_encode($admin_arr);
