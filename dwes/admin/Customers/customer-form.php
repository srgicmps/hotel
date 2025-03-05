<?php
$root = $_SERVER['DOCUMENT_ROOT'];
include($root . '/student062/dwes/includes/header.php');
include_once "../config/database.php";
include_once "../classes/Customer.php";

// Check if user is logged in and is admin
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

$database = new Database();
$db = $database->getConnection();
$customer = new Customer($db);

if ($_POST) {
    $customer->id = $_POST['id'] ?? null;
    $customer->first_name = $_POST['first_name'];
    $customer->last_name = $_POST['last_name'];
    $customer->email = $_POST['email'];
    $customer->phone = $_POST['phone'];
    $customer->address = $_POST['address'];
    $customer->dni_number = $_POST['dni_number'];

    // Handle DNI image upload
    if (isset($_FILES['dni_image']) && $_FILES['dni_image']['error'] === UPLOAD_ERR_OK) {
        $target_dir = "../../uploads/dni/";
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        $target_file = $target_dir . basename($_FILES["dni_image"]["name"]);
        if (move_uploaded_file($_FILES["dni_image"]["tmp_name"], $target_file)) {
            $customer->dni_image_url = "uploads/dni/" . basename($_FILES["dni_image"]["name"]);
        }
    }

    if ($customer->id) {
        if($customer->update()) {
            header("Location: manage-customers.php");
        }
    } else {
        if($customer->create()) {
            header("Location: manage-customers.php");
        }
    }
}

if (isset($_GET['id'])) {
    $customer->id = $_GET['id'];
    $customer->readOne();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo isset($_GET['id']) ? 'Edit' : 'Add New'; ?> Customer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2><?php echo isset($_GET['id']) ? 'Edit' : 'Add New'; ?> Customer</h2>
            <a href="manage-customers.php" class="btn btn-secondary">Back to List</a>
        </div>

        <form method="post" enctype="multipart/form-data">
            <?php if (isset($_GET['id'])): ?>
                <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
            <?php endif; ?>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">First Name</label>
                    <input type="text" name="first_name" class="form-control" 
                           value="<?php echo htmlspecialchars($customer->first_name ?? ''); ?>" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Last Name</label>
                    <input type="text" name="last_name" class="form-control" 
                           value="<?php echo htmlspecialchars($customer->last_name ?? ''); ?>" required>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" 
                       value="<?php echo htmlspecialchars($customer->email ?? ''); ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Phone</label>
                <input type="tel" name="phone" class="form-control" 
                       value="<?php echo htmlspecialchars($customer->phone ?? ''); ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">Address</label>
                <textarea name="address" class="form-control" rows="3"><?php echo htmlspecialchars($customer->address ?? ''); ?></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">DNI Number</label>
                <input type="text" name="dni_number" class="form-control" 
                       value="<?php echo htmlspecialchars($customer->dni_number ?? ''); ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">DNI Image</label>
                <input type="file" name="dni_image" class="form-control">
                <?php if (!empty($customer->dni_image_url)): ?>
                    <div class="mt-2">
                        <img src="../../<?php echo htmlspecialchars($customer->dni_image_url); ?>" 
                             class="img-thumbnail" style="max-width: 200px;">
                    </div>
                <?php endif; ?>
            </div>

            <div class="mb-3">
                <button type="submit" class="btn btn-primary">Save Customer</button>
                <a href="manage-customers.php" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</body>
</html>