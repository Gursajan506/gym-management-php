<?php
include_once '../cors.php';
include_once '../config/database.php';
include_once '../objects/Trainer.php';

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
$trainer = new Trainer($db);

$stmt = $trainer->fetchAll();

if ($stmt->rowCount() > 0) {
    $trainers=[];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $trainers[]=$row;
    }

    echo json_encode(array(
        "items" => $trainers,
    ));
    return;
    // create array
} else {

    echo json_encode(array(
        "items" => [],
    ));
}