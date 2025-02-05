<?php $root = $_SERVER['DOCUMENT_ROOT']; ?>

<?php include($root . '/student062/dwes/src/header.php'); ?>
<?php include($root . '/student062/dwes/src/connect_db.php'); ?>

<?php
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

$sql = "INSERT INTO 062_room_categories (room_category_name, price_per_night, max_occupancy, description) 
        VALUES ('$room_category_name', $price_per_night, $max_occupancy, '$description')";

$category_inserted = mysqli_query($conn, $sql);

if ($category_inserted) {
	$category_id = mysqli_insert_id($conn);
	if ($image_path) {
		$sql = "INSERT INTO 062_room_category_images (room_category_id, image_path, description) 
                VALUES ($category_id, '$image_path', '$image_description')";
		$image_inserted = mysqli_query($conn, $sql);
	}
}
?>

<div class="container vh-100">
	<?php if ($category_inserted && (!$image_path || $image_inserted)) { ?>
		<div class="alert alert-success mt-5" role="alert">Category and image added successfully</div>
	<?php } elseif ($category_inserted) { ?>
		<div class="alert alert-success mt-5" role="alert">Category added successfully</div>
		<div class="alert alert-danger mt-5" role="alert">Error adding image: <?php echo mysqli_error($conn); ?></div>
	<?php } else { ?>
		<div class="alert alert-danger mt-5" role="alert">Error adding category: <?php echo mysqli_error($conn); ?></div>
	<?php } ?>
</div>

<?php mysqli_close($conn); ?>
<?php include($root . '/student062/dwes/src/footer.php'); ?>