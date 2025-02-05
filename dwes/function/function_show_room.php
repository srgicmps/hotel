<?php
function show_room($room)
{ ?>
	<div class="col-md-4">
		<div class="mb-4 shadow-sm" style="box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
			<div class="card-body">
				<table class="table table-bordered">
					<tr>
						<th>Room Number</th>
						<td><?php echo htmlspecialchars($room['room_number']); ?></td>
					</tr>
				</table>
			</div>
		</div>
	</div>

	<div class="modal fade" id="userModal<?php echo htmlspecialchars($room['user_id']); ?>" tabindex="-1" aria-labelledby="userModalLabel<?php echo htmlspecialchars($room['user_id']); ?>" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="userModalLabel<?php echo htmlspecialchars($room['user_id']); ?>">User Information</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<table class="table table-bordered">
						<tr>
							<th>User ID</th>
							<td><?php echo htmlspecialchars($room['user_id']); ?></td>
						</tr>
						<tr>
							<th>Name</th>
							<td><?php echo htmlspecialchars($room['user_name']) . ' ' . htmlspecialchars($room['user_surname']); ?></td>
						</tr>
						<tr>
							<th>Email</th>
							<td><?php echo htmlspecialchars($room['user_email']); ?></td>
						</tr>
						<tr>
							<th>Phone</th>
							<td><?php echo htmlspecialchars($room['user_phone']); ?></td>
						</tr>
						<tr>
							<th>Username</th>
							<td><?php echo htmlspecialchars($room['user_username']); ?></td>
						</tr>
						<tr>
							<th>ID Card</th>
							<td><?php echo htmlspecialchars($room['user_id_card']); ?></td>
						</tr>
						<tr>
							<th>Category</th>
							<td><?php echo htmlspecialchars($room['user_category']); ?></td>
						</tr>
					</table>
				</div>
				<div class="modal-footer">
					<button class="btn btn-dark border rounded-0 border-dark" type="submit" style="font-weight: bold; font-family: Arial, sans-serif; font-size: 12px; letter-spacing: 2.5px;" data-bs-dismiss="modal">CLOSE</button>
				</div>
			</div>
		</div>
	</div>
<?php } ?>