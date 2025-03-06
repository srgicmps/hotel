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
    $action = isset($_POST['action']) ? $_POST['action'] : '';
    
    // Validate room ID
    if ($room_id <= 0) {
        header("Location: form.php?error=ID de habitación no válido");
        exit;
    }
    
    // Check if room exists
    $check_sql = "SELECT room_id FROM rooms WHERE room_id = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("i", $room_id);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();
    
    if ($check_result->num_rows === 0) {
        $check_stmt->close();
        header("Location: form.php?error=La habitación no existe");
        exit;
    }
    $check_stmt->close();
    
    // Process based on action
    switch ($action) {
        // Update room state
        case 'state':
            $room_state = isset($_POST['room_state']) ? $_POST['room_state'] : '';
            
            // Validate room state
            $valid_states = ['check in', 'check out', 'breakdown', 'ready'];
            if (!in_array($room_state, $valid_states)) {
                header("Location: form.php?error=Estado de habitación no válido");
                exit;
            }
            
            // Update the room state
            $update_sql = "UPDATE rooms SET room_state = ? WHERE room_id = ?";
            $update_stmt = $conn->prepare($update_sql);
            $update_stmt->bind_param("si", $room_state, $room_id);
            
            if ($update_stmt->execute()) {
                // Success - maintain any existing filters when redirecting
                $query_params = $_SERVER['QUERY_STRING'] ? '?' . $_SERVER['QUERY_STRING'] : '';
                $update_stmt->close();
                
                // Pass success message
                $redirect_url = "form.php" . $query_params;
                
                // Add success parameter only if there isn't already one
                if (strpos($redirect_url, 'success=') === false) {
                    $separator = strpos($redirect_url, '?') === false ? '?' : '&';
                    $redirect_url .= $separator . "success=state_updated";
                }
                
                header("Location: " . $redirect_url);
                exit;
            } else {
                // Error
                $error = "Error al actualizar el estado: " . $conn->error;
                $update_stmt->close();
                header("Location: form.php?error=" . urlencode($error));
                exit;
            }
            break;
            
        // Toggle room status (available/unavailable)
        case 'status':
            $room_status = isset($_POST['room_status']) ? intval($_POST['room_status']) : -1;
            
            // Validate status
            if ($room_status !== 0 && $room_status !== 1) {
                header("Location: form.php?error=Estado de disponibilidad no válido");
                exit;
            }
            
            // Update the room status
            $update_sql = "UPDATE rooms SET room_status = ? WHERE room_id = ?";
            $update_stmt = $conn->prepare($update_sql);
            $update_stmt->bind_param("ii", $room_status, $room_id);
            
            if ($update_stmt->execute()) {
                // Success - maintain any existing filters when redirecting
                $query_params = $_SERVER['QUERY_STRING'] ? '?' . $_SERVER['QUERY_STRING'] : '';
                $update_stmt->close();
                
                // Pass success message
                $redirect_url = "form.php" . $query_params;
                
                // Add success parameter only if there isn't already one
                if (strpos($redirect_url, 'success=') === false) {
                    $separator = strpos($redirect_url, '?') === false ? '?' : '&';
                    $redirect_url .= $separator . "success=status_updated";
                }
                
                header("Location: " . $redirect_url);
                exit;
            } else {
                // Error
                $error = "Error al actualizar la disponibilidad: " . $conn->error;
                $update_stmt->close();
                header("Location: form.php?error=" . urlencode($error));
                exit;
            }
            break;
            
        default:
            header("Location: form.php?error=Acción no válida");
            exit;
    }
    
} else {
    // If not POST request, redirect back
    header("Location: form.php");
    exit;
}
?>