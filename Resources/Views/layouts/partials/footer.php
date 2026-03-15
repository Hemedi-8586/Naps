<footer class="mt-auto py-4 bg-white border-top">
    <div class="container-fluid">
        <div class="row align-items-center justify-content-between">
            <div class="col-md-6 text-center text-md-start">
                <p class="mb-0 text-muted">
                    &copy; <?= date('Y') ?> <span class="fw-bold text-primary">NAPS Portal</span>. 
                    <span class="d-none d-sm-inline">Official Government System.</span>
                </p>
            </div>
            <div class="col-md-6 text-center text-md-end">
                <small class="text-muted">
                    Powered by <a href="#" class="text-decoration-none fw-semibold">UniTech Innovators</a>
                    <i class="bi bi-lightbulb-fill text-warning ms-1"></i>
                </small>
            </div>
        </div>
    </div>
</footer>

<style>
    
    body {
        display: flex;
        flex-direction: column;
        min-height: 100vh;
    } 
    .main-content { 
        flex: 1;
    }
    footer {
        font-size: 0.85rem;
    }
</style>
<script>
  document.getElementById('addUserForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const submitBtn = this.querySelector('button[type="submit"]');
    
   
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Saving...';

    fetch('/naps/admin/users/create', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            alert('User created successfully!'); 
            location.reload(); 
        } else {
            alert('Error: ' + data.message);
            submitBtn.disabled = false;
            submitBtn.innerText = 'Save User';
        }
    })
    .catch(error => {
        console.error('Error:', error);
        submitBtn.disabled = false;
        submitBtn.innerText = 'Save User';
    });
});
</script>