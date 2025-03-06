<?php
$root = $_SERVER['DOCUMENT_ROOT'];

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if user has admin privileges
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    // Redirect to login if not admin
    header("Location: /student062/hotel/src/login.php");
    exit;
}

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include database connection
    require_once $root . '/student062/hotel/config/connect_db.php';
    
    // Get form data
    $room_id = isset($_POST['room_id']) ? intval($_POST['room_id']) : 0;
    $room_number = $_POST['room_number'] ?? '';
    $room_category_id = isset($_POST['room_category_id']) ? intval($_POST['room_category_id']) : 0;
    $room_status = isset($_POST['room_status']) ? intval($_POST['room_status']) : 1;
    $room_state = $_POST['room_state'] ?? 'ready';
    
    // Validate form data
    $errors = [];
    
    if ($room_id <= 0) {
        $errors[] = "ID de habitación no válido";
    }
    
    if (empty($room_number)) {
        $errors[] = "Número de habitación es obligatorio";
    }
    
    if ($room_category_id <= 0) {
        $errors[] = "Debe seleccionar una categoría de habitación válida";
    }
    
    // Validate room state
    $valid_states = ['check in', 'check out', 'breakdown', 'ready'];
    if (!in_array($room_state, $valid_states)) {
        $errors[] = "El estado de la habitación no es válido";
    }
    
    // If there are errors, redirect back with all errors
    if (!empty($errors)) {
        header("Location: form.php?id=$room_id&error=" . urlencode(implode(", ", $errors)));
        exit;
    }
    
    // Check if room number exists (excluding current room)
    $check_sql = "SELECT room_id FROM rooms WHERE room_number = ? AND room_id != ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("si", $room_number, $room_id);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();
    
    if ($check_result->num_rows > 0) {
        $check_stmt->close();
        header("Location: form.php?id=$room_id&error=El número de habitación ya existe");
        exit;
    }
    $check_stmt->close();
    
    // Update room in database
    $sql = "UPDATE rooms SET 
                room_number = ?, 
                room_category_id = ?,
                room_status = ?, 
                room_state = ?
            WHERE room_id = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("siisi", $room_number, $room_category_id, $room_status, $room_state, $room_id);
    
    if ($stmt->execute()) {
        // Success
        $stmt->close();
        $conn->close();
        header("Location: ../select/form.php?success=updated");
        exit;
    } else {
        // Error
        $error = "Error: " . $stmt->error;
        $stmt->close();
        $conn->close();
        header("Location: form.php?id=$room_id&error=" . urlencode($error));
        exit;
    }
} else {
    // If not POST request, redirect to rooms list
    header("Location: ../select/form.php");
    exit;
}
?>