<?php
$title = "Create Account - NAPS Portal";
include __DIR__ . '/../layouts/header.php'; 
?>

<style>
    :root {
        --primary-navy: #0f172a;
        --accent-blue: #3b82f6;
    }

    .auth-main {
        min-height: 90vh;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f1f5f9;
        padding: 20px;
    }
    .auth-card-wrapper {
        background: white;
        border-radius: 16px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
        overflow: hidden;
        display: flex;
        width: 100%;
        max-width: 750px; 
        animation: fadeIn 0.4s ease-in-out;
    }

    .auth-sidebar {
        background: var(--primary-navy);
        color: white;
        padding: 30px;
        width: 35%;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .auth-form-content {
        padding: 30px 40px;
        width: 65%;
        background: white;
    }
    .form-label {
        font-size: 0.65rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 4px;
        color: #64748b;
    }

    .form-control {
        border: 1.5px solid #e2e8f0;
        border-radius: 8px;
        background: #f8fafc;
        padding: 8px 12px;
        font-size: 0.85rem;
        transition: all 0.2s;
    }

    .form-control:focus {
        background: white;
        border-color: var(--accent-blue);
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.08);
    }

    .register-btn {
        background: var(--accent-blue);
        color: white;
        border: none;
        padding: 10px;
        border-radius: 8px;
        font-weight: 600;
        width: 100%;
        font-size: 0.85rem;
        transition: 0.2s;
    }

    .register-btn:hover {
        background: #2563eb;
        transform: translateY(-1px);
    }

    @keyframes fadeIn { 
        from { opacity: 0; transform: translateY(10px); } 
        to { opacity: 1; transform: translateY(0); } 
    }

    @media (max-width: 768px) {
        .auth-sidebar { display: none; }
        .auth-form-content { width: 100%; padding: 25px; }
        .auth-card-wrapper { max-width: 400px; }
    }
</style>

<main class="auth-main">
    <div class="auth-card-wrapper">
        
        <div class="auth-sidebar d-none d-lg-flex text-center">
            <div class="mb-3">
                <i class="bi bi-shield-check text-info" style="font-size: 2.5rem;"></i>
            </div>
            <h5 class="fw-bold mb-2">Portal Access</h5>
            <p class="text-white-50 small mb-0">Official platform for national digital authorization services.</p>
            
            <div class="mt-4 pt-4 border-top border-secondary border-opacity-25 text-start">
                <div class="d-flex align-items-center gap-2 mb-2 small">
                    <i class="bi bi-check2-circle text-success"></i> <span>NIDA Verified</span>
                </div>
                <div class="d-flex align-items-center gap-2 small">
                    <i class="bi bi-lock text-info"></i> <span>Secure Data</span>
                </div>
            </div>
        </div>
    <div class="auth-form-content">
    <div class="mb-3 text-center text-lg-start">
        <h5 class="fw-bold text-dark mb-1">Create Account</h5>
        <p class="text-muted small">Fill in your details to get started.</p>
    </div>

    <div id="errorContainer">
        <?php if (isset($error)): ?>
            <div class="alert alert-danger py-2 small border-0 mb-3 rounded-3 shadow-sm">
                <i class="bi bi-exclamation-triangle me-2"></i> <?= htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>
    </div>

    <form action="/naps/register" method="POST" id="registerForm">
        <input type="hidden" name="token" value="<?= $_GET['token'] ?? '' ?>">
                <div class="row g-2">
                    <div class="col-12">
                        <label class="form-label">Full Name</label>
                        <input type="text" name="full_name" class="form-control" placeholder="Full name as per NIDA" required 
                               value="<?= htmlspecialchars($_POST['full_name'] ?? '') ?>">
                    </div>
                    
                    <div class="col-md-6">
                        <label class="form-label">NIDA Number</label>
                        <input type="text" name="nida_number" id="nidaInput" class="form-control" placeholder="20-digit ID" 
                               maxlength="20" required value="<?= htmlspecialchars($_POST['nida_number'] ?? '') ?>">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Phone Number</label>
                        <input type="tel" name="phone" class="form-control" placeholder="07XXXXXXXX" required 
                               value="<?= htmlspecialchars($_POST['phone'] ?? '') ?>">
                    </div>

                    <div class="col-12">
                        <label class="form-label">Username</label>
                        <input type="text" name="username" class="form-control" placeholder="Choose username" required 
                               value="<?= htmlspecialchars($_POST['username'] ?? '') ?>">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" id="password" class="form-control" placeholder="••••••••" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Confirm Password</label>
                        <input type="password" name="password_confirm" id="confirm_password" class="form-control" placeholder="••••••••" required>
                    </div>

                    <div class="col-12 mt-3">
                        <button type="submit" class="register-btn" id="regBtn">
                            JOIN NAPS PORTAL
                        </button>
                        <p class="text-center mt-3 small text-muted">
                            Already a member? <a href="/naps/login" class="text-primary fw-bold text-decoration-none">Sign In</a>
                        </p>
                    </div>
                </div>
            </form>
        </div>
    </div>
</main>

<script>
    
    document.getElementById('nidaInput').addEventListener('input', function(e) {
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    
    document.getElementById('registerForm').addEventListener('submit', function(e) {
        e.preventDefault(); 

        const btn = document.getElementById('regBtn');
        const errorContainer = document.getElementById('errorContainer');
        const pass = document.getElementById('password').value;
        const confirm = document.getElementById('confirm_password').value;

        
        if (pass !== confirm) {
            errorContainer.innerHTML = '<div class="alert alert-danger py-2 border-0 shadow-sm">Passwords do not match!</div>';
            return;
        }

        
        errorContainer.innerHTML = '';
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> Waiting...';

        const formData = new FormData(this);

        fetch(this.action, {
            method: 'POST',
            body: formData,
            headers: { 'Accept': 'application/json' }
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                errorContainer.innerHTML = `
                    <div class="alert alert-success py-2 border-0 shadow-sm">
                        <i class="bi bi-check-circle-fill me-2"></i> ${data.message}
                    </div>`;
                setTimeout(() => window.location.href = '/naps/login', 2000);
            } else {
                
                errorContainer.innerHTML = `
                    <div class="alert alert-danger py-2 border-0 shadow-sm">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i> ${data.message}
                    </div>`;
                btn.disabled = false;
                btn.innerHTML = 'JOIN NAPS PORTAL';
            }
        })
        .catch(err => {
            errorContainer.innerHTML = '<div class="alert alert-danger py-2 border-0 shadow-sm">A technical error has occurred. Please try again later..</div>';
            btn.disabled = false;
            btn.innerHTML = 'JOIN NAPS PORTAL';
        });
    });
</script>
<?php include __DIR__ . '/../layouts/footer.php'; ?>