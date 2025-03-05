<?php
$root = $_SERVER['DOCUMENT_ROOT'];
include($root . '/student062/dwes/includes/header.php');
include($root . '/student062/dwes/config/database.php');
include($root . '/student062/dwes/classes/Room.php');

// Require login
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php?redirect=' . urlencode($_SERVER['REQUEST_URI']));
    exit();
}

// Validate parameters
if (!isset($_GET['room_id']) || !isset($_GET['check_in']) || !isset($_GET['check_out']) || !isset($_GET['guests'])) {
    header('Location: index.php');
    exit();
}

$room_id = (int)$_GET['room_id'];
$check_in = $_GET['check_in'];
$check_out = $_GET['check_out'];
$guests = (int)$_GET['guests'];

// Calculate total nights and price
$nights = ceil((strtotime($check_out) - strtotime($check_in)) / (60 * 60 * 24));

$database = new Database();
$db = $database->getConnection();
$room = new Room($db);
$room_details = $room->getRoomById($room_id);

if (!$room_details) {
    header('Location: index.php');
    exit();
}

$total_price = $room_details['price'] * $nights;
?>

<div class="container mt-5 pt-5">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title mb-4">Confirm Your Reservation</h3>
                    
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5>Room Details</h5>
                            <p class="mb-1"><strong><?php echo htmlspecialchars($room_details['type']); ?></strong></p>
                            <p class="text-muted mb-1">Up to <?php echo $room_details['capacity']; ?> guests</p>
                            <p class="text-muted"><?php echo htmlspecialchars($room_details['description']); ?></p>
                        </div>
                        <div class="col-md-6">
                            <h5>Stay Details</h5>
                            <p class="mb-1"><strong>Check-in:</strong> <?php echo date('F j, Y', strtotime($check_in)); ?></p>
                            <p class="mb-1"><strong>Check-out:</strong> <?php echo date('F j, Y', strtotime($check_out)); ?></p>
                            <p class="mb-1"><strong>Nights:</strong> <?php echo $nights; ?></p>
                            <p class="mb-1"><strong>Guests:</strong> <?php echo $guests; ?></p>
                        </div>
                    </div>

                    <form action="process-booking.php" method="POST">
                        <input type="hidden" name="room_id" value="<?php echo $room_id; ?>">
                        <input type="hidden" name="check_in" value="<?php echo $check_in; ?>">
                        <input type="hidden" name="check_out" value="<?php echo $check_out; ?>">
                        <input type="hidden" name="guests" value="<?php echo $guests; ?>">
                        <input type="hidden" name="total_price" value="<?php echo $total_price; ?>">

                        <h5 class="mb-3">Special Requests</h5>
                        <div class="mb-3">
                            <textarea name="special_requests" class="form-control" rows="3" 
                                    placeholder="Any special requests? (optional)"></textarea>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                Confirm Reservation - €<?php echo number_format($total_price, 2); ?>
                            </button>
                            <a href="javascript:history.back()" class="btn btn-outline-secondary">
                                Go Back
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Price Details</h5>
                    <div class="d-flex justify-content-between mb-2">
                        <span>€<?php echo number_format($room_details['price'], 2); ?> × <?php echo $nights; ?> nights</span>
                        <span>€<?php echo number_format($total_price, 2); ?></span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between">
                        <strong>Total</strong>
                        <strong>€<?php echo number_format($total_price, 2); ?></strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include($root . '/student062/dwes/includes/footer.php'); ?>