MAMA MIA RESTAURANT - WEBSITE DOCUMENTATION
============================================

Thank you for choosing Mama Mia Restaurant Management System!

FOLDER STRUCTURE:
-----------------
admin/              - Admin panel files
assets/             - Static assets (CSS, JS, Images)
  css/              - Stylesheets
  js/               - JavaScript files
  images/           - Images and graphics
includes/           - PHP includes (database, header, footer, functions)
*.php               - Main website pages

SETUP INSTRUCTIONS:
-------------------
1. Database Setup:
   - Import setup.sql into your MySQL database
   - Update database credentials in includes/db.php

2. Admin Login:
   - URL: /admin/login.php
   - Default Username: admin
   - Default Password: admin123
   - IMPORTANT: Change the default password after first login!

3. Configuration:
   - Edit includes/db.php for database settings
   - Update contact information in footer and contact page
   - Add your restaurant images to assets/images/

FEATURES:
---------
- Responsive design for all devices
- Menu management system
- Online reservation system
- Special offers management
- Contact form
- Photo gallery
- Admin dashboard

PAGES:
------
Public Pages:
- index.php          - Home page
- about.php          - About us
- menu.php           - Menu listing
- offers.php         - Special offers
- reservation.php    - Reservation form
- gallery.php        - Photo gallery
- contact.php        - Contact form

Admin Pages:
- admin/login.php                - Admin login
- admin/dashboard.php            - Admin dashboard
- admin/manage_menu.php          - Menu management
- admin/manage_offers.php        - Offers management
- admin/manage_reservations.php  - Reservations management
- admin/manage_messages.php      - Messages management

CUSTOMIZATION:
--------------
- Colors: Edit assets/css/style.css and assets/css/admin.css
- Logo: Replace assets/images/logo.png
- Images: Add your images to assets/images/
- Menu Items: Use admin panel or edit database directly

SECURITY NOTES:
---------------
- Change default admin password immediately
- Keep database credentials secure
- Use HTTPS in production
- Implement proper password hashing
- Add CSRF protection for forms
- Validate and sanitize all inputs

SUPPORT:
--------
For questions or issues, please contact your developer.

VERSION: 1.0
DATE: 2025
