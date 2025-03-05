<?php
session_start();
include_once "../config/database.php";

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header("Location: ../registration.php");
    exit();
}

// Validate inputs
if (empty($_POST['email']) || empty($_POST['password']) || 
    empty($_POST['confirm_password']) || empty($_POST['first_name']) || 
    empty($_POST['last_name'])) {
    header("Location: ../registration.php?error=empty");
    exit();
}

// Check if passwords match
if ($_POST['password'] !== $_POST['confirm_password']) {
    header("Location: ../registration.php?error=passwords");
    exit();
}

$database = new Database();
$db = $database->getConnection();

// Check if email already exists
$email = $_POST['email'];
$check_query = "SELECT id FROM users WHERE email = ?";
$check_stmt = $db->prepare($check_query);
$check_stmt->bindParam(1, $email);
$check_stmt->execute();

if ($check_stmt->fetch()) {
    header("Location: ../registration.php?error=email");
    exit();
}

// Create new user
$query = "INSERT INTO users (email, password, role) VALUES (?, ?, 'customer')";
$stmt = $db->prepare($query);

$password_hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
$stmt->bindParam(1, $email);
$stmt->bindParam(2, $password_hash);

if ($stmt->execute()) {
    // Create customer profile
    $user_id = $db->lastInsertId();
    $customer_query = "INSERT INTO customers (user_id, first_name, last_name) VALUES (?, ?, ?)";
    $customer_stmt = $db->prepare($customer_query);
    $customer_stmt->bindParam(1, $user_id);
    $customer_stmt->bindParam(2, $_POST['first_name']);
    $customer_stmt->bindParam(3, $_POST['last_name']);
    
    if ($customer_stmt->execute()) {
        // Log the user in
        $_SESSION['user_id'] = $user_id;
        $_SESSION['user_email'] = $email;
        $_SESSION['user_role'] = 'customer';
        
        header("Location: ../customer/dashboard.php");
    } else {
        // If customer profile creation fails, delete the user
        $delete_query = "DELETE FROM users WHERE id = ?";
        $delete_stmt = $db->prepare($delete_query);
        $delete_stmt->bindParam(1, $user_id);
        $delete_stmt->execute();
        
        header("Location: ../registration.php?error=database");
    }
} else {
    header("Location: ../registration.php?error=database");
}
exit();
?>