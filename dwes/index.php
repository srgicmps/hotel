<?php
$root = $_SERVER['DOCUMENT_ROOT'];
include($root . '/student062/dwes/includes/header.php');
?>

<!-- admin123 -->
 <!-- password123 -->
<section class="hero">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <h1 class="hero-title">Experience Luxury & Comfort</h1>
                <p class="hero-subtitle">Your perfect getaway begins here</p>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="search-box">
                    <form action="search-rooms.php" method="post" class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label">Check In</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                <input type="text" class="form-control datepicker" name="check_in" placeholder="Select date" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Check Out</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                <input type="text" class="form-control datepicker" name="check_out" placeholder="Select date" required>
                            </div>
                        </div>
                            <div class="col-md-3">
                                <label class="form-label">Guests</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    <select class="form-control" name="guests" required>
                                        <option value="1">1 Guest</option>
                                        <option value="2" selected>2 Guests</option>
                                        <option value="3">3 Guests</option>
                                        <option value="4">4 Guests</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3 d-flex align-items-end">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fas fa-search"></i> Check Availability
                                </button>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="scroll-down">
        <i class="fas fa-chevron-down fa-2x"></i>
    </div>
</section>

<script>
     document.addEventListener('DOMContentLoaded', function() {
        const checkInPicker = flatpickr("input[name='check_in']", {
            enableTime: false,
            minDate: "today",
            dateFormat: "Y-m-d",
            altInput: true,
            altFormat: "F j, Y",
            onChange: function(selectedDates, dateStr) {
                if (selectedDates[0]) {
                    const nextDay = new Date(selectedDates[0]);
                    nextDay.setDate(nextDay.getDate() + 1);
                    checkOutPicker.set('minDate', nextDay);
                    
                    if (checkOutPicker.selectedDates[0] && checkOutPicker.selectedDates[0] <= selectedDates[0]) {
                        checkOutPicker.setDate(nextDay);
                    }
                }
            }
        });

        const checkOutPicker = flatpickr("input[name='check_out']", {
            enableTime: false,
            dateFormat: "Y-m-d",
            altInput: true,
            altFormat: "F j, Y",
            minDate: new Date().fp_incr(1)
        });

        if (checkInPicker.selectedDates[0]) {
            const nextDay = new Date(checkInPicker.selectedDates[0]);
            nextDay.setDate(nextDay.getDate() + 1);
            checkOutPicker.set('minDate', nextDay);
        }

        window.addEventListener('scroll', function() {
            if (window.scrollY > 50) {
                document.querySelector('.navbar').classList.add('scrolled');
            } else {
                document.querySelector('.navbar').classList.remove('scrolled');
            }
        });

        document.querySelector('.scroll-down').addEventListener('click', function() {
            window.scrollTo({
                top: window.innerHeight,
                behavior: 'smooth'
            });
        });
    });
</script>

<?php include($root . '/student062/dwes/includes/footer.php'); ?>