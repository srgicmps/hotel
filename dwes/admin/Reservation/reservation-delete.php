<?php
$root = $_SERVER['DOCUMENT_ROOT'];
include($root . '/student062/dwes/includes/header.php');
include_once "../config/database.php";
include_once "../classes/Reservation.php";

// Check if user is logged in and is admin
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

// Check if ID parameter exists
if (!isset($_GET['id'])) {
    header("Location: manage-reservations.php");
    exit();
}

$database = new Database();
$db = $database->getConnection();

$reservation = new Reservation($db);
$reservation->id = $_GET['id'];

// Get reservation details before deletion for validation
$reservation_data = $reservation->readOne();

// Only allow deletion of pending or cancelled reservations
if ($reservation_data['status'] !== 'pending' && $reservation_data['status'] !== 'cancelled') {
    ?>
    <!DOCTYPE html>
    <html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <title>Error</title>
        <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css' rel='stylesheet'>
    </head>
    <body>
        <div class='container mt-5'>
            <div class='alert alert-danger'>
                Error: Cannot delete an active reservation. Only pending or cancelled reservations can be deleted.
            </div>
            <a href='manage-reservations.php' class='btn btn-primary'>Back to List</a>
        </div>
    </body>
    </html>
    <?php
    exit();
}

// Try to delete the reservation
if ($reservation->delete()) {
    header("Location: manage-reservations.php");
} else {
    ?>
    <!DOCTYPE html>
    <html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <title>Error</title>
        <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css' rel='stylesheet'>
    </head>
    <body>
        <div class='container mt-5'>
            <div class='alert alert-danger'>
                Error deleting reservation. Please try again.
            </div>
            <a href='manage-reservations.php' class='btn btn-primary'>Back to List</a>
        </div>
    </body>
    </html>
    <?php
}
?>