<?php
 
// get database connection
include_once '../config/database.php';
 
// instantiate user object
include_once '../objects/payment.php';
 
$database = new Database();
$db = $database->getConnection();
 
$payment = new Payment($db);
 
// set user property values
$payment->userId = $_POST['userId'];
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