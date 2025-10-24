<?php
// Function to sanitize input data
function sanitize_input($data) {
    global $conn;
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $conn->real_escape_string($data);
}

// Function to validate email
function validate_email($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

// Function to send email
function send_email($to, $subject, $message, $headers = '') {
    if (empty($headers)) {
        $headers = "From: noreply@mamamiarestaurant.com\r\n";
        $headers .= "Reply-To: info@mamamiarestaurant.com\r\n";
        $headers .= "Content-type: text/html\r\n";
    }
    
    return mail($to, $subject, $message, $headers);
}

// Function to check if user is logged in
function is_admin_logged_in() {
    return isset($_SESSION['admin_id']) && !empty($_SESSION['admin_id']);
}

// Function to redirect to a page
function redirect($url) {
    header("Location: $url");
    exit();
}

// Function to display alert message
function display_alert($message, $type = 'success') {
    return "<div class='alert alert-$type alert-dismissible fade show' role='alert'>
        $message
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
    </div>";
}

// Function to get menu items by category
function get_menu_items_by_category($category) {
    global $conn;
    
    $stmt = $conn->prepare("SELECT * FROM menu_items WHERE category = ? ORDER BY name");
    $stmt->bind_param("s", $category);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $items = [];
    while ($row = $result->fetch_assoc()) {
        $items[] = $row;
    }
    
    $stmt->close();
    return $items;
}

// Function to get all active offers
function get_active_offers() {
    global $conn;
    
    $today = date('Y-m-d');
    $stmt = $conn->prepare("SELECT * FROM offers WHERE valid_till >= ? ORDER BY valid_till");
    $stmt->bind_param("s", $today);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $offers = [];
    while ($row = $result->fetch_assoc()) {
        $offers[] = $row;
    }
    
    $stmt->close();
    return $offers;
}
?>