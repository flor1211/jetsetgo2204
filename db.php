<?php
class Database {
    private $host = 'localhost';
    private $db_name = 'jetsetgodb';
    private $username = 'root';
    private $password = '';
    private $port = '3307';  // Specify the correct port if it's not the default
    public $conn;

    public function getConnection() {
        $this->conn = null;

        try {
            
            $this->conn = new PDO("mysql:host=" . $this->host . ";port=" . $this->port . ";dbname=" . $this->db_name, 
                                  $this->username, 
                                  $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $exception) {
            echo "Connection failed: " . $exception->getMessage();
        }

        return $this->conn;
    }
}
?>
