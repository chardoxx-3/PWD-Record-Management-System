<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'PWD Record Management System' ?></title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="<?= base_url('css/bootstrap.min.css') ?>">
    <!-- Custom CSS -->
<style>
    :root {
        --primary-color: #1e3a8a;
        --primary-dark: #1e40af;
        --primary-light: #3b82f6;
        --secondary-color: #64748b;
        --accent-color: #f8fafc;
        --text-dark: #1e293b;
        --text-light: #64748b;
        --border-color: #e2e8f0;
        --success-color: #10b981;
        --warning-color: #f59e0b;
        --danger-color: #ef4444;
    }

    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #f8fafc;
        color: var(--text-dark);
        line-height: 1.6;
        overflow-x: hidden;
    }

    .navbar-custom {
        background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
        box-shadow: 0 2px 10px rgba(30, 58, 138, 0.1);
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        z-index: 1030;
        height: 56px;
    }

    .navbar-brand {
        font-weight: 700;
        font-size: 1.5rem;
    }

    /* Wrapper for sidebar and main content */
    .wrapper {
        display: flex;
        width: 100%;
        align-items: stretch;
        margin-top: 56px; /* Height of navbar */
        min-height: calc(100vh - 56px);
    }

    .sidebar {
        background: white;
        box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
        min-height: calc(100vh - 56px);
        width: 250px;
        transition: all 0.3s;
        position: fixed;
        left: 0;
        top: 56px;
        bottom: 0;
        overflow-y: auto;
        z-index: 1020;
    }

    .sidebar.collapsed {
        margin-left: -250px;
    }

    .main-content {
        margin-left: 250px;
        padding: 20px;
        transition: all 0.3s;
        width: calc(100% - 250px);
        min-height: calc(100vh - 56px);
    }

    .main-content.expanded {
        margin-left: 0;
        width: 100%;
    }

    .sidebar .nav-link {
        color: var(--text-dark);
        padding: 12px 20px;
        margin: 2px 0;
        border-radius: 8px;
        transition: all 0.3s;
        font-weight: 500;
    }

    .sidebar .nav-link:hover {
        background-color: var(--primary-light);
        color: white;
    }

    .sidebar .nav-link.active {
        background-color: var(--primary-color);
        color: white;
    }

    .sidebar .nav-link i {
        width: 20px;
        margin-right: 10px;
    }

    .card-custom {
        border: none;
        border-radius: 12px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        transition: all 0.3s;
        border-left: 4px solid var(--primary-color);
    }

    .card-custom:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
    }

.btn-primary-custom {
    background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
    border: none;
    border-radius: 8px;
    padding: 10px 20px;
    font-weight: 600;
    transition: all 0.3s;
    color: white; /* Add this line to make text white */
}

