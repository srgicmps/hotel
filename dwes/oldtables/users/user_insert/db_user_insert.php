<?php $root = $_SERVER['DOCUMENT_ROOT']; ?>

<?php include($root . '/student062/dwes/src/header.php'); ?>

<?php include($root . '/student062/dwes/src/connect_db.php'); ?>

<?php

$user_name = $_POST['user_name'];
$user_surname = $_POST['user_surname'];
$user_id_card = $_POST['user_id_card'];
$user_username = $_POST['user_username'];
$user_password = $_POST['user_password'];
$user_email = $_POST['user_email'];
$user_phone = $_POST['user_phone'];
$user_category = $_POST['user_category'];

$sql = "INSERT INTO 062_users(user_name, user_surname, user_id_card, user_username, user_password, user_email, user_phone, user_category) VALUES('$user_name', '$user_surname', '$user_id_card', '$user_username', '$user_password', '$user_email', '$user_phone', '$user_category')";

$result = mysqli_query($conn, $sql);

mysqli_close($conn);

if ($result) {
	echo "<div class='container vh-100'><div class='alert alert-success mt-5' role='alert'>User $user_name added successfully</div></div>";
} else {
	echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}
header('Refresh: 3; URL=/student062/dwes/tables/users/user_select/db_user_select.php');

?>