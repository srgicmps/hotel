<?php
$root = $_SERVER['DOCUMENT_ROOT'];
include($root . '/student062/dwes/includes/header.php');
include_once "../config/database.php";
include_once "../classes/Room.php";

// Check if user is logged in and is admin
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

// Check if ID parameter exists
if (!isset($_GET['id'])) {
    header("Location: manage-rooms.php");
    exit();
}

$database = new Database();
$db = $database->getConnection();

$room = new Room($db);
$room->id = $_GET['id'];

// Get room details before deletion to handle image
$room->readOne();
$image_path = "../../" . $room->image_url;

// Try to delete the room
if ($room->delete()) {
    // If deletion successful, remove the room image if it exists
    if (!empty($room->image_url) && file_exists($image_path)) {
        unlink($image_path);
    }
    header("Location: manage-rooms.php");
} else {
    // If deletion fails, show error message
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
                Error deleting room. It might have active reservations.
            </div>
            <a href='manage-rooms.php' class='btn btn-primary'>Back to List</a>
        </div>
    </body>
    </html>
    <?php
}
?>