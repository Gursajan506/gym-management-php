<?php
include_once './config/database.php';
session_destroy();
header('Content-Type: application/json');