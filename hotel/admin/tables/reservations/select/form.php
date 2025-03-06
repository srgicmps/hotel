<?php
$root = $_SERVER['DOCUMENT_ROOT'];
include($root . '/student062/hotel/includes/header.php');

// Check if user has admin privileges
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    header("Location: /student062/hotel/src/login.php");
    exit;
}

require_once $root . '/student062/hotel/config/connect_db.php';

// Pagination
$recordsPerPage = 10;
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$offset = ($page - 1) * $recordsPerPage;

// Filters
$reservationState = isset($_GET['reservation_state']) ? $_GET['reservation_state'] : '';
$userId = isset($_GET['user_id']) ? intval($_GET['user_id']) : 0;
$roomId = isset($_GET['room_id']) ? intval($_GET['room_id']) : 0;
$search = isset($_GET['search']) ? trim($_GET['search']) : '';

// Success/error messages
$success = isset($_GET['success']) ? $_GET['success'] : '';
$error = isset($_GET['error']) ? $_GET['error'] : '';
?>

<div class="bg-gray-50 min-h-screen">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Top navigation -->
        <div class="mb-6 flex justify-between items-center">
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="/student062/hotel/admin/dashboard.php" class="inline-flex items-center text-gray-700 hover:text-blue-600">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                            </svg>
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="ml-1 text-gray-500 md:ml-2 font-medium">Reservas</span>
                        </div>
                    </li>
                </ol>
            </nav>
            <div class="flex gap-2">
                <a href="/student062/hotel/admin/dashboard.php" class="bg-gray-500 hover:bg-gray-600 text-white py-2 px-4 rounded-lg transition-colors flex items-center">
                    <i class="fas fa-arrow-left mr-2"></i> Volver
                </a>
                <a href="../insert/form.php" class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-lg transition-colors flex items-center">
                    <i class="fas fa-plus mr-2"></i> Nueva Reserva
                </a>
            </div>
        </div>

        <!-- Page header -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <div class="flex justify-between items-center mb-4">
                <h1 class="text-2xl font-bold text-gray-800">Gestión de Reservas</h1>
                <div class="text-sm text-gray-500">
                    <i class="fas fa-clock mr-1"></i> <?php echo date("d/m/Y H:i"); ?>
                </div>
            </div>
            
            <p class="text-gray-600 mb-6">Administra las reservas del hotel, filtra por estado, usuario, habitación o busca por número de reserva.</p>

            <!-- Advanced Search -->
            <div class="bg-gray-50 border border-gray-200 rounded-lg p-5">
                <form action="" method="GET" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div>
                        <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Búsqueda</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-search text-gray-400"></i>
                            </div>
                            <input 
                                type="text" 
                                name="search" 
                                id="search" 
                                value="<?php echo htmlspecialchars($search); ?>" 
                                placeholder="Buscar por número de reserva..." 
                                class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>

                    <div>
                        <label for="reservation_state" class="block text-sm font-medium text-gray-700 mb-1">Estado</label>
                        <select 
                            name="reservation_state" 
                            id="reservation_state" 
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Todos los estados</option>
                            <option value="cancelled" <?php echo $reservationState == 'cancelled' ? 'selected' : ''; ?>>Cancelada</option>
                            <option value="checked in" <?php echo $reservationState == 'checked in' ? 'selected' : ''; ?>>Check in</option>
                            <option value="booked" <?php echo $reservationState == 'booked' ? 'selected' : ''; ?>>Reservada</option>
                            <option value="checked out" <?php echo $reservationState == 'checked out' ? 'selected' : ''; ?>>Check out</option>
                        </select>
                    </div>

                    <div>
                        <label for="user_id" class="block text-sm font-medium text-gray-700 mb-1">Usuario</label>
                        <select 
                            name="user_id" 
                            id="user_id"
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            <option value="0">Todos los usuarios</option>
                            <?php
                            $userSql = "SELECT user_id, user_name FROM users ORDER BY user_name";
                            $userResult = $conn->query($userSql);
                            if ($userResult && $userResult->num_rows > 0) {
                                while ($user = $userResult->fetch_assoc()) {
                                    $selected = ($userId == $user['user_id']) ? 'selected' : '';
                                    echo '<option value="' . $user['user_id'] . '" ' . $selected . '>' . 
                                        htmlspecialchars($user['user_name']) . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>

                    <div>
                        <label for="room_id" class="block text-sm font-medium text-gray-700 mb-1">Habitación</label>
                        <select 
                            name="room_id" 
                            id="room_id"
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            <option value="0">Todas las habitaciones</option>
                            <?php
                            $roomSql = "SELECT room_id, room_number FROM rooms ORDER BY room_number";
                            $roomResult = $conn->query($roomSql);
                            if ($roomResult && $roomResult->num_rows > 0) {
                                while ($room = $roomResult->fetch_assoc()) {
                                    $selected = ($roomId == $room['room_id']) ? 'selected' : '';
                                    echo '<option value="' . $room['room_id'] . '" ' . $selected . '>' . 
                                        htmlspecialchars($room['room_number']) . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>
                    
                    <div class="lg:col-span-4 flex gap-2">
                        <button 
                            type="submit" 
                            class="flex-grow md:flex-grow-0 bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-md transition-colors flex items-center justify-center">
                            <i class="fas fa-filter mr-2"></i> Filtrar
                        </button>
                        
                        <a 
                            href="form.php" 
                            class="flex-grow md:flex-grow-0 bg-gray-500 hover:bg-gray-600 text-white py-2 px-4 rounded-md transition-colors flex items-center justify-center">
                            <i class="fas fa-times mr-2"></i> Limpiar filtros
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Data table -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <?php
            // Build query with filters
            $sql = "SELECT r.*, u.user_name, rm.room_number 
                   FROM reservations r 
                   LEFT JOIN users u ON r.user_id = u.user_id 
                   LEFT JOIN rooms rm ON r.room_id = rm.room_id 
                   WHERE 1=1";

            if ($reservationState) {
                $sql .= " AND r.reservation_state = '" . $conn->real_escape_string($reservationState) . "'";
            }
            if ($userId) {
                $sql .= " AND r.user_id = " . intval($userId);
            }
            if ($roomId) {
                $sql .= " AND r.room_id = " . intval($roomId);
            }
            if ($search) {
                $sql .= " AND r.reservation_number LIKE '%" . $conn->real_escape_string($search) . "%'";
            }

            // Get total count for pagination
            $countSql = str_replace("r.*, u.user_name, rm.room_number", "COUNT(*) as total", $sql);
            $countResult = $conn->query($countSql);
            $totalRows = $countResult->fetch_assoc()['total'];
            $totalPages = ceil($totalRows / $recordsPerPage);

            // Add pagination to main query
            $sql .= " ORDER BY r.reservation_id DESC LIMIT $offset, $recordsPerPage";
            $result = $conn->query($sql);

            if ($result && $result->num_rows > 0) {
            ?>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nº Reserva</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Usuario</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Habitación</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Check In</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Check Out</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php while ($row = $result->fetch_assoc()) { ?>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap"><?php echo htmlspecialchars($row['reservation_number']); ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap"><?php echo htmlspecialchars($row['user_name']); ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap"><?php echo htmlspecialchars($row['room_number']); ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap"><?php echo date('d/m/Y', strtotime($row['date_check_in'])); ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap"><?php echo date('d/m/Y', strtotime($row['date_check_out'])); ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            <?php
                                            switch ($row['reservation_state']) {
                                                case 'cancelled':
                                                    echo 'bg-red-100 text-red-800';
                                                    break;
                                                case 'checked in':
                                                    echo 'bg-green-100 text-green-800';
                                                    break;
                                                case 'booked':
                                                    echo 'bg-yellow-100 text-yellow-800';
                                                    break;
                                                case 'checked out':
                                                    echo 'bg-gray-100 text-gray-800';
                                                    break;
                                            }
                                            ?>">
                                            <?php echo ucfirst($row['reservation_state']); ?>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="../update/form.php?id=<?php echo $row['reservation_id']; ?>" class="text-blue-600 hover:text-blue-900 mr-3">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="../delete/form.php?id=<?php echo $row['reservation_id']; ?>" 
                                           class="text-red-600 hover:text-red-900"
                                           onclick="return confirm('¿Estás seguro de que deseas eliminar esta reserva?')">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <?php if ($totalPages > 1) { ?>
                    <div class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
                        <div class="flex-1 flex justify-between">
                            <?php if ($page > 1) { ?>
                                <a href="?page=<?php echo ($page - 1); ?>&search=<?php echo urlencode($search); ?>&reservation_state=<?php echo urlencode($reservationState); ?>&user_id=<?php echo $userId; ?>&room_id=<?php echo $roomId; ?>" 
                                   class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                    Anterior
                                </a>
                            <?php } ?>
                            <?php if ($page < $totalPages) { ?>
                                <a href="?page=<?php echo ($page + 1); ?>&search=<?php echo urlencode($search); ?>&reservation_state=<?php echo urlencode($reservationState); ?>&user_id=<?php echo $userId; ?>&room_id=<?php echo $roomId; ?>" 
                                   class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                    Siguiente
                                </a>
                            <?php } ?>
                        </div>
                    </div>
                <?php } ?>
            <?php } else { ?>
                <div class="text-center py-8">
                    <p class="text-gray-500">No se encontraron reservas</p>
                </div>
            <?php } ?>
        </div>
    </div>
</div>

<?php include($root . '/student062/hotel/includes/footer.php'); ?>