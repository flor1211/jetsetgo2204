<?php
require_once 'flightsDB.php';

class Crud {

    private $conn;

    public function __construct(){
        $db = new Database();
        $this->conn = $db->getConnection();
    }
    
        
    public function getAllFlights() {
        $stmt = $this->conn->prepare("CALL getAllFlights()");
        $stmt->execute();
        $result = $stmt->fetchAll();
        // var_dump($result);
        return $result;
    }



    public function addFlight($departure_location, $departure_time, $arrival_location, $arrival_time, $date, $plane_number, $seats_available, $price) {
        $stmt = $this->conn->prepare("CALL addFlight(:departure_location, :departure_time, :arrival_location, :arrival_time, :date, :plane_number, :seats_available, :price)");
        $stmt->execute([':departure_location' => $departure_location, ':departure_time' => $departure_time, ':arrival_location' => $arrival_location, ':arrival_time' => $arrival_time, ':date' => $date, ':plane_number' => $plane_number, ':seats_available' => $seats_available, ':price' => $price]);
    }

    public function updateFlight($departure_location, $departure_time, $arrival_location,$arrival_time, $date, $plane_number, $seats_available, $price) {
        $stmt = $this->conn->prepare("CALL addFlight(:departure_location, :departure_time, :arrival_location, :arrival_time, :date, :plane_number, :seats_available, :price)");
        $stmt->execute([':departure_location' => $departure_location, ':departure_time' => $departure_time, ':arrival_location' => $arrival_location, ':arrival_time' => $arrival_time, ':date' => $date, ':plane_number' => $plane_number, ':seats_available' => $seats_available, ':price' => $price]);
    }

    public function deleteFlight($id) {
        $stmt = $this->conn->prepare("CALL deleteFlight(:id)");
        return $stmt->execute([':id' => $id]);
    }



}

?>