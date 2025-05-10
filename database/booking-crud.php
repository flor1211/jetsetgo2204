<?php
require_once 'database.php';

class BookingCrud {

    private $conn;

    public function __construct(){
        $db = new Database();
        $this->conn = $db->getConnection();
    }


    /* SELECTING FLIGHTS page */

    public function searchAvailableFlights($dep, $arr, $date) {
        $stmt = $this->conn->prepare("CALL searchAvailableFlights(:dep_code, :arr_code, :flight_date)");
        $stmt->execute([
            ':dep_code' => $dep,
            ':arr_code' => $arr,
            ':flight_date' => $date
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getFlightById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM flights WHERE flight_id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    /* BOOKING */

    public function newBooking($flightID, $flightDate, $deptime, $depAcode, $depAlocation, $arrtime, $arrAcode, $arrAlocation, $planecode, $planephoto, $price) {
        $stmt = $this->conn->prepare("CALL addBooking(:flightId, :flightDate, :depTime, :depAirportcode, :depAirportlocation, :arrTime, :arrAirportcode, :arrAirportlocation, :planeCode, :planePhoto, :flightprice, @booking_id)");
        $stmt->bindParam(':flightId', $flightID);
        $stmt->bindParam(':flightDate', $flightDate);
        $stmt->bindParam(':depTime', $deptime);
        $stmt->bindParam(':depAirportcode', $depAcode);
        $stmt->bindParam(':depAirportlocation', $depAlocation);
        $stmt->bindParam(':arrTime', $arrtime);
        $stmt->bindParam(':arrAirportcode', $arrAcode);
        $stmt->bindParam(':arrAirportlocation', $arrAlocation);
        $stmt->bindParam(':planeCode', $planecode);
        $stmt->bindParam(':planePhoto', $planephoto);
        $stmt->bindParam(':flightprice', $price);

        $stmt-> execute();
        $result = $this->conn->query("SELECT @booking_id AS booking_id");
        $row = $result->fetch(PDO::FETCH_ASSOC);
        return $row['booking_id'];
    }
    

    public function addGuestDetails($bookingID, $title, $firstname, $lastname, $dob, $contactnumber, $nationality, $email){
        $stmt = $this->conn->prepare("CALL addGuestDetails(:bookingID, :gTitle, :gFirstName, :gLastName, :gDOB, :gContactNum, :gNationality, :gEmail)");
        $stmt->execute([':bookingID' => $bookingID,
                        ':gTitle' => $title,
                        ':gFirstName' => $firstname,
                        ':gLastName' => $lastname,
                        ':gDOB' => $dob,
                        ':gContactNum' => $contactnumber,
                        ':gNationality' => $nationality,
                        ':gEmail' => $email]);
    }

    public function getSelectedFlight($flightID) {
        $stmt = $this->conn->prepare("CALL getSelectedFlight(:flightID)");
        $stmt->execute([':flightID' => $flightID]);
        $result = $stmt->fetchAll();
        // var_dump($result);
        return $result;
    }

    public function searchPlane($planeCode) {
        $stmt = $this->conn->prepare("CALL searchPlane(:planeCode)");
        $stmt->execute([':planeCode' => $planeCode]);
        $result = $stmt->fetchAll();
        // var_dump($result);
        return $result;




    }


    // PAYMENT

    public function addPaymentCard($bookingID, $name, $num, $exp, $cvv) {
        $stmt = $this->conn->prepare("CALL addPaymentsCard(:bookingID, :name, :num, :exp, :cvv)");
        $stmt->bindParam(':bookingID', $bookingID);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':num', $num);
        $stmt->bindParam(':exp', $exp);
        $stmt->bindParam(':cvv', $cvv);


        $stmt-> execute();
    }

    public function addPaymentOnSite($bookingID, $name, $idnum) {
        $stmt = $this->conn->prepare("CALL addPaymentsOnSite(:bookingID, :name, :idnum)");
        $stmt->bindParam(':bookingID', $bookingID);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':idnum', $idnum);

        $stmt-> execute();

    }
}
?>