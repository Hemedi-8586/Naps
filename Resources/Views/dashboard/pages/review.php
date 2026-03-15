<div class="container-fluid content-inner mt-n5 py-0">
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h4 class="card-title">Permit Review Queue</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Applicant Details</th>
                            <th>Permit Type</th>
                            <th>Payment</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($permits)): ?>
                            <?php foreach ($permits as $permit): ?>
                            <tr>
                                <td>#<?= $permit['id'] ?></td>
                                <td>
                                    <strong><?= htmlspecialchars($permit['full_name'] ?? 'N/A') ?></strong><br>
                                    <small>NIDA: <?= htmlspecialchars($permit['nida_number'] ?? 'N/A') ?></small>
                                </td>
                                <td><?= htmlspecialchars($permit['permit_type'] ?? 'General') ?></td>
                                <td>
                                    <span class="badge bg-soft-info text-info"><?= strtoupper($permit['payment_type'] ?? 'N/A') ?></span><br>
                                    <small><?= number_format($permit['amount'] ?? 0) ?>/-</small>
                                </td>
                                <td>
                                    <span class="badge bg-<?= $permit['status'] == 'pending' ? 'warning' : ($permit['status'] == 'approved' ? 'success' : 'danger') ?>">
                                        <?= ucfirst($permit['status']) ?>
                                    </span>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-primary" 
                                            onclick="openReviewModal('<?= $permit['id'] ?>', '<?= addslashes(htmlspecialchars($permit['full_name'] ?? 'N/A')) ?>')">
                                        Review
                                    </button>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="6" class="text-center py-4">No records found.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <?php if (isset($totalPages) && $totalPages > 1): ?>
            <nav class="mt-4">
                <ul class="pagination justify-content-center">
                    <li class="page-item <?= ($currentPage <= 1) ? 'disabled' : '' ?>">
                        <a class="page-link" href="?page=<?= (int)$currentPage - 1 ?>">Previous</a>
                    </li>
                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <li class="page-item <?= ($i == (int)$currentPage) ? 'active' : '' ?>">
                            <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                        </li>
                    <?php endfor; ?>
                    <li class="page-item <?= ($currentPage >= $totalPages) ? 'disabled' : '' ?>">
                        <a class="page-link" href="?page=<?= (int)$currentPage + 1 ?>">Next</a>
                    </li>
                </ul>
            </nav>
            <?php endif; ?>
        </div>
    </div>
</div>

<div class="modal fade" id="reviewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title text-white">Reviewing: <span id="m_name"></span></h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="permit_id">
                <div class="mb-3">
                    <label class="form-label fw-bold">Internal Remarks / Reason</label>
                    <textarea id="reviewComment" class="form-control" rows="4" placeholder="Enter reason for this decision..."></textarea>
                </div>
            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" onclick="submitDecision('rejected')">Reject</button>
                <button type="button" class="btn btn-success" onclick="submitDecision('approved')">Approve</button>
            </div>
        </div>
    </div>
</div>

<script>
// Tunatumia DOMContentLoaded kuhakikisha bootstrap imeload
let myModal;
document.addEventListener('DOMContentLoaded', function() {
    myModal = new bootstrap.Modal(document.getElementById('reviewModal'));
});

function openReviewModal(id, name) {
    // Jaza data
    document.getElementById('permit_id').value = id;
    document.getElementById('m_name').innerText = name;
    document.getElementById('reviewComment').value = ''; // Safisha comment ya awali
    
    // Onyesha Modal
    myModal.show();
}

function submitDecision(status) {
    const id = document.getElementById('permit_id').value;
    const comment = document.getElementById('reviewComment').value;

    if (!id) return;

    // Optional: Validation kama ni rejection
    if (status === 'rejected' && !comment.trim()) {
        alert("Please provide a reason for rejection.");
        return;
    }

    // Onyesha loading state kidogo kwenye button
    const btn = event.target;
    const originalText = btn.innerHTML;
    btn.disabled = true;
    btn.innerHTML = 'Processing...';

    fetch('/naps/permit/decision', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({id, status, comment})
    })
    .then(res => res.json())
    .then(data => {
        if(data.status === 'success') {
            alert(data.message);
            location.reload();
        } else {
            alert("Error: " + data.message);
            btn.disabled = false;
            btn.innerHTML = originalText;
        }
    })
    .catch(err => {
        console.error(err);
        alert("A network error occurred.");
        btn.disabled = false;
        btn.innerHTML = originalText;
    });
}
</script>