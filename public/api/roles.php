<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

require_once("database.php");
require_once("../classes/roles.php");

// Connection to DB
$database = new Database();
$db = $database->getConnection();

$items = new Role($db);
$stmt = $items->getRoles();
$itemCount = $stmt->rowCount();

if ($itemCount > 0) {
    $roles = array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $role = array(
            "id" => $id,
            "name" => $name
        );
        $roles[] = $role;
    }
    echo json_encode($roles);
} else {
    http_response_code(404);
    echo json_encode(
        array("message" => "No roles found.")
    );
}


