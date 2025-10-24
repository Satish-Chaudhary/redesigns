<?php
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_id']) || empty($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

require_once '../includes/db.php';
require_once '../includes/functions.php';

// Process add/edit/delete menu item
$message = '';
$message_type = '';

// Add new menu item
if (isset($_POST['add_menu_item'])) {
    $name = sanitize_input($_POST['name']);
    $category = sanitize_input($_POST['category']);
    $price = sanitize_input($_POST['price']);
    $description = sanitize_input($_POST['description']);
    
    // Handle image upload
    $image = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $target_dir = "../assets/images/menu/";
        $image = basename($_FILES["image"]["name"]);
        $target_file = $target_dir . $image;
        
        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if ($check !== false) {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                // Image uploaded successfully
            } else {
                $message = "Sorry, there was an error uploading your file.";
                $message_type = "danger";
            }
        } else {
            $message = "File is not an image.";
            $message_type = "danger";
        }
    } else {
        $message = "Please select an image for the menu item.";
        $message_type = "danger";
    }
    
    if (empty($message) || $message_type != "danger") {
        $stmt = $conn->prepare("INSERT INTO menu_items (name, category, price, description, image) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssdss", $name, $category, $price, $description, $image);
        
        if ($stmt->execute()) {
            $message = "Menu item added successfully!";
            $message_type = "success";
        } else {
            $message = "Error: " . $stmt->error;
            $message_type = "danger";
        }
        
        $stmt->close();
    }
}

// Edit menu item
if (isset($_POST['edit_menu_item'])) {
    $id = sanitize_input($_POST['id']);
    $name = sanitize_input($_POST['name']);
    $category = sanitize_input($_POST['category']);
    $price = sanitize_input($_POST['price']);
    $description = sanitize_input($_POST['description']);
    $existing_image = sanitize_input($_POST['existing_image']);
    
    // Handle image upload
    $image = $existing_image;
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $target_dir = "../assets/images/menu/";
        $image = basename($_FILES["image"]["name"]);
        $target_file = $target_dir . $image;
        
        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if ($check !== false) {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                // Image uploaded successfully
            } else {
                $message = "Sorry, there was an error uploading your file.";
                $message_type = "danger";
            }
        } else {
            $message = "File is not an image.";
            $message_type = "danger";
        }
    }
    
    if (empty($message) || $message_type != "danger") {
        $stmt = $conn->prepare("UPDATE menu_items SET name = ?, category = ?, price = ?, description = ?, image = ? WHERE id = ?");
        $stmt->bind_param("ssdssi", $name, $category, $price, $description, $image, $id);
        
        if ($stmt->execute()) {
            $message = "Menu item updated successfully!";
            $message_type = "success";
        } else {
            $message = "Error: " . $stmt->error;
            $message_type = "danger";
        }
        
        $stmt->close();
    }
}

// Delete menu item
if (isset($_GET['delete'])) {
    $id = sanitize_input($_GET['delete']);
    
    // Get image name before deleting
    $stmt = $conn->prepare("SELECT image FROM menu_items WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $image = $row['image'];
    $stmt->close();
    
    // Delete menu item
    $stmt = $conn->prepare("DELETE FROM menu_items WHERE id = ?");
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        // Delete image file
        if (!empty($image) && file_exists("../assets/images/menu/" . $image)) {
            unlink("../assets/images/menu/" . $image);
        }
        
        $message = "Menu item deleted successfully!";
        $message_type = "success";
    } else {
        $message = "Error: " . $stmt->error;
        $message_type = "danger";
    }
    
    $stmt->close();
}

// Get all menu items
$menu_items_query = "SELECT * FROM menu_items ORDER BY category, name";
$menu_items_result = $conn->query($menu_items_query);

// Get categories
$categories_query = "SELECT DISTINCT category FROM menu_items ORDER BY category";
$categories_result = $conn->query($categories_query);
$categories = [];
while ($row = $categories_result->fetch_assoc()) {
    $categories[] = $row['category'];
}

