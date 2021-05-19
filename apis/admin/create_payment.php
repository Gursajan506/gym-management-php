<?php
include_once '../cors.php';
// get database connection
include_once '../config/database.php';
 
// instantiate user object
include_once '../objects/payment.php';
include_once '../objects/user.php';

include_once 'AdminSession.php';
 
$database = new Database();
$db = $database->getConnection();

$admin_session=new AdminSession();
if(!$admin_session->isAdminLoggedIn()){
    http_response_code(401);
    return;
}

if(!isset($_POST['user_id']) ||empty($_POST['user_id'])){
    http_response_code(404);
    header('Content-Type: application/json');
    echo json_encode(array(
        "message" => "user id is required",
    ));
    return;
}

if(!isset($_POST['amount']) ||empty($_POST['amount'])){
    http_response_code(404);
    header('Content-Type: application/json');
    echo json_encode(array(
        "message" => "Amount is required",
    ));
    return;
}


$user=new User($db);
$user->id=number_format($_POST['user_id']);
if(!$user->isIdAlreadyExist()){
    http_response_code(404);
    header('Content-Type: application/json');
    echo json_encode(array(
        "message" => "User doesn't exist",
    ));
    return;
}
$payment = new Payment($db);
 
// set user property values
$payment->user_id = $_POST['user_id'];
$payment->amount = $_POST['amount'];
$payment->created = date('Y-m-d H:i:s');


// create the user
if($payment->createPayment()){
    $payment_arr=array(
        "status" => true,
        "message" => "Payment Created Successfully!",
        "id" => $payment->id,
        "amount" => $payment->amount
    );
}
else{
    $payment_arr=array(
        "status" => false,
        "message" => "Something went wrong!"
    );
}
print_r(json_encode($payment_arr));
?>