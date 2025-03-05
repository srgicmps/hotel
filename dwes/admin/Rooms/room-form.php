<?php
$root = $_SERVER['DOCUMENT_ROOT'];
include($root . '/student062/dwes/includes/header.php');
include_once "../config/database.php";
include_once "../classes/Room.php";

// Check if user is logged in and is admin
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

$database = new Database();
$db = $database->getConnection();
$room = new Room($db);

if ($_POST) {
    $room->id = $_POST['id'] ?? null;
    $room->room_number = $_POST['room_number'];
    $room->type = $_POST['type'];
    $room->price = $_POST['price'];
    $room->capacity = $_POST['capacity'];
    $room->status = $_POST['status'];
    $room->description = $_POST['description'];

    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $target_dir = "../uploads/rooms/";
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $room->image_url = "uploads/rooms/" . basename($_FILES["image"]["name"]);
        }
    }

    if ($room->id) {
        if($room->update()) {
            header("Location: manage-rooms.php");
        }
    } else {
        if($room->create()) {
            header("Location: manage-rooms.php");
        }
    }
}

if (isset($_GET['id'])) {
    $room->id = $_GET['id'];
    $room->readOne();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo isset($_GET['id']) ? 'Edit' : 'Add New'; ?> Room</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2><?php echo isset($_GET['id']) ? 'Edit' : 'Add New'; ?> Room</h2>
            <a href="manage-rooms.php" class="btn btn-secondary">Back to List</a>
        </div>

        <form method="post" enctype="multipart/form-data">
            <?php if (isset($_GET['id'])): ?>
                <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
            <?php endif; ?>

            <div class="mb-3">
                <label class="form-label">Room Number</label>
                <input type="text" name="room_number" class="form-control" 
                       value="<?php echo htmlspecialchars($room->room_number ?? ''); ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Type</label>
                <select name="type" class="form-control" required>
                    <option value="single" <?php echo ($room->type ?? '') == 'single' ? 'selected' : ''; ?>>Single</option>
                    <option value="double" <?php echo ($room->type ?? '') == 'double' ? 'selected' : ''; ?>>Double</option>
                    <option value="suite" <?php echo ($room->type ?? '') == 'suite' ? 'selected' : ''; ?>>Suite</option>
                    <option value="deluxe" <?php echo ($room->type ?? '') == 'deluxe' ? 'selected' : ''; ?>>Deluxe</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Price (€)</label>
                <input type="number" name="price" step="0.01" class="form-control" 
                       value="<?php echo htmlspecialchars($room->price ?? ''); ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Capacity</label>
                <input type="number" name="capacity" class="form-control" 
                       value="<?php echo htmlspecialchars($room->capacity ?? ''); ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-control" required>
                    <option value="available" <?php echo ($room->status ?? '') == 'available' ? 'selected' : ''; ?>>Available</option>
                    <option value="occupied" <?php echo ($room->status ?? '') == 'occupied' ? 'selected' : ''; ?>>Occupied</option>
                    <option value="maintenance" <?php echo ($room->status ?? '') == 'maintenance' ? 'selected' : ''; ?>>Maintenance</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="3"><?php echo htmlspecialchars($room->description ?? ''); ?></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Room Image</label>
                <input type="file" name="image" class="form-control">
                <?php if (!empty($room->image_url)): ?>
                    <div class="mt-2">
                        <img src="../../<?php echo htmlspecialchars($room->image_url); ?>" 
                             class="img-thumbnail" style="max-width: 200px;">
                    </div>
                <?php endif; ?>
            </div>

            <div class="mb-3">
                <button type="submit" class="btn btn-primary">Save Room</button>
                <a href="manage-rooms.php" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>