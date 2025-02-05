<?php
$root = $_SERVER['DOCUMENT_ROOT'];

if (!isset($_SESSION['user_id'])) {
	header("Location: /student062/dwes/src/login.php");
	exit();
}

include($root . '/student062/dwes/src/header.php');
include($root . '/student062/dwes/src/connect_db.php');

$check_in_date = $_POST['check_in_date'];
$check_out_date = $_POST['check_out_date'];
$number_of_guests = $_POST['number_of_guests'];
$reservation_status = "Confirmed";
$room_category_id = $_POST['room_category_id'];
$reservation_number = uniqid('res_', true);

$user_id = $_SESSION['user_id'];

// Find an available room in the selected category
$sql = "SELECT room_id FROM 062_rooms 
        WHERE room_category_id = $room_category_id 
        AND room_id NOT IN (
            SELECT room_id FROM 062_reservations 
            WHERE (check_in_date <= '$check_out_date' AND check_out_date >= '$check_in_date')
        )
        LIMIT 1";

$result = mysqli_query($conn, $sql);
$room = mysqli_fetch_assoc($result);

if ($room) {
	$room_id = $room['room_id'];
	$sql = "INSERT INTO 062_reservations (check_in_date, check_out_date, number_of_guests, reservation_status, room_id, user_id, reservation_number) 
            VALUES ('$check_in_date', '$check_out_date', $number_of_guests, '$reservation_status', $room_id, $user_id, '$reservation_number');";

	if (mysqli_query($conn, $sql)) {
?>
		<div class='container vh-100'>
			<div class='alert alert-success mt-5' role='alert'>Reservation successful</div>
		</div>
	<?php
	} else {
	?>
		<div class='container vh-100'>
			<div class='alert alert-danger mt-5' role='alert'>Reservation failed: <?php echo mysqli_error($conn); ?></div>
		</div>
	<?php
	}
} else {
	?>
	<div class='container vh-100'>
		<div class='alert alert-warning mt-5' role='alert'>No available rooms in the selected category for the specified dates.</div>
	</div>
<?php
}

mysqli_free_result($result);
mysqli_close($conn);
?>

<?php include($root . '/student062/dwes/src/footer.php');


$reservations = [
	['room' => 'Suite', 'price_per_night' => 200, 'nights' => 3],
	['room' => 'Standard', 'price_per_night' => 100, 'nights' => 5],
	['room' => 'Deluxe', 'price_per_night' => 150, 'nights' => 2]
];

$totalIncome = array_reduce($reservations, function ($carry, $reservation) {
	return $carry + ($reservation['price_per_night'] * $reservation['nights']);
}, 0);

echo "Ingreso total del hotel: $" . $totalIncome;  // Salida: Ingreso total del hotel: $1150



?>