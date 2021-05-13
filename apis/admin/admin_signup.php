<?php
 
// get database connection
include_once '../config/database.php';
 
// instantiate user object
include_once '../objects/admin.php';
 
$database = new Database();
$db = $database->getConnection();
 
$admin = new Admin($db);
 
// set admin property values
$admin->adminname = $_POST['adminname'];
$admin->password = base64_encode($_POST['password']);
//$admin->created = date('Y-m-d H:i:s');
 
// create the user
if($admin->adminSignup()){
    $admin_arr=array(
        "status" => true,
        "message" => "Successfully Signup!",
        "id" => $admin->id,
        "username" => $admin->adminname
    );
}
else{
    $admin_arr=array(
        "status" => false,
        "message" => "admin name already exists!"
    );
}
print_r(json_encode($admin_arr));
?>