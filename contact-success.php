<?php
include 'includes/header.php';

// Check if contact form was submitted successfully
if (!isset($_SESSION['contact_success']) || $_SESSION['contact_success'] !== true) {
    header("Location: contact.php");
    exit();
}

// Unset the session variable
unset($_SESSION['contact_success']);
?>

<!-- Page Header -->
<section class="page-header" style="background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('assets/images/success-bg.jpg');">
    <div class="container">
        <div class="page-header-content">
            <h1>Message Sent</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item"><a href="contact.php">Contact</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Success</li>
                </ol>
            </nav>
        </div>
    </div>
</section>

<!-- Success Section -->
<section class="success-section section-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="success-card">
                    <div class="success-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <h2>Message Sent Successfully!</h2>
                    <p>Thank you for contacting Mama Mia Restaurant. We have received your message and will get back to you as soon as possible. A confirmation email has been sent to your registered email address.</p>
                    
                    <div class="success-info">
                        <h3>What Happens Next?</h3>
                        <ul>
                            <li>Our team will review your message within 24 hours</li>
                            <li>We'll respond to your inquiry via email or phone call</li>
                            <li>For urgent matters, please call us directly at +91 12345 67890</li>
                        </ul>
                    </div>
                    
                    <div class="success-actions">
                        <a href="index.php" class="btn btn-outline-primary">Back to Home</a>
                        <a href="reservation.php" class="btn btn-primary">Book a Table</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>