<?php $root = $_SERVER['DOCUMENT_ROOT']; ?>

<?php include($root . '/student062/dwes/src/header.php'); ?>

<?php include($root . '/student062/dwes/src/connect_db.php');

$search_query = '';
if (isset($_GET['search'])) {
	$search_query = mysqli_real_escape_string($conn, $_GET['search']);
}

$sql = 'SELECT * FROM 062_users';
if (!empty($search_query)) {
	$sql .= " WHERE user_name LIKE '%$search_query%' OR user_surname LIKE '%$search_query%' OR user_email LIKE '%$search_query%' OR user_username LIKE '%$search_query%' OR user_id_card LIKE '%$search_query%'";
}

$result = mysqli_query($conn, $sql);

$users = mysqli_fetch_all($result, MYSQLI_ASSOC);

mysqli_free_result($result);

mysqli_close($conn);

include($root . '/student062/dwes/function/function_show_user.php');
?>

<div class="container pt-3">
	<div class="row">
		<div class="col-12">
			<form method="GET" action="<?php $_SERVER['PHP_SELF']; ?>" class="d-flex mb-3">
				<input type="text" name="search" class="form-control me-2 rounded-0" placeholder="Search users" value="<?php echo htmlspecialchars($search_query); ?>">
				<button class="btn btn-dark border rounded-0 border-dark" type="submit" style="font-weight: bold; font-family: Arial, sans-serif; font-size: 12px; letter-spacing: 2.5px;">SEARCH</button>
			</form>
			<button class="btn btn-dark border rounded-0 border-dark my-3">
				<a class="nav-link" href="<?php $root; ?>/student062/dwes/tables/users/user_insert/form_user_insert.php" style="font-weight: bold; font-family: Arial, sans-serif; font-size: 12px; letter-spacing: 2.5px;">ADD NEW USER</a>
			</button>
		</div>
		<?php foreach ($users as $user) {
			show_user($user);
		} ?>
	</div>
</div>

<?php include($root . '/student062/dwes/src/footer.php'); ?>