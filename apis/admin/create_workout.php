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
    return;
}

if (!isset($_POST['title']) || empty($_POST['title'])) {
    http_response_code(404);
    header('Content-Type: application/json');
    echo json_encode(array(
        "message" => "title is required",
    ));
    return;
}

if (!isset($_POST['image']) || empty($_POST['image'])) {
    http_response_code(404);
    header('Content-Type: application/json');
    echo json_encode(array(
        "message" => "image is required",
    ));
    return;
}

if (!isset($_POST['description']) || empty($_POST['description'])) {
    http_response_code(404);
    header('Content-Type: application/json');
    echo json_encode(array(
        "message" => "description is required",
    ));
    return;
}


$obj = new Workout($db);
// set user property values
$obj->title = $_POST['title'];
$obj->image = $_POST['image'];
$obj->description = $_POST['description'];


// create the user
if ($obj->create()) {
    $response = array(
        "status" => true,
        "message" => "Workout created Successfully!",
        "id" => $obj->id
    );
} else {
    $response = array(
        "status" => false,
        "message" => "Something went wrong!"
    );
}
print_r(json_encode($response));