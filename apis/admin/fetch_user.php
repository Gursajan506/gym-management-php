<?php
include_once '../config/database.php';
include_once '../objects/user.php';

include_once 'AdminSession.php';
// get database connection
$database = new Database();
$db = $database->getConnection();

$admin_session = new AdminSession();
if (!$admin_session->isAdminLoggedIn()) {
    http_response_code(401);
    header('Content-Type: application/json');
    return;
}
if (!isset($_GET['id']) || empty($_GET['id'])) {
    http_response_code(404);
    header('Content-Type: application/json');
    echo json_encode(array(
        "message" => "Id is required",
    ));
    return;
}


// prepare user object
$user = new User($db);

$user->id = number_format(isset($_GET['id']) ? (int)$_GET['id'] : die());
$stmt = $user->fetchUser();

if ($stmt->rowCount() > 0) {
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo json_encode(array(
            "user" => $row,
        ));
        return;
    }


    // create array
} else {
    http_response_code(404);
    echo json_encode(array(
        "message" => "User is not valid"
    ));
}