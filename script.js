// Smooth scroll untuk anchor links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function(e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    });
});

// Form validation helper
function validateForm(formId) {
    const form = document.getElementById(formId);
    if (!form) return true;

    const inputs = form.querySelectorAll('input[required], select[required], textarea[required]');
    let valid = true;

    inputs.forEach(input => {
        if (!input.value.trim()) {
            input.classList.add('error');
            valid = false;
        } else {
            input.classList.remove('error');
        }
    });

    return valid;
}

// Format currency
function formatCurrency(amount) {
    return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR'
    }).format(amount);
}

// Show notification
function showNotification(message, type = 'info', duration = 3000) {
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.textContent = message;
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 1rem;
        border-radius: 4px;
        background: ${type === 'success' ? '#d4edda' : type === 'error' ? '#f8d7da' : '#d1ecf1'};
        color: ${type === 'success' ? '#155724' : type === 'error' ? '#721c24' : '#0c5460'};
        z-index: 9999;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    `;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.remove();
    }, duration);
}

// Close alert
document.querySelectorAll('[data-dismiss]').forEach(button => {
    button.addEventListener('click', function() {
        this.parentElement.remove();
    });
});

// Initialize date picker with minimum date as today
document.querySelectorAll('input[type="date"]').forEach(input => {
    input.setAttribute('min', new Date().toISOString().split('T')[0]);
});

// Mobile menu toggle
function toggleMobileMenu() {
    const menu = document.querySelector('.navbar-menu');
    menu?.classList.toggle('active');
}

// Handle form submissions
document.querySelectorAll('form').forEach(form => {
    form.addEventListener('submit', function(e) {
        // Add loading state if needed
        const submitBtn = this.querySelector('button[type="submit"]');
        if (submitBtn) {
            submitBtn.disabled = true;
            submitBtn.textContent = 'Loading...';
        }
    });
});

// Handle modal close
document.querySelectorAll('.modal-close').forEach(button => {
    button.addEventListener('click', function() {
        this.closest('.modal')?.classList.remove('active');
    });
});

// Close modal on background click
document.querySelectorAll('.modal').forEach(modal => {
    modal.addEventListener('click', function(e) {
        if (e.target === this) {
            this.classList.remove('active');
        }
    });
});

// Add active class to current navbar link
document.addEventListener('DOMContentLoaded', function() {
    const currentLocation = location.pathname;
    const menuItems = document.querySelectorAll('.navbar-menu a');
    
    menuItems.forEach(item => {
        if (item.getAttribute('href') === currentLocation) {
            item.classList.add('active');
        }
    });

    // Admin sidebar
    const adminMenuItems = document.querySelectorAll('.menu-item');
    adminMenuItems.forEach(item => {
        const href = item.getAttribute('href');
        if (window.location.href.includes(href) && href !== '#') {
            item.classList.add('active');
        }
    });
});

// Handle filter buttons
document.querySelectorAll('.filter-buttons .btn').forEach(btn => {
    if (btn.href === window.location.href) {
        btn.classList.add('btn-primary');
        btn.classList.remove('btn-secondary');
    }
});

// Confirm delete action
function confirmDelete(message = 'Apakah Anda yakin ingin menghapus?') {
    return confirm(message);
}

// Dynamic table sorting
function sortTable(columnIndex) {
    const table = document.querySelector('.admin-table');
    if (!table) return;

    const rows = Array.from(table.querySelectorAll('tbody tr'));
    const isAscending = table.dataset.sortColumn === columnIndex && table.dataset.ascending === 'true';

    rows.sort((a, b) => {
        const cellA = a.cells[columnIndex].textContent.trim();
        const cellB = b.cells[columnIndex].textContent.trim();

        if (!isNaN(cellA) && !isNaN(cellB)) {
            return isAscending ? cellB - cellA : cellA - cellB;
        }

        return isAscending ? cellB.localeCompare(cellA) : cellA.localeCompare(cellB);
    });

    rows.forEach(row => table.querySelector('tbody').appendChild(row));

    table.dataset.sortColumn = columnIndex;
    table.dataset.ascending = !isAscending;
}

// Input masking untuk phone number
document.querySelectorAll('input[type="tel"]').forEach(input => {
    input.addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        if (value.length > 12) {
            value = value.slice(0, 12);
        }
        e.target.value = value;
    });
});

// Prevent form double submission
document.querySelectorAll('form').forEach(form => {
    form.addEventListener('submit', function(e) {
        const submitBtn = this.querySelector('button[type="submit"]');
        if (submitBtn) {
            submitBtn.disabled = true;
        }
    });
});

console.log('Rantaugrafi - Photography Vendor System v1.0');
