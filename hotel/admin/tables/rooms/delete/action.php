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
    
    // Get room ID
    $room_id = isset($_POST['room_id']) ? intval($_POST['room_id']) : 0;
    
    // Validate room ID
    if ($room_id <= 0) {
        header("Location: /student062/hotel/admin/tables/rooms/select/form.php?error=ID de habitación no válido");
        exit;
    }
    
    // Check if confirmation was provided
    if (isset($_POST['confirm_delete']) && $_POST['confirm_delete'] == 'yes') {
        // First check if room exists
        $check_sql = "SELECT room_id FROM rooms WHERE room_id = ?";
        $check_stmt = $conn->prepare($check_sql);
        $check_stmt->bind_param("i", $room_id);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result();
        
        if ($check_result->num_rows === 0) {
            $check_stmt->close();
            header("Location: /student062/hotel/admin/tables/rooms/select/form.php?error=La habitación no existe");
            exit;
        }
        $check_stmt->close();
        
        // Delete the room
        $delete_sql = "DELETE FROM rooms WHERE room_id = ?";
        $delete_stmt = $conn->prepare($delete_sql);
        $delete_stmt->bind_param("i", $room_id);
        
        if ($delete_stmt->execute()) {
            // Success
            $delete_stmt->close();
            $conn->close();
            header("Location: /student062/hotel/admin/tables/rooms/select/form.php?success=deleted");
            exit;
        } else {
            // Error
            $error = "Error al eliminar: " . $conn->error;
            $delete_stmt->close();
            $conn->close();
            header("Location: /student062/hotel/admin/tables/rooms/select/form.php?error=" . urlencode($error));
            exit;
        }
    } else {
        // Deletion not confirmed, redirect back
        header("Location: /student062/hotel/admin/tables/rooms/select/form.php");
        exit;
    }
} else {
    // If not POST request, redirect to rooms list
    header("Location: /student062/hotel/admin/tables/rooms/select/form.php");
    exit;
}
?>