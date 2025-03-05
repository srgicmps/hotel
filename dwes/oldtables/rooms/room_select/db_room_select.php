<?php $root = $_SERVER['DOCUMENT_ROOT']; ?>

<?php include($root . '/student062/dwes/src/header.php'); ?>

<?php

include($root . '/student062/dwes/src/connect_db.php');

$sql = 'SELECT * FROM 062_rooms';

$result = mysqli_query($conn, $sql);

if (!$result) {
	echo "Error: " . mysqli_error($conn);
	exit;
}

if (mysqli_num_rows($result) == 0) {
	echo "No rooms found.";
	exit;
} {
	$rooms = mysqli_fetch_all($result, MYSQLI_ASSOC);
	mysqli_free_result($result);

	mysqli_close($conn);
}


include($root . '/student062/dwes/function/function_show_room.php');

?>
<div class="container pt-3">
	<div class="row">
		<div class="col-12">
			<button class="btn btn-dark border rounded-0 border-dark my-3">
				<a class="nav-link" href="<?php $root; ?>/student062/dwes/tables/rooms/room_insert/form_room_insert.php" style="font-weight: bold; font-family: Arial, sans-serif; font-size: 12px; letter-spacing: 2.5px;">ADD NEW ROOM</a>
			</button>
		</div>
		<?php foreach ($rooms as $room) {
			show_room($room);
		} ?>
	</div>
</div>

<?php include($root . '/student062/dwes/src/footer.php'); ?>