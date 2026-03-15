<?php
include __DIR__ . '/../layouts/header.php'; 
?>

<style>
    :root { --primary-navy: #0f172a; --accent-blue: #3b82f6; }
    .auth-main { min-height: 85vh; display: flex; align-items: center; background: #f1f5f9; padding: 20px 0; }
    .auth-card-wrapper { background: white; border-radius: 20px; box-shadow: 0 15px 35px rgba(0,0,0,0.05); overflow: hidden; display: flex; width: 100%; max-width: 850px; margin: auto; transition: transform 0.3s ease; }
    .auth-sidebar { background: var(--primary-navy); color: white; padding: 40px; width: 40%; display: flex; flex-direction: column; justify-content: center; }
    .auth-form-content { padding: 40px 50px; width: 60%; background: white; }
    .form-label { font-size: 0.7rem; font-weight: 700; letter-spacing: 0.5px; margin-bottom: 6px; color: #64748b; }
    .form-control { border: 1.5px solid #e2e8f0; border-radius: 10px; background: #f8fafc; padding: 10px 15px; font-size: 0.9rem; transition: all 0.2s; }
    .form-control:focus { background: white; border-color: var(--accent-blue); box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1); outline: none; }
    .input-group-text { background: #f8fafc; border: 1.5px solid #e2e8f0; border-radius: 10px; color: #64748b; }
    .login-btn { background: var(--accent-blue); color: white; border: none; padding: 12px; border-radius: 10px; font-weight: 600; width: 100%; font-size: 0.9rem; transition: all 0.2s; cursor: pointer; }
    .login-btn:hover { background: #2563eb; transform: translateY(-1px); }
    .login-btn:disabled { background: #94a3b8; cursor: not-allowed; }
    
    @media (max-width: 850px) { .auth-sidebar { display: none; } .auth-form-content { width: 100%; padding: 30px; } .auth-card-wrapper { max-width: 420px; } }
</style>

<main class="auth-main">
    <div class="container">
        <div class="auth-card-wrapper">
            <div class="auth-sidebar d-none d-lg-flex">
                <div class="bg-white bg-opacity-10 rounded-3 p-2 d-inline-block mb-3">
                    <i class="bi bi-shield-lock text-white fs-4"></i>
                </div>
                <h4 class="fw-bold text-white mb-2">NAPS Portal</h4>
                <p class="text-white-50 small mb-4">Secure gateway for national authorizations and official permits.</p>
                <div class="mt-auto small">
                    <div class="d-flex align-items-center gap-2 mb-2"><i class="bi bi-check2-circle text-info"></i><span>Encrypted Session</span></div>
                    <div class="d-flex align-items-center gap-2"><i class="bi bi-cpu text-warning"></i><span>Direct Auth</span></div>
                </div>
            </div>

            <div class="auth-form-content">
                <div class="mb-4">
                    <h4 class="fw-bold text-dark mb-1">Sign In</h4>
                    <p class="text-muted small">Enter your credentials to access the portal</p>
                </div>

                <div id="error-alert" class="alert alert-danger py-2 small border-0 mb-3 shadow-sm d-none">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    <span id="error-message"></span>
                </div>

                <form id="loginForm" novalidate>
                    <div class="mb-3">
                        <label class="form-label text-uppercase">Username</label>
                        <div class="input-group">
                            <span class="input-group-text border-end-0"><i class="bi bi-person"></i></span>
                            <input type="text" name="username" id="username" class="form-control border-start-0" 
                                   placeholder="Enter your username" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="d-flex justify-content-between">
                            <label class="form-label text-uppercase">Password</label>
                            <a href="/naps/forgot-password" class="small text-decoration-none fw-bold" style="font-size: 0.7rem;">Forgot?</a>
                        </div>
                        <div class="input-group">
                            <span class="input-group-text border-end-0"><i class="bi bi-key"></i></span>
                            <input type="password" id="password" name="password" class="form-control border-start-0 border-end-0" 
                                   placeholder="••••••••" required>
                            <button type="button" class="input-group-text border-start-0 bg-transparent" id="togglePassword">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                    </div>

                    <button type="submit" id="submitBtn" class="login-btn mb-4">
                        SIGN IN
                    </button>

                    <p class="text-center text-muted small mb-0">
                        Don't have an account? 
                        <a href="/naps/register" class="text-primary fw-bold text-decoration-none">Register</a>
                    </p>
                </form>
            </div>
        </div>
    </div>
</main>

<script>
    document.getElementById('togglePassword').addEventListener('click', function() {
        const passInput = document.getElementById('password');
        const icon = this.querySelector('i');
        if (passInput.type === 'password') {
            passInput.type = 'text';
            icon.classList.replace('bi-eye', 'bi-eye-slash');
        } else {
            passInput.type = 'password';
            icon.classList.replace('bi-eye-slash', 'bi-eye');
        }
    });

    document.getElementById('loginForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const btn = document.getElementById('submitBtn');
        const errorAlert = document.getElementById('error-alert');
        const errorMessage = document.getElementById('error-message');
        
        const formData = new FormData(this);
        const data = Object.fromEntries(formData.entries());

        
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> Checking...';
        errorAlert.classList.add('d-none');
        fetch('/naps/login', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json' 
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(result => {
            if (result.status === 'success') {
            
                if(result.token) {
                    localStorage.setItem('jwt_token', result.token);
                }
                window.location.href = result.redirect;
            } else {
           
                errorMessage.textContent = result.message;
                errorAlert.classList.remove('d-none');
                btn.disabled = false;
                btn.innerHTML = 'SIGN IN';
            }
        })
        .catch(err => {
            console.error('Login error:', err);
            errorMessage.textContent = 'Server connection failed. Try again.';
            errorAlert.classList.remove('d-none');
            btn.disabled = false;
            btn.innerHTML = 'SIGN IN';
        });
    });
</script>

<?php include __DIR__ . '/../layouts/footer.php'; ?>