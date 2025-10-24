<?php
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_id']) || empty($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

require_once '../includes/db.php';
require_once '../includes/functions.php';

// Process add/edit/delete offer
$message = '';
$message_type = '';

// Add new offer
if (isset($_POST['add_offer'])) {
    $title = sanitize_input($_POST['title']);
    $description = sanitize_input($_POST['description']);
    $discount = sanitize_input($_POST['discount']);
    $valid_till = sanitize_input($_POST['valid_till']);
    
    $stmt = $conn->prepare("INSERT INTO offers (title, description, discount, valid_till) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $title, $description, $discount, $valid_till);
    
    if ($stmt->execute()) {
        $message = "Offer added successfully!";
        $message_type = "success";
    } else {
        $message = "Error: " . $stmt->error;
        $message_type = "danger";
    }
    
    $stmt->close();
}

// Edit offer
if (isset($_POST['edit_offer'])) {
    $id = sanitize_input($_POST['id']);
    $title = sanitize_input($_POST['title']);
    $description = sanitize_input($_POST['description']);
    $discount = sanitize_input($_POST['discount']);
    $valid_till = sanitize_input($_POST['valid_till']);
    
    $stmt = $conn->prepare("UPDATE offers SET title = ?, description = ?, discount = ?, valid_till = ? WHERE id = ?");
    $stmt->bind_param("ssssi", $title, $description, $discount, $valid_till, $id);
    
    if ($stmt->execute()) {
        $message = "Offer updated successfully!";
        $message_type = "success";
    } else {
        $message = "Error: " . $stmt->error;
        $message_type = "danger";
    }
    
    $stmt->close();
}

// Delete offer
if (isset($_GET['delete'])) {
    $id = sanitize_input($_GET['delete']);
    
    $stmt = $conn->prepare("DELETE FROM offers WHERE id = ?");
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        $message = "Offer deleted successfully!";
        $message_type = "success";
    } else {
        $message = "Error: " . $stmt->error;
        $message_type = "danger";
    }
    
    $stmt->close();
}

// Get all offers
$offers_query = "SELECT * FROM offers ORDER BY valid_till DESC";
$offers_result = $conn->query($offers_query);

// Get offer to edit
$edit_offer = null;
if (isset($_GET['edit'])) {
    $id = sanitize_input($_GET['edit']);
    $stmt = $conn->prepare("SELECT * FROM offers WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $edit_offer = $result->fetch_assoc();
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Offers - Mama Mia Restaurant</title>
    
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
                <li>
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
                <li class="active">
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
                    <h2>Manage Offers</h2>
                </div>
                <div class="topbar-right">
                    <span>Welcome, <?php echo $_SESSION['admin_username']; ?></span>
                    <a href="../index.php" class="btn btn-sm btn-outline-primary" target="_blank">
                        <i class="fas fa-external-link-alt"></i> View Website
                    </a>
                </div>
            </div>
            
            <!-- Offers Content -->
            <div class="offers-content">
                <?php if (!empty($message)): ?>
                    <div class="alert alert-<?php echo $message_type; ?> alert-dismissible fade show" role="alert">
                        <?php echo $message; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
                
                <!-- Add/Edit Offer Form -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5><?php echo $edit_offer ? 'Edit Offer' : 'Add New Offer'; ?></h5>
                    </div>
                    <div class="card-body">
                        <form action="manage_offers.php" method="post">
                            <?php if ($edit_offer): ?>
                                <input type="hidden" name="id" value="<?php echo $edit_offer['id']; ?>">
                            <?php endif; ?>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="title" class="form-label">Offer Title</label>
                                    <input type="text" class="form-control" id="title" name="title" value="<?php echo $edit_offer ? $edit_offer['title'] : ''; ?>" required>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="discount" class="form-label">Discount</label>
                                    <input type="text" class="form-control" id="discount" name="discount" value="<?php echo $edit_offer ? $edit_offer['discount'] : ''; ?>" required>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" id="description" name="description" rows="3" required><?php echo $edit_offer ? $edit_offer['description'] : ''; ?></textarea>
                            </div>
                            
                            <div class="mb-3">
                                <label for="valid_till" class="form-label">Valid Until</label>
                                <input type="date" class="form-control" id="valid_till" name="valid_till" value="<?php echo $edit_offer ? $edit_offer['valid_till'] : ''; ?>" required>
                            </div>
                            
                            <div class="text-end">
                                <?php if ($edit_offer): ?>
                                    <a href="manage_offers.php" class="btn btn-secondary">Cancel</a>
                                    <button type="submit" name="edit_offer" class="btn btn-primary">Update Offer</button>
                                <?php else: ?>
                                    <button type="submit" name="add_offer" class="btn btn-primary">Add Offer</button>
                                <?php endif; ?>
                            </div>
                        </form>
                    </div>
                </div>
                
                <!-- Offers Table -->
                <div class="card">
                    <div class="card-header">
                        <h5>All Offers</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Description</th>
                                        <th>Discount</th>
                                        <th>Valid Until</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($offers_result->num_rows > 0): ?>
                                        <?php while ($row = $offers_result->fetch_assoc()): ?>
                                            <tr>
                                                <td><?php echo $row['title']; ?></td>
                                                <td><?php echo $row['description']; ?></td>
                                                <td><?php echo $row['discount']; ?></td>
                                                <td><?php echo date('d M Y', strtotime($row['valid_till'])); ?></td>
                                                <td>
                                                    <?php
                                                    $today = date('Y-m-d');
                                                    if ($row['valid_till'] >= $today) {
                                                        echo '<span class="badge bg-success">Active</span>';
                                                    } else {
                                                        echo '<span class="badge bg-danger">Expired</span>';
                                                    }
                                                    ?>
                                                </td>
                                                <td>
                                                    <a href="manage_offers.php?edit=<?php echo $row['id']; ?>" class="btn btn-sm btn-primary">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <a href="manage_offers.php?delete=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this offer?');">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endwhile; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="6" class="text-center">No offers found</td>
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