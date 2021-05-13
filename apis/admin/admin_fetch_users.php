<?php 
    include_once '../config/database.php';
    include_once '../objects/user.php';
    // get database connection
    $database = new Database();
    $db = $database->getConnection();
    
    // prepare user object
    $user = new User($db);

    $stmt = $user->fetchUsers();
    
    if($stmt->rowCount() > 0) {     // <--- change to $result->...!
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo json_encode(array(
                "status" => true,
                "id" => $row['id'],
                "username" => $row['username'],

            ));
        }
        // create array
    }
    else{
        http_response_code(400);
        echo json_encode(array(
            "status" => false,
            "message" => "Username does not exist!",
        ));
    }

    header('Content-Type: application/json');
    //echo json_encode($user_arr);
?>