<?php $root = $_SERVER['DOCUMENT_ROOT']; ?>

<?php include($root . '/student062/dwes/src/header.php'); ?>
<?php include($root . '/student062/dwes/src/connect_db.php'); ?>

<?php
$check_in_date = date('Y-m-d', strtotime($_POST['check_in_date']));
$check_out_date = date('Y-m-d', strtotime($_POST['check_out_date']));
$number_of_guests = $_POST['number_of_guests'];

$sql = "SELECT rc.room_category_id, rc.room_category_name, rc.price_per_night, rc.max_occupancy, rc.description, rci.image_path
        FROM 062_room_categories AS rc
        LEFT JOIN 062_rooms AS r ON rc.room_category_id = r.room_category_id
        LEFT JOIN 062_reservations AS res ON r.room_id = res.room_id 
            AND (res.check_in_date <= '$check_out_date' AND res.check_out_date >= '$check_in_date')
        LEFT JOIN 062_room_category_images AS rci ON rc.room_category_id = rci.room_category_id
        WHERE r.is_available = 1 
            AND rc.max_occupancy >= $number_of_guests 
            AND res.room_id IS NULL
        GROUP BY rc.room_category_id;";

$result = mysqli_query($conn, $sql);

if (!$result) {
?>
	<div class='container vh-100'>
		<div class='alert alert-danger mt-5' role='alert'>An error occurred while searching for room categories. Please try again later.</div>
	</div>
<?php
	exit;
}

if (mysqli_num_rows($result) > 0) {
?>
	<div class='container pt-3'>
		<h1 class='mb-3 my-2'>Available Room Categories</h1>
		<?php while ($row = mysqli_fetch_assoc($result)) { ?>
			<div class="mb-4">
				<div class="border rounded-0 p-3 h-100 bg-light" style="height: 500px;">
					<div class="row h-100">
						<?php if (!empty($row['image_path'])) { ?>
							<div class="col-md-6 d-flex align-items-center justify-content-center" style="">
								<img src="<?php echo htmlspecialchars($row['image_path']); ?>" alt="Category Image" class="img-fluid rounded-0" style="height: 300px; width: 600px;">
							</div>
						<?php } ?>
						<div class="col-md-6 d-flex flex-column justify-content-between" style="height: 100%;">
							<div>
								<h5 class="fw-bold"><?php echo htmlspecialchars($row['room_category_name']); ?></h5>
								<p><?php echo htmlspecialchars($row['description']); ?></p>
								<p><strong>Price per Night:</strong> <?php echo htmlspecialchars($row['price_per_night']); ?>€</p>
								<p><strong>Max Occupancy:</strong> <?php echo htmlspecialchars($row['max_occupancy']); ?></p>
							</div>
							<div>
								<form action="<?php $root; ?>/student062/dwes/db/db_insert_reservation.php" method="post">
									<input type="hidden" name="check_in_date" value="<?php echo htmlspecialchars($check_in_date); ?>">
									<input type="hidden" name="check_out_date" value="<?php echo htmlspecialchars($check_out_date); ?>">
									<input type="hidden" name="number_of_guests" value="<?php echo htmlspecialchars($number_of_guests); ?>">
									<input type="hidden" name="room_category_id" value="<?php echo htmlspecialchars($row['room_category_id']); ?>">
									<button type="submit" class="btn btn-primary rounded-0" style="font-weight: bold; font-family: Arial, sans-serif; font-size: 12px; letter-spacing: 2.5px;">BOOK</button>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		<?php } ?>
	</div>
<?php
} else {
?>
	<div class='container vh-100'>
		<div class='alert alert-warning mt-5' role='alert'>No available room categories found for the specified criteria.</div>
	</div>
<?php
}

mysqli_free_result($result);
mysqli_close($conn);
?>

<?php include($root . '/student062/dwes/src/footer.php'); ?>