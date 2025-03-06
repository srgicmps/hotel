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
$roomState = isset($_GET['room_state']) ? $_GET['room_state'] : '';
$roomStatus = isset($_GET['room_status']) ? $_GET['room_status'] : '';
$categoryId = isset($_GET['category_id']) ? intval($_GET['category_id']) : 0;
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
                            <span class="ml-1 text-gray-500 md:ml-2 font-medium">Habitaciones</span>
                        </div>
                    </li>
                </ol>
            </nav>
            <div class="flex gap-2">
                <a href="/student062/hotel/admin/dashboard.php" class="bg-gray-500 hover:bg-gray-600 text-white py-2 px-4 rounded-lg transition-colors flex items-center">
                    <i class="fas fa-arrow-left mr-2"></i> Volver
                </a>
                <a href="../insert/form.php" class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-lg transition-colors flex items-center">
                    <i class="fas fa-plus mr-2"></i> Nueva Habitación
                </a>
            </div>
        </div>

        <!-- Page header -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <div class="flex justify-between items-center mb-4">
                <h1 class="text-2xl font-bold text-gray-800">Gestión de Habitaciones</h1>
                <div class="text-sm text-gray-500">
                    <i class="fas fa-clock mr-1"></i> <?php echo date("d/m/Y H:i"); ?>
                </div>
            </div>
            
            <p class="text-gray-600 mb-6">Administra las habitaciones del hotel, filtrar por estado, categoría o buscar por número.</p>
            
            <?php if(!empty($success)): ?>
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-md flex items-center" role="alert">
                    <i class="fas fa-check-circle mr-3 text-xl"></i>
                    <div>
                        <p class="font-medium">
                        <?php 
                        switch($success) {
                            case 'deleted':
                                echo 'Habitación eliminada correctamente';
                                break;
                            case 'created':
                                echo 'Habitación creada correctamente';
                                break;
                            case 'updated':
                                echo 'Habitación actualizada correctamente';
                                break;
                            default:
                                echo 'Operación realizada con éxito';
                        }
                        ?>
                        </p>
                    </div>
                </div>
            <?php endif; ?>
            
            <?php if(!empty($error)): ?>
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-md flex items-center" role="alert">
                    <i class="fas fa-exclamation-circle mr-3 text-xl"></i>
                    <div>
                        <p class="font-medium">Ha ocurrido un error</p>
                        <p><?php echo $error; ?></p>
                    </div>
                </div>
            <?php endif; ?>

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
                                placeholder="Buscar por número..." 
                                class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>

                    <div>
                        <label for="room_state" class="block text-sm font-medium text-gray-700 mb-1">Estado</label>
                        <select 
                            name="room_state" 
                            id="room_state" 
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Todos los estados</option>
                            <option value="ready" <?php echo $roomState == 'ready' ? 'selected' : ''; ?>>Lista</option>
                            <option value="check in" <?php echo $roomState == 'check in' ? 'selected' : ''; ?>>Check in</option>
                            <option value="check out" <?php echo $roomState == 'check out' ? 'selected' : ''; ?>>Check out</option>
                            <option value="breakdown" <?php echo $roomState == 'breakdown' ? 'selected' : ''; ?>>Mantenimiento</option>
                        </select>
                    </div>

                    <div>
                        <label for="room_status" class="block text-sm font-medium text-gray-700 mb-1">Disponibilidad</label>
                        <select 
                            name="room_status" 
                            id="room_status" 
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Todas</option>
                            <option value="1" <?php echo $roomStatus === '1' ? 'selected' : ''; ?>>Disponible</option>
                            <option value="0" <?php echo $roomStatus === '0' ? 'selected' : ''; ?>>No disponible</option>
                        </select>
                    </div>

                    <div>
                        <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">Categoría</label>
                        <select 
                            name="category_id" 
                            id="category_id"
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            <option value="0">Todas las categorías</option>
                            <?php
                            $catSql = "SELECT * FROM room_categories ORDER BY room_category_name";
                            $catResult = $conn->query($catSql);
                            if ($catResult && $catResult->num_rows > 0) {
                                while ($cat = $catResult->fetch_assoc()) {
                                    $selected = ($categoryId == $cat['room_category_id']) ? 'selected' : '';
                                    echo '<option value="' . $cat['room_category_id'] . '" ' . $selected . '>' . 
                                        htmlspecialchars($cat['room_category_name']) . '</option>';
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
            $sql = "SELECT r.*, c.room_category_name, c.room_category_price_per_night 
                   FROM rooms r 
                   LEFT JOIN room_categories c ON r.room_category_id = c.room_category_id 
                   WHERE 1=1";
            
            $countSql = "SELECT COUNT(*) as total FROM rooms r WHERE 1=1";
            
            // Apply search filter
            if (!empty($search)) {
                $searchTerm = $conn->real_escape_string("%$search%");
                $condition = " AND r.room_number LIKE '$searchTerm'";
                $sql .= $condition;
                $countSql .= $condition;
            }
            
            // Apply room state filter
            if (!empty($roomState)) {
                $stateFilter = $conn->real_escape_string($roomState);
                $condition = " AND r.room_state = '$stateFilter'";
                $sql .= $condition;
                $countSql .= $condition;
            }
            
            // Apply room status filter
            if ($roomStatus !== '') {
                $statusFilter = $conn->real_escape_string($roomStatus);
                $condition = " AND r.room_status = '$statusFilter'";
                $sql .= $condition;
                $countSql .= $condition;
            }
            
            // Apply category filter
            if ($categoryId > 0) {
                $condition = " AND r.room_category_id = $categoryId";
                $sql .= $condition;
                $countSql .= $condition;
            }
            
            // Get total count for pagination
            $countResult = $conn->query($countSql);
            $totalRecords = $countResult->fetch_assoc()['total'] ?? 0;
            $totalPages = ceil($totalRecords / $recordsPerPage);
            
            // Order by room number
            $sql .= " ORDER BY r.room_number ASC LIMIT $offset, $recordsPerPage";
            
            // Execute query
            $result = $conn->query($sql);
            $roomCount = $result ? $result->num_rows : 0;
            ?>
            
            <!-- Data table header -->
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
                <div class="text-sm text-gray-500">
                    Mostrando <span class="font-medium text-gray-700"><?php echo min($recordsPerPage, $roomCount); ?></span> de 
                    <span class="font-medium text-gray-700"><?php echo $totalRecords; ?></span> habitaciones
                </div>
                <div class="flex gap-4">
                    <div class="flex items-center text-sm text-gray-500">
                        <div class="w-3 h-3 rounded-full bg-green-500 mr-2"></div> Lista
                    </div>
                    <div class="flex items-center text-sm text-gray-500">
                        <div class="w-3 h-3 rounded-full bg-blue-500 mr-2"></div> Check in
                    </div>
                    <div class="flex items-center text-sm text-gray-500">
                        <div class="w-3 h-3 rounded-full bg-yellow-500 mr-2"></div> Check out
                    </div>
                    <div class="flex items-center text-sm text-gray-500">
                        <div class="w-3 h-3 rounded-full bg-red-500 mr-2"></div> Mantenimiento
                    </div>
                </div>
            </div>

            <?php if ($roomCount > 0): ?>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Número
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Categoría
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Estado
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Precio/Noche
                            </th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Acciones
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php while($room = $result->fetch_assoc()): ?>
                            <?php 
                            // Determine row background color based on state
                            $rowClass = '';
                            $stateColor = '';
                            
                            switch($room['room_state']) {
                                case 'ready':
                                    $rowClass = 'hover:bg-green-50';
                                    $stateColor = 'bg-green-500';
                                    $stateText = 'Lista';
                                    break;
                                case 'check in':
                                    $rowClass = 'hover:bg-blue-50';
                                    $stateColor = 'bg-blue-500';
                                    $stateText = 'Check in';
                                    break;
                                case 'check out':
                                    $rowClass = 'hover:bg-yellow-50';
                                    $stateColor = 'bg-yellow-500';
                                    $stateText = 'Check out';
                                    break;
                                case 'breakdown':
                                    $rowClass = 'hover:bg-red-50';
                                    $stateColor = 'bg-red-500';
                                    $stateText = 'Mantenimiento';
                                    break;
                                default:
                                    $rowClass = 'hover:bg-gray-50';
                                    $stateColor = 'bg-gray-500';
                                    $stateText = htmlspecialchars($room['room_state']);
                            }
                            ?>
                            <tr class="<?php echo $rowClass; ?>">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10 flex items-center justify-center bg-gray-100 rounded-full">
                                            <i class="fas fa-bed text-gray-500"></i>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">
                                                <?php echo htmlspecialchars($room['room_number']); ?>
                                            </div>
                                            <div class="text-xs text-gray-500">
                                                <?php echo $room['room_status'] ? 'Disponible' : 'No disponible'; ?>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        <?php echo htmlspecialchars($room['room_category_name'] ?? 'Sin categoría'); ?>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="h-2.5 w-2.5 rounded-full <?php echo $stateColor; ?> mr-2"></div>
                                        <span class="text-sm text-gray-900">
                                            <?php echo $stateText; ?>
                                        </span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900 font-medium">
                                        €<?php echo number_format($room['room_category_price_per_night'] ?? 0, 2); ?>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex gap-2 justify-end">
                                        <!-- State Quick Update -->
                                        <form method="POST" action="quick_update.php" class="inline-flex">
                                            <input type="hidden" name="room_id" value="<?php echo $room['room_id']; ?>">
                                            <input type="hidden" name="action" value="state">
                                            <select 
                                                name="room_state" 
                                                onchange="this.form.submit()" 
                                                class="text-xs text-gray-700 border border-gray-300 rounded px-2 py-1 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                                <option value="ready" <?php echo $room['room_state'] == 'ready' ? 'selected' : ''; ?>>Lista</option>
                                                <option value="check in" <?php echo $room['room_state'] == 'check in' ? 'selected' : ''; ?>>Check in</option>
                                                <option value="check out" <?php echo $room['room_state'] == 'check out' ? 'selected' : ''; ?>>Check out</option>
                                                <option value="breakdown" <?php echo $room['room_state'] == 'breakdown' ? 'selected' : ''; ?>>Mantenimiento</option>
                                            </select>
                                        </form>
                                        
                                        <!-- Status Quick Toggle -->
                                        <form method="POST" action="quick_update.php" class="inline-flex">
                                            <input type="hidden" name="room_id" value="<?php echo $room['room_id']; ?>">
                                            <input type="hidden" name="action" value="status">
                                            <input type="hidden" name="room_status" value="<?php echo $room['room_status'] ? '0' : '1'; ?>">
                                            <button 
                                                type="submit"
                                                class="<?php echo $room['room_status'] ? 'text-green-600 hover:text-green-900' : 'text-red-600 hover:text-red-900'; ?> focus:outline-none">
                                                <i class="fas <?php echo $room['room_status'] ? 'fa-toggle-on' : 'fa-toggle-off'; ?>"></i>
                                            </button>
                                        </form>
                                        
                                        <!-- Edit Button -->
                                        <a 
                                            href="../update/form.php?id=<?php echo $room['room_id']; ?>" 
                                            class="text-blue-600 hover:text-blue-900" 
                                            title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        
                                        <!-- Delete Button -->
                                        <a 
                                            href="../delete/form.php?id=<?php echo $room['room_id']; ?>" 
                                            class="text-red-600 hover:text-red-900" 
                                            onclick="return confirm('¿Estás seguro de eliminar esta habitación?');"
                                            title="Eliminar">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <?php if ($totalPages > 1): ?>
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                    <div class="flex items-center justify-between">
                        <div class="text-sm text-gray-700">
                            Página <span class="font-medium"><?php echo $page; ?></span> de <span class="font-medium"><?php echo $totalPages; ?></span>
                        </div>
                        <div class="flex space-x-1">
                            <?php if ($page > 1): ?>
                                <a href="?page=1<?php echo !empty($search) ? '&search=' . urlencode($search) : ''; ?><?php echo !empty($roomState) ? '&room_state=' . urlencode($roomState) : ''; ?><?php echo $roomStatus !== '' ? '&room_status=' . urlencode($roomStatus) : ''; ?><?php echo $categoryId ? '&category_id=' . $categoryId : ''; ?>" class="px-4 py-2 text-sm bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                                    <i class="fas fa-angle-double-left"></i>
                                </a>
                                <a href="?page=<?php echo $page - 1; ?><?php echo !empty($search) ? '&search=' . urlencode($search) : ''; ?><?php echo !empty($roomState) ? '&room_state=' . urlencode($roomState) : ''; ?><?php echo $roomStatus !== '' ? '&room_status=' . urlencode($roomStatus) : ''; ?><?php echo $categoryId ? '&category_id=' . $categoryId : ''; ?>" class="px-4 py-2 text-sm bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                                    <i class="fas fa-angle-left"></i>
                                </a>
                            <?php else: ?>
                                <span class="px-4 py-2 text-sm bg-gray-100 text-gray-400 border border-gray-300 rounded-md">
                                    <i class="fas fa-angle-double-left"></i>
                                </span>
                                <span class="px-4 py-2 text-sm bg-gray-100 text-gray-400 border border-gray-300 rounded-md">
                                    <i class="fas fa-angle-left"></i>
                                </span>
                            <?php endif; ?>
                            
                            <!-- Current page indicator -->
                            <span class="px-4 py-2 text-sm bg-blue-600 text-white border border-blue-600 rounded-md">
                                <?php echo $page; ?>
                            </span>
                            
                            <?php if ($page < $totalPages): ?>
                                <a href="?page=<?php echo $page + 1; ?><?php echo !empty($search) ? '&search=' . urlencode($search) : ''; ?><?php echo !empty($roomState) ? '&room_state=' . urlencode($roomState) : ''; ?><?php echo $roomStatus !== '' ? '&room_status=' . urlencode($roomStatus) : ''; ?><?php echo $categoryId ? '&category_id=' . $categoryId : ''; ?>" class="px-4 py-2 text-sm bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                                    <i class="fas fa-angle-right"></i>
                                </a>
                                <a href="?page=<?php echo $totalPages; ?><?php echo !empty($search) ? '&search=' . urlencode($search) : ''; ?><?php echo !empty($roomState) ? '&room_state=' . urlencode($roomState) : ''; ?><?php echo $roomStatus !== '' ? '&room_status=' . urlencode($roomStatus) : ''; ?><?php echo $categoryId ? '&category_id=' . $categoryId : ''; ?>" class="px-4 py-2 text-sm bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                                    <i class="fas fa-angle-double-right"></i>
                                </a>
                            <?php else: ?>
                                <span class="px-4 py-2 text-sm bg-gray-100 text-gray-400 border border-gray-300 rounded-md">
                                    <i class="fas fa-angle-right"></i>
                                </span>
                                <span class="px-4 py-2 text-sm bg-gray-100 text-gray-400 border border-gray-300 rounded-md">
                                    <i class="fas fa-angle-double-right"></i>
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            
            <?php else: ?>
                <div class="p-8 text-center">
                    <div class="inline-flex rounded-full bg-gray-100 p-6 mb-4">
                        <i class="fas fa-bed text-gray-500 text-3xl"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-1">No se encontraron habitaciones</h3>
                    <p class="text-gray-500 mb-6">
                        <?php if (!empty($search) || !empty($roomState) || $roomStatus !== '' || $categoryId > 0): ?>
                            No hay resultados que coincidan con tus filtros.
                        <?php else: ?>
                            No hay habitaciones registradas en el sistema.
                        <?php endif; ?>
                    </p>
                    <?php if (!empty($search) || !empty($roomState) || $roomStatus !== '' || $categoryId > 0): ?>
                        <a href="form.php" class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-blue-700 bg-blue-100 hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <i class="fas fa-times mr-2"></i> Limpiar filtros
                        </a>
                    <?php else: ?>
                        <a href="../insert/form.php" class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <i class="fas fa-plus mr-2"></i> Añadir habitación
                        </a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include($root . '/student062/hotel/includes/footer.php'); ?>