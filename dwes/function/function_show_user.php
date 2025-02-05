<?php
function show_user($user)
{ ?>
	<div>
		<div class="mb-4">

			<table class="table table-bordered">
				<tr>
					<th>ID</th>
					<td><?php echo htmlspecialchars($user['user_id']); ?></td>
				</tr>
				<tr>
					<th>Category</th>
					<td><?php echo htmlspecialchars($user['user_category']); ?></td>
				</tr>
				<tr>
					<th>Name</th>
					<td><?php echo htmlspecialchars($user['user_name']) . ' ' . htmlspecialchars($user['user_surname']); ?></td>
				</tr>
				<tr>
					<th>Phone</th>
					<td><?php echo htmlspecialchars($user['user_phone']); ?></td>
				</tr>
				<tr>
					<th>Email</th>
					<td><?php echo htmlspecialchars($user['user_email']); ?></td>
				</tr>
				<tr>
					<th>Username</th>
					<td><?php echo htmlspecialchars($user['user_username']); ?></td>
				</tr>
				<tr>
					<th>ID Card</th>
					<td><?php echo htmlspecialchars($user['user_id_card']); ?></td>
				</tr>
			</table>
			<div class="d-flex justify-content-end">
				<form action="<?php $_SERVER['DOCUMENT_ROOT']; ?>/student062/dwes/tables/users/user_update/form_user_update.php" method="post" class="me-2">
					<input type="text" name="user_id" value="<?php echo htmlspecialchars($user['user_id']); ?>" style="display: none">
					<input type="text" name="user_category" value="<?php echo htmlspecialchars($user['user_category']); ?>" style="display: none">
					<input type=" text" name="user_name" value="<?php echo htmlspecialchars($user['user_name']); ?>" style="display: none">
					<input type="text" name="user_surname" value="<?php echo htmlspecialchars($user['user_surname']); ?>" style="display: none">
					<input type="text" name="user_email" value="<?php echo htmlspecialchars($user['user_email']); ?>" style="display: none">
					<input type="text" name="user_phone" value="<?php echo htmlspecialchars($user['user_phone']); ?>" style="display: none">
					<input type="text" name="user_username" value="<?php echo htmlspecialchars($user['user_username']); ?>" style="display: none">
					<input type="text" name="user_password" value="<?php echo htmlspecialchars($user['user_password']); ?>" style="display: none">
					<input type="text" name="user_id_card" value="<?php echo htmlspecialchars($user['user_id_card']); ?>" style="display: none">
					<button class="btn btn-primary border rounded-0 border-primary" type="submit" style="font-weight: bold; font-family: Arial, sans-serif; font-size: 12px; letter-spacing: 2.5px;">EDIT</button>
				</form>
				<form action="<?php $_SERVER['DOCUMENT_ROOT']; ?>/student062/dwes/tables/users/user_delete/form_user_delete.php" method="post">
					<input type="text" name="user_id" value="<?php echo htmlspecialchars($user['user_id']); ?>" style="display: none">
					<input type=" text" name="user_name" value="<?php echo htmlspecialchars($user['user_name']); ?>" style="display: none">
					<button class="btn btn-danger border rounded-0 border-danger" type="submit" style="font-weight: bold; font-family: Arial, sans-serif; font-size: 12px; letter-spacing: 2.5px;">DELETE</button>
				</form>
			</div>
		</div>
	</div>
<?php } ?>