<?php $root = $_SERVER['DOCUMENT_ROOT']; ?>

<?php include($root . '/student062/dwes/src/header.php'); ?>

<?php

include($root . '/student062/dwes/src/connect_db.php');

$reservation_id = $_POST['reservation_id'];
$reservation_number = $_POST['reservation_number'];
$user_id = $_POST['user_id'];
$room_id = $_POST['room_id'];
$check_in_date = $_POST['check_in_date'];
$check_out_date = $_POST['check_out_date'];
$number_of_guests = $_POST['number_of_guests'];
$reservation_status = $_POST['reservation_status'];

$sql = "UPDATE 062_reservations 
        SET reservation_number = '$reservation_number',
            user_id = '$user_id', 
            room_id = '$room_id', 
            check_in_date = '$check_in_date', 
            check_out_date = '$check_out_date', 
            number_of_guests = '$number_of_guests', 
            reservation_status = '$reservation_status',
        WHERE reservation_id = '$reservation_id';";

$result = mysqli_query($conn, $sql);

if ($result) {
    echo "<div class='container vh-100'> <div class='alert alert-success mt-5' role='alert'>Reservation updated successfully</div> </div>";
} else {
    echo "<div class='container vh-100'> <div class='alert alert-danger mt-5' role='alert'>Failed to update reservation: " . mysqli_error($conn) . "</div> </div>";
}

header('Refresh: 3; URL=/student062/dwes/tables/reservations/reservation_select/db_reservation_select.php');

?>

<?php include($root . '/student062/dwes/src/footer.php'); ?>