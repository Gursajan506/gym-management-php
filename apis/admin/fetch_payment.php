<?php
include_once '../config/database.php';
include_once '../objects/payment.php';

include_once 'AdminSession.php';
// get database connection
$database = new Database();
$db = $database->getConnection();
$admin_session = new AdminSession();
if (!$admin_session->isAdminLoggedIn()) {
    http_response_code(401);
    return;
}

// prepare user object



$payment = new Payment($db);

$stmt = $payment->fetchPayments();



if ($stmt->rowCount() > 0) {     // <--- change to $result->...!
    $payments=[];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $payments[]=$row;
    }
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $users[]=$row;
    }
    echo json_encode($payments);
    // create array
} else {
    http_response_code(400);
    echo json_encode(array(
        "status" => false,
        "message" => "Network Error",
    ));
}

header('Content-Type: application/json');
//echo json_encode($user_arr);
?>