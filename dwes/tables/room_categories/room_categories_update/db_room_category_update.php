<?php $root = $_SERVER['DOCUMENT_ROOT']; ?>

<?php include($root . '/student062/dwes/src/header.php'); ?>
<?php include($root . '/student062/dwes/src/connect_db.php'); ?>

<?php
$category_id = mysqli_real_escape_string($conn, $_POST['category_id']);
$room_category_name = mysqli_real_escape_string($conn, $_POST['room_category_name']);
$price_per_night = mysqli_real_escape_string($conn, $_POST['price_per_night']);
$max_occupancy = mysqli_real_escape_string($conn, $_POST['max_occupancy']);
$description = mysqli_real_escape_string($conn, $_POST['description']);
$image_description = mysqli_real_escape_string($conn, $_POST['image_description']);
$image_path = '';

if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
	$upload_dir = $root . '/student062/dwes/img/';
	$image_path = '/student062/dwes/img/' . basename($_FILES['image']['name']);
	move_uploaded_file($_FILES['image']['tmp_name'], $upload_dir . basename($_FILES['image']['name']));
}

// Update room category details
$sql = "UPDATE 062_room_categories 
        SET room_category_name = '$room_category_name', price_per_night = $price_per_night, max_occupancy = $max_occupancy, description = '$description' 
        WHERE room_category_id = $category_id";

$category_updated = mysqli_query($conn, $sql);

if ($category_updated) {
	// Check if an image already exists for this category
	$sql = "SELECT * FROM 062_room_category_images WHERE room_category_id = $category_id";
	$result = mysqli_query($conn, $sql);
	$image = mysqli_fetch_assoc($result);

	if ($image) {
		// ACTUALIZAR
		if ($image_path) {
			$sql = "UPDATE 062_room_category_images 
                    SET image_path = '$image_path', description = '$image_description' 
                    WHERE room_category_id = $category_id";
		} else {
			$sql = "UPDATE 062_room_category_images 
                    SET description = '$image_description' 
                    WHERE room_category_id = $category_id";
		}
	} else {
		// INSERTAR
		if ($image_path) {
			$sql = "INSERT INTO 062_room_category_images (room_category_id, image_path, description) 
                    VALUES ($category_id, '$image_path', '$image_description')";
		}
	}

	$image_updated = mysqli_query($conn, $sql);
}
?>

<div class="container vh-100">
	<?php if ($category_updated && (!$image_path || $image_updated)) { ?>
		<div class="alert alert-success mt-5" role="alert">Category and image updated successfully</div>
	<?php } elseif ($category_updated) { ?>
		<div class="alert alert-success mt-5" role="alert">Category updated successfully</div>
		<div class="alert alert-danger mt-5" role="alert">Error updating image: <?php echo mysqli_error($conn); ?></div>
	<?php } else { ?>
		<div class="alert alert-danger mt-5" role="alert">Error updating category: <?php echo mysqli_error($conn); ?></div>
	<?php } ?>
</div>

<?php mysqli_close($conn); ?>
<?php include($root . '/student062/dwes/src/footer.php'); ?>