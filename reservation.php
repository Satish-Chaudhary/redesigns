<?php
include 'includes/header.php';
require_once 'includes/db.php';
require_once 'includes/functions.php';

// Process reservation form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = sanitize_input($_POST['name']);
    $email = sanitize_input($_POST['email']);
    $phone = sanitize_input($_POST['phone']);
    $date = sanitize_input($_POST['date']);
    $time = sanitize_input($_POST['time']);
    $guests = sanitize_input($_POST['guests']);
    
    // Validate input
    $errors = [];
    
    if (empty($name)) {
        $errors[] = "Name is required";
    }
    
    if (empty($email) || !validate_email($email)) {
        $errors[] = "Valid email is required";
    }
    
    if (empty($phone)) {
        $errors[] = "Phone number is required";
    }
    
    if (empty($date)) {
        $errors[] = "Date is required";
    }
    
    if (empty($time)) {
        $errors[] = "Time is required";
    }
    
    if (empty($guests) || $guests < 1) {
        $errors[] = "Number of guests is required";
    }
    
    // If no errors, proceed with reservation
    if (empty($errors)) {
        $stmt = $conn->prepare("INSERT INTO reservations (name, email, phone, date, time, guests) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssi", $name, $email, $phone, $date, $time, $guests);
        
        if ($stmt->execute()) {
            // Send confirmation email
            $subject = "Table Reservation Confirmation - Mama Mia Restaurant";
            $message = "
                <html>
                <head>
                    <title>Table Reservation Confirmation</title>
                </head>
                <body>
                    <h2>Thank you for your reservation, $name!</h2>
                    <p>Your table has been reserved at Mama Mia Restaurant with the following details:</p>
                    <ul>
                        <li><strong>Date:</strong> $date</li>
                        <li><strong>Time:</strong> $time</li>
                        <li><strong>Number of Guests:</strong> $guests</li>
                    </ul>
                    <p>We look forward to welcoming you to our restaurant. If you need to make any changes to your reservation, please call us at +91 12345 67890.</p>
                    <p>Best regards,<br>Mama Mia Restaurant Team</p>
                </body>
                </html>
            ";
            
            send_email($email, $subject, $message);
            
            // Redirect to confirmation page
            $_SESSION['reservation_success'] = true;
            header("Location: reservation-confirmation.php");
            exit();
        } else {
            $error_message = "Error: " . $stmt->error;
        }
        
        $stmt->close();
    }
}
?>

<!-- Page Header -->
<section class="page-header" style="background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('assets/images/reservation-bg.jpg');">
    <div class="container">
        <div class="page-header-content">
            <h1>Make a Reservation</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Reservation</li>
                </ol>
            </nav>
        </div>
    </div>
</section>

<!-- Reservation Section -->
<section class="reservation-section section-padding">
    <div class="container">
        <div class="section-title">
            <h2>Book Your Table</h2>
            <p>Reserve your table online and enjoy a memorable dining experience</p>
        </div>
        
        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo $error; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
        
        <?php if (isset($error_message)): ?>
            <div class="alert alert-danger">
                <?php echo $error_message; ?>
            </div>
        <?php endif; ?>
        
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="reservation-form-container">
                    <form action="reservation.php" method="post" class="needs-validation" novalidate>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Full Name</label>
                                <input type="text" class="form-control" id="name" name="name" value="<?php echo isset($_POST['name']) ? $_POST['name'] : ''; ?>" required>
                                <div class="invalid-feedback">
                                    Please provide your full name.
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>" required>
                                <div class="invalid-feedback">
                                    Please provide a valid email.
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label">Phone Number</label>
                                <input type="tel" class="form-control" id="phone" name="phone" value="<?php echo isset($_POST['phone']) ? $_POST['phone'] : ''; ?>" required>
                                <div class="invalid-feedback">
                                    Please provide your phone number.
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="guests" class="form-label">Number of Guests</label>
                                <select class="form-select" id="guests" name="guests" required>
                                    <option value="" selected disabled>Select</option>
                                    <option value="1" <?php echo (isset($_POST['guests']) && $_POST['guests'] == '1') ? 'selected' : ''; ?>>1 Person</option>
                                    <option value="2" <?php echo (isset($_POST['guests']) && $_POST['guests'] == '2') ? 'selected' : ''; ?>>2 People</option>
                                    <option value="3" <?php echo (isset($_POST['guests']) && $_POST['guests'] == '3') ? 'selected' : ''; ?>>3 People</option>
                                    <option value="4" <?php echo (isset($_POST['guests']) && $_POST['guests'] == '4') ? 'selected' : ''; ?>>4 People</option>
                                    <option value="5" <?php echo (isset($_POST['guests']) && $_POST['guests'] == '5') ? 'selected' : ''; ?>>5 People</option>
                                    <option value="6" <?php echo (isset($_POST['guests']) && $_POST['guests'] == '6') ? 'selected' : ''; ?>>6 People</option>
                                    <option value="7" <?php echo (isset($_POST['guests']) && $_POST['guests'] == '7') ? 'selected' : ''; ?>>7 People</option>
                                    <option value="8" <?php echo (isset($_POST['guests']) && $_POST['guests'] == '8') ? 'selected' : ''; ?>>8+ People</option>
                                </select>
                                <div class="invalid-feedback">
                                    Please select the number of guests.
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="date" class="form-label">Date</label>
                                <input type="date" class="form-control" id="date" name="date" value="<?php echo isset($_POST['date']) ? $_POST['date'] : ''; ?>" required>
                                <div class="invalid-feedback">
                                    Please select a date.
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="time" class="form-label">Time</label>
                                <input type="time" class="form-control" id="time" name="time" value="<?php echo isset($_POST['time']) ? $_POST['time'] : ''; ?>" required>
                                <div class="invalid-feedback">
                                    Please select a time.
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="special-requests" class="form-label">Special Requests (Optional)</label>
                            <textarea class="form-control" id="special-requests" name="special-requests" rows="3"><?php echo isset($_POST['special-requests']) ? $_POST['special-requests'] : ''; ?></textarea>
                        </div>
                        
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary btn-lg">Book Now</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Reservation Info Section -->
<section class="reservation-info section-padding bg-light">
    <div class="container">
        <div class="section-title">
            <h2>Reservation Information</h2>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="info-box">
                    <div class="icon-box">
                        <i class="fas fa-clock"></i>
                    </div>
                    <h3>Opening Hours</h3>
                    <p>Monday - Friday: 11:00 AM - 11:00 PM</p>
                    <p>Saturday - Sunday: 10:00 AM - 12:00 AM</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="info-box">
                    <div class="icon-box">
                        <i class="fas fa-phone-alt"></i>
                    </div>
                    <h3>Contact Us</h3>
                    <p>For reservations: +91 98765 43210</p>
                    <p>For inquiries: +91 12345 67890</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="info-box">
                    <div class="icon-box">
                        <i class="fas fa-info-circle"></i>
                    </div>
                    <h3>Reservation Policy</h3>
                    <p>Please arrive on time for your reservation</p>
                    <p>For parties of 8 or more, please call us directly</p>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>