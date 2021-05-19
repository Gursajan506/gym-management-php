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

// prepare user object
$obj = new Workout($db);

$stmt = $obj->fetchAll();

if ($stmt->rowCount() > 0) {
    $items = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $items[] = $row;
    }

    echo json_encode(array(
        "items" => $items,
    ));
    return;
    // create array
} else {

    echo json_encode(array(
        "items" => [],
    ));
}