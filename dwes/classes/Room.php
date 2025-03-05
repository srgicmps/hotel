<?php
class Room {
    private $conn;
    private $table_name = "rooms";

    public $id;
    public $room_number;
    public $type;
    public $price;
    public $capacity;
    public $status;
    public $description;
    public $image_url;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function readAll() {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function readOne() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $this->room_number = $row['room_number'];
        $this->type = $row['type'];
        $this->price = $row['price'];
        $this->capacity = $row['capacity'];
        $this->status = $row['status'];
        $this->description = $row['description'];
        $this->image_url = $row['image_url'];
    }

    public function update() {
        $query = "UPDATE " . $this->table_name . "
                SET room_number = :room_number,
                    type = :type,
                    price = :price,
                    capacity = :capacity,
                    status = :status,
                    description = :description,
                    image_url = :image_url
                WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":room_number", $this->room_number);
        $stmt->bindParam(":type", $this->type);
        $stmt->bindParam(":price", $this->price);
        $stmt->bindParam(":capacity", $this->capacity);
        $stmt->bindParam(":status", $this->status);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":image_url", $this->image_url);
        $stmt->bindParam(":id", $this->id);

        return $stmt->execute();
    }

    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        return $stmt->execute();
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . "
                (room_number, type, price, capacity, status, description, image_url)
                VALUES
                (:room_number, :type, :price, :capacity, :status, :description, :image_url)";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":room_number", $this->room_number);
        $stmt->bindParam(":type", $this->type);
        $stmt->bindParam(":price", $this->price);
        $stmt->bindParam(":capacity", $this->capacity);
        $stmt->bindParam(":status", $this->status);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":image_url", $this->image_url);

        return $stmt->execute();
    }

    public function getAvailableRooms($check_in, $check_out, $guests) {
        $query = "SELECT r.* 
                  FROM rooms r 
                  WHERE r.capacity >= :guests 
                  AND r.id NOT IN (
                      SELECT room_id 
                      FROM reservations 
                      WHERE (check_in_date <= :check_out AND check_out_date >= :check_in)
                      AND status NOT IN ('cancelled', 'checked_out')
                  )
                  ORDER BY r.price ASC";
    
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':guests', $guests);
        $stmt->bindParam(':check_in', $check_in);
        $stmt->bindParam(':check_out', $check_out);
        $stmt->execute();
    
        return $stmt;
    }
}