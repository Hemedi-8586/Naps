<?php 
$role = strtolower($auth_user['role_name'] ?? 'citizen'); 
$currentPage = $viewFile ?? 'home'; 
?>

<div class="d-flex flex-column h-100 shadow-lg" style="background: #0f172a;">
    
    <div class="sidebar-header p-4 border-bottom border-secondary border-opacity-25">
        <a href="/naps/dashboard/home" class="text-decoration-none d-flex align-items-center">
            <i class="bi bi-shield-lock-fill text-primary fs-3 me-2"></i>
            <span class="fw-bold text-white fs-4">NAPS<span class="text-primary">.</span></span>
        </a>
    </div>

    <div class="nav-menu py-3 px-2 flex-grow-1 overflow-auto">
        
        <small class="text-uppercase text-muted opacity-50 px-3 mb-2 d-block" style="font-size: 0.65rem; letter-spacing: 1px;">Main Menu</small>
        
        <a href="/naps/dashboard" class="nav-link mb-1 p-3 rounded-3 d-flex align-items-center <?= ($currentPage == 'home') ? 'active-link' : 'text-white-50 hover-effect' ?>">
            <i class="bi bi-grid-1x2 me-3"></i> Dashboard
        </a>    

        <?php if ($role === 'citizen') : ?>
            <small class="text-uppercase text-muted opacity-50 px-3 mt-4 mb-2 d-block" style="font-size: 0.65rem; letter-spacing: 1px;">Service Portal</small>
            
            <a href="/naps/citizen/apply" class="nav-link mb-1 p-3 rounded-3 d-flex align-items-center <?= ($currentPage == 'apply') ? 'active-link' : 'text-white-50 hover-effect' ?>">
                <i class="bi bi-file-earmark-plus me-3"></i> Service Applications
            </a>


        <a href="/naps/profile" class="nav-link mb-1 p-3 rounded-3 d-flex align-items-center <?= ($currentPage == 'profile') ? 'active-link' : 'text-white-50 hover-effect' ?>">
            <i class="bi bi-person-badge me-3"></i> My Profile
        </a>


            <a href="/naps/citizen/applications" class="nav-link mb-1 p-3 rounded-3 d-flex align-items-center <?= ($currentPage == 'history') ? 'active-link' : 'text-white-50 hover-effect' ?>">
                <i class="bi bi-clock-history me-3"></i> Application History
            </a>

            <a href="/naps/citizen/payments" class="nav-link mb-1 p-3 rounded-3 d-flex align-items-center <?= ($currentPage == 'payments') ? 'active-link' : 'text-white-50 hover-effect' ?>">
                <i class="bi bi-credit-card-2-front me-3"></i> My Payments
            </a>

            <small class="text-uppercase text-muted opacity-50 px-3 mt-4 mb-2 d-block" style="font-size: 0.65rem; letter-spacing: 1px;">Security & Support</small>
            
            <a href="/naps/citizen/notifications" class="nav-link mb-1 p-3 rounded-3 d-flex align-items-center <?= ($currentPage == 'notifications') ? 'active-link' : 'text-white-50 hover-effect' ?>">
                <i class="bi bi-bell me-3"></i> Notifications
            </a>

            <a href="/naps/citizen/activity" class="nav-link mb-1 p-3 rounded-3 d-flex align-items-center <?= ($currentPage == 'activity') ? 'active-link' : 'text-white-50 hover-effect' ?>">
                <i class="bi bi-journal-text me-3"></i> Activity Log
            </a>

            <a href="/naps/settings" class="nav-link mb-1 p-3 rounded-3 d-flex align-items-center <?= ($currentPage == 'settings') ? 'active-link' : 'text-white-50 hover-effect' ?>">
                <i class="bi bi-gear me-3"></i> Account Settings
            </a>

            <a href="/naps/support" class="nav-link mb-1 p-3 rounded-3 d-flex align-items-center <?= ($currentPage == 'help') ? 'active-link' : 'text-white-50 hover-effect' ?>">
                <i class="bi bi-question-circle me-3"></i> Help & Support
            </a>
        <?php endif; ?>

        <?php if ($role === 'staff') : ?>
            <small class="text-uppercase text-muted opacity-50 px-3 mt-4 mb-2 d-block" style="font-size: 0.65rem; letter-spacing: 1px;">Staff Portal</small>
            
            <a href="/naps/staff/review" class="nav-link mb-1 p-3 rounded-3 d-flex align-items-center <?= ($currentPage == 'review') ? 'active-link' : 'text-white-50 hover-effect' ?>">
                <i class="bi bi-clipboard-check me-3"></i> Review Applications
            </a>


        <a href="/naps/staff/profile" class="nav-link mb-1 p-3 rounded-3 d-flex align-items-center <?= ($currentPage == 'profile') ? 'active-link' : 'text-white-50 hover-effect' ?>">
            <i class="bi bi-person-badge me-3"></i> My Profile
        </a>

            <a href="/naps/staff/reports" class="nav-link mb-1 p-3 rounded-3 d-flex align-items-center <?= ($currentPage == 'reports') ? 'active-link' : 'text-white-50 hover-effect' ?>">
                <i class="bi bi-bar-chart me-3"></i> Service Reports
            </a>

            <small class="text-uppercase text-muted opacity-50 px-3 mt-4 mb-2 d-block" style="font-size: 0.65rem; letter-spacing: 1px;">Account</small>
            <a href="/naps/settings" class="nav-link mb-1 p-3 rounded-3 d-flex align-items-center <?= ($currentPage == 'settings') ? 'active-link' : 'text-white-50 hover-effect' ?>">
                <i class="bi bi-gear me-3"></i> Account Settings
            </a>
        <?php endif; ?>

        <?php if ($role === 'admin'): ?>
            <small class="text-uppercase text-muted opacity-50 px-3 mt-4 mb-2 d-block" style="font-size: 0.65rem; letter-spacing: 1px;">Administration</small>
            
            <div class="nav-item">
                <a class="nav-link mb-1 p-3 rounded-3 d-flex align-items-center justify-content-between hover-effect <?= ($currentPage == 'users') ? 'active-link' : 'text-white-50' ?>" 
                   data-bs-toggle="collapse" href="#userTasksDrop" role="button">
                    <span><i class="bi bi-people me-3"></i> User Management</span>
                    <i class="bi bi-chevron-down small"></i>
                </a>
                
                <div class="collapse <?= ($currentPage == 'users') ? 'show' : '' ?>" id="userTasksDrop">
                    <div class="ps-4 mt-1">
                        <a href="/naps/admin/users" class="nav-link py-2 d-flex align-items-center <?= ($currentPage == 'users') ? 'text-primary fw-bold' : 'text-white-50 opacity-75 hover-text-white' ?>" style="font-size: 0.85rem;">
                            <i class="bi bi-dot me-2"></i> View Users
                        </a>
                    </div>
                </div>
            </div>

            <small class="text-uppercase text-muted opacity-50 px-3 mt-4 mb-2 d-block" style="font-size: 0.65rem; letter-spacing: 1px;">System Settings</small>
            <a href="/naps/settings" class="nav-link mb-1 p-3 rounded-3 d-flex align-items-center <?= ($currentPage == 'settings') ? 'active-link' : 'text-white-50 hover-effect' ?>">
                <i class="bi bi-gear me-3"></i> Account Settings
            </a>
        <?php endif; ?>  
    </div>

    <div class="p-3 border-top border-secondary border-opacity-25">
        <a href="/naps/logout" class="nav-link text-danger p-3 rounded-3 d-flex align-items-center hover-danger">
            <i class="bi bi-box-arrow-right me-3"></i> Logout
        </a>
    </div>
</div>