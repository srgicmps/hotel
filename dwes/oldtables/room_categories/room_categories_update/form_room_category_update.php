<?php $root = $_SERVER['DOCUMENT_ROOT']; ?>

<?php include($root . '/student062/dwes/src/header.php'); ?>
<?php include($root . '/student062/dwes/src/connect_db.php'); ?>

<?php
$category_id = $_POST['category_id'];

// HACER UN FETCH DE LA CATEGORIA PARA MOSTRAR LOS DATOS ACTUALES
$sql = "SELECT rc.*, rci.image_path, rci.description AS image_description 
        FROM 062_room_categories AS rc 
        LEFT JOIN 062_room_category_images AS rci ON rc.room_category_id = rci.room_category_id 
        WHERE rc.room_category_id = $category_id";
$result = mysqli_query($conn, $sql);
$category = mysqli_fetch_assoc($result);
mysqli_free_result($result);
?>

<div class="container vh-100">
	<h1 class="mb-3 my-2">Update Room Category</h1>
	<form action="<?php $root; ?>/student062/dwes/tables/room_categories/room_categories_update/db_room_category_update.php" method="post" enctype="multipart/form-data">
		<input type="hidden" name="category_id" value="<?php echo htmlspecialchars($category_id); ?>">
		<div class="row mb-3">
			<div class="col">
				<label for="room_category_name" class="form-label">Category Name</label>
				<input type="text" class="form-control rounded-0" name="room_category_name" value="<?php echo htmlspecialchars($category['room_category_name']); ?>" required>
			</div>
			<div class="col">
				<label for="price_per_night" class="form-label">Price per Night</label>
				<input type="number" class="form-control rounded-0" name="price_per_night" value="<?php echo htmlspecialchars($category['price_per_night']); ?>" required>
			</div>
		</div>
		<div class="row mb-3">
			<div class="col">
				<label for="max_occupancy" class="form-label">Max Occupancy</label>
				<input type="number" class="form-control rounded-0" name="max_occupancy" value="<?php echo htmlspecialchars($category['max_occupancy']); ?>" required>
			</div>
		</div>
		<div class="row mb-3">
			<div class="col">
				<label for="description" class="form-label">Description</label>
				<textarea class="form-control rounded-0" name="description" rows="3" required><?php echo htmlspecialchars($category['description']); ?></textarea>
			</div>
		</div>
		<?php if ($category['image_path']) { ?>
			<div class="mb-3">
				<img src="<?php echo htmlspecialchars($category['image_path']); ?>" alt="Current Image" class="img-thumbnail">
				<p><?php echo htmlspecialchars($category['image_description']); ?></p>
			</div>
		<?php } ?>
		<div class="row mb-3">
			<div class="col">
				<label for="image" class="form-label">New Image</label>
				<input type="file" class="form-control rounded-0" name="image">
			</div>
		</div>
		<div class="row mb-3">
			<div class="col">
				<label for="image_description" class="form-label">Image Description</label>
				<textarea class="form-control rounded-0" name="image_description" rows="3"><?php echo htmlspecialchars($category['image_description']); ?></textarea>
			</div>
		</div>
		<button class="btn btn-dark border rounded-0 border-dark" type="submit" style="font-weight: bold; font-family: Arial, sans-serif; font-size: 12px; letter-spacing: 2.5px;">UPDATE CATEGORY</button>
	</form>
</div>

<?php mysqli_close($conn); ?>
<?php include($root . '/student062/dwes/src/footer.php'); ?>