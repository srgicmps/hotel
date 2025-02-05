<?php $root = $_SERVER['DOCUMENT_ROOT']; ?>

<?php include($root . '/student062/dwes/src/header.php'); ?>

<?php
// nclude($root . '/student062/dwes/src/connect_db.php');

// $search_query = '';
// if (isset($_GET['search'])) {
// 	$search_query = mysqli_real_escape_string($conn, $_GET['search']);
// }

// $sql = 'SELECT r.*, u.user_name, u.user_surname, u.user_email, u.user_phone, u.user_username, u.user_id_card, u.user_category, ro.room_number, rc.room_category_name, rc.price_per_night, rc.max_occupancy, rc.description
//         FROM 062_reservations AS r 
//         JOIN 062_users AS u ON r.user_id = u.user_id
//         JOIN 062_rooms AS ro ON r.room_id = ro.room_id
//         JOIN 062_room_categories AS rc ON ro.room_category_id = rc.room_category_id';
// if (!empty($search_query)) {
// 	$sql .= " WHERE r.reservation_number LIKE '%$search_query%' OR r.reservation_id LIKE '%$search_query%' OR u.user_name LIKE '%$search_query%' OR u.user_surname LIKE '%$search_query%' OR rc.room_category_name LIKE '%$search_query%'";
// }

// $result = mysqli_query($conn, $sql);

// $reservations = mysqli_fetch_all($result, MYSQLI_ASSOC);

// mysqli_free_result($result);

// mysqli_close($conn);

// include($root . '/student062/dwes/function/function_show_reservation.php');
?>

<!-- <div class="container pt-3">
	<div class="row">
		<div class="col-12">
			<form method="GET" action="<?php $_SERVER['PHP_SELF']; ?>" class="d-flex mb-3">
				<input type="text" name="search" class="form-control me-2 rounded-0" placeholder="Search reservations" value="<?php echo htmlspecialchars($search_query); ?>">
				<button class="btn btn-dark border rounded-0 border-dark" type="submit" style="font-weight: bold; font-family: Arial, sans-serif; font-size: 12px; letter-spacing: 2.5px;">SEARCH</button>
			</form>
			<button class="btn btn-dark border rounded-0 border-dark my-3">
				<a class="nav-link" href="<?php $root; ?>/student062/dwes/tables/reservations/reservation_insert/form_reservation_insert.php" style="font-weight: bold; font-family: Arial, sans-serif; font-size: 12px; letter-spacing: 2.5px;">ADD NEW RESERVATION</a>
			</button>
		</div>
		<?php foreach ($reservations as $reservation) {
			show_reservation($reservation);
		} ?>
	</div>
</div> -->

<div class="container pt-3">
	<div class="row">
		<div class="col-12">
			<form id="search-form" class="d-flex mb-3">
				<input type="text" id="search-input" name="search" class="form-control me-2 rounded-0" placeholder="Search reservations">
			</form>
			<button class="btn btn-dark border rounded-0 border-dark my-3">
				<a class="nav-link" href="<?php $root; ?>/student062/dwes/tables/reservations/reservation_insert/form_reservation_insert.php" style="font-weight: bold; font-family: Arial, sans-serif; font-size: 12px; letter-spacing: 2.5px;">ADD NEW RESERVATION</a>
			</button>
		</div>
		<div id="reservation-results" class="col-12">
			<!-- Search results will be displayed here -->
		</div>
	</div>
</div>

<script>
	document.getElementById('search-input').addEventListener('input', function() {
		const searchQuery = this.value;
		const xhr = new XMLHttpRequest();
		xhr.open('GET', '<?php $root; ?>/student062/dwes/tables/reservations/search_reservations.php?search=' + encodeURIComponent(searchQuery), true);
		xhr.onload = function() {
			if (xhr.status === 200) {
				const reservations = JSON.parse(xhr.responseText);
				const resultsContainer = document.getElementById('reservation-results');
				resultsContainer.innerHTML = '';
				reservations.forEach(reservation => {
					const reservationDiv = document.createElement('div');
					reservationDiv.classList.add('mb-4');
					reservationDiv.innerHTML = `
                    <table class="table table-bordered">
                        <tr>
                            <th>Reservation Number</th>
                            <td>${reservation.reservation_number}</td>
                        </tr>
                        <tr>
                            <th>User Name</th>
                            <td>${reservation.user_name} ${reservation.user_surname}</td>
                        </tr>
                        <tr>
                            <th>Room Number</th>
                            <td>${reservation.room_number}</td>
                        </tr>
                        <tr>
                            <th>Check-in Date</th>
                            <td>${reservation.check_in_date}</td>
                        </tr>
                        <tr>
                            <th>Check-out Date</th>
                            <td>${reservation.check_out_date}</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>${reservation.reservation_status}</td>
                        </tr>
                    </table>
                `;
					resultsContainer.appendChild(reservationDiv);
				});
			}
		};
		xhr.send();
	});
</script>

<?php include($root . '/student062/dwes/src/footer.php'); ?>