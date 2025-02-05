<?php $root = $_SERVER['DOCUMENT_ROOT']; ?>

<?php include($root . '/student062/dwes/src/header.php'); ?>

<?php include($root . '/student062/dwes/src/connect_db.php');

if (isset($_POST['submit'])) {

	$user_email_username = $_POST['user_email_username'];
	$user_password = $_POST['user_password'];
	$failed_login = false;

	$sql = "SELECT * FROM 062_users WHERE user_email = '$user_email_username' OR user_username = '$user_email_username' AND user_password = '$user_password';";

	$result = mysqli_query($conn, $sql);


	if ($result && mysqli_num_rows($result) > 0) {
		$user = mysqli_fetch_assoc($result);
		$_SESSION['user_name'] = $user['user_name'];
		$_SESSION['user_id'] = $user['user_id'];
		$_SESSION['user_category'] = $user['user_category'];
		header('Location: /student062/dwes/index.php');
		exit();
	} else {
		$failed_login = true;
	}
}
?>

<div class="d-flex justify-content-center align-items-center" style="height: 70vh;">
	<form method="POST" action="<?php $root; ?>/student062/dwes/src/login.php" class="p-4 border border-dark" style="max-width: 400px;">
		<h1 class="text-center">Login</h1>
		<div class="mb-3">
			<label for="user_email_username" class="form-label">Username/Email:</label>
			<input type="text" id="user_email_username" name="user_email_username" required class="form-control border rounded-0 border-dark">
		</div>
		<div class="mb-3">
			<label for="user_password" class="form-label">Password:</label>
			<input type="password" id="user_password" name="user_password" required class="form-control border rounded-0 border-dark">
		</div>
		<?php if (isset($failed_login)) { ?>
			<?php if ($failed_login == true) { ?>
				<div class="mb-3">
					<h6 class="text-danger">Wrong credentials</h6>
				</div>
			<?php } ?>
		<?php } ?>
		<div class="text-center">
			<input type="submit" name="submit" value="LOGIN" class="btn btn-dark border rounded-0 border-dark" style="font-weight: bold; font-family: Arial, sans-serif; font-size: 12px; letter-spacing: 2.5px; ">
		</div>
	</form>
</div>

<?php include($root .  '/student062/dwes/src/footer.php'); ?>