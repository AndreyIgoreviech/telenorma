<?php
require_once("headers.php");
require_once("database.php");
require_once("classes/users.php");

$isResponseError = false;

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $database = new Database();
    $db = $database->getConnection();

    if (isset($_GET['id'])) {
        if($id = intval($_GET['id'])) {
            $user = new Users($db);
            $user->id = $id;
            $user->getUser();
            echo json_encode($user);
        } else {
            http_response_code(400);
            echo json_encode(
                array("message" => "Wrong param ID: '" . $_GET['id'] ."'")
            );
            die();
        }
    } else {
        $items = new Users($db);
        $stmt = $items->getUsers();
        $itemCount = $stmt->rowCount();

        if ($itemCount > 0) {
            $users = array();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                $user = array(
                    "id" => $id,
                    "firstname" => $firstname,
                    "lastname" => $lastname,
                    "roleId" => $roleId,
                    "role" => $role,
                    "created" => $created,
                    "updated" => $updated
                );
                $users[] = $user;
            }
            echo json_encode($users);
        } else {
            http_response_code(404);
            echo json_encode(
                array("message" => "No users found")
            );
        }
    }

    die();
} else {
    $isResponseError = true;
}

if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    $database = new Database();
    $db = $database->getConnection();
    $user = new Users($db);

    parse_str(file_get_contents("php://input"), $data);
    $user->firstname = $data['firstname'] ?? null;
    $user->lastname = $data['lastname'] ?? null;
    $user->roleId = $data['roleId'] ?? null;

    echo json_encode($user->createUser());

    die();
} else {
    $isResponseError = true;
}

if ($isResponseError) {
    http_response_code(405);
    echo json_encode(
        array("message" => "Method " . $_SERVER['REQUEST_METHOD'] . " not allowed")
    );
}
