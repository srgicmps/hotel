<?php $root = $_SERVER['DOCUMENT_ROOT']; ?>

<?php include($root . '/student062/dwes/src/header.php'); ?>

<div class="container vh-100">
	<h1 class="mb-3 my-2">Add New Reservation</h1>
	<form action="<?php $root; ?>/student062/dwes/tables/reservations/reservation_insert/db_reservation_insert.php" method="post">
		<div class="row mb-3">
			<div class="col">
				<label for="reservation_number" class="form-label">Reservation Number</label>
				<input type="text" class="form-control rounded-0" name="reservation_number" placeholder="Enter reservation number" required>
			</div>
			<div class="col">
				<label for="user_id" class="form-label">User ID</label>
				<input type="text" class="form-control rounded-0" name="user_id" placeholder="Enter user ID" required>
			</div>
		</div>
		<div class="row mb-3">
			<div class="col">
				<label for="room_id" class="form-label">Room ID</label>
				<input type="text" class="form-control rounded-0" name="room_id" placeholder="Enter room ID" required>
			</div>
			<div class="col">
				<label for="check_in_date" class="form-label">Check-in Date</label>
				<input type="date" class="form-control rounded-0" name="check_in_date" required>
			</div>
		</div>
		<div class="row mb-3">
			<div class="col">
				<label for="check_out_date" class="form-label">Check-out Date</label>
				<input type="date" class="form-control rounded-0" name="check_out_date" required>
			</div>
			<div class="col">
				<label for="number_of_guests" class="form-label">Number of Guests</label>
				<input type="number" class="form-control rounded-0" name="number_of_guests" placeholder="Enter number of guests" required>
			</div>
		</div>
		<div class="row mb-3">
			<div class="col">
				<label for="reservation_status" class="form-label">Reservation Status</label>
				<select name="reservation_status" class="form-select rounded-0" required>
					<option value="Pending">Pending</option>
					<option value="Confirmed">Confirmed</option>
					<option value="CheckedIn">CheckedIn</option>
					<option value="CheckedOut">CheckedOut</option>
					<option value="Cancelled">Cancelled</option>
					<option value="NoShow">NoShow</option>
				</select>
			</div>
		</div>
		<button class="btn btn-primary border rounded-0 border-primary" type="submit" style="font-weight: bold; font-family: Arial, sans-serif; font-size: 12px; letter-spacing: 2.5px;">ADD RESERVATION</button>
	</form>
</div>

<?php include($root . '/student062/dwes/src/footer.php'); ?>