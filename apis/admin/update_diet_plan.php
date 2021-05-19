<?php
include_once '../cors.php';
include_once '../config/database.php';
include_once '../objects/DietPlan.php';

include_once 'AdminSession.php';
 
$database = new Database();
$db = $database->getConnection();

$admin_session=new AdminSession();
if(!$admin_session->isAdminLoggedIn()){
    http_response_code(401);
    return;
}

if(!isset($_POST['id']) ||empty($_POST['id'])){
    http_response_code(404);
    echo json_encode(array(
        "message" => "Id is required",
    ));
    return;
}

if(!isset($_POST['title']) ||empty($_POST['title'])){
    http_response_code(404);
    echo json_encode(array(
        "message" => "title is required",
    ));
    return;
}

if(!isset($_POST['image']) ||empty($_POST['image'])){
    http_response_code(404);
    echo json_encode(array(
        "message" => "image is required",
    ));
    return;
}

if(!isset($_POST['description']) ||empty($_POST['description'])){
    http_response_code(404);
    echo json_encode(array(
        "message" => "description is required",
    ));
    return;
}

$obj = new DietPlan($db);
$obj->title =  $_POST['title'];
$obj->image =  $_POST['image'];
$obj->id =(int) $_POST['id'];
$obj->description = $_POST['description'];
$stmt = $obj->update();
if($stmt->rowCount() > 0){
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $response=array(
        "status" => true,
        "message" => "Updated Successfully",
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
