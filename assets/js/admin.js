document.addEventListener('DOMContentLoaded', function() {
    // Toggle sidebar on mobile
    const sidebarToggle = document.createElement('button');
    sidebarToggle.className = 'btn btn-link d-lg-none';
    sidebarToggle.innerHTML = '<i class="fas fa-bars"></i>';
    sidebarToggle.style.position = 'fixed';
    sidebarToggle.style.top = '15px';
    sidebarToggle.style.left = '15px';
    sidebarToggle.style.zIndex = '1001';
    sidebarToggle.style.color = 'var(--dark-color)';
    
    document.querySelector('.admin-topbar').prepend(sidebarToggle);
    
    sidebarToggle.addEventListener('click', function() {
        document.querySelector('.admin-sidebar').classList.toggle('show');
    });
    
    // Close sidebar when clicking outside on mobile
    document.addEventListener('click', function(event) {
        const sidebar = document.querySelector('.admin-sidebar');
        const toggle = document.querySelector('.admin-topbar .btn-link');
        
        if (window.innerWidth <= 991 && 
            !sidebar.contains(event.target) && 
            !toggle.contains(event.target) && 
            sidebar.classList.contains('show')) {
            sidebar.classList.remove('show');
        }
    });
    
    // Form validation
    const forms = document.querySelectorAll('.needs-validation');
    
    forms.forEach(form => {
        form.addEventListener('submit', function(event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            
            form.classList.add('was-validated');
        }, false);
    });
    
    // Auto-hide alerts after 5 seconds
    const alerts = document.querySelectorAll('.alert');
    
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.classList.remove('show');
            
            setTimeout(() => {
                alert.remove();
            }, 150);
        }, 5000);
    });
    
    // Confirm delete actions
    const deleteButtons = document.querySelectorAll('.btn-danger');
    
    deleteButtons.forEach(button => {
        if (button.textContent.includes('Delete') || button.innerHTML.includes('fa-trash')) {
            button.addEventListener('click', function(event) {
                if (!confirm('Are you sure you want to delete this item?')) {
                    event.preventDefault();
                }
            });
        }
    });
    
    // Initialize date inputs with today's date as minimum
    const dateInputs = document.querySelectorAll('input[type="date"]');
    
    dateInputs.forEach(input => {
        const today = new Date();
        const dd = String(today.getDate()).padStart(2, '0');
        const mm = String(today.getMonth() + 1).padStart(2, '0');
        const yyyy = today.getFullYear();
        
        input.min = `${yyyy}-${mm}-${dd}`;
    });
    
    // Add active class to current menu item
    const currentPath = window.location.pathname;
    const menuItems = document.querySelectorAll('.sidebar-menu li');
    
    menuItems.forEach(item => {
        const link = item.querySelector('a');
        if (link && link.getAttribute('href') === currentPath.split('/').pop()) {
            item.classList.add('active');
        }
    });
});