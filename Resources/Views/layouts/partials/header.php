<header class="top-nav d-flex align-items-center justify-content-between bg-white border-bottom px-4 shadow-sm" 
        style="height: 70px; position: fixed; top: 0; right: 0; left: 260px; z-index: 1030; backdrop-filter: blur(10px); background: rgba(255, 255, 255, 0.85) !important;">
    
    <div class="d-flex align-items-center">
        <button class="btn btn-light d-md-none me-2 border-0 bg-transparent" id="sidebarToggle">
            <i class="bi bi-list fs-4"></i>
        </button>
        <div class="page-info">
            <h6 class="fw-bold mb-0 text-dark"><?= $title ?? 'Dashboard' ?></h6>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0" style="font-size: 0.7rem;">
                    <li class="breadcrumb-item"><a href="#" class="text-decoration-none text-muted">NAPS</a></li>
                    <li class="breadcrumb-item active text-primary" aria-current="page"><?= ucfirst($role) ?></li>
                </ol>
            </nav>
        </div>
    </div>
    
    <div class="user-profile d-flex align-items-center">
        <div class="d-none d-lg-block me-4">
            <div class="input-group input-group-sm">
                <span class="input-group-text bg-light border-0"><i class="bi bi-search text-muted"></i></span>
                <input type="text" class="form-control bg-light border-0" placeholder="Search here..." style="width: 200px;">
            </div>
        </div>

        <div class="dropdown">
            <button class="btn ... " id="notificationBtn" data-bs-toggle="dropdown">
                  <i class="bi bi-bell"></i>
             <span id="notif-badge" class="badge ... ">0</span>
         </button>
            
            <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg p-0 mt-2 overflow-hidden" style="width: 300px;">
                <li class="p-3 border-bottom d-flex justify-content-between align-items-center">
                    <span class="fw-bold">Notifications</span>
                    <span id="notif-count-text" class="badge bg-primary-subtle text-primary rounded-pill small">0 New</span>
                </li>
                
                <div id="notif-dropdown-list" class="notification-list" style="max-height: 300px; overflow-y: auto;">
                    <li class="p-4 text-center">
                        <div class="spinner-border spinner-border-sm text-primary" role="status"></div>
                        <p class="small text-muted mb-0 mt-2">Loading...</p>
                    </li>
                </div>
                
                <li>
                    <a class="dropdown-item text-center py-2 small text-primary fw-bold bg-light" href="/naps/citizen/notifications">
                        View All Notifications
                    </a>
                </li>
            </ul>
        </div>
        <div class="text-end me-3 d-none d-sm-block">
            <div class="text-dark fw-bold small lh-1 text-capitalize"><?= $auth_user['username'] ?></div>
            <div class="d-flex align-items-center justify-content-end mt-1">
                <span class="badge bg-primary bg-opacity-10 text-primary border border-primary-subtle rounded-pill" style="font-size: 0.6rem;">
                   <i class="bi bi-check-circle-fill me-1" style="font-size: 0.5rem;"></i>
                   <?= strtoupper($auth_user['role_name']) ?>
                </span>
            </div>
        </div>

        <div class="dropdown">
            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center shadow-sm" 
                 style="width: 42px; height: 42px; cursor: pointer; font-weight: bold; font-size: 1.1rem; border: 2px solid #fff;" 
                 data-bs-toggle="dropdown">
                <?= strtoupper(substr($auth_user['username'], 0, 1)) ?>
            </div>
            <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg mt-2 py-2" style="min-width: 200px;">
                <li class="px-3 py-2 border-bottom mb-2">
                    <p class="mb-0 small fw-bold text-dark"><?= $auth_user['username'] ?></p>
                    <p class="mb-0 text-muted" style="font-size: 0.65rem;">Hali: Online</p>
                </li>
                <li><a class="dropdown-item py-2" href="/naps/profile"><i class="bi bi-person me-2"></i> My profile</a></li>
                <li><a class="dropdown-item py-2" href="/naps/settings"><i class="bi bi-gear me-2"></i> Settings</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item text-danger py-2" href="/naps/logout"><i class="bi bi-box-arrow-right me-2"></i> Sign Out</a></li>
            </ul>
        </div>
    </div>
