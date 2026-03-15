<?php 
$title = "About NAPS - National Authorization & Permits System";
include 'layouts/header.php'; 
?>

<style>
    .about-page { 
        padding-top: 1px; 
        font-family: 'Inter', sans-serif; 
    }
    .bg-primary-soft { background-color: rgba(13, 110, 253, 0.1); }
    .step-badge { 
        width: 40px; height: 40px; background: #0d6efd; color: white; 
        border-radius: 50%; display: flex; align-items: center; 
        justify-content: center; margin: 0 auto; font-weight: bold;
        box-shadow: 0 4px 10px rgba(13, 110, 253, 0.3);
    }
    .transition-hover { transition: transform 0.3s ease, box-shadow 0.3s ease; }
    .transition-hover:hover { 
        transform: translateY(-8px); 
        background: #fff; 
        box-shadow: 0 12px 25px rgba(0,0,0,0.08); 
        border-color: transparent !important; 
    }
</style>

<div class="about-page">
    <section class="hero-section py-5" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
        <div class="container py-3">
            <div class="row align-items-center g-5">
                <div class="col-lg-7">
                    <div class="badge bg-primary-soft text-primary px-3 py-2 rounded-pill mb-3">
                        <i class="bi bi-shield-check me-2"></i>Official Government Platform
                    </div>
                    <h1 class="display-5 fw-bold text-dark mb-4">
                        National Authorization &<br>
                        <span class="text-primary">Permits System (NAPS)</span>
                    </h1>
                    <p class="lead text-muted mb-4">
                        NAPS is a centralized digital gateway designed to streamline the issuance of permits and licenses in Tanzania. We provide a single window for all regulatory services, ensuring transparency and efficiency.
                    </p>
                    <div class="d-flex gap-3">
                        <a href="/naps/apply" class="btn btn-primary btn-lg px-4 shadow-sm">Get Started</a>
                        <a href="/naps/contact" class="btn btn-outline-dark btn-lg px-4">Contact Support</a>
                    </div>
                </div>
                
                <div class="col-lg-5 d-none d-lg-block">
                    <div class="card border-0 shadow-lg p-4 rounded-4 bg-white">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-success text-white rounded-circle p-2 me-3" style="width: 35px; height: 35px; display: flex; align-items: center; justify-content: center;">
                                <i class="bi bi-lock-fill"></i>
                            </div>
                            <h5 class="mb-0 fw-bold">Secure Processing</h5>
                        </div>
                        <p class="small text-muted mb-0">Your data is protected under the Personal Data Protection Act, ensuring maximum privacy and security.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5 bg-white">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold">Our Core Pillars</h2>
                <p class="text-muted">Built on modern public service delivery standards</p>
            </div>
            
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="p-4 rounded-4 border h-100 transition-hover">
                        <i class="bi bi-eye text-primary fs-2 mb-3 d-block"></i>
                        <h5 class="fw-bold">Transparency</h5>
                        <p class="text-muted small mb-0">Real-time tracking of your applications. Every stage of the process is visible and accountable.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-4 rounded-4 border h-100 transition-hover">
                        <i class="bi bi-lightning-charge text-success fs-2 mb-3 d-block"></i>
                        <h5 class="fw-bold">Efficiency</h5>
                        <p class="text-muted small mb-0">Zero paperwork. We have eliminated delays through fully automated digital workflows.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-4 rounded-4 border h-100 transition-hover">
                        <i class="bi bi-cpu text-warning fs-2 mb-3 d-block"></i>
                        <h5 class="fw-bold">Integration</h5>
                        <p class="text-muted small mb-0">Connected with government agencies for instant document and payment verification.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5 bg-light">
        <div class="container text-center">
            <h2 class="fw-bold mb-5">How It Works</h2>
            <div class="row g-4">
                <div class="col-md-3">
                    <div class="step-item">
                        <div class="step-badge">1</div>
                        <h6 class="fw-bold mt-3">Register</h6>
                        <p class="small text-muted px-3">Create an account using your NIDA or TIN number.</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="step-item">
                        <div class="step-badge">2</div>
                        <h6 class="fw-bold mt-3">Apply</h6>
                        <p class="small text-muted px-3">Fill out the form and upload required documents.</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="step-item">
                        <div class="step-badge">3</div>
                        <h6 class="fw-bold mt-3">Payment</h6>
                        <p class="small text-muted px-3">Pay securely via GePG Control Number.</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="step-item">
                        <div class="step-badge">4</div>
                        <h6 class="fw-bold mt-3">Download</h6>
                        <p class="small text-muted px-3">Receive your QR-coded verified permit instantly.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5 text-center text-white" style="background: #0d6efd;">
        <div class="container">
            <h3 class="fw-bold mb-3">Ready to get started?</h3>
            <p class="mb-4 opacity-75">Join thousands of users experiencing efficient government services.</p>
            <a href="/naps/apply" class="btn btn-light btn-lg px-5 fw-bold text-primary shadow">Apply Now</a>
        </div>
    </section>
</div>

<?php include 'layouts/footer.php'; ?>