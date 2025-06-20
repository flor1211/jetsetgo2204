<?php

class Database {
    private $host = 'localhost';
    private $db_name = 'jetsetgodb';
    private $username = 'root';
    private $password = '';
    private $port = '3306';
    private $conn;

    public function __construct(){
        $this->connect();
    }

    private function connect(){
        try {
            $this->conn = new PDO(
                "mysql:host={$this->host};dbname={$this->db_name}; port={$this->port};charset=utf8mb4",
                $this->username,
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        } catch (PDOException $e){
            die("Connection failed: " . $e->getMessage());
        }
    }

    public function getConnection() {
        return $this->conn;
        
    }
}

