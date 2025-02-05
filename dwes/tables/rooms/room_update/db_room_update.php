<?php $root = $_SERVER['DOCUMENT_ROOT']; ?>

<?php include($root . "/student062/dwes/src/header.php"); ?>

<?php include($root . "/student062/dwes/src/connect_db.php");

$room_id = $_POST['room_id'];
$room_number = $_POST['room_number'];
$room_capacity = $_POST['room_capacity'];
$room_type = $_POST['room_type'];
$room_price = $_POST['room_price'];

$sql = "UPDATE 062_rooms SET room_number = '$room_number', room_capacity = '$room_capacity', room_type = '$room_type', room_price = '$room_price' WHERE room_id = '$room_id';";

$result = mysqli_query($conn, $sql);

if ($result == 1) {
	echo "<div class='container vh-100'> <div class='alert alert-success mt-5' role='alert'>Room updated successfully</div> </div>";
}

header('Refresh: 3; URL=/student062/dwes/tables/rooms/room_select/db_room_select.php');
?>

<?php include($root . "/student062/dwes/src/footer.php"); ?>