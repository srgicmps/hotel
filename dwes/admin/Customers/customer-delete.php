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

// Check if ID parameter exists
if (!isset($_GET['id'])) {
    header("Location: manage-customers.php");
    exit();
}

$database = new Database();
$db = $database->getConnection();

$customer = new Customer($db);
$customer->id = $_GET['id'];

$customer->readOne();
$dni_image_path = "../../" . $customer->dni_image_url;

if ($customer->delete()) {
    if (!empty($customer->dni_image_url) && file_exists($dni_image_path)) {
        unlink($dni_image_path);
    }
    header("Location: manage-customers.php");
} else {
    echo "<!DOCTYPE html>
          <html lang='en'>
          <head>
              <meta charset='UTF-8'>
              <title>Error</title>
              <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css' rel='stylesheet'>
          </head>
          <body>
              <div class='container mt-5'>
                  <div class='alert alert-danger'>
                      Error deleting customer. They might have active reservations.
                  </div>
                  <a href='manage-customers.php' class='btn btn-primary'>Back to List</a>
              </div>
          </body>
          </html>";
}
?>