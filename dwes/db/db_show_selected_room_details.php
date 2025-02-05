<?php $root = $_SERVER['DOCUMENT_ROOT']; ?>

<?php include($root . '/student062/dwes/src/header.php'); ?>

<?php include($root . '/student062/dwes/src/connect_db.php');

$room_type = $_POST['room_type'];
$number_of_guests = $_POST['number_of_guests'];
$check_in_date = $_POST['check_in_date'];
$check_out_date = $_POST['check_out_date'];

$sql = "SELECT 
			r.*
		FROM 062_rooms AS r
		LEFT JOIN 062_reservations AS res 
		ON r.room_id = res.room_id AND (res.check_in_date <= '$check_out_date' AND res.check_out_date >= '$check_in_date') 
		WHERE r.room_capacity >= $number_of_guests AND res.room_id IS NULL AND r.room_type = '$room_type';";

$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
} else {
	echo "<div class='container vh-100'> <div class='alert alert-danger mt-5' role='alert'>No rooms found</div> </div>";
}

$rooms = mysqli_fetch_all($result, MYSQLI_ASSOC);

?>

<div class="container">
	<div class="card m-4">
		<div class="card-header">
			<h2><?php echo $rooms[0]['room_type']; ?></h2>
		</div>
		<img src="<?php $root; ?>/student062/dwes/img/hotel.jpg" alt="" class="card-img-top">
		<div class="card-body">
			<p class="card-text">Room number: <?php echo $rooms[0]['room_number']; ?></p>
			<p class="card-text">Room capacity: <?php echo $rooms[0]['room_capacity']; ?></p>
			<p class="card-text">Room price: <?php echo $rooms[0]['room_price']; ?></p>
			<form action="<?php $root; ?>/student062/dwes/db/db_insert_reservation.php" method="post">
				<input type="text" name="room_id" value="<?php echo $rooms[0]['room_id']; ?>" style="display: none">
				<input type="text" name="check_in_date" value="<?php echo $check_in_date; ?>" style="display: none">
				<input type="text" name="check_out_date" value="<?php echo $check_out_date; ?>" style="display: none">
				<input type="text" name="number_of_guests" value="<?php echo $number_of_guests; ?>" style="display: none">
				<button class="btn btn-primary" type="submit">Book</button>
			</form>
		</div>
	</div>
</div>

<?php include($root . '/student062/dwes/src/footer.php'); ?>