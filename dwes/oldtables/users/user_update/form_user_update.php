<?php $root = $_SERVER['DOCUMENT_ROOT']; ?>

<?php include($root . '/student062/dwes/src/header.php'); ?>

<div class="container vh-100">
	<h1 class="mb-3 my-2">Update User</h1>
	<form action="<?php $root; ?>/student062/dwes/tables/users/user_update/db_user_update.php" class="form" method="post">
		<input type="hidden" name="user_id" value="<?php echo htmlspecialchars($_POST['user_id']); ?>">
		<div class="row mb-3">
			<div class="col">
				<label for="user_name" class="form-label">Name</label>
				<input type="text" class="form-control rounded-0" name="user_name" value="<?php echo htmlspecialchars($_POST['user_name']); ?>" placeholder="Enter name" title="Enter the user's first name">
			</div>
			<div class="col">
				<label for="user_surname" class="form-label">Surname</label>
				<input type="text" class="form-control rounded-0" name="user_surname" value="<?php echo htmlspecialchars($_POST['user_surname']); ?>" placeholder="Enter surname" title="Enter the user's surname">
			</div>
		</div>
		<div class="row mb-3">
			<div class="col">
				<label for="user_id_card" class="form-label">ID Card</label>
				<input type="text" class="form-control rounded-0" name="user_id_card" value="<?php echo htmlspecialchars($_POST['user_id_card']); ?>" placeholder="Enter ID card number" title="Enter the user's ID card number">
			</div>
			<div class="col">
				<label for="user_username" class="form-label">Username</label>
				<input type="text" class="form-control rounded-0" name="user_username" value="<?php echo htmlspecialchars($_POST['user_username']); ?>" placeholder="Enter username" title="Enter the user's username">
			</div>
		</div>
		<div class="row mb-3">
			<div class="col">
				<label for="user_password" class="form-label">Password</label>
				<input type="password" class="form-control rounded-0" name="user_password" value="<?php echo htmlspecialchars($_POST['user_password']); ?>" placeholder="Enter password" title="Enter the user's password">
			</div>
			<div class="col">
				<label for="user_email" class="form-label">Email</label>
				<input type="email" class="form-control rounded-0" name="user_email" value="<?php echo htmlspecialchars($_POST['user_email']); ?>" placeholder="Enter email" title="Enter the user's email address">
			</div>
		</div>
		<div class="row mb-3">
			<div class="col">
				<label for="user_phone" class="form-label">Phone Number</label>
				<input type="text" class="form-control rounded-0" name="user_phone" value="<?php echo htmlspecialchars($_POST['user_phone']); ?>" maxlength="9" placeholder="Enter phone number" title="Enter the user's phone number">
			</div>
			<div class="col">
				<label for="user_category" class="form-label">User Category</label>
				<select name="user_category" class="form-select rounded-0" aria-label="Change category select" title="Select the user's category">
					<?php if ($_POST['user_category'] == "Admin") { ?>
						<option value="admin" selected>Admin</option>
						<option value="user">User</option>
					<?php } else { ?>
						<option value="admin">Admin</option>
						<option value="user" selected>User</option>
					<?php } ?>
				</select>
			</div>
		</div>
		<button class="btn btn-primary mt-3 rounded-0" type="submit" style="font-weight: bold; font-family: Arial, sans-serif; font-size: 12px; letter-spacing: 2.5px;">SUBMIT</button>
	</form>
</div>

<?php include($root . '/student062/dwes/src/footer.php'); ?>