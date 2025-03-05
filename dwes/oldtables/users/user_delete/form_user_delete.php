<?php $root = $_SERVER['DOCUMENT_ROOT']; ?>

<?php include($root . '/student062/dwes/src/header.php'); ?>

<div class="container vh-100">
	<h1> Do you want to delete <?php echo htmlspecialchars($_POST['user_name']); ?> from your database?</h1>
	<form action="<?php $root; ?>/student062/dwes/tables/users/user_delete/db_user_delete.php" class="form" method="post">
		<div class="form-group">
			<input type="text" name="user_id" class="form-control rounded-0" value="<?php echo htmlspecialchars($_POST['user_id']); ?>" style="display: none">
		</div>
		<button class="btn btn-dark border rounded-0" type="submit" style="font-weight: bold; font-family: Arial, sans-serif; font-size: 12px; letter-spacing: 2.5px;">DELETE</button>
	</form>
</div>

<?php include($root . '/student062/dwes/src/footer.php'); ?>