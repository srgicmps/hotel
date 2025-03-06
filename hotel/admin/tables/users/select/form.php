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
$userRole = ''; // or appropriate default value
$types = ''; // or appropriate default value
$userStatus = isset($_GET['user_status']) ? $_GET['user_status'] : ''; // or appropriate default value

// Pagination
$recordsPerPage = 10;
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$offset = ($page - 1) * $recordsPerPage;

// Filters
$isAdmin = isset($_GET['is_admin']) ? $_GET['is_admin'] : '';
$search = isset($_GET['search']) ? trim($_GET['search']) : '';

// Success/error messages
$success = isset($_GET['success']) ? $_GET['success'] : '';
$error = isset($_GET['error']) ? $_GET['error'] : '';

// Build SQL query
$sql = "SELECT * FROM users WHERE 1=1";
$sqlCount = "SELECT COUNT(*) as total FROM users WHERE 1=1";

if ($userRole !== '') {
    $sqlCount .= " AND user_role = ?";
    $sql .= " AND user_role = ?";
    $params[] = $userRole;
    $types .= "s";
}

if ($userStatus !== '') {
    $sqlCount .= " AND user_status = ?";
    $sql .= " AND user_status = ?";
    $params[] = $userStatus;
    $types .= "i";
}

if (!empty($search)) {
    $searchParam = "%$search%";
    $sqlCount .= " AND (first_name LIKE ? OR last_name LIKE ? OR email LIKE ? OR dni LIKE ?)";
    $sql .= " AND (first_name LIKE ? OR last_name LIKE ? OR email LIKE ? OR dni LIKE ?)";
    $params[] = $searchParam;
    $params[] = $searchParam;
    $params[] = $searchParam;
    $params[] = $searchParam;
    $types .= "ssss";
}

// Get total count for pagination
$stmtCount = $conn->prepare($sqlCount);
if (!empty($params)) {
    $stmtCount->bind_param($types, ...$params);
}
$stmtCount->execute();
$resultCount = $stmtCount->get_result();
$totalRecords = $resultCount->fetch_assoc()['total'];
$totalPages = ceil($totalRecords / $recordsPerPage);

// Add pagination to the main query
$sql .= " ORDER BY last_name, first_name LIMIT ?, ?";
$params[] = $offset;
$params[] = $recordsPerPage;
$types .= "ii";

// Prepare and execute main query
$stmt = $conn->prepare($sql);
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();
?>

