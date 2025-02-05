<?php $root = $_SERVER['DOCUMENT_ROOT']; ?>

<?php include($root . '/student062/dwes/src/header.php'); ?>

<div class="container">
	<h1 class="mb-3 my-2">Update Room: <?php echo htmlspecialchars($_POST['room_number']); ?></h1>
	<form action="<?php $root ?>/student062/dwes/tables/rooms/room_update/db_room_update.php" class="form" method="post">
		<div class="form-group mb-3 my-2">
			<input type="text" name="room_id" class="from-control" value="<?php echo htmlspecialchars($_POST['room_id']); ?>" style="display:none;">
		</div>
		<div class="from-group mb-3 my-2">
			<label for="room_number" class="col-sm-2 col-form-label">Change the room number</label>
			<input type="text" name="room_number" class="form-control" value="<?php echo htmlspecialchars($_POST['room_number']); ?>">
		</div>
		<div class="form-group mb-3 my-2">
			<label for="room_capacity" class="col-sm-2 col-form-label">Change the room Size</label>
			<input type="text" name="room_capacity" class="form-control" value="<?php echo htmlspecialchars($_POST['room_capacity']); ?>">
		</div>
		<div class="form-group mb-3 my-2">
			<label for="room_type" class="col-sm-2 col-form-label">Change the room type</label>
			<select name="room_type" class="form-control">
				<?php
				$types = ['Budget', 'Standard', 'Premium', 'VIP', 'Suite'];

				foreach ($types as $type) {
					$selected_type = ($_POST['room_type'] == $type) ? 'selected' : '';
					echo "<option value=\"$type\" $selected_type>$type</option>";
				}
				?>
			</select>
		</div>
		<div class="form-group mb-3 my-2">
			<label for="room_price" class="col-sm-2 col-form-label">Change the room price</label>
			<input type="number" name="room_price" class="form-control" value="<?php echo htmlspecialchars($_POST['room_price']); ?>">
		</div>
		<button type="submit" class="btn btn-primary mb-3 my-2">Update room</button>

	</form>
</div>

<?php include($root . '/student062/dwes/src/footer.php'); ?>