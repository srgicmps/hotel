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
$first_name = $_POST['first_name'] ?? '';
$last_name = $_POST['last_name'] ?? '';
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';
$user_role = $_POST['user_role'] ?? 'customer';

// Validate data
$errors = [];

if (empty($first_name)) {
    $errors[] = "El nombre es obligatorio";
}

if (empty($last_name)) {
    $errors[] = "Los apellidos son obligatorios";
}

if (empty($email)) {
    $errors[] = "El email es obligatorio";
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "El formato del email no es válido";
}

if (empty($password)) {
    $errors[] = "La contraseña es obligatoria";
} elseif (strlen($password) < 6) {
    $errors[] = "La contraseña debe tener al menos 6 caracteres";
}

// Check if email already exists
$check_sql = "SELECT user_id FROM users WHERE email = ?";
$check_stmt = $conn->prepare($check_sql);
$check_stmt->bind_param("s", $email);
$check_stmt->execute();
$check_result = $check_stmt->get_result();

if ($check_result->num_rows > 0) {
    $errors[] = "Este email ya está en uso";
}
$check_stmt->close();

// If there are errors, redirect back with error message
if (!empty($errors)) {
    header("Location: form.php?error=" . urlencode(implode(", ", $errors)));
    exit;
}

// Hash password
$password_hash = password_hash($password, PASSWORD_DEFAULT);

// Insert user into database
$sql = "INSERT INTO users (first_name, last_name, email, user_password, user_role) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    header("Location: form.php?error=" . urlencode("Error en la preparación de la consulta: " . $conn->error));
    exit;
}

$stmt->bind_param("sssss", $first_name, $last_name, $email, $password_hash, $user_role);

// Execute the statement
if ($stmt->execute()) {
    // Redirect to the user list with success message
    header("Location: ../select/form.php?success=created");
} else {
    // Redirect with error message
    header("Location: form.php?error=" . urlencode("Error al crear el usuario: " . $conn->error));
}

$stmt->close();
$conn->close();
?>