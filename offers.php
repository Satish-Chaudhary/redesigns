<?php
require_once 'includes/db.php';
$pageTitle = 'Special Offers - Mama Mia Restaurant';
include 'includes/header.php';
?>

<section class="container">
    <h2>Special Offers</h2>
    
    <div class="offers-grid">
        <div class="offer-card">
            <h3>Weekend Special</h3>
            <p class="discount">20% OFF</p>
            <p>Every Saturday & Sunday on all pasta dishes</p>
            <p><small>Valid until end of month</small></p>
        </div>
        
        <div class="offer-card">
            <h3>Family Feast</h3>
            <p class="discount">$49.99</p>
            <p>Complete family meal for 4 people</p>
            <p><small>Includes appetizer, main course, and dessert</small></p>
        </div>
        
        <div class="offer-card">
            <h3>Happy Hour</h3>
            <p class="discount">Buy 1 Get 1</p>
            <p>On selected beverages 4-6 PM daily</p>
            <p><small>Monday to Friday</small></p>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