</header>

<script>
    const sidebarBtn = document.getElementById('sidebarToggle');
    if (sidebarBtn) {
        sidebarBtn.addEventListener('click', function() {
            const sidebar = document.querySelector('.sidebar-container');
            sidebar.style.display = sidebar.style.display === 'none' ? 'block' : 'none';
        });
    }
    document.addEventListener('DOMContentLoaded', function() {
        const token = localStorage.getItem('jwt_token');
        if (!token) return;

        const badge = document.getElementById('notif-badge');
        const countText = document.getElementById('notif-count-text');
        const list = document.getElementById('notif-dropdown-list');
        function updateCount() {
            fetch('/naps/notifications/count-unread', {
                headers: { 'Authorization': 'Bearer ' + token }
            })
            .then(res => res.json())
            .then(data => {
                if(data.count > 0) {
                    badge.innerText = data.count > 9 ? '9+' : data.count;
                    badge.style.display = 'block';
                    countText.innerText = data.count + ' New';
                } else {
                    badge.style.display = 'none';
                    countText.innerText = '0 New';
                }
            });
        }
        document.getElementById('notificationBtn').addEventListener('click', function() {
            fetch('/naps/notifications/latest', {
                headers: { 'Authorization': 'Bearer ' + token }
            })
            .then(res => res.json())
            .then(data => {
                list.innerHTML = '';
                if(data.notifications && data.notifications.length > 0) {
                    data.notifications.forEach(n => {
                        const isReadClass = n.is_read == 0 ? 'fw-bold bg-light' : 'text-muted';
                        const iconClass = n.message.toLowerCase().includes('pay') ? 'bi-credit-card text-success' : 'bi-info-circle text-primary';
                        
                        list.innerHTML += `
                            <li>
                                <a class="dropdown-item py-3 px-3 border-bottom d-flex align-items-start ${isReadClass}" href="/naps/dashboard/notifications">
                                    <div class="me-3">
                                        <div class="p-2 rounded-circle bg-white border shadow-sm" style="font-size: 0.8rem;">
                                            <i class="bi ${iconClass}"></i>
                                        </div>
                                    </div>
                                    <div style="white-space: normal;">
                                        <p class="mb-0 small">${n.message}</p>
                                        <small class="text-muted" style="font-size: 0.65rem;">Just now</small>
                                    </div>
                                </a>
                            </li>`;
                    });
                } else {
                    list.innerHTML = '<li class="p-4 text-center text-muted small">No notifications found</li>';
                }
            });
        });
        updateCount();
        
        setInterval(updateCount, 60000);
    });
    document.addEventListener('DOMContentLoaded', function() {
    const token = localStorage.getItem('jwt_token'); 
    const notifBtn = document.getElementById('notificationBtn');
    const notifList = document.getElementById('notif-dropdown-list');

    if (notifBtn) {
        notifBtn.addEventListener('click', function() {
            
            notifList.innerHTML = '<li class="p-3 text-center small text-muted">Loading...</li>';

            fetch('/naps/notifications/latest', {
                headers: { 'Authorization': 'Bearer ' + token }
            })
            .then(res => res.json())
            .then(data => {
                notifList.innerHTML = ''; 
                
                if (data.notifications && data.notifications.length > 0) {
                    data.notifications.forEach(n => {
                      
                        notifList.innerHTML += `
                            <li>
                                <a class="dropdown-item py-2 border-bottom ${n.is_read == 0 ? 'fw-bold bg-light' : ''}" href="/naps/dashboard/notifications">
                                    <small class="d-block text-wrap">${n.message}</small>
                                    <span style="font-size: 10px;" class="text-muted">${n.created_at}</span>
                                </a>
                            </li>`;
                    });
                } else {
                    notifList.innerHTML = '<li class="p-3 text-center small text-muted">No new notifications</li>';
                }
            })
            .catch(err => {
                notifList.innerHTML = '<li class="p-3 text-center text-danger small">Error loading notifications</li>';
            });
        });
    }
});
</script>