// Get menu item to edit
$edit_item = null;
if (isset($_GET['edit'])) {
    $id = sanitize_input($_GET['edit']);
    $stmt = $conn->prepare("SELECT * FROM menu_items WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $edit_item = $result->fetch_assoc();
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Menu - Mama Mia Restaurant</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>
    <div class="admin-container">
        <!-- Sidebar -->
        <div class="admin-sidebar">
            <div class="sidebar-header">
                <img src="../assets/images/logo.png" alt="Mama Mia Restaurant" height="40">
                <h4>Admin Panel</h4>
            </div>
            
            <ul class="sidebar-menu">
                <li>
                    <a href="dashboard.php">
                        <i class="fas fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="active">
                    <a href="manage_menu.php">
                        <i class="fas fa-utensils"></i>
                        <span>Manage Menu</span>
                    </a>
                </li>
                <li>
                    <a href="manage_reservations.php">
                        <i class="fas fa-calendar-check"></i>
                        <span>Reservations</span>
                    </a>
                </li>
                <li>
                    <a href="manage_offers.php">
                        <i class="fas fa-tags"></i>
                        <span>Offers</span>
                    </a>
                </li>
                <li>
                    <a href="manage_messages.php">
                        <i class="fas fa-envelope"></i>
                        <span>Messages</span>
                    </a>
                </li>
                <li>
                    <a href="logout.php">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Logout</span>
                    </a>
                </li>
            </ul>
        </div>
        
        <!-- Main Content -->
        <div class="admin-content">
            <!-- Topbar -->
            <div class="admin-topbar">
                <div class="topbar-left">
                    <h2>Manage Menu</h2>
                </div>
                <div class="topbar-right">
                    <span>Welcome, <?php echo $_SESSION['admin_username']; ?></span>
                    <a href="../index.php" class="btn btn-sm btn-outline-primary" target="_blank">
                        <i class="fas fa-external-link-alt"></i> View Website
                    </a>
                </div>
            </div>
            
            <!-- Menu Content -->
            <div class="menu-content">
                <?php if (!empty($message)): ?>
                    <div class="alert alert-<?php echo $message_type; ?> alert-dismissible fade show" role="alert">
                        <?php echo $message; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
                
                <!-- Add/Edit Menu Item Form -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5><?php echo $edit_item ? 'Edit Menu Item' : 'Add New Menu Item'; ?></h5>
                    </div>
                    <div class="card-body">
                        <form action="manage_menu.php" method="post" enctype="multipart/form-data">
                            <?php if ($edit_item): ?>
                                <input type="hidden" name="id" value="<?php echo $edit_item['id']; ?>">
                                <input type="hidden" name="existing_image" value="<?php echo $edit_item['image']; ?>">
                            <?php endif; ?>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label">Item Name</label>
                                    <input type="text" class="form-control" id="name" name="name" value="<?php echo $edit_item ? $edit_item['name'] : ''; ?>" required>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="category" class="form-label">Category</label>
                                    <select class="form-select" id="category" name="category" required>
                                        <option value="" selected disabled>Select Category</option>
                                        <?php foreach ($categories as $category): ?>
                                            <option value="<?php echo $category; ?>" <?php echo ($edit_item && $edit_item['category'] == $category) ? 'selected' : ''; ?>>
                                                <?php echo $category; ?>
                                            </option>
                                        <?php endforeach; ?>
                                        <option value="new">+ Add New Category</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="price" class="form-label">Price (₹)</label>
                                    <input type="number" class="form-control" id="price" name="price" step="0.01" value="<?php echo $edit_item ? $edit_item['price'] : ''; ?>" required>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="image" class="form-label">Image</label>
                                    <input type="file" class="form-control" id="image" name="image" accept="image/*" <?php echo !$edit_item ? 'required' : ''; ?>>
                                    <?php if ($edit_item && !empty($edit_item['image'])): ?>
                                        <div class="mt-2">
                                            <img src="../assets/images/menu/<?php echo $edit_item['image']; ?>" alt="<?php echo $edit_item['name']; ?>" height="50">
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" id="description" name="description" rows="3" required><?php echo $edit_item ? $edit_item['description'] : ''; ?></textarea>
                            </div>
                            
                            <div class="text-end">
                                <?php if ($edit_item): ?>
                                    <a href="manage_menu.php" class="btn btn-secondary">Cancel</a>
                                    <button type="submit" name="edit_menu_item" class="btn btn-primary">Update Item</button>
                                <?php else: ?>
                                    <button type="submit" name="add_menu_item" class="btn btn-primary">Add Item</button>
                                <?php endif; ?>
                            </div>
                        </form>
                    </div>
                </div>
                
                <!-- Menu Items Table -->
                <div class="card">
                    <div class="card-header">
                        <h5>Menu Items</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>Category</th>
                                        <th>Price</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($menu_items_result->num_rows > 0): ?>
                                        <?php while ($row = $menu_items_result->fetch_assoc()): ?>
                                            <tr>
                                                <td>
                                                    <?php if (!empty($row['image']) && file_exists("../assets/images/menu/" . $row['image'])): ?>
                                                        <img src="../assets/images/menu/<?php echo $row['image']; ?>" alt="<?php echo $row['name']; ?>" height="50">
                                                    <?php else: ?>
                                                        <img src="https://via.placeholder.com/50" alt="No Image" height="50">
                                                    <?php endif; ?>
                                                </td>
                                                <td><?php echo $row['name']; ?></td>
                                                <td><?php echo $row['category']; ?></td>
                                                <td>₹<?php echo number_format($row['price'], 2); ?></td>
                                                <td>
                                                    <a href="manage_menu.php?edit=<?php echo $row['id']; ?>" class="btn btn-sm btn-primary">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <a href="manage_menu.php?delete=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this item?');">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endwhile; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="5" class="text-center">No menu items found</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom JS -->
    <script src="../assets/js/admin.js"></script>
</body>
</html>