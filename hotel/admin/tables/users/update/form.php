<?php
$root = $_SERVER['DOCUMENT_ROOT'];
include($root . '/student062/hotel/includes/header.php');

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if user has admin privileges
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    header("Location: /student062/hotel/src/login.php");
    exit;
}

// Get user ID from URL
$user_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($user_id <= 0) {
    header("Location: ../select/form.php?error=" . urlencode("ID de usuario no válido"));
    exit;
}

// Get user data from database
require_once $root . '/student062/hotel/config/connect_db.php';

$sql = "SELECT * FROM users WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    $stmt->close();
    $conn->close();
    header("Location: ../select/form.php?error=" . urlencode("Usuario no encontrado"));
    exit;
}

$user = $result->fetch_assoc();
$stmt->close();
$conn->close();
?>
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <div class="flex flex-col md:flex-row">
        <!-- Admin Sidebar -->
        <div class="w-full md:w-64 bg-gray-800 text-white p-4 rounded-lg mb-6 md:mb-0 md:mr-6">
            <h2 class="text-xl font-bold mb-6">Panel de Administración</h2>
            
            <nav>
                <ul>
                    <li class="mb-1">
                        <a href="/student062/hotel/admin/dashboard.php" class="block p-2 rounded hover:bg-gray-700">
                            <i class="fas fa-tachometer-alt mr-2"></i> Dashboard
                        </a>
                    </li>
                    
                    <!-- Users -->
                    <li class="mb-4">
                        <div class="block p-2 font-medium bg-gray-700 rounded">
                            <i class="fas fa-users mr-2"></i> Usuarios
                        </div>
                        <ul class="pl-4">
                            <li>
                                <a href="../select/form.php" class="block p-2 text-gray-300 hover:text-white">
                                    <i class="fas fa-list mr-2"></i> Ver Todos
                                </a>
                            </li>
                            <li>
                                <a href="../insert/form.php" class="block p-2 text-gray-300 hover:text-white">
                                    <i class="fas fa-plus mr-2"></i> Añadir Nuevo
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </div>

        <!-- Main content -->
        <div class="flex-1">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold">Actualizar Usuario</h1>
                <a href="../select/form.php" class="bg-gray-500 hover:bg-gray-600 text-white py-2 px-4 rounded">
                    <i class="fas fa-arrow-left mr-2"></i>Volver al Listado
                </a>
            </div>

            <?php if (isset($_GET['success'])): ?>
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                <p>¡Usuario actualizado correctamente!</p>
            </div>
            <?php endif; ?>

            <?php if (isset($_GET['error'])): ?>
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
                <p><?php echo htmlspecialchars($_GET['error']); ?></p>
            </div>
            <?php endif; ?>

            <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                <form action="action.php" method="POST">
                    <input type="hidden" name="user_id" value="<?php echo $user['user_id']; ?>">
                    
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="user_username">
                            Nombre de usuario *
                        </label>
                        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                               type="text" name="user_username" id="user_username" 
                               value="<?php echo htmlspecialchars($user['user_username']); ?>" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="email">
                            Email *
                        </label>
                        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                               type="email" name="email" id="email" 
                               value="<?php echo htmlspecialchars($user['email']); ?>" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="user_role">
                            Rol *
                        </label>
                        <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                                name="user_role" id="user_role">
                            <option value="admin" <?php echo $user['user_role'] === 'admin' ? 'selected' : ''; ?>>Administrador</option>
                            <option value="employee" <?php echo $user['user_role'] === 'employee' ? 'selected' : ''; ?>>Empleado</option>
                            <option value="customer" <?php echo $user['user_role'] === 'customer' ? 'selected' : ''; ?>>Cliente</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="first_name">
                            Nombre
                        </label>
                        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                               type="text" name="first_name" id="first_name" 
                               value="<?php echo htmlspecialchars($user['first_name']); ?>">
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="last_name">
                            Apellidos
                        </label>
                        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                               type="text" name="last_name" id="last_name" 
                               value="<?php echo htmlspecialchars($user['last_name']); ?>">
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="dni">
                            DNI
                        </label>
                        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                               type="text" name="dni" id="dni" 
                               value="<?php echo htmlspecialchars($user['dni']); ?>">
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="phone_number">
                            Teléfono
                        </label>
                        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                               type="text" name="phone_number" id="phone_number" 
                               value="<?php echo htmlspecialchars($user['phone_number']); ?>">
                    </div>

                    <div class="mb-6">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="new_password">
                            Nueva contraseña
                        </label>
                        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                               type="password" name="new_password" id="new_password" 
                               placeholder="Dejar en blanco para mantener la actual">
                    </div>

                    <div class="flex items-center justify-between">
                        <a href="../select/form.php" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Cancelar
                        </a>
                        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                            <i class="fas fa-save mr-2"></i>Guardar Cambios
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<?php include($root . '/student062/hotel/includes/footer.php'); ?>