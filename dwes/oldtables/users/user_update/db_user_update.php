<?php $root = $_SERVER['DOCUMENT_ROOT']; ?>

<?php include($root . '/student062/dwes/src/header.php'); ?>

<?php

include($root . '/student062/dwes/src/connect_db.php');

$user_id = $_POST['user_id'];
$user_name = $_POST['user_name'];
$user_surname = $_POST['user_surname'];
$user_id_card = $_POST['user_id_card'];
$user_username = $_POST['user_username'];
$user_password = $_POST['user_password'];
$user_email = $_POST['user_email'];
$user_phone = $_POST['user_phone'];
$user_category = $_POST['user_category'];

$sql = "UPDATE 062_users SET user_name = '$user_name', user_surname = '$user_surname', user_id_card = '$user_id_card', user_username = '$user_username', user_password = '$user_password', user_email = '$user_email', user_phone = '$user_phone', user_category = '$user_category' WHERE user_id = '$user_id';";

$result = mysqli_query($conn, $sql);

if ($result == 1) {
	echo "<div class='container vh-100'> <div class='alert alert-success mt-5' role='alert'>User updated successfully</div> </div>";
}

header('Refresh: 3; URL=/student062/dwes/tables/users/user_select/db_user_select.php');

?>

<?php include($root . '/student062/dwes/src/footer.php'); ?>