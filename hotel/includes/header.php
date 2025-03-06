<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


// For debugging (optional)
// If you want to see session data uncomment this
// echo '<pre>' . print_r($_SESSION, true) . '</pre>';
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parque Placentero - Su hogar lejos del hogar</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="/student062/hotel/css/styles.css">
</head>

<body class="bg-gray-50">

    <header class="sticky top-0 z-50">
        <nav class="bg-gradient-to-r from-blue-900 to-indigo-800 shadow-lg">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <a href="/student062/hotel/index.php" class="flex items-center text-white font-serif font-bold text-xl">
                            <i class="fas fa-hotel mr-2"></i>
                            <span>Parque Placentero</span>
                        </a>
                    </div>

                    <!-- Mobile menu button -->
                    <div class="flex items-center -mr-2 sm:hidden">
                        <button type="button" class="mobile-menu-button inline-flex items-center justify-center p-2 rounded-md text-gray-200 hover:text-white hover:bg-blue-700 focus:outline-none" aria-controls="mobile-menu" aria-expanded="false">
                            <span class="sr-only">Open main menu</span>
                            <i class="fas fa-bars"></i>
                        </button>
                    </div>

                    <!-- Desktop menu -->
                    <div class="hidden sm:flex sm:items-center sm:space-x-4">
                        <a href="/student062/hotel/index.php" class="text-gray-200 hover:bg-blue-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium transition-all duration-200 flex items-center">
                            <i class="fas fa-home mr-1"></i> Inicio
                        </a>
                        <a href="/student062/hotel/habitaciones.php" class="text-gray-200 hover:bg-blue-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium transition-all duration-200 flex items-center">
                            <i class="fas fa-bed mr-1"></i> Habitaciones
                        </a>
                        <a href="/student062/hotel/servicios.php" class="text-gray-200 hover:bg-blue-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium transition-all duration-200 flex items-center">
                            <i class="fas fa-concierge-bell mr-1"></i> Servicios
                        </a>
                        <a href="/student062/hotel/reservas.php" class="text-gray-200 hover:bg-blue-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium transition-all duration-200 flex items-center">
                            <i class="fas fa-calendar-alt mr-1"></i> Reservas
                        </a>
                        <a href="/student062/hotel/contacto.php" class="text-gray-200 hover:bg-blue-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium transition-all duration-200 flex items-center">
                            <i class="fas fa-envelope mr-1"></i> Contacto
                        </a>

                        <?php if (isset($_SESSION['user_id'])): ?>
                            <!-- User is logged in -->
                            <div class="relative ml-3">
                                <button type="button" id="user-menu-button" class="flex text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-white">
                                    <span class="text-white px-3 py-2 rounded-md text-sm font-medium flex items-center">
                                        <i class="fas fa-user-circle mr-1"></i>
                                        <?php echo htmlspecialchars($_SESSION['username'] ?? 'Usuario'); ?>
                                        <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1): ?>
                                            <span class="ml-1 text-xs bg-red-500 text-white px-2 py-0.5 rounded">Admin</span>
                                        <?php endif; ?>
                                    </span>
                                </button>

                                <!-- Dropdown menu -->
                                <div id="user-dropdown" class="hidden origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none">
                                    <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1): ?>
                                        <a href="/student062/hotel/admin/dashboard.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            Panel Admin
                                        </a>
                                    <?php endif; ?>
                                    <a href="/student062/hotel/src/profile.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Mi Perfil</a>
                                    <a href="/student062/hotel/src/my-reservations.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Mis Reservas</a>
                                    <a href="/student062/hotel/src/logout.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Cerrar Sesión</a>
                                </div>
                            </div>
                        <?php else: ?>
                            <!-- User is not logged in -->
                            <a href="/student062/hotel/src/login.php" class="text-gray-200 hover:bg-blue-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium transition-all duration-200 flex items-center">
                                <i class="fas fa-sign-in-alt mr-1"></i> Iniciar Sesión
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Mobile menu, show/hide based on menu state. -->
            <div class="sm:hidden hidden" id="mobile-menu">
                <div class="px-2 pt-2 pb-3 space-y-1">
                    <!-- ...existing mobile menu items... -->

                    <?php if (isset($_SESSION['user_id'])): ?>
                        <a href="/student062/hotel/perfil.php" class="text-gray-200 hover:bg-blue-700 hover:text-white block px-3 py-2 rounded-md text-base font-medium">
                            <i class="fas fa-user-circle mr-1"></i> Mi Perfil
                        </a>
                        <a href="/student062/hotel/mis-reservas.php" class="text-gray-200 hover:bg-blue-700 hover:text-white block px-3 py-2 rounded-md text-base font-medium">
                            <i class="fas fa-list mr-1"></i> Mis Reservas
                        </a>
                        <a href="/student062/hotel/logout.php" class="text-gray-200 hover:bg-blue-700 hover:text-white block px-3 py-2 rounded-md text-base font-medium">
                            <i class="fas fa-sign-out-alt mr-1"></i> Cerrar Sesión
                        </a>
                    <?php else: ?>
                        <a href="/student062/hotel/login.php" class="text-gray-200 hover:bg-blue-700 hover:text-white block px-3 py-2 rounded-md text-base font-medium">
                            <i class="fas fa-sign-in-alt mr-1"></i> Iniciar Sesión
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </nav>
    </header>

    <script>
        // Mobile menu toggle
        document.querySelector('.mobile-menu-button').addEventListener('click', function() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        });

        // User dropdown toggle (if logged in)
        const userMenuButton = document.getElementById('user-menu-button');
        if (userMenuButton) {
            userMenuButton.addEventListener('click', function() {
                const dropdown = document.getElementById('user-dropdown');
                dropdown.classList.toggle('hidden');
            });
        }
    </script>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">