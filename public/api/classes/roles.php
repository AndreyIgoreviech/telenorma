<?php

class Roles
{
    // Connection
    private $connection;

    // Table
    private $db_table = "roles";

    // Columns
    public $id;
    public $name;

    // Db connection
    public function __construct($db)
    {
        $this->connection = $db;
    }

    // GET ALL
    public function getRoles()
    {
        $sqlQuery = "SELECT id, name FROM " . $this->db_table . "";
        $stmt = $this->connection->prepare($sqlQuery);
        $stmt->execute();
        return $stmt;
    }
}

