<?php
include_once '../cors.php';
include_once '../config/database.php';
include_once '../objects/Trainer.php';

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
    header('Content-Type: application/json');
    echo json_encode(array(
        "message" => "Id is required",
    ));
    return;
}

if(!isset($_POST['name']) ||empty($_POST['name'])){
    http_response_code(404);
    header('Content-Type: application/json');
    echo json_encode(array(
        "message" => "name is required",
    ));
    return;
}

if(!isset($_POST['image']) ||empty($_POST['image'])){
    http_response_code(404);
    header('Content-Type: application/json');
    echo json_encode(array(
        "message" => "image is required",
    ));
    return;
}

if(!isset($_POST['experience']) ||empty($_POST['experience'])){
    http_response_code(404);
    header('Content-Type: application/json');
    echo json_encode(array(
        "message" => "experience is required",
    ));
    return;
}



$trainer = new Trainer($db);
 
// set user property values
$trainer->name =  $_POST['name'];
$trainer->image =  $_POST['image'];
$trainer->id =(int) $_POST['id'];
$trainer->experience = $_POST['experience'];
$stmt = $trainer->update();
if($stmt->rowCount() > 0){
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    // create array
    $user_arr=array(
        "status" => true,
        "message" => "Updated Successfully",
    );
}
else{
    http_response_code(400);
    $user_arr=array(
        "status" => false,
        "message" => "Something went wrong",
    );
}

header('Content-Type: application/json');
echo json_encode($user_arr);