<div class="bg-gray-50 min-h-screen">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Top navigation -->
        <div class="mb-6 flex justify-between items-center">
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="/student062/hotel/admin/dashboard.php" class="inline-flex items-center text-gray-700 hover:text-blue-600">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                            </svg>
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="ml-1 text-gray-500 md:ml-2 font-medium">Usuarios</span>
                        </div>
                    </li>
                </ol>
            </nav>
            <div class="flex gap-2">
                <a href="/student062/hotel/admin/dashboard.php" class="bg-gray-500 hover:bg-gray-600 text-white py-2 px-4 rounded-lg transition-colors flex items-center">
                    <i class="fas fa-arrow-left mr-2"></i> Volver
                </a>
                <a href="../insert/form.php" class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-lg transition-colors flex items-center">
                    <i class="fas fa-plus mr-2"></i> Nuevo Usuario
                </a>
            </div>
        </div>

        <!-- Page header -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <div class="flex justify-between items-center mb-4">
                <h1 class="text-2xl font-bold text-gray-800">Gestión de Usuarios</h1>
                <div class="text-sm text-gray-500">
                    <i class="fas fa-clock mr-1"></i> <?php echo date("d/m/Y H:i"); ?>
                </div>
            </div>

            <p class="text-gray-600 mb-6">Administra los usuarios del sistema, filtra por tipo de usuario o busca por nombre y email.</p>

            <?php if ($success): ?>
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-md flex items-center" role="alert">
                    <i class="fas fa-check-circle mr-3 text-xl"></i>
                    <div>
                        <p class="font-medium">
                            <?php
                            switch ($success) {
                                case 'deleted':
                                    echo 'Usuario eliminado correctamente';
                                    break;
                                case 'created':
                                    echo 'Usuario creado correctamente';
                                    break;
                                case 'updated':
                                    echo 'Usuario actualizado correctamente';
                                    break;
                                default:
                                    echo 'Operación realizada con éxito';
                            }
                            ?>
                        </p>
                    </div>
                </div>
            <?php endif; ?>

            <?php if ($error): ?>
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
                <form method="GET" action="form.php" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="col-span-2">
                        <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Buscar</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-search text-gray-400"></i>
                            </div>
                            <input type="text"
                                name="search"
                                id="search"
                                value="<?php echo htmlspecialchars($search); ?>"
                                placeholder="Nombre, apellido, email o DNI..."
                                class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>

                    <div>
                        <label for="user_role" class="block text-sm font-medium text-gray-700 mb-1">Rol</label>
                        <select name="user_role"
                            id="user_role"
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Todos los roles</option>
                            <option value="admin" <?php echo $userRole === 'admin' ? 'selected' : ''; ?>>Administrador</option>
                            <option value="employee" <?php echo $userRole === 'employee' ? 'selected' : ''; ?>>Empleado</option>
                            <option value="customer" <?php echo $userRole === 'customer' ? 'selected' : ''; ?>>Cliente</option>
                        </select>
                    </div>

                    <div>
                        <label for="user_status" class="block text-sm font-medium text-gray-700 mb-1">Estado</label>
                        <select name="user_status"
                            id="user_status"
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Todos los estados</option>
                            <option value="1" <?php echo $userStatus === '1' ? 'selected' : ''; ?>>Activo</option>
                            <option value="0" <?php echo $userStatus === '0' ? 'selected' : ''; ?>>Inactivo</option>
                        </select>
                    </div>

                    <div class="md:col-span-3 flex gap-2">
                        <button type="submit" class="flex-grow md:flex-grow-0 bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-md transition-colors flex items-center justify-center">
                            <i class="fas fa-filter mr-2"></i> Filtrar
                        </button>

                        <?php if (!empty($search) || $userRole !== '' || $userStatus !== ''): ?>
                            <a href="form.php" class="flex-grow md:flex-grow-0 bg-gray-500 hover:bg-gray-600 text-white py-2 px-4 rounded-md transition-colors flex items-center justify-center">
                                <i class="fas fa-times mr-2"></i> Limpiar filtros
                            </a>
                        <?php endif; ?>
                    </div>
                </form>
            </div>

            <!-- Users Table -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
                    <div class="text-sm text-gray-500">
                        Mostrando <span class="font-medium text-gray-700"><?php echo min(($page - 1) * $recordsPerPage + 1, $totalRecords); ?></span>
                        a <span class="font-medium text-gray-700"><?php echo min($page * $recordsPerPage, $totalRecords); ?></span>
                        de <span class="font-medium text-gray-700"><?php echo $totalRecords; ?></span> usuarios
                    </div>
                    <div class="flex gap-4">
                        <div class="flex items-center text-sm text-gray-500">
                            <div class="w-3 h-3 rounded-full bg-purple-500 mr-2"></div> Administrador
                        </div>
                        <div class="flex items-center text-sm text-gray-500">
                            <div class="w-3 h-3 rounded-full bg-blue-500 mr-2"></div> Usuario
                        </div>
                    </div>
                </div>

                <?php if ($result && $result->num_rows > 0): ?>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipo</th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <?php while ($user = $result->fetch_assoc()): ?>
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <?php echo htmlspecialchars($user['user_id']); ?>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10 bg-gray-100 rounded-full flex items-center justify-center">
                                                    <i class="fas fa-user text-gray-500"></i>
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">
                                                        <?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <?php echo htmlspecialchars($user['email']); ?>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                                <?php echo htmlspecialchars($user['user_role']); ?>
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <a href="../update/form.php?id=<?php echo $user['user_id']; ?>"
                                                class="text-blue-600 hover:text-blue-900 mr-3">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <?php if ($user['user_id'] != $_SESSION['user_id']): ?>
                                                <a href="../delete/form.php?id=<?php echo $user['user_id']; ?>"
                                                    class="text-red-600 hover:text-red-900">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            <?php endif; ?>
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
                                    <?php
                                    // Previous page link
                                    if ($page > 1):
                                        $prevPageUrl = "form.php?page=" . ($page - 1);
                                        if (!empty($search)) $prevPageUrl .= "&search=" . urlencode($search);
                                        if ($isAdmin !== '') $prevPageUrl .= "&is_admin=" . urlencode($isAdmin);
                                    ?>
                                        <a href="<?php echo $prevPageUrl; ?>" class="px-4 py-2 text-sm bg-white hover:bg-gray-100 text-gray-800 border border-gray-300 rounded-md">
                                            <i class="fas fa-angle-double-left"></i>
                                        </a>
                                    <?php else: ?>
                                        <span class="px-4 py-2 text-sm bg-gray-100 text-gray-400 border border-gray-300 rounded-md">
                                            <i class="fas fa-angle-double-left"></i>
                                        </span>
                                    <?php endif; ?>

                                    <?php
                                    $startPage = max(1, $page - 2);
                                    $endPage = min($startPage + 4, $totalPages);
                                    if ($endPage - $startPage < 4) $startPage = max(1, $endPage - 4);

                                    for ($i = $startPage; $i <= $endPage; $i++):
                                        $pageUrl = "form.php?page=$i";
                                        if (!empty($search)) $pageUrl .= "&search=" . urlencode($search);
                                        if ($isAdmin !== '') $pageUrl .= "&is_admin=" . urlencode($isAdmin);
                                    ?>
                                        <?php if ($i == $page): ?>
                                            <span class="px-4 py-2 text-sm bg-blue-600 text-white border border-blue-600 rounded-md">
                                                <?php echo $i; ?>
                                            </span>
                                        <?php else: ?>
                                            <a href="<?php echo $pageUrl; ?>" class="px-4 py-2 text-sm bg-white hover:bg-gray-100 text-gray-800 border border-gray-300 rounded-md">
                                                <?php echo $i; ?>
                                            </a>
                                        <?php endif; ?>
                                    <?php endfor; ?>

                                    <?php
                                    if ($page < $totalPages):
                                        $nextPageUrl = "form.php?page=" . ($page + 1);
                                        if (!empty($search)) $nextPageUrl .= "&search=" . urlencode($search);
                                        if ($isAdmin !== '') $nextPageUrl .= "&is_admin=" . urlencode($isAdmin);
                                    ?>
                                        <a href="<?php echo $nextPageUrl; ?>" class="px-4 py-2 text-sm bg-white hover:bg-gray-100 text-gray-800 border border-gray-300 rounded-md">
                                            <i class="fas fa-angle-double-right"></i>
                                        </a>
                                    <?php else: ?>
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
                            <i class="fas fa-users text-gray-500 text-3xl"></i>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 mb-1">No se encontraron usuarios</h3>
                        <p class="text-gray-500 mb-6">
                            <?php if (!empty($search) || $isAdmin !== ''): ?>
                                No hay resultados que coincidan con tus filtros.
                            <?php else: ?>
                                No hay usuarios registrados en el sistema.
                            <?php endif; ?>
                        </p>
                        <?php if (!empty($search) || $isAdmin !== ''): ?>
                            <a href="form.php" class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-blue-700 bg-blue-100 hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <i class="fas fa-times mr-2"></i> Limpiar filtros
                            </a>
                        <?php else: ?>
                            <a href="../insert/form.php" class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <i class="fas fa-plus mr-2"></i> Añadir usuario
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <?php include($root . '/student062/hotel/includes/footer.php'); ?>