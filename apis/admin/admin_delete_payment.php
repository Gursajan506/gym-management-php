<?php
 
// get database connection
include_once '../config/database.php';
 
// instantiate user object
include_once '../objects/payment.php';
 
$database = new Database();
$db = $database->getConnection();
 
$payment = new Payment($db);
 
// set user property values
$payment->id = number_format(isset($_POST['id'])? $_POST['id']: die());
$stmt = $payment->deletePayment();
// create the user
if($stmt->rowCount() > 0){
    // get retrieved row
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    // create array

    $user_arr=array(
        "status" => true,
        "message" => "Deleted Successfully",
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