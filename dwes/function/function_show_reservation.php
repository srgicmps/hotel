<?php
function show_reservation($reservation)
{
?>
	<div>
		<div class="mb-4">

			<table class="table table-bordered">
				<tr>
					<th>Reservation Number</th>
					<td><?php echo htmlspecialchars($reservation['reservation_number']); ?></td>
				</tr>
				<tr>
					<th>Reservation ID</th>
					<td><?php echo htmlspecialchars($reservation['reservation_id']); ?></td>
				</tr>
				<tr>
					<th>User ID</th>
					<td><?php echo htmlspecialchars($reservation['user_id']); ?></td>
				</tr>
				<tr>
					<th>User Name</th>
					<td>
						<a href="#" data-bs-toggle="modal" data-bs-target="#userModal<?php echo htmlspecialchars($reservation['user_id']); ?>">
							<?php echo htmlspecialchars($reservation['user_name']) . ' ' . htmlspecialchars($reservation['user_surname']); ?>
						</a>
					</td>
				</tr>
				<tr>
					<th>Room ID</th>
					<td>
						<a href="#" data-bs-toggle="modal" data-bs-target="#roomModal<?php echo htmlspecialchars($reservation['room_id']); ?>">
							<?php echo htmlspecialchars($reservation['room_id']); ?> (Room Number: <?php echo htmlspecialchars($reservation['room_number']); ?>)
						</a>
					</td>
				</tr>
				<tr>
					<th>Check-in Date</th>
					<td><?php echo htmlspecialchars($reservation['check_in_date']); ?></td>
				</tr>
				<tr>
					<th>Check-out Date</th>
					<td><?php echo htmlspecialchars($reservation['check_out_date']); ?></td>
				</tr>
				<tr>
					<th>Number of Guests</th>
					<td><?php echo htmlspecialchars($reservation['number_of_guests']); ?></td>
				</tr>
				<tr>
					<th>Status</th>
					<td><?php echo htmlspecialchars($reservation['reservation_status']); ?></td>
				</tr>
			</table>
			<div class="d-flex justify-content-end">
				<form action="<?php $_SERVER['DOCUMENT_ROOT']; ?>/student062/dwes/tables/reservations/reservation_update/form_reservation_update.php" method="post" class="me-2">
					<input type="hidden" name="reservation_id" value="<?php echo htmlspecialchars($reservation['reservation_id']); ?>">
					<input type="hidden" name="reservation_number" value="<?php echo htmlspecialchars($reservation['reservation_number']); ?>">
					<input type="hidden" name="user_id" value="<?php echo htmlspecialchars($reservation['user_id']); ?>">
					<input type="hidden" name="room_id" value="<?php echo htmlspecialchars($reservation['room_id']); ?>">
					<input type="hidden" name="check_in_date" value="<?php echo htmlspecialchars($reservation['check_in_date']); ?>">
					<input type="hidden" name="check_out_date" value="<?php echo htmlspecialchars($reservation['check_out_date']); ?>">
					<input type="hidden" name="number_of_guests" value="<?php echo htmlspecialchars($reservation['number_of_guests']); ?>">
					<input type="hidden" name="reservation_status" value="<?php echo htmlspecialchars($reservation['reservation_status']); ?>">
					<button class="btn btn-primary border rounded-0 border-primary" type="submit" style="font-weight: bold; font-family: Arial, sans-serif; font-size: 12px; letter-spacing: 2.5px;">EDIT</button>
				</form>
				<form action="<?php $_SERVER['DOCUMENT_ROOT']; ?>/student062/dwes/tables/reservations/reservation_delete/form_reservation_delete.php" method="post">
					<input type="hidden" name="reservation_id" value="<?php echo htmlspecialchars($reservation['reservation_id']); ?>">
					<button class="btn btn-danger border rounded-0 border-danger" type="submit" style="font-weight: bold; font-family: Arial, sans-serif; font-size: 12px; letter-spacing: 2.5px;">DELETE</button>
				</form>
			</div>
		</div>
	</div>

	<div class="modal fade" id="userModal<?php echo htmlspecialchars($reservation['user_id']); ?>" tabindex="-1" aria-labelledby="userModalLabel<?php echo htmlspecialchars($reservation['user_id']); ?>" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="userModalLabel<?php echo htmlspecialchars($reservation['user_id']); ?>">User Information</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<table class="table table-bordered">
						<tr>
							<th>User ID</th>
							<td><?php echo htmlspecialchars($reservation['user_id']); ?></td>
						</tr>
						<tr>
							<th>Name</th>
							<td><?php echo htmlspecialchars($reservation['user_name']) . ' ' . htmlspecialchars($reservation['user_surname']); ?></td>
						</tr>
						<tr>
							<th>Email</th>
							<td><?php echo htmlspecialchars($reservation['user_email']); ?></td>
						</tr>
						<tr>
							<th>Phone</th>
							<td><?php echo htmlspecialchars($reservation['user_phone']); ?></td>
						</tr>
						<tr>
							<th>Username</th>
							<td><?php echo htmlspecialchars($reservation['user_username']); ?></td>
						</tr>
						<tr>
							<th>ID Card</th>
							<td><?php echo htmlspecialchars($reservation['user_id_card']); ?></td>
						</tr>
						<tr>
							<th>Category</th>
							<td><?php echo htmlspecialchars($reservation['user_category']); ?></td>
						</tr>
					</table>
				</div>
				<div class="modal-footer">
					<button class="btn btn-dark border rounded-0 border-dark" type="submit" style="font-weight: bold; font-family: Arial, sans-serif; font-size: 12px; letter-spacing: 2.5px;" data-bs-dismiss="modal">CLOSE</button>
				</div>
			</div>
		</div>
	</div>

	<div class=" modal fade" id="roomModal<?php echo htmlspecialchars($reservation['room_id']); ?>" tabindex="-1" aria-labelledby="roomModalLabel<?php echo htmlspecialchars($reservation['room_id']); ?>" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="roomModalLabel<?php echo htmlspecialchars($reservation['room_id']); ?>">Room Details</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<table class="table table-bordered">
						<tr>
							<th>Room ID</th>
							<td><?php echo htmlspecialchars($reservation['room_id']); ?></td>
						</tr>
						<tr>
							<th>Room Number</th>
							<td><?php echo htmlspecialchars($reservation['room_number']); ?></td>
						</tr>
						<tr>
							<th>Room Category</th>
							<td><?php echo htmlspecialchars($reservation['room_category_name']); ?></td>
						</tr>
						<tr>
							<th>Price per Night</th>
							<td><?php echo htmlspecialchars($reservation['price_per_night']); ?>€</td>
						</tr>
						<tr>
							<th>Max Occupancy</th>
							<td><?php echo htmlspecialchars($reservation['max_occupancy']); ?></td>
						</tr>
						<tr>
							<th>Description</th>
							<td><?php echo htmlspecialchars($reservation['description']); ?></td>
						</tr>
					</table>
				</div>
				<div class="modal-footer">
					<button class="btn btn-dark border rounded-0 border-dark" type="submit" style="font-weight: bold; font-family: Arial, sans-serif; font-size: 12px; letter-spacing: 2.5px;" data-bs-dismiss="modal">CLOSE</button>
				</div>
			</div>
		</div>
	</div>
<?php
}
?>