<?php
 
// get database connection
include_once '../config/database.php';
 
// instantiate user object
include_once '../objects/payment.php';
 
$database = new Database();
$db = $database->getConnection();
 
$payment = new Payment($db);
 
// set user property values

$payment->userId = number_format(isset($_POST['userId']) ? $_POST['userId'] : die());
$payment->amount = isset($_POST['amount']) ? $_POST['amount'] : die();
$payment->created = date('Y-m-d H:i:s');
$payment->id = number_format(isset($_POST['id'])? $_POST['id']: die());
$stmt = $payment->updatePayment();
// create the user
if($stmt->rowCount() > 0){
    // get retrieved row
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
?>