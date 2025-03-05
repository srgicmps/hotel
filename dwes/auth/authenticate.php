<?php
session_start();
include_once "../config/database.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../login.php");
    exit();
}

try {
    $database = new Database();
    $db = $database->getConnection();

    // Validate inputs
    if (empty($_POST['email']) || empty($_POST['password'])) {
        throw new Exception('Please fill in all fields');
    }

    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Modified query to check plain text password
    $query = "SELECT u.*, c.id as customer_id 
              FROM users u 
              LEFT JOIN customers c ON u.id = c.user_id 
              WHERE u.email = :email AND u.password = :password";

    $stmt = $db->prepare($query);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $password);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Set session variables
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['user_role'] = $user['role'];
        
        if ($user['customer_id']) {
            $_SESSION['customer_id'] = $user['customer_id'];
        }

        header("Location: ../index.php");
        exit();
    } else {
        throw new Exception('Invalid email or password');
    }

} catch (Exception $e) {
    header("Location: ../login.php?error=" . urlencode($e->getMessage()));
    exit();
}