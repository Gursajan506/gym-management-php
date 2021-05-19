<?php
include_once '../cors.php';
include_once '../config/database.php';
include_once '../objects/DietPlan.php';
include_once '../objects/user.php';
include_once '../objects/Trainer.php';
include_once '../objects/Workout.php';
include_once '../objects/payment.php';
$database = new Database();
$db = $database->getConnection();

$diet = new DietPlan($db);
$pt = new Trainer($db);
$workout = new Workout($db);

$stmt_diet = $diet->fetchAll();
$diets = [];
if ($stmt_diet->rowCount() > 0) {
    while ($row = $stmt_diet->fetch(PDO::FETCH_ASSOC)) {
        $diets[] = $row;
    }
}

$stmt_workouts = $workout->fetchAll();
$workouts = [];
if ($stmt_workouts->rowCount() > 0) {
    while ($row = $stmt_workouts->fetch(PDO::FETCH_ASSOC)) {
        $workouts[] = $row;
    }
}

$stmt_pt = $pt->fetchAll();
$pts = [];
if ($stmt_pt->rowCount() > 0) {
    while ($row = $stmt_pt->fetch(PDO::FETCH_ASSOC)) {
        $pts[] = $row;
    }
}

$items = array(
    "trainers" => $pts,
    "workouts" => $workouts,
    "diet_plans" => $diets,
);
echo json_encode(array(
    "dashboard" => $items,
));