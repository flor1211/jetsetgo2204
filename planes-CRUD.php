<?php
require_once 'db.php';

class Crud {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->getConnection();
    }
    public function AddPlane($plane_code, $seats, $status, $photo) {  
        $stmt = $this->conn->prepare("CALL AddPlane(:p_code, :p_seats, :p_status, :p_photo)");
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

    public function UpdatePlane($id, $plane_num, $seats, $status, $plane_photo) {
        $stmt = $this->conn->prepare("CALL UpdatePlane(:p_id, :p_code, :p_seats, :p_status, :p_photo)");
        return $stmt->execute([
            ':p_id' => $id,
            ':p_code' => $plane_num,
            ':p_seats' => $seats,
            ':p_status' => $status,
            ':p_photo' => $plane_photo
        ]);
    }
    public function deletePlane($plane_id) {
        $stmt = $this->conn->prepare("CALL DeletePlane(:p_id)");
        return $stmt->execute([':p_id' => $plane_id]);
    }
}