<?php
$total = count($permits ?? []);
$approved = count(array_filter($permits ?? [], fn($p) => $p['status'] === 'Approved'));
$rejected = count(array_filter($permits ?? [], fn($p) => $p['status'] === 'Rejected'));
?>

<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <h4 class="fw-bold text-dark">Overall Application History</h4>
            <p class="text-muted small">Track all your submitted permit requests from day one.</p>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm bg-primary text-white">
                <div class="card-body p-3 d-flex align-items-center">
                    <div class="rounded-circle bg-white bg-opacity-25 p-3 me-3">
                        <i class="bi bi-stack fs-4"></i>
                    </div>
                    <div>
                        <h6 class="mb-0 small opacity-75">Total Requests</h6>
                        <h3 class="fw-bold mb-0"><?= $total ?></h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm bg-success text-white">
                <div class="card-body p-3 d-flex align-items-center">
                    <div class="rounded-circle bg-white bg-opacity-25 p-3 me-3">
                        <i class="bi bi-check2-all fs-4"></i>
                    </div>
                    <div>
                        <h6 class="mb-0 small opacity-75">Approved Permits</h6>
                        <h3 class="fw-bold mb-0"><?= $approved ?></h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm bg-danger text-white">
                <div class="card-body p-3 d-flex align-items-center">
                    <div class="rounded-circle bg-white bg-opacity-25 p-3 me-3">
                        <i class="bi bi-x-octagon fs-4"></i>
                    </div>
                    <div>
                        <h6 class="mb-0 small opacity-75">Rejected Requests</h6>
                        <h3 class="fw-bold mb-0"><?= $rejected ?></h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 py-3 small fw-bold text-muted">ID</th>
                            <th class="py-3 small fw-bold text-muted">PERMIT TYPE</th>
                            <th class="py-3 small fw-bold text-muted">SUBMISSION DATE</th>
                            <th class="py-3 small fw-bold text-muted">STATUS</th>
                            <th class="py-3 small fw-bold text-muted">INSPECTION DATE</th>
                            <th class="py-3 small fw-bold text-muted text-end pe-4">ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($permits)): foreach ($permits as $permit): ?>
                        <tr>
                            <td class="ps-4 small text-muted">#<?= str_pad($permit['id'], 5, '0', STR_PAD_LEFT) ?></td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="bg-light rounded p-2 me-2">
                                        <i class="bi bi-file-earmark-text text-primary"></i>
                                    </div>
                                    <span class="fw-bold small"><?= $permit['permit_type'] ?></span>
                                </div>
                            </td>
                            <td class="small text-muted"><?= date('M d, Y', strtotime($permit['created_at'])) ?></td>
                            <td>
                                <?php 
                                    $status = $permit['status'];
                                    $badge = match($status) {
                                        'Approved' => 'bg-success-subtle text-success border-success',
                                        'Rejected' => 'bg-danger-subtle text-danger border-danger',
                                        default    => 'bg-warning-subtle text-warning border-warning'
                                    };
                                ?>
                                <span class="badge <?= $badge ?> border rounded-pill px-3 py-2 small">
                                    <?= $status ?>
                                </span>
                            </td>
                            <td class="small text-muted">
                                <?= $permit['inspected_at'] ? date('M d, Y', strtotime($permit['inspected_at'])) : '<span class="text-black-50">Not Inspected</span>' ?>
                            </td>
                            <td class="text-end pe-4">
                                <button class="btn btn-sm btn-outline-dark border-0 rounded-circle" title="View Details">
                                    <i class="bi bi-three-dots-vertical"></i>
                                </button>
                            </td>
                        </tr>
                        <?php endforeach; else: ?>
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <p class="text-muted mb-0">No history available.</p>
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>