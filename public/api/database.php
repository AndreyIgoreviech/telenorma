<?php

class Database
{
    private $host = "telenorma_db"; // this is name of docker container not localhost
    private $database_name = "telenorma_db"; // same name like container for DB
    private $username = "telenorma_user_db";
    private $password = "134&d%25hiortg@%T31f2_45QWD";
    public $conn;

    public function getConnection()
    {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->database_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
        } catch (PDOException $exception) {
            echo "Database could not be connected: " . $exception->getMessage();
        }
        return $this->conn;
    }
}

?>
