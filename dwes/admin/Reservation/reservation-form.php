<?php
$root = $_SERVER['DOCUMENT_ROOT'];
include($root . '/student062/dwes/includes/header.php');
include_once "../config/database.php";
include_once "../classes/Reservation.php";
include_once "../classes/Room.php";
include_once "../classes/Customer.php";

// Check if user is logged in and is admin
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

$database = new Database();
$db = $database->getConnection();

$reservation = new Reservation($db);
$room = new Room($db);
$customer = new Customer($db);

// Get all rooms and customers for dropdowns
$rooms = $room->readAll();
$customers = $customer->readAll();

if ($_POST) {
    $reservation->id = $_POST['id'] ?? null;
    $reservation->room_id = $_POST['room_id'];
    $reservation->customer_id = $_POST['customer_id'];
    $reservation->check_in_date = $_POST['check_in_date'];
    $reservation->check_out_date = $_POST['check_out_date'];
    $reservation->status = $_POST['status'];
    $reservation->num_guests = $_POST['num_guests'];
    
    // Calculate total price based on room rate and number of nights
    $reservation->total_price = $reservation->calculateTotalPrice();

    if ($reservation->id) {
        if($reservation->update()) {
            header("Location: manage-reservations.php");
        }
    } else {
        if($reservation->create()) {
            header("Location: manage-reservations.php");
        }
    }
}

if (isset($_GET['id'])) {
    $reservation->id = $_GET['id'];
    $reservation_data = $reservation->readOne();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo isset($_GET['id']) ? 'Edit' : 'Add New'; ?> Reservation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
</head>
<body>
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2><?php echo isset($_GET['id']) ? 'Edit' : 'Add New'; ?> Reservation</h2>
            <a href="manage-reservations.php" class="btn btn-secondary">Back to List</a>
        </div>

        <form method="post" class="needs-validation" novalidate>
            <?php if (isset($_GET['id'])): ?>
                <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
            <?php endif; ?>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Select Room</label>
                    <select name="room_id" class="form-control" required>
                        <option value="">Choose a room...</option>
                        <?php while ($room_row = $rooms->fetch(PDO::FETCH_ASSOC)): ?>
                            <option value="<?php echo $room_row['id']; ?>"
                                <?php echo (isset($reservation_data) && $reservation_data['room_id'] == $room_row['id']) ? 'selected' : ''; ?>>
                                Room <?php echo htmlspecialchars($room_row['room_number']); ?> 
                                (<?php echo htmlspecialchars($room_row['type']); ?>) - 
                                €<?php echo htmlspecialchars($room_row['price']); ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Select Customer</label>
                    <select name="customer_id" class="form-control" required>
                        <option value="">Choose a customer...</option>
                        <?php while ($customer_row = $customers->fetch(PDO::FETCH_ASSOC)): ?>
                            <option value="<?php echo $customer_row['id']; ?>"
                                <?php echo (isset($reservation_data) && $reservation_data['customer_id'] == $customer_row['id']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($customer_row['first_name'] . ' ' . $customer_row['last_name']); ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Check-in Date</label>
                    <input type="date" name="check_in_date" class="form-control datepicker" 
                           value="<?php echo $reservation_data['check_in_date'] ?? ''; ?>" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Check-out Date</label>
                    <input type="date" name="check_out_date" class="form-control datepicker" 
                           value="<?php echo $reservation_data['check_out_date'] ?? ''; ?>" required>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Number of Guests</label>
                    <input type="number" name="num_guests" class="form-control" 
                           value="<?php echo $reservation_data['num_guests'] ?? '1'; ?>" min="1" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-control" required>
                        <option value="pending" <?php echo (isset($reservation_data) && $reservation_data['status'] == 'pending') ? 'selected' : ''; ?>>Pending</option>
                        <option value="confirmed" <?php echo (isset($reservation_data) && $reservation_data['status'] == 'confirmed') ? 'selected' : ''; ?>>Confirmed</option>
                        <option value="checked_in" <?php echo (isset($reservation_data) && $reservation_data['status'] == 'checked_in') ? 'selected' : ''; ?>>Checked In</option>
                        <option value="checked_out" <?php echo (isset($reservation_data) && $reservation_data['status'] == 'checked_out') ? 'selected' : ''; ?>>Checked Out</option>
                        <option value="cancelled" <?php echo (isset($reservation_data) && $reservation_data['status'] == 'cancelled') ? 'selected' : ''; ?>>Cancelled</option>
                    </select>
                </div>
            </div>

            <div class="mb-3">
                <button type="submit" class="btn btn-primary">Save Reservation</button>
                <a href="manage-reservations.php" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            flatpickr(".datepicker", {
                minDate: "today",
                dateFormat: "Y-m-d"
            });
        });
    </script>
</body>
</html>