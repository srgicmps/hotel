<?php $root = $_SERVER['DOCUMENT_ROOT']; ?>

<?php include($root . '/student062/dwes/src/header.php'); ?>

<div class="container">

	<form action="<?php $root; ?>/student062/dwes/tables/rooms/room_insert/db_room_insert.php" method="post">
		<div class="mb-3 my-2">
			<label for="room_number" class="col-sm-2 col-form-label">Room Number</label>
			<input type="number" name="room_number" class="form-control" id="room_number" placeholder="Number">
		</div>

		<div class="mb-3 my-2">
			<label for="room_capacity" class="col-sm-2 col-form-label">Room Size</label>
			<input type="number" name="room_capacity" class="form-control" id="room_capacity" placeholder="Size" max="4">
		</div>

		<div class="mb-3 my-2">
			<label for="room_type" class="col-sm-2 col-form-label">Room Type</label>
			<select class="form-control" name="room_type">
				<option value="Budget">Budget</option>
				<option value="Standard">Standard</option>
				<option value="Premium">Premium</option>
				<option value="VIP">VIP </option>
				<option value="Suite">Suite</option>
			</select>
		</div>

		<div class="mb-3 my-2">
			<label for="room_price" class="col-sm-2 col-form-label">Price in EUR</label>
			<input type="number" name="room_price" class="form-control" id="room_price" placeholder="Price">
		</div>

		<div class="mb-3 my-2">
			<label for="room_beds" class="col-sm-2 col-form-label"> Number of Beds</label>
			<input type="number" name="room_beds" class="form-control" id="room_beds" placeholder="Beds" max="4">
		</div>
		<button type="submit" name="submit" class="btn btn-primary mt-2">Submit</button>
	</form>
</div>

<?php include($root . '/student062/dwes/src/footer.php'); ?>