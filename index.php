<?php
include 'includes/header.php';
?>

<!-- Hero Section -->
<section class="hero">
    <div class="container">
        <div class="hero-content">
            <h1>Mama Mia Restaurant</h1>
            <p>Eat. Drink. Chill. The Mama Mia Way.</p>
            <a href="menu.php" class="btn btn-primary">Explore Menu</a>
            <a href="reservation.php" class="btn btn-outline-light">Book a Table</a>
        </div>
    </div>
</section>

<!-- About Section -->
<section class="about section-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="about-img">
                    <img src="assets\images\about.webp" alt="About Mama Mia Restaurant" class="img-fluid">
                </div>
                <div class="chef-section">
                    <div class="text-center">
                        <img src="assets\images\chief.jpg" alt="Head Chef" class="chef-img">
                        <h4>Chef Antonio Rossi</h4>
                        <p>Head Chef with 20+ years of experience in international cuisine</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="about-content">
                    <h2>About Mama Mia Restaurant</h2>
                    <p>Welcome to Mama Mia Restaurant, a multi-cuisine fine dining and sports lounge located in the
                        heart of Vijay Nagar, Indore. Since our establishment, we've been dedicated to providing our
                        guests with exceptional culinary experiences in a vibrant and welcoming atmosphere.</p>
                    <p>Our mission is to delight your taste buds with our diverse menu featuring dishes from around the
                        world, prepared with the finest ingredients and a touch of innovation. Whether you're here for a
                        romantic dinner, a family gathering, or to catch the latest sports game, Mama Mia is the perfect
                        destination.</p>
                    <p>Our team of experienced chefs and friendly staff are committed to making your visit memorable. We
                        take pride in our warm hospitality, attention to detail, and the passion we pour into every dish
                        we serve.</p>

                </div>
            </div>
        </div>
    </div>
</section>

<!-- Menu Preview Section -->
<section class="menu-preview section-padding bg-light">
    <div class="container">
        <div class="section-title">
            <h2>Our Specialties</h2>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="menu-item">
                    <div class="menu-item-img">
                        <img src="assets/images/Truffle-Pasta.jpg" alt="Pasta" class="img-fluid">
                    </div>
                    <div class="menu-item-content">
                        <h4>Truffle Pasta</h4>
                        <p>Homemade pasta with black truffle sauce, parmesan, and fresh herbs</p>
                        <div class="menu-item-footer">
                            <span class="menu-price">$18.99</span>
                            <a href="menu.php" class="btn btn-sm btn-outline-primary">View Menu</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="menu-item">
                    <div class="menu-item-img">
                        <img src="assets/images/Grilled-Ribeye.jpg" alt="Steak" class="img-fluid">
                    </div>
                    <div class="menu-item-content">
                        <h4>Grilled Ribeye</h4>
                        <p>Premium ribeye steak grilled to perfection, served with roasted vegetables</p>
                        <div class="menu-item-footer">
                            <span class="menu-price">$24.99</span>
                            <a href="menu.php" class="btn btn-sm btn-outline-primary">View Menu</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="menu-item">
                    <div class="menu-item-img">
                        <img src="assets/images/Mama-Mia-Special.jpg" alt="Cocktail" class="img-fluid">
                    </div>
                    <div class="menu-item-content">
                        <h4>Mama Mia Special</h4>
                        <p>Our signature cocktail with premium spirits, fresh fruits, and exotic spices</p>
                        <div class="menu-item-footer">
                            <span class="menu-price">$12.99</span>
                            <a href="menu.php" class="btn btn-sm btn-outline-primary">View Menu</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-center mt-4">
            <a href="menu.php" class="btn btn-primary">View Full Menu</a>
        </div>
    </div>
</section>

<!-- Offers Section -->
<section class="offers section-padding">
    <div class="container">
        <div class="section-title">
            <h2>Current Offers</h2>
        </div>
        <div class="row">
            <?php
            require_once 'includes/db.php';
            require_once 'includes/functions.php';

            $offers = get_active_offers();

            if (count($offers) > 0) {
                foreach ($offers as $offer) {
                    echo '<div class="col-md-4">
                        <div class="offer-card">
                            <div class="offer-img">
                                <img src="assets/images/offer.jpg" alt="' . $offer['title'] . '" class="img-fluid">
                            </div>
                            <div class="offer-content">
                                <h3>' . $offer['title'] . '</h3>
                                <span class="offer-discount">' . $offer['discount'] . '</span>
                                <p>' . $offer['description'] . '</p>
                                <p class="offer-valid">Valid until: ' . date('F d, Y', strtotime($offer['valid_till'])) . '</p>
                            </div>
                        </div>
                    </div>';
                }
            } else {
                echo '<div class="col-12 text-center">
                    <p>No active offers at the moment. Check back soon!</p>
                </div>';
            }
            ?>
        </div>
        <div class="text-center mt-4">
            <a href="offers.php" class="btn btn-primary">View All Offers</a>
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section class="testimonials section-padding bg-light">
    <div class="container">
        <div class="section-title">
            <h2>What Our Customers Say</h2>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="testimonial-card">
                    <div class="testimonial-content">
                        <div class="rating">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <p>"Absolutely fantastic dining experience! The food was delicious, the service was impeccable,
                            and the ambiance was perfect for our anniversary dinner."</p>
                    </div>
                    <div class="testimonial-author">
                        <img src="assets/images/customer1.jpg" alt="Customer" class="img-fluid">
                        <div class='Name-title'>
                            <h5>Sarah Johnson</h5>
                            <p>Regular Customer</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="testimonial-card">
                    <div class="testimonial-content">
                        <div class="rating">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <p>"Best place in Indore to watch sports while enjoying great food and drinks. The atmosphere
                            during cricket matches is electric!"</p>
                    </div>
                    <div class="testimonial-author">
                        <img src="assets/images/customer2.jpg" alt="Customer" class="img-fluid">
                        <div class='Name-title'>
                            <h5>Rajesh Patel</h5>
                            <p>Sports Enthusiast</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="testimonial-card">
                    <div class="testimonial-content">
                        <div class="rating">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                        </div>
                        <p>"The pasta dishes are to die for! As an Italian food lover, I can say this is the most
                            authentic Italian cuisine I've had in Indore."</p>
                    </div>
                    <div class="testimonial-author">
                        <img src="assets/images/customer3.jpg" alt="Customer" class="img-fluid">
                        <div class='Name-title'>
                            <h5>Maria Garcia</h5>
                            <p>Food Blogger</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Reservation CTA Section -->
<section class="reservation-cta section-padding">
    <div class="container">
        <div class="reservation-cta-content text-center">
            <h2>Ready to Experience Mama Mia?</h2>
            <p>Book your table now and embark on a culinary journey like no other</p>
            <a href="reservation.php" class="btn btn-primary btn-lg">Book a Table</a>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>