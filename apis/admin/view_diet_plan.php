<?php
include_once '../cors.php';
include_once '../config/database.php';
include_once '../objects/DietPlan.php';

include_once 'AdminSession.php';
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
    echo json_encode(array(
        "message" => "Id is required",
    ));
    return;
}

$obj = new DietPlan($db);

$obj->id = number_format(isset($_GET['id']) ? (int)$_GET['id'] : die());
$stmt = $obj->fetchOne();

if ($stmt->rowCount() > 0) {
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo json_encode(array(
            "item" => $row,
        ));
        return;
    }

} else {
    http_response_code(404);
    echo json_encode(array(
        "message" => "Item is not valid"
    ));
}