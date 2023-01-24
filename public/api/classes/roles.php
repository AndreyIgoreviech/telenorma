<?php

class Roles
{
    // Connection
    private $conn;

    // Table
    private $db_table = "roles";

    // Columns
    public $id;
    public $name;

    // Db connection
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // GET ALL
    public function getRoles()
    {
        $sqlQuery = "SELECT id, name FROM " . $this->db_table . "";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->execute();
        return $stmt;
    }

    // CREATE
    public function createRole()
    {
        $sqlQuery = "INSERT INTO
                        " . $this->db_table . "
                    SET
                        name = :name";

        $stmt = $this->conn->prepare($sqlQuery);

        // sanitize
        $this->name = htmlspecialchars(strip_tags($this->name));

        // bind data
        $stmt->bindParam(":name", $this->name);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // READ single
    public function getRole()
    {
        $sqlQuery = "SELECT
                        id, 
                        name                
                      FROM
                        " . $this->db_table . "
                    WHERE 
                       id = ?
                    LIMIT 0,1";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
        $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->name = $dataRow['name'];
    }

    // UPDATE
    public function updateRole()
    {
        $sqlQuery = "UPDATE
                        " . $this->db_table . "
                    SET
                        name = :name,
                    WHERE 
                        id = :id";

        $stmt = $this->conn->prepare($sqlQuery);

        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->id = htmlspecialchars(strip_tags($this->id));

        // bind data
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":id", $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // DELETE
    function deleteRole()
    {
        $sqlQuery = "DELETE FROM " . $this->db_table . " WHERE id = ?";
        $stmt = $this->conn->prepare($sqlQuery);

        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(1, $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>
