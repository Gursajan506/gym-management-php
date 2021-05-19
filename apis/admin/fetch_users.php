<?php
include_once '../cors.php';
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

    echo json_encode(array(
        "users" => $users,
    ));
    return;
    // create array
} else {

    echo json_encode(array(
        "users" => [],
    ));
}