<?php
// Start session
session_start();

// Check if user has admin privileges
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    // Redirect to login if not admin
    header("Location: /student062/hotel/src/login.php");
    exit;
}

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: form.php");
    exit;
}

// Include database connection
$root = $_SERVER['DOCUMENT_ROOT'];
require_once $root . '/student062/hotel/config/connect_db.php';

// Get form data
$room_number = $_POST['room_number'] ?? '';
$room_category_id = isset($_POST['room_category_id']) ? intval($_POST['room_category_id']) : 0;
$room_status = isset($_POST['room_status']) ? intval($_POST['room_status']) : 1; // Default to available (1)
$room_state = $_POST['room_state'] ?? 'ready'; // Default to ready

// Validate data
$errors = [];

if (empty($room_number)) {
    $errors[] = "El número de habitación es obligatorio";
}

if ($room_category_id <= 0) {
    $errors[] = "Debe seleccionar una categoría de habitación válida";
}

// Validate room state
$valid_states = ['check in', 'check out', 'breakdown', 'ready'];
if (!in_array($room_state, $valid_states)) {
    $errors[] = "El estado de la habitación no es válido";
}

// Check if room number already exists
$check_sql = "SELECT room_id FROM rooms WHERE room_number = ?";
$check_stmt = $conn->prepare($check_sql);
$check_stmt->bind_param("s", $room_number);
$check_stmt->execute();
$check_result = $check_stmt->get_result();

if ($check_result->num_rows > 0) {
    $errors[] = "Ya existe una habitación con este número";
}
$check_stmt->close();

// If there are errors, redirect back with error message
if (!empty($errors)) {
    header("Location: form.php?error=" . urlencode(implode(", ", $errors)));
    exit;
}

// Prepare the SQL statement based on the actual database schema
$sql = "INSERT INTO rooms (room_number, room_category_id, room_status, room_state) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    header("Location: form.php?error=" . urlencode("Error en la preparación de la consulta: " . $conn->error));
    exit;
}

$stmt->bind_param("siis", $room_number, $room_category_id, $room_status, $room_state);

// Execute the statement
if ($stmt->execute()) {
    // Redirect to the room list with success message
    header("Location: ../select/form.php?success=created");
} else {
    // Redirect with error message
    header("Location: form.php?error=" . urlencode("Error al crear la habitación: " . $conn->error));
}

$stmt->close();
$conn->close();
?>