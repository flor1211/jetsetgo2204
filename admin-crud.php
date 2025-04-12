<?php
require_once 'flightsDB.php';

class Crud {

    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    public function getAllFlights() {
        $stmt = $this->conn->prepare("CALL getAllFlights()");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

   public function addFlight($departure_location, $departure_time, $arrival_location, $arrival_time, $date, $plane_code, $seats_available, $price) {
    $stmt = $this->conn->prepare("CALL addFlight(:dep_loc, :dep_time, :arr_loc, :arr_time, :flight_date, :pcode, :number_of_seats, :flight_price)");
    $stmt->execute(params: [
        ':dep_loc' => $departure_location,
        ':dep_time' => $departure_time,
        ':arr_loc' => $arrival_location,
        ':arr_time' => $arrival_time,
        ':flight_date' => $date,
        ':pcode' => $plane_code,
        ':number_of_seats' => $seats_available,
        ':flight_price' => $price

    ]);
}


    public function updateFlight($id, $departure_location, $departure_time, $arrival_location, $arrival_time, $date, $plane_code, $seats_available, $price) {
        $stmt = $this->conn->prepare("CALL updateFlight(:id, :departure_location, :departure_time, :arrival_location, :arrival_time, :date, :plane_number, :seats_available, :price)");
        $stmt->execute([
            ':id' => $id,
            ':departure_location' => $departure_location,
            ':departure_time' => $departure_time,
            ':arrival_location' => $arrival_location,
            ':arrival_time' => $arrival_time,
            ':date' => $date,
            ':plane_code' => $plane_code,
            ':seats_available' => $seats_available,
            ':price' => $price
        ]);
    }

    public function deleteFlight($id) {
        $stmt = $this->conn->prepare("CALL deleteFlight(:id)");
        $stmt->execute([':id' => $id]);
    }
}
?>
