<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-md-12">
            <h4 class="fw-bold"><i class="bi bi-clock-history me-2 text-primary"></i>Activity Log</h4>
            <p class="text-muted small">Recent actions performed on your account.</p>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 py-3 border-0">Action</th>
                            <th class="py-3 border-0">IP Address</th>
                            <th class="py-3 border-0 text-end pe-4">Date & Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!empty($activities)): foreach($activities as $a): ?>
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center">
                                        <div class="p-2 bg-primary-subtle rounded-circle me-3">
                                            <i class="bi bi-activity text-primary"></i>
                                        </div>
                                        <span class="fw-semibold"><?= htmlspecialchars($a['action']) ?></span>
                                    </div>
                                </td>
                                <td class="text-muted"><?= htmlspecialchars($a['ip_address'] ?? '0.0.0.0') ?></td>
                                <td class="text-end pe-4">
                                    <span class="badge bg-light text-dark border fw-normal">
                                        <?= isset($a['created_at']) ? date('M d, Y - H:i', strtotime($a['created_at'])) : 'N/A' ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; else: ?>
                            <tr>
                                <td colspan="3" class="text-center py-5 text-muted">No activity recorded yet.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <?php 
        // Logic salama ya Pagination
        $current = isset($currentPage) ? (int)$currentPage : 1;
        $total = isset($totalPages) ? (int)$totalPages : 1;

        if($total > 1): 
        ?>
        <div class="card-footer bg-white border-0 py-3 shadow-sm">
            <nav aria-label="Page navigation">
                <ul class="pagination justify-content-center mb-0">
                    
                    <li class="page-item <?= ($current <= 1) ? 'disabled' : '' ?>">
                        <a class="page-link border-0 shadow-none text-primary" href="?page=<?= ($current - 1) ?>">
                            <i class="bi bi-chevron-left"></i>
                        </a>
                    </li>

                    <?php for($i = 1; $i <= $total; $i++): ?>
                        <li class="page-item mx-1">
                            <a class="page-link border-0 rounded-3 <?= ($i == $current) ? 'bg-primary text-white shadow-sm' : 'bg-light text-muted hover-bg-light' ?>" 
                               href="?page=<?= $i ?>">
                                <?= $i ?>
                            </a>
                        </li>
                    <?php endfor; ?>

                    <li class="page-item <?= ($current >= $total) ? 'disabled' : '' ?>">
                        <a class="page-link border-0 shadow-none text-primary" href="?page=<?= ($current + 1) ?>">
                            <i class="bi bi-chevron-right"></i>
                        </a>
                    </li>

                </ul>
            </nav>
        </div>
        <?php endif; ?>
    </div>
</div>

<style>
    .page-link {
        transition: all 0.2s ease-in-out;
        font-weight: 500;
        padding: 0.5rem 1rem;
    }
    .hover-bg-light:hover {
        background-color: #e9ecef !important;
        color: #0d6efd !important;
        transform: translateY(-1px);
    }
    .page-item.disabled .page-link {
        color: #adb5bd !important;
        background-color: transparent !important;
        cursor: not-allowed;
    }
    .bg-primary-subtle {
        background-color: rgba(13, 110, 253, 0.1) !important;
    }
</style>