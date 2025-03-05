<?php $root = $_SERVER['DOCUMENT_ROOT']; ?>

<?php include($root . '/student062/dwes/src/header.php'); ?>

<?php

include($root . '/student062/dwes/src/connect_db.php');

if ($_SERVER['REQUEST_METHOD'] == "POST") {
	$user_id = $_POST['user_id'];
} else {
	echo ('Request method not post');
}

$sql = "DELETE FROM 062_users WHERE user_id = '$user_id'";
$result = mysqli_query($conn, $sql);

mysqli_close($conn);

if ($result) {
	echo "<div class='container vh-100'> <div class='alert alert-success mt-5' role='alert'>User deleted successfully</div> </div>";
}

header('Refresh: 3; URL=/student062/dwes/tables/users/user_select/db_user_select.php');

?>

<?php include($root . '/student062/dwes/src/footer.php'); ?>