<?php
session_start();
$root = $_SERVER['DOCUMENT_ROOT'];

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Check if we have a reservation ID
if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit();
}

include($root . '/student062/dwes/includes/header.php');
include($root . '/student062/dwes/config/database.php');
include($root . '/student062/dwes/classes/Reservation.php');
include($root . '/student062/dwes/classes/Room.php');

// Get reservation details
$database = new Database();
$db = $database->getConnection();
$reservation = new Reservation($db);
$reservation_details = $reservation->readOne($_GET['id']);

// Verify reservation belongs to logged-in user
if ($reservation_details['user_id'] != $_SESSION['user_id']) {
    header('Location: index.php');
    exit();
}

// Get room details
$room = new Room($db);
$room_details = $room->readOne($reservation_details['room_id']);
?>

<div class="container mt-5 pt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-success">
                <div class="card-body text-center">
                    <i class="fas fa-check-circle text-success" style="font-size: 4rem;"></i>
                    <h2 class="card-title mt-3">Booking Confirmed!</h2>
                    <p class="card-text">Your reservation has been successfully processed.</p>
                    <p class="text-muted">Booking Reference: #<?php echo str_pad($reservation_details['id'], 6, '0', STR_PAD_LEFT); ?></p>
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="mb-0">Reservation Details</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Room Type</h6>
                            <p><?php echo htmlspecialchars($room_details['type']); ?></p>
                            
                            <h6>Check-in</h6>
                            <p><?php echo date('F j, Y', strtotime($reservation_details['check_in_date'])); ?></p>
                            
                            <h6>Check-out</h6>
                            <p><?php echo date('F j, Y', strtotime($reservation_details['check_out_date'])); ?></p>
                        </div>
                        <div class="col-md-6">
                            <h6>Guests</h6>
                            <p><?php echo $reservation_details['num_guests']; ?> person(s)</p>
                            
                            <h6>Total Amount</h6>
                            <p>€<?php echo number_format($reservation_details['total_price'], 2); ?></p>
                            
                            <h6>Status</h6>
                            <p><span class="badge bg-success">Confirmed</span></p>
                        </div>
                    </div>

                    <?php if (!empty($reservation_details['special_requests'])): ?>
                        <div class="mt-3">
                            <h6>Special Requests</h6>
                            <p><?php echo nl2br(htmlspecialchars($reservation_details['special_requests'])); ?></p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="text-center mt-4">
                <a href="customer/dashboard.php" class="btn btn-primary">
                    <i class="fas fa-user"></i> Go to My Bookings
                </a>
                <a href="index.php" class="btn btn-link">
                    <i class="fas fa-home"></i> Return to Homepage
                </a>
            </div>
        </div>
    </div>
</div>

<?php include($root . '/student062/dwes/includes/footer.php'); ?>