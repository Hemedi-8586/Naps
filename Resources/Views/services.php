<?php include 'layouts/header.php'; ?>

<style>
    .services-wrapper {
        
        padding-top: 20px; 
        min-height: 80vh;
        background-color: #f8f9fa;
    }
    .service-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border-radius: 16px;
    }
    .service-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 1rem 3rem rgba(0,0,0,0.08) !important;
    }
    .feature-icon {
        width: 60px; 
        height: 60px;
        border-radius: 12px;
    }
</style>

<div class="services-wrapper">
    <div class="container py-4">
        <div class="text-center mb-5">
            <h6 class="text-primary fw-bold text-uppercase small tracking-widest">Solutions</h6>
            <h1 class="display-5 fw-bold text-dark">Our Core Services</h1>
            <p class="text-muted mx-auto" style="max-width: 600px;">
                NAPS provides a comprehensive suite of digital tools to streamline authorization processes for both citizens and administrators.
            </p>
        </div>

        <div class="row g-4">
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm p-3 service-card">
                    <div class="card-body">
                        <div class="feature-icon bg-primary bg-gradient text-white mb-4 d-inline-flex align-items-center justify-content-center">
                            <i class="bi bi-file-earmark-check fs-3"></i>
                        </div>
                        <h4 class="fw-bold">Permit Application</h4>
                        <p class="text-muted small">Submit various permit applications digitally with an intuitive step-by-step guidance system.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm p-3 service-card">
                    <div class="card-body">
                        <div class="feature-icon bg-success bg-gradient text-white mb-4 d-inline-flex align-items-center justify-content-center">
                            <i class="bi bi-search fs-3"></i>
                        </div>
                        <h4 class="fw-bold">Real-time Tracking</h4>
                        <p class="text-muted small">Monitor the status of your applications in real-time from submission to final approval.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm p-3 service-card">
                    <div class="card-body">
                        <div class="feature-icon bg-warning bg-gradient text-white mb-4 d-inline-flex align-items-center justify-content-center">
                            <i class="bi bi-shield-lock fs-3"></i>
                        </div>
                        <h4 class="fw-bold">Digital Verification</h4>
                        <p class="text-muted small">Authentic QR-coded permits that can be verified instantly by any authorized officer.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'layouts/footer.php'; ?>