<?php
$root = $_SERVER['DOCUMENT_ROOT'];
include($root . '/student062/hotel/includes/header.php');

// Check if user has admin privileges
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    header("Location: /student062/hotel/src/login.php");
    exit;
}

require_once $root . '/student062/hotel/config/connect_db.php';

// Get error message
$error = isset($_GET['error']) ? $_GET['error'] : '';
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
                    
                    <!-- Rooms -->
                    <li class="mb-4">
                        <div class="block p-2 font-medium">
                            <i class="fas fa-bed mr-2"></i> Habitaciones
                        </div>
                        <ul class="pl-4">
                            <li>
                                <a href="/student062/hotel/admin/tables/rooms/select/form.php" class="block p-2 text-gray-300 hover:text-white">
                                    <i class="fas fa-list mr-2"></i> Ver Todas
                                </a>
                            </li>
                            <li>
                                <a href="/student062/hotel/admin/tables/rooms/insert/form.php" class="block p-2 text-gray-300 hover:text-white">
                                    <i class="fas fa-plus mr-2"></i> Añadir Nueva
                                </a>
                            </li>
                        </ul>
                    </li>
                    
                    <!-- Users -->
                    <li class="mb-4">
                        <div class="block p-2 font-medium bg-gray-700 rounded">
                            <i class="fas fa-users mr-2"></i> Usuarios
                        </div>
                        <ul class="pl-4">
                            <li>
                                <a href="/student062/hotel/admin/tables/users/select/form.php" class="block p-2 text-gray-300 hover:text-white">
                                    <i class="fas fa-list mr-2"></i> Ver Todos
                                </a>
                            </li>
                            <li>
                                <a href="/student062/hotel/admin/tables/users/insert/form.php" class="block p-2 bg-gray-600 text-white rounded">
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
                <h1 class="text-2xl font-bold">Añadir Nuevo Usuario</h1>
                <a href="../select/form.php" class="bg-gray-500 hover:bg-gray-600 text-white py-2 px-4 rounded">
                    <i class="fas fa-arrow-left mr-2"></i>Volver al Listado
                </a>
            </div>
            
            <?php if($error): ?>
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
                <p><?php echo $error; ?></p>
            </div>
            <?php endif; ?>
            
            <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                <form action="action.php" method="POST">
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="first_name">
                            Nombre *
                        </label>
                        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                               id="first_name" 
                               name="first_name" 
                               type="text" 
                               required
                               placeholder="Nombre">
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="last_name">
                            Apellidos *
                        </label>
                        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                               id="last_name" 
                               name="last_name" 
                               type="text" 
                               required
                               placeholder="Apellidos">
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="email">
                            Email *
                        </label>
                        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                               id="email" 
                               name="email" 
                               type="email" 
                               required
                               placeholder="email@ejemplo.com">
                    </div>
                    
                    <div class="mb-6">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
                            Contraseña *
                        </label>
                        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                               id="password" 
                               name="password" 
                               type="password"
                               required
                               placeholder="Mínimo 6 caracteres">
                        <p class="text-gray-500 text-xs mt-1">La contraseña debe tener al menos 6 caracteres.</p>
                    </div>
                    
                    <div class="mb-6">
                        <div class="flex items-center">
                            <input id="is_admin" name="is_admin" type="checkbox" value="1" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <label for="is_admin" class="ml-2 block text-sm text-gray-900">
                                Usuario con privilegios de administración
                            </label>
                        </div>
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <a href="../select/form.php" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Cancelar
                        </a>
                        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                            <i class="fas fa-save mr-2"></i>Guardar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include($root . '/student062/hotel/includes/footer.php'); ?>