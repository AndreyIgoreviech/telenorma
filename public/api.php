<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

require_once("database.php");

// Connection to DB
$database = new Database();
$db = $database->getConnection();

echo json_encode("Hello");
