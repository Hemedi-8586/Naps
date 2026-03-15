<div class="container-fluid py-4">
    <div class="row mb-4 align-items-center">
        <div class="col-md-7">
            <h4 class="fw-bold text-dark mb-1">
                <i class="bi bi-bell-fill text-primary me-2"></i>Notifications
            </h4>
            <p class="text-muted small mb-0">Manage your system alerts and latest updates.</p>
        </div>
        <div class="col-md-5 text-md-end mt-3 mt-md-0">
            <div class="btn-group shadow-sm">
                <button class="btn btn-white border btn-sm active">All</button>
                <button class="btn btn-white border btn-sm">Unread</button>
            </div>
            <button class="btn btn-primary btn-sm ms-2 shadow-sm" onclick="location.reload()">
                <i class="bi bi-arrow-clockwise"></i>
            </button>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="list-group list-group-flush">
                    <?php if (!empty($notifications)): foreach ($notifications as $n): ?>
                        <div class="list-group-item p-4 border-bottom position-relative <?= !$n['is_read'] ? 'bg-light-subtle shadow-none' : 'opacity-75' ?>" 
                             id="notif-row-<?= $n['id'] ?>" style="transition: all 0.3s ease;">
                            
                            <div class="d-flex align-items-start">
                                <div class="flex-shrink-0 me-3">
                                    <?php 
                                        $isPayment = str_contains(strtolower($n['message']), 'pay');
                                        $isApp = str_contains(strtolower($n['message']), 'permit');
                                    ?>
                                    <div class="rounded-circle d-flex align-items-center justify-content-center" 
                                         style="width: 45px; height: 45px; background: <?= !$n['is_read'] ? '#e7f1ff' : '#f8f9fa' ?>;">
                                        <i class="bi <?= $isPayment ? 'bi-credit-card text-success' : ($isApp ? 'bi-file-earmark-text text-primary' : 'bi-info-circle text-secondary') ?> fs-5"></i>
                                    </div>
                                </div>

                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <span class="small fw-bold text-uppercase tracking-wider <?= !$n['is_read'] ? 'text-primary' : 'text-muted' ?>" style="font-size: 0.7rem;">
                                            <?= $isPayment ? 'Payment Alert' : ($isApp ? 'Permit Update' : 'System Info') ?>
                                        </span>
                                        <span class="text-muted" style="font-size: 0.75rem;">
                                            <i class="bi bi-clock me-1"></i><?= date('d M, H:i', strtotime($n['created_at'])) ?>
                                        </span>
                                    </div>
                                    
                                    <h6 class="mb-1 <?= !$n['is_read'] ? 'fw-bold text-dark' : 'text-muted' ?>" style="line-height: 1.5;">
                                        <?= htmlspecialchars($n['message']) ?>
                                    </h6>
                                    
                                    <div class="mt-2 d-flex align-items-center">
                                        <?php if (!$n['is_read']): ?>
                                            <button class="btn btn-sm btn-link text-decoration-none p-0 fw-bold small" 
                                                    onclick="markAsRead(<?= $n['id'] ?>)">
                                                Mark as read
                                            </button>
                                            <span class="mx-2 text-light">|</span>
                                        <?php endif; ?>
                                        <a href="#" class="text-decoration-none small text-secondary">View details</a>
                                    </div>
                                </div>

                                <?php if (!$n['is_read']): ?>
                                    <div class="ms-3">
                                        <span class="p-1 bg-primary border border-light rounded-circle d-block animate__animated animate__pulse animate__infinite"></span>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; else: ?>
                        <div class="text-center py-5">
                            <div class="mb-3">
                                <i class="bi bi-chat-left-dots text-light" style="font-size: 5rem;"></i>
                            </div>
                            <h5 class="text-dark fw-bold">All caught up!</h5>
                            <p class="text-muted small">You don't have any new notifications at the moment.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-light-subtle { background-color: #f0f7ff !important; }
    .tracking-wider { letter-spacing: 0.05em; }
    .list-group-item:hover { background-color: #fcfcfc; }
</style>

<script>
function markAsRead(id) {
    const row = document.getElementById(`notif-row-${id}`);
    
    fetch('/naps/notifications/read', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: new URLSearchParams({ 'id': id })
    })
    .then(res => res.json())
    .then(data => {
        if (data.status === 'success') {
          
            row.style.opacity = '0.6';
            row.classList.remove('bg-light-subtle');
            const h6 = row.querySelector('h6');
            h6.classList.remove('fw-bold', 'text-dark');
            h6.classList.add('text-muted');
            
            const btn = row.querySelector('button');
            if(btn) btn.parentElement.remove();
            const dot = row.querySelector('.bg-primary.rounded-circle');
            if(dot) dot.remove();
        }
    })
    .catch(err => console.error("Error marking notification as read:", err));
}
</script>