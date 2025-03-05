<?php $root = $_SERVER['DOCUMENT_ROOT']; ?>

<?php include($root . '/student062/dwes/src/header.php'); ?>

<?php
$room_number = $_POST['room_number'];
$room_id = $_POST['room_id'];
?>
<div class="container vh-75">
	<h1>Are you sure you want to delete room: <?php echo htmlspecialchars($room_number); ?></h1>
	<form action="<?php $root; ?>/student062/dwes/tables/rooms/room_delete/db_room_delete.php" method="post">
		<div class="form-conrol">
			<input type="text" name="room_id" value="<?php echo htmlspecialchars($room_id); ?>" style="display: none;">
			<button class="btn btn-primary" type="submit">Delete</button>
		</div>
	</form>
</div>

<?php include($root . '/student062/dwes/src/footer.php'); ?>