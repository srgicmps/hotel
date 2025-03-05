<?php
$root = $_SERVER['DOCUMENT_ROOT'];
include($root . '/student062/dwes/src/connect_db.php');

$search_query = '';
if (isset($_GET['search'])) {
        $search_query = mysqli_real_escape_string($conn, $_GET['search']);
}

$sql = 'SELECT r.*, u.user_name, u.user_surname, u.user_email, u.user_phone, u.user_username, u.user_id_card, u.user_category, ro.room_number, rc.room_category_name, rc.price_per_night, rc.max_occupancy, rc.description
        FROM 062_reservations AS r 
        JOIN 062_users AS u ON r.user_id = u.user_id
        JOIN 062_rooms AS ro ON r.room_id = ro.room_id
        JOIN 062_room_categories AS rc ON ro.room_category_id = rc.room_category_id';
if (!empty($search_query)) {
        $sql .= " WHERE r.reservation_number LIKE '%$search_query%' OR r.reservation_id LIKE '%$search_query%' OR u.user_name LIKE '%$search_query%' OR u.user_surname LIKE '%$search_query%' OR rc.room_category_name LIKE '%$search_query%'";
}

$result = mysqli_query($conn, $sql);

$reservations = mysqli_fetch_all($result, MYSQLI_ASSOC);

mysqli_free_result($result);
mysqli_close($conn);

header('Content-Type: application/json');
echo json_encode($reservations);
