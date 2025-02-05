<?php $root = $_SERVER['DOCUMENT_ROOT']; ?>

<?php include($root . '/student062/dwes/src/header.php'); ?>

<div class="container pt-3">
	<h1 class="mb-3 my-2">Add New User</h1>
	<form action="<?php $root; ?>/student062/dwes/tables/users/user_insert/db_user_insert.php" method="post" class="rounded-0">
		<small class="form-text text-muted mb-3">We'll never share your information with anyone.</small>
		<table class="table table-bordered">
			<tr>
				<th>Name</th>
				<td><input type="text" name="user_name" class="form-control rounded-0" placeholder="Enter name" required></td>
			</tr>
			<tr>
				<th>Surname</th>
				<td><input type="text" name="user_surname" class="form-control rounded-0" placeholder="Enter surname" required></td>
			</tr>
			<tr>
				<th>ID Card</th>
				<td><input type="text" name="user_id_card" class="form-control rounded-0" placeholder="Enter ID card" minlength="9" maxlength="9"></td>
			</tr>
			<tr>
				<th>Username</th>
				<td><input type="text" name="user_username" class="form-control rounded-0" placeholder="Enter username" required></td>
			</tr>
			<tr>
				<th>Password</th>
				<td><input type="password" name="user_password" class="form-control rounded-0" placeholder="Enter password" required></td>
			</tr>
			<tr>
				<th>Email</th>
				<td><input type="email" name="user_email" class="form-control rounded-0" placeholder="Enter email"></td>
			</tr>
			<tr>
				<th>Phone</th>
				<td><input type="text" name="user_phone" class="form-control rounded-0" placeholder="Enter phone" minlength="9" maxlength="9"></td>
			</tr>
			<tr>
				<th>Category</th>
				<td>
					<select name="user_category" id="user_category" class="form-select border rounded-0" required>
						<option value="user" default>User</option>
						<option value="admin">Admin</option>
					</select>
				</td>
			</tr>
		</table>
		<div>
			<button class="btn btn-dark border rounded-0" type="submit" style="font-weight: bold; font-family: Arial, sans-serif; font-size: 12px; letter-spacing: 2.5px;">SUBMIT</button>
		</div>
	</form>
</div>

<?php include($root . '/student062/dwes/src/footer.php'); ?>