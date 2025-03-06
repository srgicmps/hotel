<?php
$root = $_SERVER['DOCUMENT_ROOT'];
include($root . '/student062/hotel/includes/header.php');

if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    // Redirect to login if not admin
    header("Location: /student062/hotel/src/login.php");
    exit;
}

include($root . '/student062/hotel/config/connect_db.php');
?>

<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <div class="flex flex-col md:flex-row">
        <!-- Admin Sidebar -->
        <div class="w-full md:w-64 bg-gray-800 text-white p-4 rounded-lg mb-6 md:mb-0 md:mr-6">
            <h2 class="text-xl font-bold mb-6">Panel de Administración</h2>
            
            <nav>
                <ul>
                    <li class="mb-1">
                        <a href="/student062/hotel/admin/dashboard.php" class="block p-2 rounded bg-gray-700">
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
                    
                    <!-- Room Categories -->
                    <li class="mb-4">
                        <div class="block p-2 font-medium">
                            <i class="fas fa-tags mr-2"></i> Categorías
                        </div>
                        <ul class="pl-4">
                            <li>
                                <a href="/student062/hotel/admin/tables/room_categories/select/form.php" class="block p-2 text-gray-300 hover:text-white">
                                    <i class="fas fa-list mr-2"></i> Ver Todas
                                </a>
                            </li>
                            <li>
                                <a href="/student062/hotel/admin/tables/room_categories/insert/form.php" class="block p-2 text-gray-300 hover:text-white">
                                    <i class="fas fa-plus mr-2"></i> Añadir Nueva
                                </a>
                            </li>
                        </ul>
                    </li>
                    
                    <!-- Reservations -->
                    <li class="mb-4">
                        <div class="block p-2 font-medium">
                            <i class="fas fa-calendar-check mr-2"></i> Reservaciones
                        </div>
                        <ul class="pl-4">
                            <li>
                                <a href="/student062/hotel/admin/tables/reservations/select/form.php" class="block p-2 text-gray-300 hover:text-white">
                                    <i class="fas fa-list mr-2"></i> Ver Todas
                                </a>
                            </li>
                            <li>
                                <a href="/student062/hotel/admin/tables/reservations/insert/form.php" class="block p-2 text-gray-300 hover:text-white">
                                    <i class="fas fa-plus mr-2"></i> Añadir Nueva
                                </a>
                            </li>
                        </ul>
                    </li>
                    
                    <!-- Users -->
                    <li class="mb-4">
                        <div class="block p-2 font-medium">
                            <i class="fas fa-users mr-2"></i> Usuarios
                        </div>
                        <ul class="pl-4">
                            <li>
                                <a href="/student062/hotel/admin/tables/users/select/form.php" class="block p-2 text-gray-300 hover:text-white">
                                    <i class="fas fa-list mr-2"></i> Ver Todos
                                </a>
                            </li>
                            <li>
                                <a href="/student062/hotel/admin/tables/users/insert/form.php" class="block p-2 text-gray-300 hover:text-white">
                                    <i class="fas fa-plus mr-2"></i> Añadir Nuevo
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </div>
        
        <!-- Main content area -->
        <div class="flex-1">
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-2xl font-bold">Dashboard</h1>
                <div class="text-sm text-gray-500">
                    <i class="fas fa-clock mr-1"></i> 
                    <?php echo date("d/m/Y H:i"); ?>
                </div>
            </div>
            
            <!-- Key stats summary -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
                <!-- Rooms Card -->
                <div class="bg-white rounded-lg shadow p-4">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                            <i class="fas fa-bed text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <h2 class="text-sm font-medium text-gray-500">Habitaciones</h2>
                            <div class="text-xl font-bold text-gray-900">
                                <?php
                                $sql = "SELECT COUNT(*) as count FROM rooms";
                                $result = $conn->query($sql);
                                $row = $result->fetch_assoc();
                                echo $row['count'] ?? '0';
                                ?>
                            </div>
                        </div>
                    </div>
                    <a href="/student062/hotel/admin/tables/rooms/select/form.php" class="text-blue-500 hover:underline text-xs mt-3 inline-block">
                        <i class="fas fa-arrow-right mr-1"></i> Ver todas
                    </a>
                </div>
                
                <!-- Available Rooms Card -->
                <div class="bg-white rounded-lg shadow p-4">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-green-100 text-green-600">
                            <i class="fas fa-door-open text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <h2 class="text-sm font-medium text-gray-500">Disponibles</h2>
                            <div class="text-xl font-bold text-gray-900">
                                <?php
                                $sql = "SELECT COUNT(*) as count FROM rooms WHERE room_status = 1 AND room_state = 'ready'";
                                $result = $conn->query($sql);
                                $row = $result->fetch_assoc();
                                echo $row['count'] ?? '0';
                                ?>
                            </div>
                        </div>
                    </div>
                    <a href="/student062/hotel/admin/tables/rooms/select/form.php?status=1&state=ready" class="text-green-500 hover:underline text-xs mt-3 inline-block">
                        <i class="fas fa-arrow-right mr-1"></i> Ver detalles
                    </a>
                </div>
                
                <!-- Categories Card -->
                <div class="bg-white rounded-lg shadow p-4">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                            <i class="fas fa-tags text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <h2 class="text-sm font-medium text-gray-500">Categorías</h2>
                            <div class="text-xl font-bold text-gray-900">
                                <?php
                                $sql = "SELECT COUNT(*) as count FROM room_categories";
                                $result = $conn->query($sql);
                                $row = $result->fetch_assoc();
                                echo $row['count'] ?? '0';
                                ?>
                            </div>
                        </div>
                    </div>
                    <a href="/student062/hotel/admin/tables/room_categories/select/form.php" class="text-purple-500 hover:underline text-xs mt-3 inline-block">
                        <i class="fas fa-arrow-right mr-1"></i> Ver todas
                    </a>
                </div>
                
                <!-- Users Card -->
                <div class="bg-white rounded-lg shadow p-4">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                            <i class="fas fa-users text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <h2 class="text-sm font-medium text-gray-500">Usuarios</h2>
                            <div class="text-xl font-bold text-gray-900">
                                <?php
                                $sql = "SELECT COUNT(*) as count FROM users";
                                $result = $conn->query($sql);
                                $row = $result->fetch_assoc();
                                echo $row['count'] ?? '0';
                                ?>
                            </div>
                        </div>
                    </div>
                    <a href="/student062/hotel/admin/tables/users/select/form.php" class="text-yellow-500 hover:underline text-xs mt-3 inline-block">
                        <i class="fas fa-arrow-right mr-1"></i> Ver todos
                    </a>
                </div>
            </div>
            
            <!-- Room Status Overview -->
            <div class="bg-white rounded-lg shadow mb-8">
                <div class="px-4 py-5 border-b border-gray-200">
                    <h2 class="text-lg font-medium text-gray-900">Estado de Habitaciones</h2>
                </div>
                <div class="p-4">
                    <div class="flex flex-wrap">
                        <?php
                        // State count: ready
                        $sql = "SELECT COUNT(*) as count FROM rooms WHERE room_state = 'ready'";
                        $result = $conn->query($sql);
                        $readyCount = $result->fetch_assoc()['count'] ?? 0;
                        
                        // State count: check in
                        $sql = "SELECT COUNT(*) as count FROM rooms WHERE room_state = 'check in'";
                        $result = $conn->query($sql);
                        $checkInCount = $result->fetch_assoc()['count'] ?? 0;
                        
                        // State count: check out
                        $sql = "SELECT COUNT(*) as count FROM rooms WHERE room_state = 'check out'";
                        $result = $conn->query($sql);
                        $checkOutCount = $result->fetch_assoc()['count'] ?? 0;
                        
                        // State count: breakdown
                        $sql = "SELECT COUNT(*) as count FROM rooms WHERE room_state = 'breakdown'";
                        $result = $conn->query($sql);
                        $breakdownCount = $result->fetch_assoc()['count'] ?? 0;
                        
                        // Get total count
                        $sql = "SELECT COUNT(*) as count FROM rooms";
                        $result = $conn->query($sql);
                        $totalCount = $result->fetch_assoc()['count'] ?? 1; // Avoid division by zero
                        ?>
                        
                        <!-- Ready -->
                        <div class="w-full sm:w-1/2 md:w-1/4 px-2 mb-4">
                            <div class="bg-green-50 rounded p-3">
                                <div class="flex justify-between items-center">
                                    <span class="text-green-700 font-medium">Listas</span>
                                    <span class="text-green-700 font-bold"><?php echo $readyCount; ?></span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2 mt-2">
                                    <div class="bg-green-600 h-2 rounded-full" style="width: <?php echo ($readyCount / $totalCount * 100); ?>%"></div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Check In -->
                        <div class="w-full sm:w-1/2 md:w-1/4 px-2 mb-4">
                            <div class="bg-blue-50 rounded p-3">
                                <div class="flex justify-between items-center">
                                    <span class="text-blue-700 font-medium">Check in</span>
                                    <span class="text-blue-700 font-bold"><?php echo $checkInCount; ?></span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2 mt-2">
                                    <div class="bg-blue-600 h-2 rounded-full" style="width: <?php echo ($checkInCount / $totalCount * 100); ?>%"></div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Check Out -->
                        <div class="w-full sm:w-1/2 md:w-1/4 px-2 mb-4">
                            <div class="bg-yellow-50 rounded p-3">
                                <div class="flex justify-between items-center">
                                    <span class="text-yellow-700 font-medium">Check out</span>
                                    <span class="text-yellow-700 font-bold"><?php echo $checkOutCount; ?></span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2 mt-2">
                                    <div class="bg-yellow-600 h-2 rounded-full" style="width: <?php echo ($checkOutCount / $totalCount * 100); ?>%"></div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Breakdown -->
                        <div class="w-full sm:w-1/2 md:w-1/4 px-2 mb-4">
                            <div class="bg-red-50 rounded p-3">
                                <div class="flex justify-between items-center">
                                    <span class="text-red-700 font-medium">Mantenimiento</span>
                                    <span class="text-red-700 font-bold"><?php echo $breakdownCount; ?></span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2 mt-2">
                                    <div class="bg-red-600 h-2 rounded-full" style="width: <?php echo ($breakdownCount / $totalCount * 100); ?>%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Latest Bookings -->
            <div class="bg-white rounded-lg shadow">
                <div class="px-4 py-5 border-b border-gray-200 flex justify-between items-center">
                    <h2 class="text-lg font-medium text-gray-900">Últimas Reservas</h2>
                    <a href="/student062/hotel/admin/tables/reservations/select/form.php" class="text-sm text-blue-500 hover:underline">
                        Ver todas <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cliente</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Habitación</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Check In</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Check Out</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php
                            // Este código es solo un ejemplo para mostrar cómo se vería.
                            // Deberás adaptarlo a tu esquema de base de datos real para reservas.
                            
                            // Intenta consultar la tabla de reservas si existe
                            $hasReservations = false;
                            
                            try {
                                $sql = "SHOW TABLES LIKE 'reservations'";
                                $result = $conn->query($sql);
                                
                                if ($result && $result->num_rows > 0) {
                                    $sql = "SELECT 
                                            r.*, 
                                            u.first_name, 
                                            u.last_name,
                                            rm.room_number
                                        FROM 
                                            reservations r
                                            LEFT JOIN users u ON r.user_id = u.user_id
                                            LEFT JOIN rooms rm ON r.room_id = rm.room_id
                                        ORDER BY 
                                            r.created_at DESC
                                        LIMIT 5";
                                            
                                    $result = $conn->query($sql);
                                    $hasReservations = ($result && $result->num_rows > 0);
                                    
                                    if ($hasReservations) {
                                        while ($row = $result->fetch_assoc()) {
                                            echo '<tr>';
                                            echo '<td class="px-6 py-4 whitespace-nowrap">#' . htmlspecialchars($row['reservation_id'] ?? '') . '</td>';
                                            echo '<td class="px-6 py-4 whitespace-nowrap">' . htmlspecialchars($row['first_name'] . ' ' . $row['last_name']) . '</td>';
                                            echo '<td class="px-6 py-4 whitespace-nowrap">' . htmlspecialchars($row['room_number'] ?? '') . '</td>';
                                            echo '<td class="px-6 py-4 whitespace-nowrap">' . htmlspecialchars($row['check_in_date'] ?? '') . '</td>';
                                            echo '<td class="px-6 py-4 whitespace-nowrap">' . htmlspecialchars($row['check_out_date'] ?? '') . '</td>';
                                            
                                            // Estado con indicador de color
                                            echo '<td class="px-6 py-4 whitespace-nowrap">';
                                            switch($row['status'] ?? '') {
                                                case 'confirmed':
                                                    echo '<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Confirmada</span>';
                                                    break;
                                                case 'pending':
                                                    echo '<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Pendiente</span>';
                                                    break;
                                                case 'cancelled':
                                                    echo '<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Cancelada</span>';
                                                    break;
                                                default:
                                                    echo '<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">' . htmlspecialchars($row['status'] ?? 'Desconocido') . '</span>';
                                            }
                                            echo '</td>';
                                            
                                            // Enlaces de acción
                                            echo '<td class="px-6 py-4 whitespace-nowrap text-sm font-medium">';
                                            echo '<a href="/student062/hotel/admin/tables/reservations/update/form.php?id=' . ($row['reservation_id'] ?? '') . '" class="text-blue-600 hover:text-blue-900 mr-3">';
                                            echo '<i class="fas fa-edit"></i>';
                                            echo '</a>';
                                            echo '<a href="/student062/hotel/admin/tables/reservations/delete/form.php?id=' . ($row['reservation_id'] ?? '') . '" class="text-red-600 hover:text-red-900">';
                                            echo '<i class="fas fa-trash"></i>';
                                            echo '</a>';
                                            echo '</td>';
                                            echo '</tr>';
                                        }
                                    }
                                }
                            } catch (Exception $e) {
                                // Si hay un error, simplemente muestra el mensaje de no reservas
                                $hasReservations = false;
                            }
                            
                            if (!$hasReservations) {
                                echo '<tr><td colspan="7" class="px-6 py-4 text-center">No hay reservas disponibles</td></tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include($root . '/student062/hotel/includes/footer.php'); ?>