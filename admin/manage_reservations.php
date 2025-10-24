<?php
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_id']) || empty($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

require_once '../includes/db.php';
require_once '../includes/functions.php';

// Process update reservation status
$message = '';
$message_type = '';

if (isset($_POST['update_status'])) {
    $id = sanitize_input($_POST['id']);
    $status = sanitize_input($_POST['status']);
    
    $stmt = $conn->prepare("UPDATE reservations SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $status, $id);
    
    if ($stmt->execute()) {
        $message = "Reservation status updated successfully!";
        $message_type = "success";
    } else {
        $message = "Error: " . $stmt->error;
        $message_type = "danger";
    }
    
    $stmt->close();
}

// Get all reservations
$reservations_query = "SELECT * FROM reservations ORDER BY date DESC, time DESC";
$reservations_result = $conn->query($reservations_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Reservations - Mama Mia Restaurant</title>
    
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
                <li class="active">
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
                    <h2>Manage Reservations</h2>
                </div>
                <div class="topbar-right">
                    <span>Welcome, <?php echo $_SESSION['admin_username']; ?></span>
                    <a href="../index.php" class="btn btn-sm btn-outline-primary" target="_blank">
                        <i class="fas fa-external-link-alt"></i> View Website
                    </a>
                </div>
            </div>
            
            <!-- Reservations Content -->
            <div class="reservations-content">
                <?php if (!empty($message)): ?>
                    <div class="alert alert-<?php echo $message_type; ?> alert-dismissible fade show" role="alert">
                        <?php echo $message; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
                
                <!-- Reservations Table -->
                <div class="card">
                    <div class="card-header">
                        <h5>All Reservations</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Date</th>
                                        <th>Time</th>
                                        <th>Guests</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($reservations_result->num_rows > 0): ?>
                                        <?php while ($row = $reservations_result->fetch_assoc()): ?>
                                            <tr>
                                                <td><?php echo $row['id']; ?></td>
                                                <td><?php echo $row['name']; ?></td>
                                                <td><?php echo $row['email']; ?></td>
                                                <td><?php echo $row['phone']; ?></td>
                                                <td><?php echo date('d M Y', strtotime($row['date'])); ?></td>
                                                <td><?php echo date('h:i A', strtotime($row['time'])); ?></td>
                                                <td><?php echo $row['guests']; ?></td>
                                                <td>
                                                    <span class="badge <?php 
                                                        echo $row['status'] == 'Pending' ? 'bg-warning' : 
                                                            ($row['status'] == 'Confirmed' ? 'bg-success' : 
                                                            ($row['status'] == 'Cancelled' ? 'bg-danger' : 'bg-info')); 
                                                    ?>">
                                                        <?php echo $row['status']; ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-bs-toggle="dropdown">
                                                            Update Status
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            <li>
                                                                <form action="manage_reservations.php" method="post">
                                                                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                                                    <input type="hidden" name="status" value="Pending">
                                                                    <button type="submit" name="update_status" class="dropdown-item">Pending</button>
                                                                </form>
                                                            </li>
                                                            <li>
                                                                <form action="manage_reservations.php" method="post">
                                                                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                                                    <input type="hidden" name="status" value="Confirmed">
                                                                    <button type="submit" name="update_status" class="dropdown-item">Confirmed</button>
                                                                </form>
                                                            </li>
                                                            <li>
                                                                <form action="manage_reservations.php" method="post">
                                                                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                                                    <input type="hidden" name="status" value="Cancelled">
                                                                    <button type="submit" name="update_status" class="dropdown-item">Cancelled</button>
                                                                </form>
                                                            </li>
                                                            <li>
                                                                <form action="manage_reservations.php" method="post">
                                                                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                                                    <input type="hidden" name="status" value="Completed">
                                                                    <button type="submit" name="update_status" class="dropdown-item">Completed</button>
                                                                </form>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endwhile; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="9" class="text-center">No reservations found</td>
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