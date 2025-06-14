<?php
require_once 'database.php';

class Crud
{

    private $conn;

    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    // LOGIN page

    // LOGIN WITH HASHED PASSWORD
    public function loginUserPass($username, $password)
    {

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
    public function loginUser($username, $password)
    {

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

    // Dashboard
    public function getDashboardCounts()
    {
        try {

            $stmt = $this->conn->prepare("CALL getDashboardCounts()");
            $stmt->execute();

            $counts = $stmt->fetch(PDO::FETCH_ASSOC);


            return $counts;
        } catch (PDOException $e) {
            echo "Error fetching dashboard counts: " . $e->getMessage();
        }
    }

    public function getModeofPaymentCount(){
        
        $stmt = $this->conn->prepare("CALL getModeofPaymentCount()");
        $stmt->execute();

        $mopcount = $stmt->fetchAll();

        return $mopcount;
    }

    public function getPaymentStatusCount(){
        
        $stmt = $this->conn->prepare("CALL getPaymentStatusCount()");
        $stmt->execute();
        $mopcount = $stmt->fetchAll();

        return $mopcount;
    }

    
    public function getNationalityCount(){
        
        $stmt = $this->conn->prepare("CALL getNationalityCount()");
        $stmt->execute();

        $mopcount = $stmt->fetchAll();

        return $mopcount;
    }

    public function getRecentBookings(){
        
        $stmt = $this->conn->prepare("CALL getRecentBookings()");
        $stmt->execute();

        $recents = $stmt->fetchAll();

        return $recents;
    }



    // User Profile

    public function getAccountDetails($accountID)
    {
        $stmt = $this->conn->prepare("CALL getAccountDetails(:accountID)");
        $stmt->execute([':accountID' => $accountID]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateAccountPhoto($accountID, $photo)
    {
        $stmt = $this->conn->prepare("CALL uploadAccountPhoto(:a_ID, :a_photo)");
        $stmt->execute([':a_ID' => $accountID, ':a_photo' => $photo]);
    }

    public function updateUserProfile($accountID, $name, $username, $password)
    {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $this->conn->prepare("CALL updateUserProfile(:a_id, :a_username, :a_password, :a_fullname)");
        $stmt->execute([':a_id' => $accountID, ':a_fullname' => $name,  ':a_username' => $username,  ':a_password' => $hashedPassword]);
    }


    // Guest Details page

    public function countGuest($search)
    {
        $stmt = $this->conn->prepare("CALL getGuestCount(:search)");
        $stmt->execute([':search' => $search]);
        $result = $stmt->fetch();
        return $result['totalguest'];
    }

    public function searchGuestwithLimit($search, $limit, $offset)
    {
        $stmt = $this->conn->prepare("CALL getGuestPagedSearch(:search, :limit, :offset)");
        $stmt->bindParam(':search', $search);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

        // Guest Details page

    public function countCardPayments($search)
    {
        $stmt = $this->conn->prepare("CALL getPaymentCardCount(:search)");
        $stmt->execute([':search' => $search]);
        $result = $stmt->fetch();
        return $result['totalcard'];
    }

    public function searchCardPaymentswithLimit($search, $limit, $offset)
    {
        $stmt = $this->conn->prepare("CALL searchCardPayments(:search, :limit, :offset)");
        $stmt->bindParam(':search', $search);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    
    public function countOnsitePayments($search)
    {
        $stmt = $this->conn->prepare("CALL getPaymentOnsiteCount(:search)");
        $stmt->execute([':search' => $search]);
        $result = $stmt->fetch();
        return $result['totalonsite'];
    }
    
    public function searchOnsitePaymentswithLimit($search, $limit, $offset)
    {
        $stmt = $this->conn->prepare("CALL searchCardPayments(:search, :limit, :offset)");
        $stmt->bindParam(':search', $search);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }





    // Airport page

    public function getAllAirports()
    {
        $stmt = $this->conn->prepare("CALL getallAirports()");
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $result;
    }


    public function searchAirport($search)
    {
        $stmt = $this->conn->prepare("CALL searchAirport(:search)");
        $stmt->execute([':search' => $search]);
        $result = $stmt->fetchAll();
        // var_dump($result);
        return $result;
    }


    public function addAirport($airport_code, $airport_name, $airport_location)
    {
        $stmt = $this->conn->prepare("CALL addAirport(:a_code, :a_name, :a_location)");
        $stmt->execute([':a_code' => $airport_code, ':a_name' => $airport_name, ':a_location' => $airport_location]);
    }

    public function updateAirport($airport_id, $airport_code, $airport_name, $airport_location)
    {
        $stmt = $this->conn->prepare("CALL updateAirport(:a_id, :a_code, :a_name, :a_location)");
        $stmt->execute([':a_id' => $airport_id, ':a_code' => $airport_code, ':a_name' => $airport_name, ':a_location' => $airport_location]);
    }

    public function deleteAirport($airport_id)
    {
        $stmt = $this->conn->prepare("CALL deleteAirport(:a_id)");
        return $stmt->execute([':a_id' => $airport_id]);
    }

    public function searchAirportswithLimit($search, $limit, $offset)
    {
        $stmt = $this->conn->prepare("CALL getAirportsPagedSearch(:search, :limit, :offset)");
        $stmt->bindParam(':search', $search);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function countAirports($search)
    {
        $stmt = $this->conn->prepare("CALL getAirportsCount(:search)");
        $stmt->execute([':search' => $search]);
        $result = $stmt->fetch();
        return $result['TotalAirports'];
    }

    // Accounts page

    public function getAllAccounts()
    {
        $stmt = $this->conn->prepare("CALL getAllAccounts()");
        $stmt->execute();
        $result = $stmt->fetchAll();
        // var_dump($result);
        return $result;
    }

    public function searchAccount($search)
    {
        $stmt = $this->conn->prepare("CALL searchAccount(:search)");
        $stmt->execute([':search' => $search]);
        $result = $stmt->fetchAll();
        // var_dump($result);
        return $result;
    }

    public function addAccount($username, $password, $role)
    {

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $this->conn->prepare("CALL addAccount(:a_username, :a_password, :a_role)");
        $stmt->execute([':a_username' => $username, ':a_password' => $hashedPassword, ':a_role' => $role]);
    }


    public function updateAccount($id, $username, $password, $role)
    {
        try {
            $stmt = $this->conn->prepare("CALL updateAccount(:a_id, :a_username, :a_password, :a_role)");
            $stmt->execute([':a_id' => $id, ':a_username' => $username, ':a_password' => $password, ':a_role' => $role]);
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage(); 
        }
    }


    public function deleteAccount($id)
    {
        var_dump($_POST);
        $stmt = $this->conn->prepare("CALL deleteAccount(:a_id)");
        return $stmt->execute([':a_id' => $id]);
    }

    public function searchAccountswithLimit($search, $limit, $offset)
    {
        $stmt = $this->conn->prepare("CALL getAccountsPagedSearch(:search, :limit, :offset)");
        $stmt->bindParam(':search', $search);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function countAccounts($search)
    {
        $stmt = $this->conn->prepare("CALL getAccounstCount(:search)");
        $stmt->execute([':search' => $search]);
        $result = $stmt->fetch();
        return $result['TotalAccounts'];
    }




    // Plane page

    public function addPlane($plane_code, $seats, $status, $photo)
    {
        $stmt = $this->conn->prepare("CALL addPlane(:p_code, :p_seats, :p_status, :p_photo)");
        $stmt->execute([
            ':p_code' => $plane_code,
            ':p_seats' => $seats,
            ':p_status' => $status,
            ':p_photo' => $photo
        ]);
    }
    public function getAllPlanes()
    {
        $stmt = $this->conn->prepare("CALL getAllPlanes()");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllAvailablePlanes()
    {
        $stmt = $this->conn->prepare("CALL getAvailablePlanes()");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function getPlaneDetails($code)
    {
        $stmt = $this->conn->prepare("CALL getPlaneDetails(:p_code)");
        $stmt->execute([':p_code' => $code]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function updatePlane($id, $plane_num, $seats, $status, $plane_photo)
    {
        $stmt = $this->conn->prepare("CALL updatePlane(:p_id, :p_code, :p_seats, :p_status, :p_photo)");
        return $stmt->execute([
            ':p_id' => $id,
            ':p_code' => $plane_num,
            ':p_seats' => $seats,
            ':p_status' => $status,
            ':p_photo' => $plane_photo
        ]);
    }
    public function deletePlane($plane_id)
    {
        $stmt = $this->conn->prepare("CALL deletePlane(:p_id)");
        return $stmt->execute([':p_id' => $plane_id]);
    }


    public function getTotalFlightsByPlane($plane_code){
        $stmt = $this->conn->prepare("CALL getTotalFlightsByPlane(:planeCode)");
        return $stmt->execute([':planeCode' => $plane_code]);
    }


    // Flights page

    public function getAllFlights()
    {
        $stmt = $this->conn->prepare("CALL getAllFlights()");
        $stmt->execute();
        $result = $stmt->fetchAll();
        // var_dump($result);
        return $result;
    }

    public function addFlight($departure_code, $departure_name, $departure_location, $departure_time, $arrival_code, $arrival_name, $arrival_location, $arrival_time, $date, $plane_code, $plane_photo, $seats_available, $price, $saleStatus)
    {
        $stmt = $this->conn->prepare("CALL addFlight(:dep_loc, :dep_time, :arr_loc, :arr_time, :flightdate, :planecode, :numofseats, :flight_price, :saleStatus, :dep_code, :dep_name, :arr_code, :arr_name, :planephoto)");
        $stmt->execute([
            ':dep_loc' => $departure_location,
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
            ':planephoto' => $plane_photo
        ]);
    }

    public function updateFlight($id, $departure_code, $departure_name, $departure_location, $departure_time, $arrival_code, $arrival_name, $arrival_location, $arrival_time, $date, $plane_code, $plane_photo, $seats_available, $price, $saleStatus)
    {
        $stmt = $this->conn->prepare("CALL updateFlight(:flightid, :dep_loc, :dep_time, :arr_loc, :arr_time, :flightdate, :planecode, :numseats, :price, :saleStatus, :dep_code, :dep_name, :arr_code, :arr_name, :planephoto)");
        $stmt->execute([
            'flightid' => $id,
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
            ':planephoto' => $plane_photo
        ]);
    }

    public function deleteFlight($id)
    {
        $stmt = $this->conn->prepare("CALL deleteFlight(:flightid)");
        return $stmt->execute([':flightid' => $id]);
    }

    // flight view

    public function viewGuestsByFlight($flight_id, $dep_location, $arr_location) {
        $passengerDetails = [];
    
        if (isset($flight_id, $dep_location, $arr_location)) {
            try {
                $stmt = $this->conn->prepare("CALL getGuestDetailsByRoute(:dep, :arr, :flight_id)");
                $stmt->bindParam(':dep', $dep_location, PDO::PARAM_STR);
                $stmt->bindParam(':arr', $arr_location, PDO::PARAM_STR);
                $stmt->bindParam(':flight_id', $flight_id, PDO::PARAM_INT);
                $stmt->execute();
    
                $passengerDetails = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $stmt->closeCursor(); // Important to clear results when using stored procedures
            } catch (PDOException $e) {
                echo "An error occurred: " . $e->getMessage();
            }
        }
    
        return $passengerDetails;
    }

    // for flights booking count
    
   public function getTotalBookingByFlight($flight_id) {
    try {
        
        $stmt = $this->conn->prepare("CALL getTotalBookingByFlight(:flight_id)");

        
        $stmt->bindParam(':flight_id', $flight_id, PDO::PARAM_INT);

        
        $stmt->execute();

        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        
        return $result['total_passengers'] ?? 0;

    } catch (PDOException $e) {
        
        return 0;
    }
}


// airports

public function getAllAirportsFromView() {
    try {
        $stmt = $this->conn->prepare("SELECT * FROM view_all_airports");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error fetching airports from view: " . $e->getMessage();
        return [];
    }
}


public function getFlightsByCodeView() {
    try {
        $stmt = $this->conn->prepare("SELECT * FROM view_flights_by_code");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {       
        echo "Error fetching flights by code from view: " . $e->getMessage();
        return [];
    }
}


public function getFlightsWithBookedSeats() {
    try {
        $stmt = $this->conn->prepare("
            SELECT 
                f.*,
                COALESCE(v.booked_seats, 0) AS booked_seats
            FROM 
                flights f
            LEFT JOIN 
                view_flight_booked_seats v ON f.flight_id = v.flight_id
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error fetching flights with booked seats: " . $e->getMessage();
        return [];
    }
}

    // Bookings

    public function getAllBookings()
    {
        $stmt = $this->conn->prepare("CALL getAllBookings()");
        $stmt->execute();
        $result = $stmt->fetchAll();
        // var_dump($result);
        return $result;
    }

    public function getAllPassengers()
    {
        $stmt = $this->conn->prepare("CALL getAllPassenger()");
        $stmt->execute();
        $result = $stmt->fetchAll();
        // var_dump($result);
        return $result;
    }

    // public function updateBookings($booking_id, $booking_date, $flight_id, $flight_date, $dep_time, $dep_airportcode, $dep_airportlocation, $arr_time, $arr_airportcode, $arr_airportlocation, $plane_code, $plane_photo, $price) {
    //     $stmt = $this->conn->prepare("CALL updateBookings(:p_bookingid, :p_bookingdate, :p_flightid, :p_flightdate, :p_deptime, :p_depairportcode, 
    //     :p_depairportlocation, :p_arrtime, :p_arrairportcode, :p_arrairportlocation, :p_planecode, :p_planephoto, :p_price)");
    //     return $stmt->execute([
    //         ':p_bookingid' => $booking_id,
    //         ':p_bookingdate' => $booking_date,
    //         ':p_flightid' => $flight_id,
    //         ':p_flightdate' => $flight_date,
    //         ':p_deptime' => $dep_time,
    //         ':p_depairportcode' => $dep_airportcode,
    //         ':p_depairportlocation' => $dep_airportlocation,
    //         ':p_arrtime' => $arr_time,
    //         ':p_arrairportcode' => $arr_airportcode,
    //         ':p_arrairportlocation' => $arr_airportlocation,
    //         ':p_planecode' => $plane_code,
    //         ':p_planephoto' => $plane_photo,
    //         ':p_price' => $price
    //     ]);
    // }

    public function deleteBookings($booking_id)
    {
        $stmt = $this->conn->prepare("CALL deleteBookings(:bookingid)");
        return $stmt->execute([':bookingid' => $booking_id]);
    }

    public function getPaymentInfo($booking_id){
        $stmt = $this->conn->prepare("CALL getPaymentInfo(:bookingid)");
        $stmt->execute([':bookingid' => $booking_id]);
        $result = $stmt->fetchAll();
        return $result;
    }

    public function getAllPayments(){
        $stmt = $this->conn->prepare("CALL getAllPayments()");
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $result;
    }
}
