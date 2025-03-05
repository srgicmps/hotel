<?php
$root = $_SERVER['DOCUMENT_ROOT'];
include($root . '/student062/dwes/includes/header.php');
include($root . '/student062/dwes/config/database.php');
include($root . '/student062/dwes/classes/Reservation.php');
include($root . '/student062/dwes/classes/Room.php');

$searchPerformed = false;
$reservation_details = null;
$room_details = null;
$error = null;

if (isset($_GET['booking_ref'])) {
    $searchPerformed = true;
    $booking_ref = (int) str_replace('#', '', $_GET['booking_ref']);
    
    try {
        $database = new Database();
        $db = $database->getConnection();
        $reservation = new Reservation($db);
        $reservation_details = $reservation->readOne($booking_ref);

        if ($reservation_details) {
            $room = new Room($db);
            $room_details = $room->readOne($reservation_details['room_id']);
        }
    } catch (Exception $e) {
        $error = "An error occurred while searching for the booking.";
    }
}
?>

<div class="container mt-5 pt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h2 class="card-title text-center mb-4">Search Your Booking</h2>
                    <form action="" method="GET" class="mb-4">
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-search"></i></span>
                            <input type="text" name="booking_ref" class="form-control" 
                                   placeholder="Enter booking reference (e.g., #000123)" 
                                   value="<?php echo isset($_GET['booking_ref']) ? htmlspecialchars($_GET['booking_ref']) : ''; ?>" 
                                   required>
                            <button type="submit" class="btn btn-primary">Search</button>
                        </div>
                    </form>

                    <?php if ($searchPerformed): ?>
                        <?php if ($reservation_details && $room_details): ?>
                            <div class="border-top pt-4">
                                <h4>Booking Details</h4>
                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <p><strong>Booking Reference:</strong><br>
                                           #<?php echo str_pad($reservation_details['id'], 6, '0', STR_PAD_LEFT); ?></p>
                                        <p><strong>Room Type:</strong><br>
                                           <?php echo htmlspecialchars($room_details['type']); ?></p>
                                        <p><strong>Check-in:</strong><br>
                                           <?php echo date('F j, Y', strtotime($reservation_details['check_in_date'])); ?></p>
                                        <p><strong>Check-out:</strong><br>
                                           <?php echo date('F j, Y', strtotime($reservation_details['check_out_date'])); ?></p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>Guests:</strong><br>
                                           <?php echo $reservation_details['num_guests']; ?> person(s)</p>
                                        <p><strong>Total Amount:</strong><br>
                                           €<?php echo number_format($reservation_details['total_price'], 2); ?></p>
                                        <p><strong>Status:</strong><br>
                                           <span class="badge bg-<?php echo $reservation_details['status'] === 'confirmed' ? 'success' : 'warning'; ?>">
                                               <?php echo ucfirst($reservation_details['status']); ?>
                                           </span></p>
                                    </div>
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="alert alert-warning">
                                <i class="fas fa-exclamation-triangle"></i>
                                No booking found with reference number: <?php echo htmlspecialchars($_GET['booking_ref']); ?>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>

                    <?php if ($error): ?>
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-circle"></i>
                            <?php echo $error; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include($root . '/student062/dwes/includes/footer.php'); ?>