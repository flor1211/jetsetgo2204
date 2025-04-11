<?php
require_once 'db.php';

class Crud {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->getConnection();
    }
    public function AddPlane($plane_num, $seats, $status, $image_url) {  
        $stmt = $this->conn->prepare("CALL AddPlane(:plane_num, :seats, :status, :image_url)");
        $stmt->execute([
            ':plane_num' => $plane_num,
            ':seats' => $seats,
            ':status' => $status,
            ':image_url' => $image_url
        ]);
    }
    public function getAllPlanes() { 
        $stmt = $this->conn->prepare("CALL GetAllPlanes()");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function UpdatePlane($id, $plane_num, $seats, $status, $plane_photo) {
        $stmt = $this->conn->prepare("CALL UpdatePlane(:id, :plane_num, :seats, :status, :plane_photo)");
        return $stmt->execute([
            ':id' => $id,
            ':plane_num' => $plane_num,
            ':seats' => $seats,
            ':status' => $status,
            ':plane_photo' => $plane_photo
        ]);
    }
    public function deletePlane($plane_id) {
        $stmt = $this->conn->prepare("CALL DeletePlane(:plane_id)");
        return $stmt->execute([':plane_id' => $plane_id]);
    }
}