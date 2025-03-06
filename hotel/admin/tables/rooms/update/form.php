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
    'room_category_id' => '',
    'room_status' => 1,
    'room_state' => 'ready'
];

$error = isset($_GET['error']) ? $_GET['error'] : '';
$success = isset($_GET['success']) ? true : false;

// Get available room categories
$categories = [];
$cat_sql = "SELECT * FROM room_categories ORDER BY room_category_name";
$cat_result = $conn->query($cat_sql);

if ($cat_result && $cat_result->num_rows > 0) {
    while ($row = $cat_result->fetch_assoc()) {
        $categories[] = $row;
    }
}

// Check if ID is provided
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $room_id = $_GET['id'];
    
    // Get room data
    $sql = "SELECT * FROM rooms WHERE room_id = ?";
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
    $error = "ID de habitación no proporcionado";
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
                <h1 class="text-2xl font-bold">Actualizar Habitación</h1>
                <a href="../select/form.php" class="bg-gray-500 hover:bg-gray-600 text-white py-2 px-4 rounded">
                    <i class="fas fa-arrow-left mr-2"></i>Volver al Listado
                </a>
            </div>
            
            <?php if($success): ?>
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                <p>¡Habitación actualizada correctamente!</p>
            </div>
            <?php endif; ?>
            
            <?php if($error): ?>
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
                <p><?php echo $error; ?></p>
            </div>
            <?php endif; ?>
            
            <?php if(empty($categories)): ?>
            <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-6" role="alert">
                <p>Debe crear categorías de habitaciones antes de editar esta habitación.</p>
                <div class="mt-2">
                    <a href="/student062/hotel/admin/tables/room_categories/insert/form.php" class="bg-yellow-500 hover:bg-yellow-600 text-white py-1 px-3 rounded text-sm inline-block">
                        Crear categoría de habitación
                    </a>
                </div>
            </div>
            <?php else: ?>
            
            <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                <form action="action.php" method="POST">
                    <input type="hidden" name="room_id" value="<?php echo htmlspecialchars($room['room_id']); ?>">
                    
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="room_number">
                            Número de Habitación *
                        </label>
                        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                               id="room_number" 
                               name="room_number" 
                               type="text" 
                               required
                               value="<?php echo htmlspecialchars($room['room_number']); ?>"
                               placeholder="Ej: 101">
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="room_category_id">
                            Categoría de Habitación *
                        </label>
                        <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                               id="room_category_id" 
                               name="room_category_id" 
                               required>
                            <option value="">Seleccione una categoría</option>
                            <?php foreach($categories as $category): ?>
                            <option value="<?php echo $category['room_category_id']; ?>" <?php if($room['room_category_id'] == $category['room_category_id']) echo 'selected'; ?>>
                                <?php echo htmlspecialchars($category['room_category_name']); ?> - €<?php echo number_format($category['room_category_price_per_night'], 2); ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="room_status">
                            Disponibilidad
                        </label>
                        <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                               id="room_status" 
                               name="room_status">
                            <option value="1" <?php if($room['room_status'] == 1) echo 'selected'; ?>>Disponible</option>
                            <option value="0" <?php if($room['room_status'] == 0) echo 'selected'; ?>>No disponible</option>
                        </select>
                    </div>
                    
                    <div class="mb-6">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="room_state">
                            Estado
                        </label>
                        <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                               id="room_state" 
                               name="room_state">
                            <option value="ready" <?php if($room['room_state'] == 'ready') echo 'selected'; ?>>Lista</option>
                            <option value="check in" <?php if($room['room_state'] == 'check in') echo 'selected'; ?>>Check in</option>
                            <option value="check out" <?php if($room['room_state'] == 'check out') echo 'selected'; ?>>Check out</option>
                            <option value="breakdown" <?php if($room['room_state'] == 'breakdown') echo 'selected'; ?>>Mantenimiento</option>
                        </select>
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
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include($root . '/student062/hotel/includes/footer.php'); ?>