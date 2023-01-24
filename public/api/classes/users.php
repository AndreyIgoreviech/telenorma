<?php

class Users
{
    // Connection
    private $connection;

    // Table
    private $db_table = "users";
    private $db_table_role = "roles";

    // Columns
    public $id;
    public $firstname;
    public $lastname;
    public $roleId;
    public $role;
    public $created;
    public $updated;

    // Db connection
    public function __construct($db)
    {
        $this->connection = $db;
    }

    // GET ALL
    public function getUsers()
    {
        $sqlQuery = "SELECT t1.id, t1.firstname, t1.lastname, t1.roleId, t2.name AS 'role', t1.created, t1.updated
                    FROM " . $this->db_table . " AS t1 JOIN " . $this->db_table_role . " AS t2
                    WHERE t1.roleId = t2.id";
        $stmt = $this->connection->prepare($sqlQuery);
        $stmt->execute();
        return $stmt;
    }

    // CREATE
    public function createUser()
    {
        $sqlQuery = "INSERT INTO
                        " . $this->db_table . "
                    SET
                        firstname = :firstname,
                        lastname = :lastname, 
                        roleId = :roleId";

        $stmt = $this->connection->prepare($sqlQuery);

        // sanitize
        $this->firstname = htmlspecialchars(strip_tags($this->firstname));
        $this->lastname = htmlspecialchars(strip_tags($this->lastname));
        $this->roleId = htmlspecialchars(strip_tags($this->roleId));

        // bind data
        $stmt->bindParam(":firstname", $this->firstname);
        $stmt->bindParam(":lastname", $this->lastname);
        $stmt->bindParam(":roleId", $this->roleId);

        if ($stmt->execute()) {
            $this->id = $this->connection->lastInsertId();
            $this->getUser();
            return $this;
        }
        return false;
    }

    // READ single
    public function getUser()
    {
        $sqlQuery = "SELECT t1.id, t1.firstname, t1.lastname, t1.roleId, t2.name AS 'role', t1.created, t1.updated
                    FROM " . $this->db_table . " AS t1 JOIN " . $this->db_table_role . " AS t2
                    WHERE t1.roleId = t2.id AND t1.id = :id 
                    LIMIT 0,1";
        $stmt = $this->connection->prepare($sqlQuery);
        $stmt->bindParam(":id", $this->id);
        $stmt->execute();
        $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->id = intval($dataRow['id']);
        $this->firstname = $dataRow['firstname'];
        $this->lastname = $dataRow['lastname'];
        $this->roleId = $dataRow['roleId'];
        $this->role = $dataRow['role'];
        $this->created = $dataRow['created'];
        $this->updated = $dataRow['updated'];
    }

    // UPDATE
    public function updateUser()
    {
        $sqlQuery = "UPDATE
                        " . $this->db_table . "
                    SET
                        firstname = :firstname,
                        lastname = :lastname, 
                        roleId = :roleId, 
                        updated = :updated
                    WHERE 
                        id = :id";

        $stmt = $this->connection->prepare($sqlQuery);

        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->firstname = htmlspecialchars(strip_tags($this->firstname));
        $this->lastname = htmlspecialchars(strip_tags($this->lastname));
        $this->roleId = htmlspecialchars(strip_tags($this->roleId));

        // bind data
        $stmt->bindParam(":firstname", $this->firstname);
        $stmt->bindParam(":lastname", $this->lastname);
        $stmt->bindParam(":roleId", $this->roleId);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // DELETE
    function deleteUser()
    {
        $sqlQuery = "DELETE FROM " . $this->db_table . " WHERE id = ?";
        $stmt = $this->connection->prepare($sqlQuery);

        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(1, $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