.btn-primary-custom:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(30, 58, 138, 0.3);
    color: white; /* Ensure text stays white on hover too */
}

    .table-custom th {
        background-color: var(--primary-color);
        color: white;
        border: none;
        font-weight: 600;
    }

    .table-custom td {
        border-color: var(--border-color);
        vertical-align: middle;
    }

    .stat-card {
        background: white;
        border-radius: 12px;
        padding: 20px;
        text-align: center;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        border-left: 4px solid var(--primary-color);
    }

    .stat-number {
        font-size: 2.5rem;
        font-weight: 700;
        color: var(--primary-color);
        margin-bottom: 0;
    }

    .stat-label {
        color: var(--text-light);
        font-weight: 500;
        margin-bottom: 0;
    }

    .alert-custom {
        border: none;
        border-radius: 8px;
        border-left: 4px solid;
    }

    .login-container {
        min-height: 100vh;
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .login-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        width: 100%;
        max-width: 400px;
    }

    .form-control-custom {
        border: 2px solid var(--border-color);
        border-radius: 8px;
        padding: 12px 15px;
        transition: all 0.3s;
    }

    .form-control-custom:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.2rem rgba(30, 58, 138, 0.1);
    }

    .badge-custom {
        padding: 6px 12px;
        border-radius: 20px;
        font-weight: 500;
    }

    /* Fix for sidebar sticky footer */
    .sidebar-sticky {
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .sidebar-footer {
        margin-top: auto;
    }

    @media (max-width: 768px) {
        .sidebar {
            margin-left: -250px;
            z-index: 1040;
        }
        
        .sidebar.show {
            margin-left: 0;
        }
        
        .main-content {
            margin-left: 0;
            width: 100%;
        }
        
        .wrapper {
            margin-top: 56px;
        }
    }
    .main-content {
    margin-left: 250px;
    padding: 20px;
    transition: all 0.3s;
    width: calc(100% - 250px);
    min-height: calc(100vh - 56px);
    padding-top: 60px; /* Add this line - increased padding to account for navbar */
}

</style>
</head>
<body>
    <?php if (session()->get('isLoggedIn')): ?>
        <!-- Navigation will be included here -->
        <?= $this->include('templates/navigation') ?>
        
        <div class="container-fluid">
            <div class="row">
                <!-- Sidebar -->
                <?= $this->include('templates/sidebar') ?>
                
                <!-- Main content -->
                <main class="main-content col">
                    <!-- Content will be rendered here -->
                    <?= $this->renderSection('content') ?>
                </main>
            </div>
        </div>
    <?php else: ?>
        <!-- For login page -->
        <?= $this->renderSection('content') ?>
    <?php endif; ?>



<div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 9999;"></div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    
    <!-- Custom JS -->
<script>
    // Toggle sidebar on mobile
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.querySelector('.main-content');
        sidebar.classList.toggle('show');
        
        // Optional: Add overlay for mobile
        if (sidebar.classList.contains('show')) {
            createOverlay();
        } else {
            removeOverlay();
        }
    }

    // Create overlay for mobile sidebar
    function createOverlay() {
        const overlay = document.createElement('div');
        overlay.className = 'sidebar-overlay';
        overlay.style.cssText = `
            position: fixed;
            top: 56px;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.5);
            z-index: 1010;
        `;
        overlay.onclick = toggleSidebar;
        document.body.appendChild(overlay);
    }

    function removeOverlay() {
        const overlay = document.querySelector('.sidebar-overlay');
        if (overlay) {
            overlay.remove();
        }
    }

    // Auto-hide alerts after 5 seconds
    document.addEventListener('DOMContentLoaded', function() {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            setTimeout(() => {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }, 5000);
        });
    });

    // Form validation enhancement
    document.addEventListener('DOMContentLoaded', function() {
        const forms = document.querySelectorAll('form');
        forms.forEach(form => {
            form.addEventListener('submit', function() {
                const submitBtn = this.querySelector('button[type="submit"]');
                if (submitBtn) {
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
                }
            });
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
    const toastEl = document.getElementById('liveToast');
    const toastMessage = document.getElementById('toastMessage');
    
    // Check for toast message in session
    const toastData = <?= json_encode(session()->getFlashdata('toast')) ?>;
    
    if (toastData) {
        // Set toast message and type
        toastMessage.textContent = toastData.message;
        
        // Customize toast based on type
        const toastHeader = toastEl.querySelector('.toast-header');
        const icon = toastHeader.querySelector('i');
        
        switch(toastData.type) {
            case 'success':
                icon.className = 'fas fa-check-circle me-2 text-success';
                break;
            case 'error':
                icon.className = 'fas fa-exclamation-circle me-2 text-danger';
                break;
            case 'warning':
                icon.className = 'fas fa-exclamation-triangle me-2 text-warning';
                break;
            case 'info':
                icon.className = 'fas fa-info-circle me-2 text-info';
                break;
        }
        
        // Show the toast
        const toast = new bootstrap.Toast(toastEl);
        toast.show();
    }
    
    // Auto-hide success toasts after 5 seconds
    if (toastData && toastData.type === 'success') {
        setTimeout(() => {
            const toast = bootstrap.Toast.getInstance(toastEl);
            if (toast) {
                toast.hide();
            }
        }, 5000);
    }
});

// Toast notification system
class ToastManager {
    constructor() {
        this.container = document.querySelector('.toast-container');
        this.init();
    }
    
    init() {
        // Check for session toasts
        const toastData = <?= json_encode(session()->getFlashdata('toast')) ?>;
        if (toastData) {
            this.show(toastData.message, toastData.type);
        }
    }
    
    show(message, type = 'info') {
        const toastId = 'toast-' + Date.now();
        const toastHtml = `
            <div id="${toastId}" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header">
                    <i class="${this.getIcon(type)} me-2"></i>
                    <strong class="me-auto">${this.getTitle(type)}</strong>
                    <small>Just now</small>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">
                    ${message}
                </div>
            </div>
        `;
        
        this.container.insertAdjacentHTML('beforeend', toastHtml);
        const toastElement = document.getElementById(toastId);
        const toast = new bootstrap.Toast(toastElement);
        
        // Auto-hide success toasts after 5 seconds
        if (type === 'success') {
            setTimeout(() => toast.hide(), 5000);
        }
        
        toast.show();
        
        // Remove from DOM after hide
        toastElement.addEventListener('hidden.bs.toast', () => {
            toastElement.remove();
        });
    }
    
    getIcon(type) {
        const icons = {
            'success': 'fas fa-check-circle text-success',
            'error': 'fas fa-exclamation-circle text-danger',
            'warning': 'fas fa-exclamation-triangle text-warning',
            'info': 'fas fa-info-circle text-info'
        };
        return icons[type] || icons.info;
    }
    
    getTitle(type) {
        const titles = {
            'success': 'Success',
            'error': 'Error',
            'warning': 'Warning',
            'info': 'Information'
        };
        return titles[type] || titles.info;
    }
}

// Initialize toast manager when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    window.toastManager = new ToastManager();
});



</script>
    
    <?= $this->renderSection('scripts') ?>
</body>
</html>