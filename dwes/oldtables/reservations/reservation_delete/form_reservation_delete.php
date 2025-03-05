<?php $root = $_SERVER['DOCUMENT_ROOT']; ?>

<?php include($root . '/student062/dwes/src/header.php'); ?>

<div class="container vh-100">
	<h1 class="mb-3 my-2">Delete Reservation</h1>
	<form action="<?php $root; ?>/student062/dwes/tables/reservations/reservation_delete/db_reservation_delete.php" method="post">
		<input type="hidden" name="reservation_id" value="<?php echo htmlspecialchars($_POST['reservation_id']); ?>">
		<div class="alert alert-warning rounded-0" role="alert">
			Are you sure you want to delete this reservation?
		</div>
		<button class="btn btn-danger border rounded-0 border-danger" type="submit" style="font-weight: bold; font-family: Arial, sans-serif; font-size: 12px; letter-spacing: 2.5px;">DELETE</button>
		<a href="<?php $root; ?>/student062/dwes/tables/reservations/reservation_select/db_reservation_select.php" class="btn btn-secondary border rounded-0 border-secondary" style="font-weight: bold; font-family: Arial, sans-serif; font-size: 12px; letter-spacing: 2.5px;">CANCEL</a>
	</form>
</div>

<?php include($root . '/student062/dwes/src/footer.php'); ?>