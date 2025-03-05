<?php $root = $_SERVER['DOCUMENT_ROOT']; ?>

<?php include($root . '/student062/dwes/src/header.php'); ?>

<?php include($root . '/student062/dwes/src/connect_db.php');

$room_number = $_POST['room_number'];
$room_capacity = $_POST['room_capacity'];
$room_type = $_POST['room_type'];
$room_price = $_POST['room_price'];

$sql = "INSERT INTO 062_rooms(room_number, room_capacity, room_type, room_price) VALUES('$room_number', '$room_capacity', '$room_type', '$room_price')";

$result = mysqli_query($conn, $sql);

mysqli_close($conn);

if ($result) {
	echo "<div class='container vh-100'><div class='alert alert-success mt-5' role='alert'>Room $room_number added successfully</div></div>";
} else {
	echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

header('Refresh: 3; URL=/student062/dwes/tables/rooms/room_select/db_room_select.php');

?>

<?php include($root . '/student062/dwes/src/footer.php'); ?>