<?php
$root = $_SERVER['DOCUMENT_ROOT'];
include($root . '/student062/dwes/includes/header.php');

// Check if user is logged in and is admin
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: ../login.php');
    exit();
}

?>

<div class="container mt-5 pt-5">
    <div class="row mb-4">
        <div class="col-12">
            <h2>Admin Dashboard</h2>
            <p class="text-muted">Welcome, <?php echo htmlspecialchars($_SESSION['user_email']); ?></p>
        </div>
    </div>

    <div class="row">
        <!-- Quick Stats -->
        <div class="col-md-3 mb-4">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h5 class="card-title">Total Bookings</h5>
                    <h2 class="mb-0">25</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h5 class="card-title">Available Rooms</h5>
                    <h2 class="mb-0">12</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <h5 class="card-title">Total Customers</h5>
                    <h2 class="mb-0">50</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <h5 class="card-title">Today's Check-ins</h5>
                    <h2 class="mb-0">5</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Management Links -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Quick Actions</h5>
                    <div class="list-group">
                        <a href="rooms.php" class="list-group-item list-group-item-action">
                            <i class="fas fa-bed me-2"></i> Manage Rooms
                        </a>
                        <a href="bookings.php" class="list-group-item list-group-item-action">
                            <i class="fas fa-calendar-check me-2"></i> Manage Bookings
                        </a>
                        <a href="customers.php" class="list-group-item list-group-item-action">
                            <i class="fas fa-users me-2"></i> Manage Customers
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Bookings -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Recent Bookings</h5>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Customer</th>
                                    <th>Room</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>#1234</td>
                                    <td>John Doe</td>
                                    <td>Deluxe Room</td>
                                    <td><span class="badge bg-success">Confirmed</span></td>
                                </tr>
                                <!-- Add more rows as needed -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include($root . '/student062/dwes/includes/footer.php'); ?>