<?php
$root = $_SERVER['DOCUMENT_ROOT'];

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if user has admin privileges
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    header("Location: /student062/hotel/src/login.php");
    exit;
}

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include database connection
    require_once $root . '/student062/hotel/config/connect_db.php';
    
    // Get form data
    $user_id = isset($_POST['user_id']) ? intval($_POST['user_id']) : 0;
    $user_username = $_POST['user_username'] ?? '';
    $email = $_POST['email'] ?? '';
    $user_role = $_POST['user_role'] ?? '';
    $first_name = $_POST['first_name'] ?? '';
    $last_name = $_POST['last_name'] ?? '';
    $dni = $_POST['dni'] ?? '';
    $phone_number = $_POST['phone_number'] ?? '';
    $new_password = $_POST['new_password'] ?? '';
    
    // Validate form data
    $errors = [];
    
    if ($user_id <= 0) {
        $errors[] = "ID de usuario no válido";
    }
    
    if (empty($user_username)) {
        $errors[] = "Nombre de usuario es obligatorio";
    }
    
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Correo electrónico no válido";
    }
    
    // If there are errors, redirect back with errors
    if (!empty($errors)) {
        header("Location: form.php?id=$user_id&error=" . urlencode(implode(", ", $errors)));
        exit;
    }
    
    // Check if email exists (excluding current user)
    $check_sql = "SELECT user_id FROM users WHERE email = ? AND user_id != ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("si", $email, $user_id);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();
    
    if ($check_result->num_rows > 0) {
        $check_stmt->close();
        header("Location: form.php?id=$user_id&error=El correo electrónico ya está registrado");
        exit;
    }
    $check_stmt->close();
    
    // Prepare SQL based on whether a new password was provided
    if (!empty($new_password)) {
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $sql = "UPDATE users SET 
                    user_username = ?, 
                    email = ?,
                    user_password = ?,
                    user_role = ?,
                    first_name = ?,
                    last_name = ?,
                    dni = ?,
                    phone_number = ?
                WHERE user_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssssi", 
            $user_username, 
            $email, 
            $hashed_password, 
            $user_role,
            $first_name,
            $last_name,
            $dni,
            $phone_number,
            $user_id
        );
    } else {
        $sql = "UPDATE users SET 
                    user_username = ?, 
                    email = ?,
                    user_role = ?,
                    first_name = ?,
                    last_name = ?,
                    dni = ?,
                    phone_number = ?
                WHERE user_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssssi", 
            $user_username, 
            $email, 
            $user_role,
            $first_name,
            $last_name,
            $dni,
            $phone_number,
            $user_id
        );
    }
    
    if ($stmt->execute()) {
        // Success
        $stmt->close();
        $conn->close();
        header("Location: form.php?id=$user_id&success=1");
        exit;
    } else {
        // Error
        $error = "Error: " . $stmt->error;
        $stmt->close();
        $conn->close();
        header("Location: form.php?id=$user_id&error=" . urlencode($error));
        exit;
    }
} else {
    // If not POST request, redirect to users list
    header("Location: ../select/form.php");
    exit;
}
?>