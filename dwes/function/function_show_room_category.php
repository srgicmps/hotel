<?php
function show_room_category($category)
{ ?>
	<div class="mb-4">
		<table class="table table-bordered">
			<tr>
				<th>Category ID</th>
				<td><?php echo htmlspecialchars($category['room_category_id']); ?></td>
			</tr>
			<tr>
				<th>Category Name</th>
				<td><?php echo htmlspecialchars($category['room_category_name']); ?></td>
			</tr>
			<tr>
				<th>Price per Night</th>
				<td><?php echo htmlspecialchars($category['price_per_night']); ?>€</td>
			</tr>
			<tr>
				<th>Max Occupancy</th>
				<td><?php echo htmlspecialchars($category['max_occupancy']); ?></td>
			</tr>
			<tr>
				<th>Description</th>
				<td><?php echo htmlspecialchars($category['description']); ?></td>
			</tr>
			<?php if (!empty($category['image_path'])) { ?>
				<tr>
					<th>Image</th>
					<td><img src="<?php echo htmlspecialchars($category['image_path']); ?>" alt="Category Image" class="img-thumbnail" style="max-width: 200px;"></td>
				</tr>
			<?php } ?>
		</table>
		<div class="d-flex justify-content-end">
			<form action="<?php $_SERVER['DOCUMENT_ROOT']; ?>/student062/dwes/tables/room_categories/room_categories_update/form_room_category_update.php" method="post" class="me-2">
				<input type="hidden" name="category_id" value="<?php echo htmlspecialchars($category['room_category_id']); ?>">
				<input type="hidden" name="room_category_name" value="<?php echo htmlspecialchars($category['room_category_name']); ?>">
				<input type="hidden" name="price_per_night" value="<?php echo htmlspecialchars($category['price_per_night']); ?>">
				<input type="hidden" name="max_occupancy" value="<?php echo htmlspecialchars($category['max_occupancy']); ?>">
				<input type="hidden" name="description" value="<?php echo htmlspecialchars($category['description']); ?>">
				<button class="btn btn-primary border rounded-0 border-primary" type="submit" style="font-weight: bold; font-family: Arial, sans-serif; font-size: 12px; letter-spacing: 2.5px;">EDIT</button>
			</form>
			<form action="<?php $_SERVER['DOCUMENT_ROOT']; ?>/student062/dwes/tables/room_categories/db_room_category_delete.php" method="post">
				<input type="hidden" name="category_id" value="<?php echo htmlspecialchars($category['room_category_id']); ?>">
				<button class="btn btn-danger border rounded-0 border-danger" type="submit" style="font-weight: bold; font-family: Arial, sans-serif; font-size: 12px; letter-spacing: 2.5px;">DELETE</button>
			</form>
		</div>
	</div>
<?php } ?>