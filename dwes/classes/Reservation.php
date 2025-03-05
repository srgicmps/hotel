<?php
class Reservation {
    private $conn;
    private $table_name = "reservations";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create($data) {
        $query = "INSERT INTO " . $this->table_name . "
                (user_id, room_id, check_in, check_out, num_guests, 
                total_price, status, created_at)
                VALUES
                (:user_id, :room_id, :check_in, :check_out, :num_guests,
                :total_price, :status, NOW())";

        try {
            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':user_id', $data['user_id']);
            $stmt->bindParam(':room_id', $data['room_id']);
            $stmt->bindParam(':check_in', $data['check_in']);
            $stmt->bindParam(':check_out', $data['check_out']);
            $stmt->bindParam(':num_guests', $data['num_guests']);
            $stmt->bindParam(':total_price', $data['total_price']);
            $stmt->bindParam(':status', $data['status']);

            return $stmt->execute();
            
        } catch(PDOException $e) {
            error_log("Error creating reservation: " . $e->getMessage());
            return false;
        }
    }
    public function isRoomAvailable($room_id, $check_in, $check_out) {
        $query = "SELECT COUNT(*) FROM " . $this->table_name . "
                  WHERE room_id = :room_id 
                  AND status != 'cancelled'
                  AND (
                      (check_in <= :check_in AND check_out >= :check_in)
                      OR 
                      (check_in <= :check_out AND check_out >= :check_out)
                      OR 
                      (check_in >= :check_in AND check_out <= :check_out)
                  )";
    
        try {
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':room_id', $room_id);
            $stmt->bindParam(':check_in', $check_in);
            $stmt->bindParam(':check_out', $check_out);
            $stmt->execute();
            
            return (int)$stmt->fetchColumn() === 0;
        } catch(PDOException $e) {
            error_log("Error checking room availability: " . $e->getMessage());
            return false;
        }
    }
}