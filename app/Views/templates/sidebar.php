
<nav id="sidebar" class="sidebar">
    <div class="sidebar-sticky">
        <div class="sidebar-header p-3 border-bottom">
            <h6 class="mb-0 text-uppercase text-primary">
                <i class="fas fa-tachometer-alt me-2"></i>
                Main Navigation
            </h6>
        </div>
        
        <ul class="nav flex-column mt-3">
            <li class="nav-item">
                <a class="nav-link <?= current_url() == base_url('/dashboard') ? 'active' : '' ?>" href="<?= base_url('/dashboard') ?>">
                    <i class="fas fa-home"></i>
                    Dashboard
                </a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link <?= strpos(current_url(), '/pwd-profiles') !== false ? 'active' : '' ?>" href="<?= base_url('/pwd-profiles') ?>">
                    <i class="fas fa-users"></i>
                    PWD Profiles
                </a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link <?= strpos(current_url(), '/assistance') !== false ? 'active' : '' ?>" href="<?= base_url('/assistance') ?>">
                    <i class="fas fa-hands-helping"></i>
                    Assistance
                </a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link <?= strpos(current_url(), '/reports') !== false ? 'active' : '' ?>" href="<?= base_url('/reports') ?>">
                    <i class="fas fa-chart-bar"></i>
                    Reports
                </a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link <?= strpos(current_url(), '/admin') !== false ? 'active' : '' ?>" href="<?= base_url('/admin/audit-log') ?>">
                    <i class="fas fa-clipboard-list"></i>
                    Audit Log
                </a>
            </li>
        </ul>
        
        <div class="sidebar-footer mt-auto p-3 border-top">
            <div class="d-grid">
                <a href="<?= base_url('/admin/profile') ?>" class="btn btn-outline-primary btn-sm">
                    <i class="fas fa-user-cog me-1"></i>
                    Profile Settings
                </a>
            </div>
        </div>
    </div>
</nav>