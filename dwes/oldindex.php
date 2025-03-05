<?php $root = $_SERVER['DOCUMENT_ROOT']; ?>

<?php include($root . '/student062/dwes/src/header.php'); ?>

<div id="background-container" class="d-flex justify-content-center align-items-center flex-column container-fluid" style="height: 80vh;">
	<div class="bg-light border shadow p-5 d-flex flex-column justify-content-center align-items-center mb-5">
		<h1 style="font-family: 'Cormorant Garamond', serif; font-weight: 300; font-style: normal; ">Encuentra tu próxima estancia</h1>
		<h4 style="font-family: 'Cormorant Garamond', serif; font-weight: 300; font-style: normal;">Busca las mejores ofertas y habitaciones directamente desde nuestra web...</h4>
	</div>
	<form action="<?php $root; ?>/student062/dwes/db/db_room_category_search.php" method="post" class="bg-light border shadow p-5 d-flex justify-content-center align-items-center">
		<div class="d-flex flex-column mx-4">
			<label class="text-nowrap mb-3 text-uppercase" for="check_in_date">Arrival Date</label>
			<input type="date" class="bg-transparent border border-transparent" id="check_in_date" name="check_in_date" value="<?php echo date('Y-m-d'); ?>" name="arrival" required>
		</div>
		<div class="d-flex flex-column mx-4">
			<label class="text-nowrap mb-3 text-uppercase" for="check_out_date">Departure Date</label>
			<input type="date" class="bg-transparent border border-transparent" id="check_out_date" name="check_out_date" value="<?php echo date('Y-m-d', strtotime('+1 day')); ?>" name="departure" required>
		</div>
		<div class="d-flex flex-column mx-4">
			<label class="text-nowrap mb-3 text-uppercase" for="number_of_guests">Number of People</label>
			<input type="number" class="bg-transparent border border-transparent" value="2" id="number_of_guests" name="number_of_guests" min="1" max="4" required>
		</div>
		<button type="submit" class="border-0 p-2 px-4 text-white mx-4" style="background-color: #7f7f7f; font-weight: bold; font-family: Arial, sans-serif; font-size: 12px; letter-spacing: 2.5px;">CHECK AVAILABILITY</button>
	</form>


</div>


<?php include($root . '/student062/dwes/src/footer.php'); ?>