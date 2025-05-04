<?php
require_once 'database.php';

class Crud {

    private $conn;

    public function __construct(){
        $db = new Database();
        $this->conn = $db->getConnection();
    }

// LOGIN page

        // LOGIN WITH HASHED PASSWORD
    public function loginUserPass($username, $password){

        $stmt = $this->conn->prepare("CALL AuthenticateUser(:username)");
        $stmt->execute([':username' => $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($user) {

            if (password_verify($password, $user['account_password'])) {

                $_SESSION['loggedin'] = true;
                $_SESSION['accountID'] = $user['account_id'];
                $_SESSION['username'] = $user['account_username'];
                $_SESSION['role'] = $user['account_role'];
                $_SESSION['login_success'] = true;


                if ($_SESSION['role'] == 'Administrator') {
                    header("Location: admin/dashboard.php");
                } elseif ($_SESSION['role'] == 'Front Desk') {
                    header("Location: frontdesk/dashboard.php");
                }
                exit;

            } else {

                $error = "Invalid username or password.";
                return $error;
            }
        } else {

            $error = "Invalid username or password.";
            return $error;
        }
    }

        // LOGIN WITHOUT HASHED PASSWORD
    public function loginUser($username, $password){
        
        $stmt = $this->conn->prepare("CALL AuthenticateUserPass(:username, :password)");
        $stmt->execute([':username' => $username, ':password' => $password]);
        $control = $stmt->fetch(PDO::FETCH_OBJ);
        
        if ($control) {

            $_SESSION['loggedin'] = true;
            $_SESSION['accountID'] = $control->account_id;
            $_SESSION['username'] = $control->account_username;
            $_SESSION['role'] = $control->account_role;
            $_SESSION['login_success'] = true;

            if ($control->account_role === 'Administrator') {
                header("Location: admin/dashboard.php");
                exit;

            } elseif ($control->account_role === 'Front Desk') {
                header("Location: frontdesk/dashboard.php");
                exit;

            } else {
                $error = "Invalid account.";
                return $error;
            }
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
        $stmt = $this->conn->prepare("CALL addAirport(:a_code, :a_name, :a_location)");
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

    public function searchAirportswithLimit($search, $limit, $offset) {
        $stmt = $this->conn->prepare("CALL getAirportsPagedSearch(:search, :limit, :offset)");
        $stmt->bindParam(':search', $search);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    public function countAirports($search) {
        $stmt = $this->conn->prepare("CALL getAirportsCount(:search)");
        $stmt->execute([':search' => $search]);
        $result = $stmt->fetch();
        return $result['TotalAirports'];
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

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $this->conn->prepare("CALL addAccount(:a_username, :a_password, :a_role)");
        $stmt->execute([':a_username' => $username, ':a_password' => $hashedPassword, ':a_role' => $role]);

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

    public function searchAccountswithLimit($search, $limit, $offset) {
        $stmt = $this->conn->prepare("CALL getAccountsPagedSearch(:search, :limit, :offset)");
        $stmt->bindParam(':search', $search);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    public function countAccounts($search) {
        $stmt = $this->conn->prepare("CALL getAccounstCount(:search)");
        $stmt->execute([':search' => $search]);
        $result = $stmt->fetch();
        return $result['TotalAccounts'];
    }

// User Profile

    public function getAccountDetails($accountID) {
        $stmt = $this->conn->prepare("CALL getAccountDetails(:accountID)");
        $stmt->execute([':accountID' => $accountID]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function updateAccountPhoto($accountID, $photo) {
        $stmt = $this->conn->prepare("CALL uploadAccountPhoto(:a_ID, :a_photo)");
        $stmt->execute([':a_ID' => $accountID, ':a_photo' => $photo]);
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
            $stmt = $this->conn->prepare("CALL getAllPlanes()");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function getAllAvailablePlanes() { 
            $stmt = $this->conn->prepare("CALL getAvailablePlanes()");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }


        public function getPlaneDetails($code) { 
            $stmt = $this->conn->prepare("CALL getPlaneDetails(:p_code)");
            $stmt->execute([':p_code' => $code]);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;

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

    public function addFlight($departure_code, $departure_name, $departure_location, $departure_time, $arrival_code, $arrival_name, $arrival_location, $arrival_time, $date, $plane_code, $plane_photo, $seats_available, $price, $saleStatus) {
        $stmt = $this->conn->prepare("CALL addFlight(:dep_loc, :dep_time, :arr_loc, :arr_time, :flightdate, :planecode, :numofseats, :flight_price, :saleStatus, :dep_code, :dep_name, :arr_code, :arr_name, :planephoto)");
        $stmt->execute([':dep_loc' => $departure_location, 
                        ':dep_time' => $departure_time, 
                        ':arr_loc' => $arrival_location, 
                        ':arr_time' => $arrival_time, 
                        ':flightdate' => $date, 
                        ':planecode' => $plane_code, 
                        ':numofseats' => $seats_available, 
                        ':flight_price' => $price,
                        ':saleStatus' => $saleStatus,
                        ':dep_code' => $departure_code,
                        ':dep_name' => $departure_name,
                        ':arr_code' => $arrival_code,
                        ':arr_name' => $arrival_name,
                        ':planephoto' => $plane_photo]);
    }

    public function updateFlight($id, $departure_code, $departure_name, $departure_location, $departure_time, $arrival_code, $arrival_name, $arrival_location, $arrival_time, $date, $plane_code, $plane_photo, $seats_available, $price, $saleStatus) {
        $stmt = $this->conn->prepare("CALL updateFlight(:flightid, :dep_loc, :dep_time, :arr_loc, :arr_time, :flightdate, :planecode, :numseats, :price, :saleStatus, :dep_code, :dep_name, :arr_code, :arr_name, :planephoto)");
        $stmt->execute(['flightid' => $id,
                        ':dep_loc' => $departure_location, 
                        ':dep_time' => $departure_time, 
                        ':arr_loc' => $arrival_location, 
                        ':arr_time' => $arrival_time, 
                        ':flightdate' => $date, 
                        ':planecode' => $plane_code, 
                        ':numseats' => $seats_available, 
                        ':price' => $price,
                        ':saleStatus' => $saleStatus,
                        ':dep_code' => $departure_code,
                        ':dep_name' => $departure_name,
                        ':arr_code' => $arrival_code,
                        ':arr_name' => $arrival_name,
                        ':planephoto' => $plane_photo]);
    }

    public function deleteFlight($id) {
        $stmt = $this->conn->prepare("CALL deleteFlight(:flightid)");
        return $stmt->execute([':flightid' => $id]);
    }

}
?>