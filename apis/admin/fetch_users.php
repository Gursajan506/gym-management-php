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

// prepare user object
$user = new User($db);

$stmt = $user->fetchUsers();

if ($stmt->rowCount() > 0) {
    $users=[];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $users[]=$row;
    }
    echo json_encode($users);
    return;
    // create array
} else {
    http_response_code(400);
    echo json_encode(array(
        "status" => false,
        "message" => "Username does not exist!",
    ));
}