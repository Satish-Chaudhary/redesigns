<?php
include 'includes/header.php';
?>

<!-- Page Header -->
<section class="page-header" style="background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('assets/images/gallery-bg.jpg');">
    <div class="container">
        <div class="page-header-content">
            <h1>Gallery</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Gallery</li>
                </ol>
            </nav>
        </div>
    </div>
</section>

<!-- Gallery Section -->
<section class="gallery-section section-padding">
    <div class="container">
        <div class="section-title">
            <h2>Our Gallery</h2>
            <p>Take a visual tour of Mama Mia Restaurant</p>
        </div>
        
        <!-- Gallery Filter -->
        <div class="gallery-filter">
            <ul class="filter-list">
                <li class="filter-btn active" data-filter="all">All</li>
                <li class="filter-btn" data-filter="restaurant">Restaurant</li>
                <li class="filter-btn" data-filter="food">Food</li>
                <li class="filter-btn" data-filter="events">Events</li>
                <li class="filter-btn" data-filter="team">Team</li>
            </ul>
        </div>
        
        <!-- Gallery Grid -->
        <div class="gallery-grid">
            <div class="row">
                <!-- Restaurant Images -->
                <div class="col-md-4 gallery-item" data-category="restaurant">
                    <div class="gallery-inner">
                        <img src="assets/images/gallery/restaurant1.jpg" alt="Restaurant Interior" class="img-fluid">
                        <div class="gallery-overlay">
                            <div class="gallery-info">
                                <h4>Main Dining Area</h4>
                                <p>Elegant and sophisticated ambiance</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4 gallery-item" data-category="restaurant">
                    <div class="gallery-inner">
                        <img src="assets/images/gallery/restaurant2.jpg" alt="Restaurant Exterior" class="img-fluid">
                        <div class="gallery-overlay">
                            <div class="gallery-info">
                                <h4>Exterior View</h4>
                                <p>Welcoming entrance to Mama Mia</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4 gallery-item" data-category="restaurant">
                    <div class="gallery-inner">
                        <img src="assets/images/gallery/restaurant3.jpg" alt="Sports Lounge" class="img-fluid">
                        <div class="gallery-overlay">
                            <div class="gallery-info">
                                <h4>Sports Lounge</h4>
                                <p>Catch your favorite games here</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Food Images -->
                <div class="col-md-4 gallery-item" data-category="food">
                    <div class="gallery-inner">
                        <img src="assets/images/gallery/food1.jpg" alt="Italian Cuisine" class="img-fluid">
                        <div class="gallery-overlay">
                            <div class="gallery-info">
                                <h4>Italian Delights</h4>
                                <p>Authentic Italian pasta dishes</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4 gallery-item" data-category="food">
                    <div class="gallery-inner">
                        <img src="assets/images/gallery/food2.jpg" alt="Grilled Specialties" class="img-fluid">
                        <div class="gallery-overlay">
                            <div class="gallery-info">
                                <h4>Grilled Specialties</h4>
                                <p>Juicy grilled meats and seafood</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4 gallery-item" data-category="food">
                    <div class="gallery-inner">
                        <img src="assets/images/gallery/food3.jpg" alt="Desserts" class="img-fluid">
                        <div class="gallery-overlay">
                            <div class="gallery-info">
                                <h4>Decadent Desserts</h4>
                                <p>Sweet endings to your meal</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Events Images -->
                <div class="col-md-4 gallery-item" data-category="events">
                    <div class="gallery-inner">
                        <img src="assets/images/gallery/event1.jpg" alt="Live Music" class="img-fluid">
                        <div class="gallery-overlay">
                            <div class="gallery-info">
                                <h4>Live Music Nights</h4>
                                <p>Enjoy performances by local artists</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4 gallery-item" data-category="events">
                    <div class="gallery-inner">
                        <img src="assets/images/gallery/event2.jpg" alt="Private Events" class="img-fluid">
                        <div class="gallery-overlay">
                            <div class="gallery-info">
                                <h4>Private Events</h4>
                                <p>Host your special occasions with us</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4 gallery-item" data-category="events">
                    <div class="gallery-inner">
                        <img src="assets/images/gallery/event3.jpg" alt="Wine Tasting" class="img-fluid">
                        <div class="gallery-overlay">
                            <div class="gallery-info">
                                <h4>Wine Tasting Events</h4>
                                <p>Explore our curated wine selection</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Team Images -->
                <div class="col-md-4 gallery-item" data-category="team">
                    <div class="gallery-inner">
                        <img src="assets/images/gallery/team1.jpg" alt="Chef Team" class="img-fluid">
                        <div class="gallery-overlay">
                            <div class="gallery-info">
                                <h4>Our Chefs</h4>
                                <p>Culinary experts crafting your meals</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4 gallery-item" data-category="team">
                    <div class="gallery-inner">
                        <img src="assets/images/gallery/team2.jpg" alt="Service Team" class="img-fluid">
                        <div class="gallery-overlay">
                            <div class="gallery-info">
                                <h4>Service Team</h4>
                                <p>Dedicated to making your experience memorable</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4 gallery-item" data-category="team">
                    <div class="gallery-inner">
                        <img src="assets/images/gallery/team3.jpg" alt="Management Team" class="img-fluid">
                        <div class="gallery-overlay">
                            <div class="gallery-info">
                                <h4>Management Team</h4>
                                <p>Leading with passion and expertise</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Visit Us Section -->
<section class="visit-us section-padding bg-light">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h2>Visit Us Today</h2>
                <p>Experience the perfect blend of exquisite food, warm hospitality, and vibrant ambiance at Mama Mia Restaurant. Whether you're planning a romantic dinner, a family gathering, or a night out with friends, we have the perfect setting for you.</p>
                <p>Our team is dedicated to ensuring that every visit is memorable. From the moment you step through our doors to the last bite of your meal, we strive to exceed your expectations.</p>
                <a href="reservation.php" class="btn btn-primary">Book a Table</a>
            </div>
            <div class="col-lg-6">
                <div class="map-container">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3680.947913937319!2d75.89807931496156!3d22.7556780850924!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39631b4f746348b7%3A0x7d2a3a4a5a5a5a5a!2sVijay%20Nagar%2C%20Indore%2C%20Madhya%20Pradesh!5e0!3m2!1sen!2sin!4v1629264607123!5m2!1sen!2sin" allowfullscreen="" loading="lazy"></iframe>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>