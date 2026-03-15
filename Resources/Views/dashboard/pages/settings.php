<div class="container-fluid py-4">
    <h4 class="fw-bold mb-4">Account Settings</h4>

    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card border-0 shadow-sm rounded-4 p-3">
                <div class="d-flex align-items-center mb-3">
                    <div class="p-2 bg-primary-subtle rounded-3 me-3">
                        <i class="bi bi-palette text-primary"></i>
                    </div>
                    <h6 class="mb-0 fw-bold">Theme (Theme)</h6>
                </div>
                <div class="form-check form-switch p-0 d-flex justify-content-between align-items-center">
                    <label class="form-check-label">Dark Mode</label>
                    <input class="form-check-input ms-0" type="checkbox" id="themeToggle" 
                           <?= $user_settings['theme_preference'] == 'dark' ? 'checked' : '' ?>>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card border-0 shadow-sm rounded-4 p-3">
                <div class="d-flex align-items-center mb-3">
                    <div class="p-2 bg-warning-subtle rounded-3 me-3">
                        <i class="bi bi-translate text-warning"></i>
                    </div>
                    <h6 class="mb-0 fw-bold">Languages (Language)</h6>
                </div>
                <select class="form-select border-0 bg-light" id="langSelect">
                    <option value="sw" <?= $user_settings['language_preference'] == 'sw' ? 'selected' : '' ?>>Kiswahili</option>
                    <option value="en" <?= $user_settings['language_preference'] == 'en' ? 'selected' : '' ?>>English</option>
                </select>
            </div>
        </div>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const token = localStorage.getItem('jwt_token');

    const themeBtn = document.getElementById('themeToggle');
    if (themeBtn) {
        themeBtn.addEventListener('change', function() {
            const themeValue = this.checked ? 'dark' : 'light';
            
            fetch('/naps/settings/update-theme', {
                method: 'POST',
                headers: { 
                    'Authorization': 'Bearer ' + token, 
                    'Content-Type': 'application/json' 
                },
                body: JSON.stringify({ theme: themeValue.trim() }) 
            })
            .then(res => res.json())
            .then(data => {
                if(data.status === 'success') {
                    location.reload(); 
                } else {
                    alert("Imeshindwa kubadili theme!");
                }
            })
            .catch(err => console.error('Error:', err));
        });
    }
    const langBtn = document.getElementById('langSelect');
    if (langBtn) {
        langBtn.addEventListener('change', function() {
            const langValue = this.value;
            fetch('/naps/settings/update-lang', {
                method: 'POST',
                headers: { 
                    'Authorization': 'Bearer ' + token, 
                    'Content-Type': 'application/json' 
                },
                body: JSON.stringify({ lang: langValue.trim() })
            })
            .then(res => res.json())
            .then(data => {
                if(data.status === 'success') {
                    location.reload();
                }
            })
            .catch(err => console.error('Error:', err));
        });
    }
});
</script>