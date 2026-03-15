<?php 
include 'layouts/header.php'; 
?>

<style>
    .hero-section {
        
        padding-top: 40px; 
        min-height: 85vh;
        display: flex;
        align-items: center;
        background-color: #ffffff;
    }
    .bg-primary-soft { background-color: rgba(13, 110, 253, 0.1); }
    
    .floating-icon {
        animation: float 3s ease-in-out infinite;
    }
    @keyframes float {
        0% { transform: translateY(0px); }
        50% { transform: translateY(-15px); }
        100% { transform: translateY(0px); }
    }
</style>

<div class="container-fluid hero-section">
    <div class="container"> 
        <div class="row align-items-center g-5">
            <div class="col-lg-6 text-center text-lg-start">
                <div class="badge bg-primary-soft text-primary px-3 py-2 rounded-pill mb-3 shadow-sm border border-primary">
                    <i class="bi bi-shield-shaded me-1"></i> Official Government Portal
                </div>
                
                <h1 class="display-3 fw-bold lh-1 mb-3 text-dark">
                    National Authorization & <span class="text-primary">Permits System</span>
                </h1>
                
                <p class="lead text-muted mb-4">
                    The official digital gateway for streamlining national documentation. Apply, track, and manage your official permits with ease and transparency.
                </p>

                <div class="d-grid gap-3 d-sm-flex justify-content-sm-center justify-content-lg-start">
                    <a href="/naps/login" class="btn btn-primary btn-lg px-5 py-3 shadow">
                        <i class="bi bi-rocket-takeoff me-2"></i> Get Started Now
                    </a>
                    <a href="/naps/about" class="btn btn-outline-dark btn-lg px-5 py-3">
                        Explore Features
                    </a>
                </div>
                
                <div class="row mt-5 pt-4 border-top">
                    <div class="col-4">
                        <h4 class="fw-bold mb-0 text-primary">Secure</h4>
                        <small class="text-muted">Encrypted</small>
                    </div>
                    <div class="col-4 border-start border-end">
                        <h4 class="fw-bold mb-0 text-primary">Fast</h4>
                        <small class="text-muted">Real-time</small>
                    </div>
                    <div class="col-4">
                        <h4 class="fw-bold mb-0 text-primary">24/7</h4>
                        <small class="text-muted">Online Access</small>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 text-center">
                <div class="position-relative">
                    <div class="p-5">
                        <i class="bi bi-file-earmark-lock-fill text-primary" style="font-size: 18rem; opacity: 0.07; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);"></i>
                        
                        <i class="bi bi-shield-shaded text-primary" style="font-size: 14rem; opacity: 0.1; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);"></i>
                        
                        <div class="floating-icon">
                            <i class="bi bi-patch-check-fill text-primary shadow-lg rounded-circle" style="font-size: 10rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'layouts/footer.php'; ?>