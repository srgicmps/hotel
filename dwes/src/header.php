<?php session_start(); ?>


<?php $root = $_SERVER['DOCUMENT_ROOT']; ?>

<?php

$current_page = basename($_SERVER['PHP_SELF']);

?>
<!DOCTYPE html>

<html>

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>FROST</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
	<style>
		@import url('https://fonts.googleapis.com/css2?family=Azeret+Mono:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');
		@import url('https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap');
		@import url('https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');
		@import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap');
	</style>
	<link rel="icon" href="" type="image/ico">
</head>

<body class="vh-100 bg-light" style="background-image: url('./img/background.jpg'); background-size: cover;">
	<nav class="navbar navbar-expand-lg sticky-top p-4" data-bs-theme="dark" style="transition: background-color 0.5s;" onmouseover="this.style.backgroundColor='#f8f9fa'; this.setAttribute('data-bs-theme', 'light');" onmouseout="this.style.backgroundColor='transparent'; this.setAttribute('data-bs-theme', 'dark');">
		<div class="container-fluid">
			<?php
			if ($current_page === 'index.php') { ?>
				<a class="navbar-brand my-1 fs-2 fw-medium" id="title" href="<?php $root; ?>/student062/dwes" style="font-family: 'Cormorant Garamond', serif; font-weight: 300; font-style: normal; ">FROST</a>
				<button class="navbar-toggler border rounded-pill border-dark" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
			<?php } else { ?>
				<a class="navbar-brand my-1 fs-2 fw-medium text-dark" id="title" href="<?php $root; ?>/student062/dwes" style="font-family: 'Cormorant Garamond', serif; font-weight: 300; font-style: normal; ">FROST</a>
				<button class="navbar-toggler border rounded-pill border-dark" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
			<?php } ?>


			<?php if (isset($_SESSION['user_name']) && isset($_SESSION['user_category'])) { ?>
				<div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
					<?php if ($_SESSION['user_category'] == 'Admin') { ?>
						<ul class="navbar-nav my-1">
							<!-- <li class="nav-item">
						<a class="nav-link active" aria-current="page" href="#">Home</a>
					</li> -->
							<!-- <li class="nav-item">
						<a class="nav-link" href="#">Link</a>
					</li> -->
							<li class="nav-item dropdown">
								<?php
								if ($current_page === 'index.php') { ?>
									<button class="dropdown-toggle ms-1 bg-transparent border-0" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
										Admin Buttons
									</button>
									<ul class="dropdown-menu border border-dark">
										<li><a class="dropdown-item" href="<?php $root; ?>/student062/dwes/tables/users/user_select/db_user_select.php">Ver clientes</a></li>
										<li><a class="dropdown-item" href="<?php $root; ?>/student062/dwes/tables/room_categories/room_categories_select/db_room_category_select.php">Ver categorias de habitacion</a></li>
										<li><a class="dropdown-item" href="<?php $root; ?>/student062/dwes/tables/rooms/room_select/db_room_select.php">Ver habitaciones</a></li>
										<li><a href="<?php $root; ?>/student062/dwes/tables/reservations/reservation_select/db_reservation_select.php" class="dropdown-item">Ver reservas</a></li>
										<!-- <li><a class="dropdown-item" href="#">Something else here</a></li> -->
									</ul>
								<?php } else { ?>
									<button class="dropdown-toggle ms-1 text-dark bg-transparent border-0" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
										Admin Buttons
									</button>
									<ul class="dropdown-menu bg-light border border-dark">
										<li><a class="dropdown-item text-dark" href="<?php $root; ?>/student062/dwes/tables/users/user_select/db_user_select.php">Ver clientes</a></li>
										<li><a class="dropdown-item" href="<?php $root; ?>/student062/dwes/tables/room_categories/room_categories_select/db_room_category_select.php">Ver categorias de habitacion</a></li>
										<li><a class="dropdown-item text-dark" href="<?php $root; ?>/student062/dwes/tables/rooms/room_select/db_room_select.php">Ver habitaciones</a></li>
										<li><a href="<?php $root; ?>/student062/dwes/tables/reservations/reservation_select/db_reservation_select.php" class="dropdown-item text-dark">Ver reservas</a></li>
										<!-- <li><a class="dropdown-item" href="#">Something else here</a></li> -->
									</ul>
								<?php } ?>
							</li>
						<?php } elseif ($_SESSION['user_category'] == "user") { ?>

						<?php } ?>
						</ul>
						<ul class="navbar-nav my-1 justify-content-end">
							<li class="nav-item dropstart">
								<?php
								if ($current_page === 'index.php') { ?>
									<button class="dropdown-toggle ms-1 bg-transparent border-0" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
										<?php echo $_SESSION['user_name']; ?>
									</button>
									<ul class="dropdown-menu border border-dark">
										<li>
											<a class="dropdown-item" href="<?php $root; ?>/student062/dwes/src/db_logout.php">Logout</a>
										</li>
										<!-- <li class="dropdown-divider"></li> -->
										<li>
											<a class="dropdown-item" href="">Profile</a>
										</li>
									</ul>
								<?php } else { ?>
									<button class="dropdown-toggle ms-1 text-dark bg-transparent border-0" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
										<?php echo $_SESSION['user_name']; ?>
									</button>
									<ul class="dropdown-menu border border-dark bg-light">
										<li>
											<a class="dropdown-item text-dark" href="<?php $root; ?>/student062/dwes/src/db_logout.php">Logout</a>
										</li>
										<!-- <li class="dropdown-divider"></li> -->
										<li>
											<a class="dropdown-item text-dark" href="">Profile</a>
										</li>
									</ul>
								<?php } ?>

							</li>
							<!-- <li class="nav-item">
						<a class="nav-link disabled" aria-disabled="true">Disabled</a>
					</li> -->
						</ul>
					<?php } else { ?>
						<div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">

							<ul class="navbar-nav my-1">
								<a href="<?php $root; ?>/student062/dwes/src/login.php">
									<div class="text-center">
										<input type="submit" name="submit" value="LOGIN" class="btn btn-dark border rounded-0 border-dark" style="font-weight: bold; font-family: Arial, sans-serif; font-size: 12px; letter-spacing: 2.5px; ">
									</div>
								</a>
							</ul>
						<?php } ?>
						<!-- <form class="d-flex" role="search">
					<input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
					<button class="btn btn-outline-success" type="submit">Search</button>
				</form> -->
						</div>
				</div>
	</nav>