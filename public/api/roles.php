<?php
require_once("headers.php");
require_once("database.php");
require_once("classes/roles.php");

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $database = new Database();
    $db = $database->getConnection();

    $items = new Roles($db);
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
            array("message" => "No roles found")
        );
    }
} else {
    http_response_code(405);
    echo json_encode(
        array("message" => "Method " . $_SERVER['REQUEST_METHOD'] . " not allowed")
    );
}


