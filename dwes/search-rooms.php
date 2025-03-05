<?php
$root = $_SERVER['DOCUMENT_ROOT'];
include($root . '/student062/dwes/includes/header.php');
include($root . '/student062/dwes/config/database.php');
include($root . '/student062/dwes/classes/Room.php');

if (!isset($_POST['check_in']) || !isset($_POST['check_out']) || !isset($_POST['guests'])) {
    header('Location: index.php');
    exit();
}

$check_in = $_POST['check_in'];
$check_out = $_POST['check_out'];
$guests = (int)$_POST['guests'];

$database = new Database();
$db = $database->getConnection();
$room = new Room($db);

$available_rooms = $room->getAvailableRooms($check_in, $check_out, $guests);
?>
<style>
    .search-results {
        background-color: #f8f9fa;
        min-height: 100vh;
        padding-top: 4rem;
    }
    
    .search-header {
        background: linear-gradient(135deg, #1e3d59 0%, #2b5876 100%);
        color: white;
        padding: 2rem 0;
        margin-bottom: 3rem;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    .room-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border: none;
        border-radius: 12px;
        overflow: hidden;
    }

    .room-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }

    .room-card .card-img-top {
        height: 240px;
        object-fit: cover;
    }

    .room-card .card-body {
        padding: 1.5rem;
    }

    .room-card .card-title {
        color: #1e3d59;
        font-size: 1.4rem;
        margin-bottom: 1rem;
    }

    .price-tag {
        background: #f8f9fa;
        padding: 0.5rem 1rem;
        border-radius: 8px;
    }

    .btn-book {
        background: #1e3d59;
        border: none;
        padding: 0.8rem 1.5rem;
        transition: all 0.3s ease;
    }

    .btn-book:hover {
        background: #15293d;
        transform: translateY(-2px);
    }

    .features-list {
        list-style: none;
        padding: 0;
        margin: 1rem 0;
    }

    .features-list li {
        margin-bottom: 0.5rem;
        color: #666;
    }

    .features-list i {
        color: #1e3d59;
        margin-right: 0.5rem;
        width: 20px;
    }
</style>

<div class="search-results">
    <div class="search-header">
        <div class="container">
            <h2 class="mb-2">Available Rooms</h2>
            <p class="mb-0">
                <i class="fas fa-calendar-alt me-2"></i>
                <?php 
                echo "From " . date('F j, Y', strtotime($check_in)) . 
                     " to " . date('F j, Y', strtotime($check_out)) . 
                     " · " . $guests . " guest" . ($guests > 1 ? 's' : ''); 
                ?>
            </p>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <?php if ($available_rooms && $available_rooms->rowCount() > 0): ?>
                <?php while ($room = $available_rooms->fetch(PDO::FETCH_ASSOC)): ?>
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card room-card">
                        <img src="<?php echo htmlspecialchars('/student062/dwes/assets/images/rooms/' . $room['image_url']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($room['type']); ?>" onerror="this.src='student062/dwes/assets/images/rooms/room.jpg'">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($room['type']); ?></h5>
                                
                                <ul class="features-list">
                                    <li><i class="fas fa-user-friends"></i> Up to <?php echo $room['capacity']; ?> guests</li>
                                    <li><i class="fas fa-wifi"></i> Free WiFi</li>
                                    <li><i class="fas fa-snowflake"></i> Air Conditioning</li>
                                </ul>

                                <p class="card-text small text-muted"><?php echo htmlspecialchars($room['description']); ?></p>
                                
                                <div class="d-flex justify-content-between align-items-center mt-4">
                                    <div class="price-tag">
                                        <strong class="h4 mb-0">€<?php echo number_format($room['price'], 2); ?></strong>
                                        <small class="text-muted d-block">per night</small>
                                    </div>
                                    <a href="book-room.php?room_id=<?php echo $room['id']; ?>&check_in=<?php echo $check_in; ?>&check_out=<?php echo $check_out; ?>&guests=<?php echo $guests; ?>" 
                                       class="btn btn-primary btn-book">
                                        <i class="fas fa-check me-2"></i>Select Room
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="col-12 text-center py-5">
                    <div class="alert alert-info d-inline-block">
                        <i class="fas fa-info-circle me-2"></i>
                        No rooms available for the selected dates and number of guests.
                        <br><br>
                        <a href="index.php" class="btn btn-outline-primary">
                            <i class="fas fa-arrow-left me-2"></i>Try different dates
                        </a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include($root . '/student062/dwes/includes/footer.php'); ?>