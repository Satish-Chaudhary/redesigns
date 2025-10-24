<?php
include 'includes/header.php';
require_once 'includes/db.php';
require_once 'includes/functions.php';

// Get all menu categories
$categories_query = "SELECT DISTINCT category FROM menu_items ORDER BY category";
$categories_result = $conn->query($categories_query);
$categories = [];
while ($row = $categories_result->fetch_assoc()) {
    $categories[] = $row['category'];
}

// Get menu items by category
$menu_items = [];
foreach ($categories as $category) {
    $menu_items[$category] = get_menu_items_by_category($category);
}
?>

<!-- Page Header -->
<section class="page-header" style="background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('assets/images/menu-bg.jpg');">
    <div class="container">
        <div class="page-header-content">
            <h1>Our Menu</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Menu</li>
                </ol>
            </nav>
        </div>
    </div>
</section>

<!-- Menu Section -->
<section class="menu-section section-padding">
    <div class="container">
        <div class="section-title">
            <h2>Culinary Delights</h2>
            <p>Explore our diverse menu featuring cuisines from around the world</p>
        </div>
        
        <!-- Search Bar -->
        <div class="row mb-4">
            <div class="col-md-6 mx-auto">
                <div class="search-box">
                    <input type="text" id="menuSearch" class="form-control" placeholder="Search for dishes...">
                    <i class="fas fa-search"></i>
                </div>
            </div>
        </div>
        
        <!-- Menu Tabs -->
        <ul class="nav nav-tabs menu-tabs" id="menuTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="all-tab" data-bs-toggle="tab" data-bs-target="#all" type="button" role="tab" data-category="all">All</button>
            </li>
            <?php foreach ($categories as $category): ?>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="<?php echo strtolower(str_replace(' ', '-', $category)); ?>-tab" data-bs-toggle="tab" data-bs-target="#<?php echo strtolower(str_replace(' ', '-', $category)); ?>" type="button" role="tab" data-category="<?php echo $category; ?>"><?php echo $category; ?></button>
            </li>
            <?php endforeach; ?>
        </ul>
        
        <!-- Menu Content -->
        <div class="tab-content" id="menuTabsContent">
            <div class="tab-pane fade show active" id="all" role="tabpanel">
                <div class="row">
                    <?php foreach ($menu_items as $category_items): ?>
                        <?php foreach ($category_items as $item): ?>
                            <div class="col-md-4 menu-item" data-category="<?php echo $item['category']; ?>">
                                <div class="menu-item-card">
                                    <div class="menu-item-img">
                                        <img src="assets/images/menu/<?php echo $item['image']; ?>" alt="<?php echo $item['name']; ?>" class="img-fluid">
                                    </div>
                                    <div class="menu-item-content">
                                        <h4><?php echo $item['name']; ?></h4>
                                        <p><?php echo $item['description']; ?></p>
                                        <div class="menu-item-footer">
                                            <span class="menu-price">₹<?php echo number_format($item['price'], 2); ?></span>
                                            <button class="btn btn-sm btn-primary add-to-cart" data-id="<?php echo $item['id']; ?>" data-name="<?php echo $item['name']; ?>" data-price="<?php echo $item['price']; ?>">Add to Cart</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endforeach; ?>
                </div>
            </div>
            
            <?php foreach ($categories as $category): ?>
            <div class="tab-pane fade" id="<?php echo strtolower(str_replace(' ', '-', $category)); ?>" role="tabpanel">
                <div class="row">
                    <?php foreach ($menu_items[$category] as $item): ?>
                        <div class="col-md-4 menu-item" data-category="<?php echo $item['category']; ?>">
                            <div class="menu-item-card">
                                <div class="menu-item-img">
                                    <img src="assets/images/menu/<?php echo $item['image']; ?>" alt="<?php echo $item['name']; ?>" class="img-fluid">
                                </div>
                                <div class="menu-item-content">
                                    <h4><?php echo $item['name']; ?></h4>
                                    <p><?php echo $item['description']; ?></p>
                                    <div class="menu-item-footer">
                                        <span class="menu-price">₹<?php echo number_format($item['price'], 2); ?></span>
                                        <button class="btn btn-sm btn-primary add-to-cart" data-id="<?php echo $item['id']; ?>" data-name="<?php echo $item['name']; ?>" data-price="<?php echo $item['price']; ?>">Add to Cart</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        
        <!-- Today's Special -->
        <div class="today-special mt-5">
            <div class="section-title">
                <h2>Today's Special</h2>
            </div>
            <div class="row">
                <div class="col-md-6 mx-auto">
                    <div class="special-dish">
                        <div class="special-dish-img">
                            <img src="assets/images/special.jpg" alt="Today's Special" class="img-fluid">
                        </div>
                        <div class="special-dish-content">
                            <h3>Seafood Risotto</h3>
                            <p>Creamy Arborio rice cooked with fresh seafood, white wine, and herbs, finished with parmesan cheese</p>
                            <div class="special-dish-footer">
                                <span class="menu-price">₹<?php echo number_format(450, 2); ?></span>
                                <button class="btn btn-primary">Order Now</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Menu Download Section -->
<section class="menu-download section-padding bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 mx-auto text-center">
                <h2>Download Our Menu</h2>
                <p>Take our menu with you or share it with friends</p>
                <a href="#" class="btn btn-primary"><i class="fas fa-download"></i> Download PDF Menu</a>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>