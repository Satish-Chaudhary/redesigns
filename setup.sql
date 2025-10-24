CREATE DATABASE IF NOT EXISTS mama_mia_restaurant2;
USE mama_mia_restaurant2;

-- Admin table
CREATE TABLE admin (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL
);

-- Menu items table
CREATE TABLE menu_items (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    category VARCHAR(50) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    description TEXT,
    image VARCHAR(255) NOT NULL
);

-- Reservations table
CREATE TABLE reservations (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    date DATE NOT NULL,
    time TIME NOT NULL,
    guests INT(11) NOT NULL,
    status VARCHAR(20) DEFAULT 'Pending'
);

-- Offers table
CREATE TABLE offers (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100) NOT NULL,
    description TEXT NOT NULL,
    discount VARCHAR(50) NOT NULL,
    valid_till DATE NOT NULL
);

-- Messages table
CREATE TABLE messages (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    subject VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert default admin user (password: admin123)
INSERT INTO admin (username, password_hash) VALUES 
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');

-- Insert sample menu items
INSERT INTO menu_items (name, category, price, description, image) VALUES
('Garlic Bread', 'Starters', 5.99, 'Freshly baked bread with garlic butter and herbs', 'garlic-bread.jpg'),
('Caesar Salad', 'Starters', 8.99, 'Crisp romaine lettuce with Caesar dressing, croutons, and parmesan', 'caesar-salad.jpg'),
('Margherita Pizza', 'Main Course', 12.99, 'Classic pizza with tomato sauce, mozzarella, and basil', 'margherita-pizza.jpg'),
('Grilled Salmon', 'Main Course', 18.99, 'Fresh salmon grilled to perfection with lemon butter sauce', 'grilled-salmon.jpg'),
('Tiramisu', 'Desserts', 7.99, 'Classic Italian dessert with coffee-soaked ladyfingers and mascarpone', 'tiramisu.jpg'),
('Chocolate Lava Cake', 'Desserts', 8.99, 'Warm chocolate cake with a molten center, served with vanilla ice cream', 'chocolate-lava.jpg'),
('Soft Drinks', 'Beverages', 2.99, 'Coca-Cola, Sprite, Fanta, or Iced Tea', 'soft-drinks.jpg'),
('House Wine', 'Beverages', 8.99, 'Glass of red or white wine', 'house-wine.jpg');

-- Insert sample offers
INSERT INTO offers (title, description, discount, valid_till) VALUES
('Happy Hour', '20% off on all cocktails from 5 PM to 7 PM', '20%', '2023-12-31'),
('Weekend Brunch', 'Special brunch menu with complimentary mimosa', 'Free Mimosa', '2023-12-31'),
('Family Deal', '20% off for families of 4 or more', '20%', '2023-12-31');