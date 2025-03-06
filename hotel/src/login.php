<?php
// Start session at the very beginning
session_start();

// Check if already logged in
if (isset($_SESSION['user_id'])) {
    header("Location: /student062/hotel/index.php");
    exit;
}

// Initialize error variable
$error = '';

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once $_SERVER['DOCUMENT_ROOT'] . '/student062/hotel/config/connect_db.php';
    
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    if (empty($username) || empty($password)) {
        $error = "Por favor, introduce tu nombre de usuario y contraseña.";
    } else {
        // Query user
        $sql = "SELECT user_id, user_username, first_name, last_name, user_password, user_role 
                FROM users 
                WHERE user_username = ? AND user_status = 1";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            
            if ($password === $user['user_password']) {
                // Set session variables
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['username'] = $user['user_username'];
                $_SESSION['name'] = $user['first_name'] . ' ' . $user['last_name'];
                $_SESSION['is_admin'] = ($user['user_role'] === 'admin') ? 1 : 0;
                
                // Redirect based on role
                if ($user['user_role'] === 'admin') {
                    header("Location: /student062/hotel/admin/dashboard.php");
                } else {
                    header("Location: /student062/hotel/index.php");
                }
                exit;
            } else {
                $error = "Contraseña incorrecta.";
            }
        } else {
            $error = "Usuario no encontrado o no activo.";
        }
        
        $stmt->close();
        $conn->close();
    }
}

// Now we can safely include the header
require_once $_SERVER['DOCUMENT_ROOT'] . '/student062/hotel/includes/header.php';
?>

<!-- Login Form HTML -->
<div class="max-w-md mx-auto my-12 px-6">
    <div class="bg-white rounded-lg shadow-lg p-8">
        <div class="text-center mb-8">
            <h2 class="text-3xl font-bold text-gray-800">Iniciar Sesión</h2>
            <p class="text-gray-600 mt-2">Accede a tu cuenta del hotel</p>
        </div>
        
        <?php if(!empty($error)): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>
        
        <form method="POST" action="">
            <div class="mb-6">
                <label for="username" class="block text-gray-700 text-sm font-medium mb-2">Nombre de Usuario</label>
                <input type="text" id="username" name="username" 
                       class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                       required>
            </div>
            
            <div class="mb-6">
                <div class="flex justify-between items-center">
                    <label for="password" class="block text-gray-700 text-sm font-medium mb-2">Contraseña</label>
                    <a href="#" class="text-sm text-blue-600 hover:underline">¿Olvidaste tu contraseña?</a>
                </div>
                <input type="password" id="password" name="password" 
                       class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                       required>
            </div>
            
            <div class="mb-6">
                <label class="inline-flex items-center">
                    <input type="checkbox" name="remember" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    <span class="ml-2 text-gray-700 text-sm">Recordar sesión</span>
                </label>
            </div>
            
            <div>
                <button type="submit" class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">
                    Iniciar Sesión
                </button>
            </div>
        </form>
        
        <div class="mt-6 text-center text-sm">
            <p>¿No tienes una cuenta? <a href="/student062/hotel/src/register.php" class="text-blue-600 hover:underline font-medium">Regístrate</a></p>
        </div>
    </div>
</div>

<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/student062/hotel/includes/footer.php'; ?>