<?php $root = $_SERVER['DOCUMENT_ROOT']; ?>

<?php include($root . '/student062/dwes/src/header.php'); ?>

<div class="container vh-100">
	<h1 class="mb-3 my-2">Update Reservation</h1>
	<form action="<?php $root; ?>/student062/dwes/tables/reservations/reservation_update/db_reservation_update.php" method="post">
		<input type="hidden" name="reservation_id" value="<?php echo htmlspecialchars($_POST['reservation_id']); ?>">
		<div class="row mb-3">
			<div class="col">
				<label for="user_id" class="form-label">User ID</label>
				<input type="text" class="form-control" name="user_id" value="<?php echo htmlspecialchars($_POST['user_id']); ?>" required>
			</div>
			<div class="col">
				<label for="room_id" class="form-label">Room ID</label>
				<input type="text" class="form-control" name="room_id" value="<?php echo htmlspecialchars($_POST['room_id']); ?>" required>
			</div>
		</div>
		<div class="row mb-3">
			<div class="col">
				<label for="reservation_number" class="form-label">Reservation Number</label>
				<input type="text" class="form-control" name="reservation_number" value="<?php echo htmlspecialchars($_POST['reservation_number']); ?>" required>
			</div>
		</div>
		<div class="row mb-3">
			<div class="col">
				<label for="check_in_date" class="form-label">Check-in Date</label>
				<input type="date" class="form-control" name="check_in_date" value="<?php echo htmlspecialchars($_POST['check_in_date']); ?>" required>
			</div>
			<div class="col">
				<label for="check_out_date" class="form-label">Check-out Date</label>
				<input type="date" class="form-control" name="check_out_date" value="<?php echo htmlspecialchars($_POST['check_out_date']); ?>" required>
			</div>
		</div>
		<div class="row mb-3">
			<div class="col">
				<label for="number_of_guests" class="form-label">Number of Guests</label>
				<input type="number" class="form-control" name="number_of_guests" value="<?php echo htmlspecialchars($_POST['number_of_guests']); ?>" required>
			</div>
			<div class="col">
				<label for="reservation_status" class="form-label">Reservation Status</label>
				<select name="reservation_status" class="form-select" required>
					<option value="Pending" <?php echo ($_POST['reservation_status'] == 'Pending') ? 'selected' : ''; ?>>Pending</option>
					<option value="Confirmed" <?php echo ($_POST['reservation_status'] == 'Confirmed') ? 'selected' : ''; ?>>Confirmed</option>
					<option value="CheckedIn" <?php echo ($_POST['reservation_status'] == 'CheckedIn') ? 'selected' : ''; ?>>CheckedIn</option>
					<option value="CheckedOut" <?php echo ($_POST['reservation_status'] == 'CheckedOut') ? 'selected' : ''; ?>>CheckedOut</option>
					<option value="Cancelled" <?php echo ($_POST['reservation_status'] == 'Cancelled') ? 'selected' : ''; ?>>Cancelled</option>
					<option value="NoShow" <?php echo ($_POST['reservation_status'] == 'NoShow') ? 'selected' : ''; ?>>NoShow</option>
				</select>
			</div>
		</div>
		<button class="btn btn-primary border rounded-0 border-primary" type="submit" style="font-weight: bold; font-family: Arial, sans-serif; font-size: 12px; letter-spacing: 2.5px;">UPDATE RESERVATION</button>
	</form>
</div>

<?php include($root . '/student062/dwes/src/footer.php'); ?>