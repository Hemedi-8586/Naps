<?php
$p = $profile ?? []; 
$u = $auth_user ?? [];
?>

<div class="container-fluid py-1">
    <div class="row">
        <div class="col-12 mb-4">
            <h4 class="fw-bold text-dark"><i class="bi bi-person-circle me-2"></i> Personal Profile</h4>
            <p class="text-muted small">Manage your account details and security settings.</p>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm text-center p-4 h-100">
                <div class="card-body">
                    <img src="https://ui-avatars.com/api/?name=<?= urlencode($p['full_name'] ?? 'User') ?>&background=0d6efd&color=fff&size=128" 
                         class="rounded-circle shadow-sm mb-3" style="width: 110px; height: 110px; object-fit: cover;">
                    
                    <h5 class="fw-bold mb-1"><?= htmlspecialchars($p['full_name'] ?? 'Citizen User') ?></h5>
                    <p class="text-muted small mb-3">@<?= htmlspecialchars($u['username'] ?? 'guest') ?></p>
                    
                    <span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-2">
                        <i class="bi bi-patch-check-fill me-1"></i> <?= strtoupper($u['role'] ?? 'CITIZEN') ?>
                    </span>
                    <hr class="my-4 opacity-25">
                    <div class="text-start">
                        <p class="small text-muted mb-1">Account Status: <span class="text-success fw-bold">Active</span></p>
                        <p class="small text-muted mb-0">NIDA Verified: <span class="text-primary fw-bold">Yes</span></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h6 class="m-0 fw-bold text-primary">Edit Information</h6>
                </div>
                <div class="card-body p-4">
                    <form id="profileUpdateForm">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted">Username</label>
                                <input type="text" class="form-control bg-light border-0 shadow-none" value="<?= $u['username'] ?? '' ?>" readonly disabled>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted">NIDA Number</label>
                                <input type="text" class="form-control bg-light border-0 shadow-none" value="<?= $p['nida_number'] ?? 'Not Set' ?>" readonly disabled>
                            </div>

                            <div class="col-12"><hr class="my-2 opacity-25"></div>

                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Full Name (NIDA Registered)</label>
                                <input type="text" name="full_name" class="form-control border-secondary-subtle" 
                                       value="<?= htmlspecialchars($p['full_name'] ?? '') ?>" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Phone Number</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light">+255</span>
                                    <input type="tel" name="phone" class="form-control border-secondary-subtle" 
                                           value="<?= htmlspecialchars($p['phone'] ?? '') ?>" placeholder="712345678" required>
                                </div>
                            </div>

                            <div class="col-12"><hr class="my-2 opacity-25"></div>

                            <div class="col-12 mb-1">
                                <h6 class="fw-bold text-dark small">Security Settings</h6>
                                <p class="text-muted" style="font-size: 0.7rem;">Leave blank if you do not want to change your password.</p>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-bold">New Password</label>
                                <input type="password" name="password" id="new_password" class="form-control border-secondary-subtle" placeholder="Enter new password">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Confirm Password</label>
                                <input type="password" id="confirm_password" class="form-control border-secondary-subtle" placeholder="Re-type password">
                                <small id="passwordHelp" class="text-danger d-none" style="font-size: 0.7rem;">Passwords do not match!</small>
                            </div>

                            <div class="col-12 mt-4 text-end">
                                <button type="submit" class="btn btn-primary px-5 py-2 shadow-sm" id="saveBtn">
                                    <i class="bi bi-shield-check me-2"></i>Save Changes
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('profileUpdateForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const btn = document.getElementById('saveBtn');
    const pass = document.getElementById('new_password').value;
    const confirm = document.getElementById('confirm_password').value;
    const helpText = document.getElementById('passwordHelp');
    if (pass !== "" && pass !== confirm) {
        helpText.classList.remove('d-none');
        return;
    }
    helpText.classList.add('d-none');

    const originalText = btn.innerHTML;
    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Processing...';

    fetch('/naps/citizen/update-profile', {
        method: 'POST',
        body: new FormData(this),
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: data.message,
                timer: 2000,
                showConfirmButton: false
            }).then(() => location.reload());
        } else {
            alert(data.message || 'An error occurred!');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Server connection failed!');
    })
    .finally(() => {
        btn.disabled = false;
        btn.innerHTML = originalText;
    });
});
</script>