<?php
include_once '../cors.php';
include_once '../config/database.php';
include_once '../objects/Workout.php';

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
        "message" => "id is required",
    ));
    return;
}

$obj = new Workout($db);

$obj->id =(int) $_POST['id'];
$stmt = $obj->delete();
if($stmt->rowCount() > 0){
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    // create array

    $response=array(
        "status" => true,
        "message" => "Deleted Successfully",
    );
}
else{
    http_response_code(400);
    $response=array(
        "status" => false,
        "message" => "Something went wrong",
    );
}
echo json_encode($response);