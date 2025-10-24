<?php
include 'includes/header.php';

// Check if reservation was successful
if (!isset($_SESSION['reservation_success']) || $_SESSION['reservation_success'] !== true) {
    header("Location: reservation.php");
    exit();
}

// Unset the session variable
unset($_SESSION['reservation_success']);
?>

<!-- Page Header -->
<section class="page-header" style="background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('assets/images/success-bg.jpg');">
    <div class="container">
        <div class="page-header-content">
            <h1>Reservation Confirmed</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item"><a href="reservation.php">Reservation</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Confirmation</li>
                </ol>
            </nav>
        </div>
    </div>
</section>

<!-- Confirmation Section -->
<section class="confirmation-section section-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="confirmation-card">
                    <div class="confirmation-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <h2>Reservation Confirmed!</h2>
                    <p>Thank you for choosing Mama Mia Restaurant. Your table has been successfully reserved. A confirmation email has been sent to your registered email address.</p>
                    
                    <div class="confirmation-details">
                        <h3>Reservation Details</h3>
                        <div class="detail-item">
                            <span class="detail-label">Date:</span>
                            <span class="detail-value"><?php echo isset($_SESSION['reservation_date']) ? $_SESSION['reservation_date'] : ''; ?></span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Time:</span>
                            <span class="detail-value"><?php echo isset($_SESSION['reservation_time']) ? $_SESSION['reservation_time'] : ''; ?></span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Number of Guests:</span>
                            <span class="detail-value"><?php echo isset($_SESSION['reservation_guests']) ? $_SESSION['reservation_guests'] : ''; ?></span>
                        </div>
                    </div>
                    
                    <div class="confirmation-info">
                        <h3>Important Information</h3>
                        <ul>
                            <li>Please arrive 10 minutes before your reservation time</li>
                            <li>If you need to cancel or modify your reservation, please call us at least 2 hours in advance</li>
                            <li>For parties of 8 or more, please contact us directly for special arrangements</li>
                            <li>Our dress code is smart casual</li>
                        </ul>
                    </div>
                    
                    <div class="confirmation-actions">
                        <a href="index.php" class="btn btn-outline-primary">Back to Home</a>
                        <a href="menu.php" class="btn btn-primary">View Menu</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>