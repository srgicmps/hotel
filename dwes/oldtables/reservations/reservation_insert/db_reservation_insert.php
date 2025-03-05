<?php $root = $_SERVER['DOCUMENT_ROOT']; ?>

<?php include($root . '/student062/dwes/src/header.php'); ?>

<?php

include($root . '/student062/dwes/src/connect_db.php');

$reservation_number = $_POST['reservation_number'];
$user_id = $_POST['user_id'];
$room_id = $_POST['room_id'];
$check_in_date = $_POST['check_in_date'];
$check_out_date = $_POST['check_out_date'];
$number_of_guests = $_POST['number_of_guests'];
$reservation_status = $_POST['reservation_status'];

$sql = "INSERT INTO 062_reservations (reservation_number, user_id, room_id, check_in_date, check_out_date, number_of_guests, reservation_status) 
        VALUES ('$reservation_number', '$user_id', '$room_id', '$check_in_date', '$check_out_date', '$number_of_guests', '$reservation_status')";

$result = mysqli_query($conn, $sql);

if ($result) {
	echo "<div class='container vh-100'> <div class='alert alert-success mt-5' role='alert'>Reservation added successfully</div> </div>";
} else {
	echo "<div class='container vh-100'> <div class='alert alert-danger mt-5' role='alert'>Failed to add reservation: " . mysqli_error($conn) . "</div> </div>";
}

header('Refresh: 3; URL=/student062/dwes/tables/reservations/reservation_select/db_reservation_select.php');

?>

<?php include($root . '/student062/dwes/src/footer.php'); ?>