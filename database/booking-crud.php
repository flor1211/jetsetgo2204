<?php
require_once 'database.php';

class Crud {

    private $conn;

    public function __construct(){
        $db = new Database();
        $this->conn = $db->getConnection();
    }


    /* SELECTING FLIGHTS page */

    public function searchAvailableFlights($dep, $arr) {
        $stmt = $this->conn->prepare("CALL searchAvailableFlights(:dep_code, :arr_code)");
        $stmt->execute([
            ':dep_code' => $dep,
            ':arr_code' => $arr
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getFlightById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM flights WHERE flight_id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


}
?>