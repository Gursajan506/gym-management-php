<?php
include_once '../cors.php';
include_once '../config/database.php';
include_once '../objects/DietPlan.php';
include_once '../objects/user.php';
include_once '../objects/Trainer.php';
include_once '../objects/Workout.php';
include_once '../objects/payment.php';
include_once 'AdminSession.php';
$database = new Database();
$db = $database->getConnection();

$admin_session = new AdminSession();
if (!$admin_session->isAdminLoggedIn()) {
    http_response_code(401);
    return;
}
$diet = new DietPlan($db);
$users = new User($db);
$pt = new Trainer($db);
$workout = new Workout($db);
$payment = new Payment($db);


$items = array(
    array(
        "title" => "Growth",
        "percentage" => "-",
        "action_link" => "",
    ),
    array(
        "title" => "User",
        "percentage" => $users->count(),
        "action_link" => "/admin/users",
    ),
    array(
        "title" => "Payments",
        "percentage" => $payment->count(),
        "action_link" => "/admin/payments",
    ),
    array(
        "title" => "Personal Trainers",
        "percentage" => $pt->count(),
        "action_link" => "/admin/trainers",
    ),
    array(
        "title" => "Workout",
        "percentage" => $workout->count(),
        "action_link" => "/admin/workouts",
    ),
    array(
        "title" => "Diet Plan",
        "percentage" => $diet->count(),
        "action_link" => "/admin/diets",
    ),
);
echo json_encode(array(
    "dashboard" => $items,
));