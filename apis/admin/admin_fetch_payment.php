<?php 
    include_once '../config/database.php';
    include_once '../objects/payment.php';
    // get database connection
    $database = new Database();
    $db = $database->getConnection();
    
    // prepare user object
    $payment = new Payment($db);

    $stmt = $payment->fetchPayments();
    
    if($stmt->rowCount() > 0) {     // <--- change to $result->...!
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo json_encode(array(
                "status" => true,
                "id" => $row['id'],
                "userId" => $row['userId'],
                "amount" => $row['amount'],

            ));
        }
        // create array
    }
    else{
        http_response_code(400);
        echo json_encode(array(
            "status" => false,
            "message" => "Network Error",
        ));
    }

    header('Content-Type: application/json');
    //echo json_encode($user_arr);
?>