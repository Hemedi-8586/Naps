<div class="container-fluid py-4">
    <div class="row mb-5 justify-content-center">
        <div class="col-md-10">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h6 class="m-0 fw-bold text-primary"><i class="bi bi-file-earmark-plus me-2"></i>Apply for New Permit</h6>
                </div>
                <div class="card-body p-4">
                    <form id="permitForm">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Permit Type</label>
                                <select name="permit_type" class="form-select border-secondary-subtle" required>
                                    <option value="">-- Choose Type --</option>
                                    <option value="Building">Building Permit</option>
                                    <option value="Renovation">Renovation Permit</option>
                                    <option value="Demolition">Demolition Permit</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Supporting Document (PDF)</label>
                                <input type="file" name="permit_doc" class="form-control border-secondary-subtle">
                            </div>
                            <div class="col-12 text-end">
                                <button type="submit" class="btn btn-primary px-5 shadow-sm" id="submitBtn">Submit Application</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h6 class="m-0 fw-bold text-dark"><i class="bi bi-clock-history me-2"></i>My Application History</h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                       <table class="table table-hover align-middle mb-0">
    <thead class="bg-light">
        <tr>
            <th class="ps-4 small fw-bold text-muted">SUBMISSION DATE</th>
            <th class="small fw-bold text-muted">PERMIT TYPE</th>
            <th class="small fw-bold text-muted">CURRENT STATUS</th>
            <th class="small fw-bold text-muted">INSPECTOR'S REMARKS</th>
            <th class="small fw-bold text-muted text-end pe-4">ACTION</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($permits)): foreach ($permits as $permit): ?>
            <tr>
                <td class="ps-4 small text-muted">
                    <?= date('M d, Y', strtotime($permit['created_at'])) ?>
                </td>

                <td class="small fw-bold text-dark">
                    <span class="d-block"><?= htmlspecialchars($permit['permit_type']) ?></span>
                </td>

                <td>
                    <?php 
                        
                        $status = $permit['status'];
                        $badgeClass = match($status) {
                            'Approved' => 'bg-success',
                            'Rejected' => 'bg-danger',
                            default    => 'bg-warning text-dark' 
                        };
                    ?>
                    <span class="badge <?= $badgeClass ?> rounded-pill px-3 py-2 small">
                        <i class="bi bi-clock-history me-1"></i> <?= $status ?>
                    </span>
                </td>

                <td class="small text-muted fst-italic">
                    <div style="max-width: 250px;" class="text-truncate" title="<?= htmlspecialchars($permit['inspection_comments'] ?? '') ?>">
                        <?= !empty($permit['inspection_comments']) ? htmlspecialchars($permit['inspection_comments']) : 'Pending review...' ?>
                    </div>
                </td>

                <td class="text-end pe-4">
                    <div class="btn-group shadow-sm">
                        <button class="btn btn-sm btn-white border" title="View Details">
                            <i class="bi bi-eye text-primary"></i>
                        </button>
                        <?php if ($status === 'Pending'): ?>
                        <button class="btn btn-sm btn-white border text-danger" title="Cancel Application">
                            <i class="bi bi-x-circle"></i>
                        </button>
                        <?php endif; ?>
                    </div>
                </td>
            </tr>
        <?php endforeach; else: ?>
            <tr>
                <td colspan="5" class="text-center py-5">
                    <div class="py-3">
                        <i class="bi bi-inbox-fill text-light display-1 d-block mb-3"></i>
                        <h6 class="text-muted fw-normal">No pending applications found.</h6>
                        <p class="small text-muted mb-0">Once you apply, your tracking details will appear here.</p>
                    </div>
                </td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
document.getElementById('permitForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const btn = document.getElementById('submitBtn');
    btn.disabled = true;
    btn.innerHTML = 'Processing...';

    fetch('/naps/citizen/apply', { 
        method: 'POST',
        body: new FormData(this),
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            alert(data.message);
          
            location.reload(); 
        } else {
            alert(data.message);
            btn.disabled = false;
            btn.innerHTML = 'Submit Application';
        }
    })
    .catch(error => {
        console.error('Error:', error);
        btn.disabled = false;
        btn.innerHTML = 'Submit Application';
    });
});
</script>