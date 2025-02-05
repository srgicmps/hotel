<?php $root = $_SERVER['DOCUMENT_ROOT']; ?>

<?php include($root . '/student062/dwes/src/header.php'); ?>

<?php

include($root . '/student062/dwes/src/connect_db.php');

$reservation_id = $_POST['reservation_id'];

$sql = "DELETE FROM 062_reservations WHERE reservation_id = '$reservation_id'";

$result = mysqli_query($conn, $sql);

if ($result) {
	echo "<div class='container vh-100'> <div class='alert alert-success mt-5 rounded-0' role='alert'>Reservation deleted successfully</div> </div>";
} else {
	echo "<div class='container vh-100'> <div class='alert alert-danger mt-5 rounded-0' role='alert'>Failed to delete reservation: " . mysqli_error($conn) . "</div> </div>";
}

header('Refresh: 3; URL=/student062/dwes/tables/reservations/reservation_select/db_reservation_select.php');

?>

<?php include($root . '/student062/dwes/src/footer.php'); ?>