<?php
require_once 'database.php';

class Crud {

    private $conn;

    public function __construct(){
        $db = new Database();
        $this->conn = $db->getConnection();
    }

// LOGIN page

    public function login($username, $password){

        $stmt = $this->conn->prepare("CALL AuthenticateUser(:username, :password)");
        $stmt->execute([':username' => $username, ':password' => $password]);
        $control = $stmt->fetch(PDO::FETCH_OBJ);
        
        if ($control) {

            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $control->account_username;
            $_SESSION['login_success'] = true;

            header("Location: admin/dashboard.php");
            exit;
        } else {
            $error = "Invalid username or password.";
            return $error;
        }
    }
    

// Airport page
        
    public function getAllAirports() {
        $stmt = $this->conn->prepare("CALL getallAirports()");
        $stmt->execute();
        $result = $stmt->fetchAll();
        // var_dump($result);
        return $result;
    }

    public function searchAirport($search) {
        $stmt = $this->conn->prepare("CALL searchAirport(:search)");
        $stmt->execute([':search' => $search]);
        $result = $stmt->fetchAll();
        // var_dump($result);
        return $result;
    }

    public function addAirport($airport_code, $airport_name, $airport_location) {
        $stmt = $this->conn->prepare("CALL addNewAirport(:a_code, :a_name, :a_location)");
        $stmt->execute([':a_code' => $airport_code, ':a_name' => $airport_name, ':a_location' => $airport_location]);
    }

    public function updateAirport($airport_id, $airport_code, $airport_name, $airport_location) {
        $stmt = $this->conn->prepare("CALL updateAirport(:a_id, :a_code, :a_name, :a_location)");
        $stmt->execute([':a_id' => $airport_id, ':a_code' => $airport_code, ':a_name' => $airport_name, ':a_location' => $airport_location]);
    }

    public function deleteAirport($airport_id) {
        $stmt = $this->conn->prepare("CALL deleteAirport(:a_id)");
        return $stmt->execute([':a_id' => $airport_id]);
    }

// Accounts page

    public function getAllAccounts() {
        $stmt = $this->conn->prepare("CALL getAllAccounts()");
        $stmt->execute();
        $result = $stmt->fetchAll();
        // var_dump($result);
        return $result;
    }

    public function searchAccount($search) {
        $stmt = $this->conn->prepare("CALL searchAccount(:search)");
        $stmt->execute([':search' => $search]);
        $result = $stmt->fetchAll();
        // var_dump($result);
        return $result;
    }

    public function addAccount($username, $password, $role) {
        $stmt = $this->conn->prepare("CALL addAccount(:a_username, :a_password, :a_role)");
        $stmt->execute([':a_username' => $username, ':a_password' => $password, ':a_role' => $role]);

    }


    public function updateAccount($id, $username, $password, $role) {
        try {
            $stmt = $this->conn->prepare("CALL updateAccount(:a_id, :a_username, :a_password, :a_role)");
            $stmt->execute([':a_id' => $id, ':a_username' => $username, ':a_password' => $password, ':a_role' => $role]);
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage(); // Debugging message
        }
    }
    

    public function deleteAccount($id) {
        var_dump($_POST);
        $stmt = $this->conn->prepare("CALL deleteAccount(:a_id)");
        return $stmt->execute([':a_id' => $id]);
    }




// Plane page

        public function addPlane($plane_code, $seats, $status, $photo) {  
            $stmt = $this->conn->prepare("CALL addPlane(:p_code, :p_seats, :p_status, :p_photo)");
            $stmt->execute([
                ':p_code' => $plane_code,
                ':p_seats' => $seats,
                ':p_status' => $status,
                ':p_photo' => $photo
            ]);
        }
        public function getAllPlanes() { 
            $stmt = $this->conn->prepare("CALL GetAllPlanes()");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function updatePlane($id, $plane_num, $seats, $status, $plane_photo) {
            $stmt = $this->conn->prepare("CALL updatePlane(:p_id, :p_code, :p_seats, :p_status, :p_photo)");
            return $stmt->execute([
                ':p_id' => $id,
                ':p_code' => $plane_num,
                ':p_seats' => $seats,
                ':p_status' => $status,
                ':p_photo' => $plane_photo
            ]);
        }
        public function deletePlane($plane_id) {
            $stmt = $this->conn->prepare("CALL deletePlane(:p_id)");
            return $stmt->execute([':p_id' => $plane_id]);
        }

    

// Flights page

    public function getAllFlights() {
        $stmt = $this->conn->prepare("CALL getAllFlights()");
        $stmt->execute();
        $result = $stmt->fetchAll();
        // var_dump($result);
        return $result;
    }

    public function addFlight($departure_location, $departure_time, $arrival_location, $arrival_time, $date, $plane_code, $seats_available, $price) {
        $stmt = $this->conn->prepare("CALL addFlight(:dep_loc, :dep_time, :arr_loc, :arr_time, :flightdate, :planecode, :numofseats, :price)");
        $stmt->execute([':dep_loc' => $departure_location, 
                        ':dep_time' => $departure_time, 
                        ':arr_loc' => $arrival_location, 
                        ':arr_time' => $arrival_time, 
                        ':flightdate' => $date, 
                        ':planecode' => $plane_code, 
                        ':numofseats' => $seats_available, 
                        ':price' => $price]);
    }

    public function updateFlight($id, $departure_location, $departure_time, $arrival_location,$arrival_time, $date, $plane_code, $seats_available, $price) {
        $stmt = $this->conn->prepare("CALL updateFlight(:flightid, :dep_loc, :dep_time, :arr_loc, :arr_time, :flightdate, :planecode, :numseats, :price)");
        $stmt->execute(['flightid' => $id,
                        ':dep_loc' => $departure_location, 
                        ':dep_time' => $departure_time, 
                        ':arr_loc' => $arrival_location, 
                        ':arr_time' => $arrival_time, 
                        ':flightdate' => $date, 
                        ':planecode' => $plane_code, 
                        ':numseats' => $seats_available, 
                        ':price' => $price]);
    }

    public function deleteFlight($id) {
        $stmt = $this->conn->prepare("CALL deleteFlight(:flightid)");
        return $stmt->execute([':flightid' => $id]);
    }

}
?>