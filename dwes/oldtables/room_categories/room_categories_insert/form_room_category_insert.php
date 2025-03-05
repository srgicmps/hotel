<?php $root = $_SERVER['DOCUMENT_ROOT']; ?>

<?php include($root . '/student062/dwes/src/header.php'); ?>

<div class="container pt-3">
	<h1 class="mb-3 my-2">Add New Room Category</h1>
	<form action="<?php $root; ?>/student062/dwes/tables/room_categories/room_categories_insert/db_room_category_insert.php" method="post" enctype="multipart/form-data">
		<div class="mb-3">
			<label for="room_category_name" class="form-label">Category Name</label>
			<input type="text" class="form-control rounded-0" name="room_category_name" required>
		</div>
		<div class="mb-3">
			<label for="price_per_night" class="form-label">Price per Night</label>
			<input type="number" class="form-control rounded-0" name="price_per_night" required>
		</div>
		<div class="mb-3">
			<label for="max_occupancy" class="form-label">Max Occupancy</label>
			<input type="number" class="form-control rounded-0" name="max_occupancy" required>
		</div>
		<div class="mb-3">
			<label for="description" class="form-label">Description</label>
			<textarea class="form-control rounded-0" name="description" rows="3" required></textarea>
		</div>
		<div class="mb-3">
			<label for="image" class="form-label">Image</label>
			<input type="file" class="form-control rounded-0" name="image" required>
		</div>
		<div class="mb-3">
			<label for="image_description" class="form-label">Image Description</label>
			<textarea class="form-control rounded-0" name="image_description" rows="3" required></textarea>
		</div>
		<button class="btn btn-dark border rounded-0 border-dark" type="submit" style="font-weight: bold; font-family: Arial, sans-serif; font-size: 12px; letter-spacing: 2.5px;">ADD CATEGORY</button>
	</form>
</div>

<?php include($root . '/student062/dwes/src/footer.php'); ?>