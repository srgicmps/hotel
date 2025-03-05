<?php
$root = $_SERVER['DOCUMENT_ROOT'];
include($root . '/student062/dwes/includes/header.php');
include($root . '/student062/dwes/config/database.php');
include($root . '/student062/dwes/classes/Reservation.php');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Validate form submission
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit();
}

// Validate required fields
$required_fields = ['room_id', 'check_in', 'check_out', 'guests', 'total_price'];
foreach ($required_fields as $field) {
    if (!isset($_POST[$field])) {
        header('Location: index.php');
        exit();
    }
}

try {
    $database = new Database();
    $db = $database->getConnection();
    $reservation = new Reservation($db);

    // Set reservation properties
    $reservation->room_id = $_POST['room_id'];
    $reservation->user_id = $_SESSION['user_id'];
    $reservation->check_in_date = $_POST['check_in'];
    $reservation->check_out_date = $_POST['check_out'];
    $reservation->num_guests = $_POST['guests'];
    $reservation->total_price = $_POST['total_price'];
    $reservation->special_requests = $_POST['special_requests'] ?? '';
    $reservation->status = 'pending';
    $reservation->created_at = date('Y-m-d H:i:s');

    // Create the reservation
    if ($reservation->create()) {
        // Store reservation ID in session for confirmation page
        $_SESSION['last_reservation_id'] = $reservation->id;
        
        // Redirect to confirmation page
        header('Location: booking-confirmation.php?id=' . $reservation->id);
        exit();
    } else {
        throw new Exception('Failed to create reservation');
    }

} catch (Exception $e) {
    $_SESSION['error'] = 'Booking failed: ' . $e->getMessage();
    header('Location: book_room.php?' . http_build_query($_POST));
    exit();
}
?>