<?php
require_once("headers.php");
require_once("database.php");
require_once("classes/users.php");

$isResponseError = false;

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $database = new Database();
    $db = $database->getConnection();

    if (isset($_GET['id'])) {
        if ($id = intval($_GET['id'])) {
            $user = new Users($db);
            $user->id = $id;
            $user->getUser();
            if ($user->id) {
                echo json_encode($user);
            } else {
                echo json_encode(false);
            }
        } else {
            http_response_code(400);
            echo json_encode(
                array("message" => "Wrong param ID: '" . $_GET['id'] . "'")
            );
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
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $database = new Database();
    $db = $database->getConnection();
    $user = new Users($db);

    parse_str(file_get_contents("php://input"), $data);
    $user->id = $data['id'] ?? null;
    $user->firstname = $data['firstname'] ?? null;
    $user->lastname = $data['lastname'] ?? null;
    $user->roleId = $data['roleId'] ?? null;

    echo json_encode($user->updateUser());

    die();
}

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $database = new Database();
    $db = $database->getConnection();

    parse_str(file_get_contents("php://input"), $data);
    $id = intval($data['id']);

    if ($id) {
        $user = new Users($db);
        $user->id = $id;
        if ($user->deleteUser()) {
            echo json_encode($id);
        } else {
            echo json_encode(0);
        }
    } else {
        http_response_code(404);
        echo json_encode(
            array("message" => "User with this  found")
        );
    }

    die();
}

http_response_code(405);
echo json_encode(
    array("message" => "Method " . $_SERVER['REQUEST_METHOD'] . " not allowed")
);
