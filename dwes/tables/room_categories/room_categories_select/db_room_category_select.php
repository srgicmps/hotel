<?php $root = $_SERVER['DOCUMENT_ROOT']; ?>

<?php include($root . '/student062/dwes/src/header.php'); ?>
<?php include($root . '/student062/dwes/src/connect_db.php'); ?>

<?php
$search_query = '';
if (isset($_GET['search'])) {
	$search_query = mysqli_real_escape_string($conn, $_GET['search']);
}

$sql = 'SELECT rc.*, rci.image_path 
        FROM 062_room_categories AS rc 
        LEFT JOIN 062_room_category_images AS rci ON rc.room_category_id = rci.room_category_id';
if (!empty($search_query)) {
	$sql .= " WHERE rc.room_category_name LIKE '%$search_query%' OR rc.description LIKE '%$search_query%'";
}

$result = mysqli_query($conn, $sql);

$categories = mysqli_fetch_all($result, MYSQLI_ASSOC);

mysqli_free_result($result);

mysqli_close($conn);

include($root . '/student062/dwes/function/function_show_room_category.php');
?>

<div class="container pt-3">
	<div class="row">
		<div class="col-12">
			<form method="GET" action="<?php $_SERVER['PHP_SELF']; ?>" class="d-flex mb-3">
				<input type="text" name="search" class="form-control me-2 rounded-0" placeholder="Search room categories" value="<?php echo htmlspecialchars($search_query); ?>">
				<button class="btn btn-dark border rounded-0 border-dark" type="submit" style="font-weight: bold; font-family: Arial, sans-serif; font-size: 12px; letter-spacing: 2.5px;">SEARCH</button>
			</form>
			<button class="btn btn-dark border rounded-0 border-dark my-3">
				<a class="nav-link" href="<?php $root; ?>/student062/dwes/tables/room_categories/room_categories_insert/form_room_category_insert.php" style="font-weight: bold; font-family: Arial, sans-serif; font-size: 12px; letter-spacing: 2.5px;">ADD NEW CATEGORY</a>
			</button>
		</div>
		<?php foreach ($categories as $category) {
			show_room_category($category);
		} ?>
	</div>
</div>

<?php include($root . '/student062/dwes/src/footer.php'); ?>