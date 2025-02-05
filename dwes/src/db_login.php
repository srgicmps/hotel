<?php $root = $_SERVER['DOCUMENT_ROOT']; ?>

<?php include($root . '/student062/dwes/src/header.php'); ?>

<?php include($root . '/student062/dwes/src/connect_db.php');


if (isset($_POST['submit'])) {

	$user_email_username = $_POST['user_email_username'];
	$user_password = $_POST['user_password'];

	$sql = "SELECT * FROM 062_users WHERE user_email = '$user_email_username' OR user_username = '$user_email_username' AND user_password = '$user_password';";

	$result = mysqli_query($conn, $sql);

	$user = mysqli_fetch_assoc($result);

	if (mysqli_num_rows($result) > 0) {
		$_SESSION['user_name'] = $user['user_name'];
		$_SESSION['user_category'] = $user['user_category'];
	} else {
		echo "Login failed";
	}
}

header('Refresh: 0; URL=/student062/dwes/index.php');
?>

<?php include($root .  '/student062/dwes/src/footer.php'); ?>