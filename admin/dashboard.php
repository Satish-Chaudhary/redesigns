<?php
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_id']) || empty($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

require_once '../includes/db.php';
require_once '../includes/functions.php';

// Get statistics for dashboard
$total_bookings_query = "SELECT COUNT(*) as total FROM reservations";
$total_bookings_result = $conn->query($total_bookings_query);
$total_bookings = $total_bookings_result->fetch_assoc()['total'];

$pending_bookings_query = "SELECT COUNT(*) as total FROM reservations WHERE status = 'Pending'";
$pending_bookings_result = $conn->query($pending_bookings_query);
$pending_bookings = $pending_bookings_result->fetch_assoc()['total'];

$total_menu_items_query = "SELECT COUNT(*) as total FROM menu_items";
$total_menu_items_result = $conn->query($total_menu_items_query);
$total_menu_items = $total_menu_items_result->fetch_assoc()['total'];

$total_messages_query = "SELECT COUNT(*) as total FROM messages";
$total_messages_result = $conn->query($total_messages_query);
$total_messages = $total_messages_result->fetch_assoc()['total'];

$total_offers_query = "SELECT COUNT(*) as total FROM offers";
$total_offers_result = $conn->query($total_offers_query);
$total_offers = $total_offers_result->fetch_assoc()['total'];

// Get recent reservations
$recent_reservations_query = "SELECT * FROM reservations ORDER BY id DESC LIMIT 5";
$recent_reservations_result = $conn->query($recent_reservations_query);

// Get recent messages
$recent_messages_query = "SELECT * FROM messages ORDER BY id DESC LIMIT 5";
$recent_messages_result = $conn->query($recent_messages_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Mama Mia Restaurant</title>
    
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
                <li class="active">
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
                    <h2>Dashboard</h2>
                </div>
                <div class="topbar-right">
                    <span>Welcome, <?php echo $_SESSION['admin_username']; ?></span>
                    <a href="../index.php" class="btn btn-sm btn-outline-primary" target="_blank">
                        <i class="fas fa-external-link-alt"></i> View Website
                    </a>
                </div>
            </div>
            
            <!-- Dashboard Content -->
            <div class="dashboard-content">
                <!-- Stats Cards -->
                <div class="row">
                    <div class="col-md-4">
                        <div class="stat-card">
                            <div class="stat-icon bg-primary">
                                <i class="fas fa-calendar-check"></i>
                            </div>
                            <div class="stat-info">
                                <h3><?php echo $total_bookings; ?></h3>
                                <p>Total Bookings</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="stat-card">
                            <div class="stat-icon bg-warning">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div class="stat-info">
                                <h3><?php echo $pending_bookings; ?></h3>
                                <p>Pending Bookings</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="stat-card">
                            <div class="stat-icon bg-info">
                                <i class="fas fa-utensils"></i>
                            </div>
                            <div class="stat-info">
                                <h3><?php echo $total_menu_items; ?></h3>
                                <p>Menu Items</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row mt-4">
                    <div class="col-md-4">
                        <div class="stat-card">
                            <div class="stat-icon bg-success">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div class="stat-info">
                                <h3><?php echo $total_messages; ?></h3>
                                <p>Messages</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="stat-card">
                            <div class="stat-icon bg-danger">
                                <i class="fas fa-tags"></i>
                            </div>
                            <div class="stat-info">
                                <h3><?php echo $total_offers; ?></h3>
                                <p>Active Offers</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Recent Reservations -->
                <div class="row mt-4">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h5>Recent Reservations</h5>
                                <a href="manage_reservations.php" class="btn btn-sm btn-primary">View All</a>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Date</th>
                                                <th>Time</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if ($recent_reservations_result->num_rows > 0): ?>
                                                <?php while ($row = $recent_reservations_result->fetch_assoc()): ?>
                                                    <tr>
                                                        <td><?php echo $row['name']; ?></td>
                                                        <td><?php echo date('d M Y', strtotime($row['date'])); ?></td>
                                                        <td><?php echo date('h:i A', strtotime($row['time'])); ?></td>
                                                        <td>
                                                            <span class="badge <?php echo $row['status'] == 'Pending' ? 'bg-warning' : 'bg-success'; ?>">
                                                                <?php echo $row['status']; ?>
                                                            </span>
                                                        </td>
                                                    </tr>
                                                <?php endwhile; ?>
                                            <?php else: ?>
                                                <tr>
                                                    <td colspan="4" class="text-center">No reservations found</td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Recent Messages -->
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h5>Recent Messages</h5>
                                <a href="manage_messages.php" class="btn btn-sm btn-primary">View All</a>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Subject</th>
                                                <th>Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if ($recent_messages_result->num_rows > 0): ?>
                                                <?php while ($row = $recent_messages_result->fetch_assoc()): ?>
                                                    <tr>
                                                        <td><?php echo $row['name']; ?></td>
                                                        <td><?php echo $row['email']; ?></td>
                                                        <td><?php echo $row['subject']; ?></td>
                                                        <td><?php echo date('d M Y', strtotime($row['created_at'])); ?></td>
                                                    </tr>
                                                <?php endwhile; ?>
                                            <?php else: ?>
                                                <tr>
                                                    <td colspan="4" class="text-center">No messages found</td>
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
        </div>
    </div>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom JS -->
    <script src="../assets/js/admin.js"></script>
</body>
</html>