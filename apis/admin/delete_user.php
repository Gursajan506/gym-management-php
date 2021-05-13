<?php
 
// get database connection
include_once '../config/database.php';
 
// instantiate user object
include_once '../objects/user.php';

include_once 'AdminSession.php';
 
$database = new Database();
$db = $database->getConnection();



$admin_session = new AdminSession();
if (!$admin_session->isAdminLoggedIn()) {
    http_response_code(401);
    header('Content-Type: application/json');
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
$user->id = number_format(isset($_POST['id'])? $_POST['id']: die());
$stmt = $user->deleteUser();
// create the user
if($stmt->rowCount() > 0){
    // get retrieved row
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    // create array

    $user_arr=array(
        "status" => true,
        "message" => "Deleted Successfully",
    );
}
else{
    http_response_code(400);
    $user_arr=array(
        "status" => false,
        "message" => "Cannot delete user. Payments are linked",
    );
}

header('Content-Type: application/json');
echo json_encode($user_arr);
?>