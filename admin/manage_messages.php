<?php
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_id']) || empty($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

require_once '../includes/db.php';
require_once '../includes/functions.php';

// Process delete message
$message = '';
$message_type = '';

if (isset($_GET['delete'])) {
    $id = sanitize_input($_GET['delete']);
    
    $stmt = $conn->prepare("DELETE FROM messages WHERE id = ?");
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        $message = "Message deleted successfully!";
        $message_type = "success";
    } else {
        $message = "Error: " . $stmt->error;
        $message_type = "danger";
    }
    
    $stmt->close();
}

// Get all messages
$messages_query = "SELECT * FROM messages ORDER BY created_at DESC";
$messages_result = $conn->query($messages_query);

// Get message to view
$view_message = null;
if (isset($_GET['view'])) {
    $id = sanitize_input($_GET['view']);
    $stmt = $conn->prepare("SELECT * FROM messages WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $view_message = $result->fetch_assoc();
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Messages - Mama Mia Restaurant</title>
    
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
                <li>
                    <a href="manage_offers.php">
                        <i class="fas fa-tags"></i>
                        <span>Offers</span>
                    </a>
                </li>
                <li class="active">
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
                    <h2>Manage Messages</h2>
                </div>
                <div class="topbar-right">
                    <span>Welcome, <?php echo $_SESSION['admin_username']; ?></span>
                    <a href="../index.php" class="btn btn-sm btn-outline-primary" target="_blank">
                        <i class="fas fa-external-link-alt"></i> View Website
                    </a>
                </div>
            </div>
            
            <!-- Messages Content -->
            <div class="messages-content">
                <?php if (!empty($message)): ?>
                    <div class="alert alert-<?php echo $message_type; ?> alert-dismissible fade show" role="alert">
                        <?php echo $message; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
                
                <?php if ($view_message): ?>
                    <!-- View Message -->
                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5>Message Details</h5>
                            <a href="manage_messages.php" class="btn btn-sm btn-secondary">Back to Messages</a>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <p><strong>Name:</strong> <?php echo $view_message['name']; ?></p>
                                    <p><strong>Email:</strong> <?php echo $view_message['email']; ?></p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Subject:</strong> <?php echo $view_message['subject']; ?></p>
                                    <p><strong>Date:</strong> <?php echo date('d M Y, h:i A', strtotime($view_message['created_at'])); ?></p>
                                </div>
                            </div>
                            <div class="mb-3">
                                <p><strong>Message:</strong></p>
                                <div class="message-content">
                                    <?php echo nl2br($view_message['message']); ?>
                                </div>
                            </div>
                            <div class="text-end">
                                <a href="mailto:<?php echo $view_message['email']; ?>?subject=Re: <?php echo urlencode($view_message['subject']); ?>" class="btn btn-primary">
                                    <i class="fas fa-reply"></i> Reply
                                </a>
                                <a href="manage_messages.php?delete=<?php echo $view_message['id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this message?');">
                                    <i class="fas fa-trash"></i> Delete
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                
                <!-- Messages Table -->
                <div class="card">
                    <div class="card-header">
                        <h5>All Messages</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Subject</th>
                                        <th>Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($messages_result->num_rows > 0): ?>
                                        <?php while ($row = $messages_result->fetch_assoc()): ?>
                                            <tr>
                                                <td><?php echo $row['id']; ?></td>
                                                <td><?php echo $row['name']; ?></td>
                                                <td><?php echo $row['email']; ?></td>
                                                <td><?php echo $row['subject']; ?></td>
                                                <td><?php echo date('d M Y', strtotime($row['created_at'])); ?></td>
                                                <td>
                                                    <a href="manage_messages.php?view=<?php echo $row['id']; ?>" class="btn btn-sm btn-primary">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="mailto:<?php echo $row['email']; ?>?subject=Re: <?php echo urlencode($row['subject']); ?>" class="btn btn-sm btn-success">
                                                        <i class="fas fa-reply"></i>
                                                    </a>
                                                    <a href="manage_messages.php?delete=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this message?');">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endwhile; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="6" class="text-center">No messages found</td>
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