<div class="container-fluid content-inner mt-n5 py-0">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex flex-wrap align-items-center justify-content-between">
                        <div class="d-flex flex-wrap align-items-center">
                            <div class="profile-img position-relative me-3 mb-3 mb-lg-0 profile-logo-area">
                                <img src="/naps/Public/assets/images/avatars/01.png" alt="User-Profile" class="theme-color-default-img img-fluid rounded-pill avatar-100">
                            </div>
                            <div class="d-flex flex-wrap align-items-center mb-3 mb-lg-0">
                                <div class="profile-detail">
                                    <h4 class="fw-bold"><?= htmlspecialchars($profile['full_name'] ?? $profile['username']) ?></h4>
                                    <p class="mb-0 text-primary"><?= htmlspecialchars($profile['role_name'] ?? 'Staff') ?> | <?= htmlspecialchars($profile['department'] ?? 'No Department') ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Job Information</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between">
                            <strong>Employee ID:</strong>
                            <span class="text-muted"><?= htmlspecialchars($profile['staff_id'] ?? 'N/A') ?></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <strong>Status:</strong>
                            <span class="badge bg-success"><?= htmlspecialchars($profile['status'] ?? 'Active') ?></span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Update Person Information</h5>
                </div>
                <div class="card-body">
                    <form id="staffProfileForm">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">full name</label>
                                <input type="text" name="full_name" class="form-control" value="<?= htmlspecialchars($profile['full_name'] ?? '') ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">phone</label>
                                <input type="text" name="phone" class="form-control" value="<?= htmlspecialchars($profile['phone'] ?? '') ?>">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Department</label>
                                <input type="text" name="department" class="form-control" value="<?= htmlspecialchars($profile['department'] ?? '') ?>">
                            </div>
                        </div>
                        <div class="text-end">
                            <button type="submit" class="btn btn-primary" id="saveBtn">save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('staffProfileForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const btn = document.getElementById('saveBtn');
    btn.disabled = true;
    btn.innerHTML = 'Inasave...';

    const formData = new FormData(this);

    fetch('/naps/staff/profile/update', {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if(data.status === 'success') {
            alert(data.message);
            location.reload(); 
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => console.error('Error:', error))
    .finally(() => {
        btn.disabled = false;
        btn.innerHTML = 'Save changes';
    });
});
</script>