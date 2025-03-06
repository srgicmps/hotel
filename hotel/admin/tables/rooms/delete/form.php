<?php
$root = $_SERVER['DOCUMENT_ROOT'];
include($root . '/student062/hotel/includes/header.php');

// Check if user has admin privileges
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    header("Location: /student062/hotel/src/login.php");
    exit;
}

require_once $root . '/student062/hotel/config/connect_db.php';

// Initialize variables
$room = [
    'room_id' => '',
    'room_number' => '',
    'room_category_name' => '',
    'room_state' => '',
    'room_status' => ''
];

$error = '';

// Check if ID is provided
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $room_id = $_GET['id'];
    
    // Get room data
    $sql = "SELECT r.*, c.room_category_name 
            FROM rooms r
            LEFT JOIN room_categories c ON r.room_category_id = c.room_category_id 
            WHERE r.room_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $room_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 1) {
        $room = $result->fetch_assoc();
    } else {
        $error = "Habitación no encontrada";
    }
    
    $stmt->close();
} else {
    $error = "ID de habitación no válido";
}
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
                        <div class="block p-2 font-medium bg-gray-700 rounded">
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
                </ul>
            </nav>
        </div>
        
        <!-- Main content -->
        <div class="flex-1">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold">Eliminar Habitación</h1>
                <a href="../select/form.php" class="bg-gray-500 hover:bg-gray-600 text-white py-2 px-4 rounded">
                    <i class="fas fa-arrow-left mr-2"></i>Volver al Listado
                </a>
            </div>
            
            <?php if($error): ?>
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
                <p><?php echo $error; ?></p>
                <div class="mt-3">
                    <a href="../select/form.php" class="bg-red-500 hover:bg-red-600 text-white py-2 px-4 rounded inline-block">
                        Volver al Listado
                    </a>
                </div>
            </div>
            <?php else: ?>
                <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                    <div class="mb-6">
                        <h2 class="text-lg font-semibold text-gray-700 mb-3">¿Estás seguro de eliminar esta habitación?</h2>
                        <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-6">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-exclamation-triangle text-red-400"></i>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-red-700">
                                        Esta acción no se puede deshacer. Se eliminarán permanentemente los datos de esta habitación.
                                    </p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-gray-100 p-4 rounded-lg mb-6">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <p class="text-sm text-gray-600">Número de Habitación:</p>
                                    <p class="font-semibold"><?php echo htmlspecialchars($room['room_number']); ?></p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">Categoría:</p>
                                    <p class="font-semibold"><?php echo htmlspecialchars($room['room_category_name'] ?? 'Sin categoría'); ?></p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">Estado:</p>
                                    <p class="font-semibold">
                                        <?php 
                                        switch($room['room_state']) {
                                            case 'ready':
                                                echo 'Lista';
                                                break;
                                            case 'check in':
                                                echo 'Check in';
                                                break;
                                            case 'check out':
                                                echo 'Check out';
                                                break;
                                            case 'breakdown':
                                                echo 'Mantenimiento';
                                                break;
                                            default:
                                                echo htmlspecialchars($room['room_state'] ?? 'Desconocido');
                                        }
                                        ?>
                                    </p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">Disponibilidad:</p>
                                    <p class="font-semibold">
                                        <?php echo $room['room_status'] ? 'Disponible' : 'No disponible'; ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <form action="action.php" method="POST" class="flex items-center justify-between">
                        <input type="hidden" name="room_id" value="<?php echo $room['room_id']; ?>">
                        <input type="hidden" name="confirm_delete" value="yes">
                        
                        <div>
                            <a href="../select/form.php" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                <i class="fas fa-times mr-2"></i>Cancelar
                            </a>
                        </div>
                        
                        <div>
                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                <i class="fas fa-trash-alt mr-2"></i>Eliminar Permanentemente
                            </button>
                        </div>
                    </form>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include($root . '/student062/hotel/includes/footer.php'); ?>