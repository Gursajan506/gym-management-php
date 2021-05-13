<?php
include_once './config/database.php';
include_once './objects/user.php';
// get database connection
$database = new Database();
$db = $database->getConnection();

if(!isset($_SESSION['username'])){
    http_response_code(401);
    header('Content-Type: application/json');
    return;
}
if(!isset($_SESSION['is_admin'])){
    http_response_code(401);
    header('Content-Type: application/json');
    return;
}
if($_SESSION['is_admin']){
    $user_arr = array(
        "username" => "Admin",
        "is_admin" => true,
    );
    header('Content-Type: application/json');
    echo json_encode($user_arr);
    return;
}

// prepare user object
$user = new User($db);
$user->username = $_SESSION['username'];
$stmt = $user->getUser();

if ($stmt->rowCount() > 0) {
    // get retrieved row
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    // create array
    $user_arr = array(
        "status" => true,
        "message" => "user get successfully!",
        "id" => $row['id'],
        "username" => $row['username']
    );
} else {
    http_response_code(400);
    $user_arr = array(
        "status" => false,
        "message" => "Username does not exist!",
    );
}

header('Content-Type: application/json');
echo json_encode($user_arr);
?>