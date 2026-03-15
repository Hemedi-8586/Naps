<style>
    .dashboard-wrapper {
        background: #f4f7fa;
        min-height: 100vh;
        padding-top: 20px;
    }
    .welcome-banner {
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        border-radius: 20px;
        padding: 40px;
        position: relative;
        overflow: hidden;
    }
    .welcome-banner::after {
        content: "";
        position: absolute;
        top: -50px;
        right: -50px;
        width: 200px;
        height: 200px;
        background: rgba(255, 255, 255, 0.03);
        border-radius: 50%;
    }
    .service-poster {
        border: none;
        border-radius: 20px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        background: #fff;
    }
    .service-poster:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.08) !important;
    }
    .icon-shape {
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
    }
    .quick-link-card {
        border-radius: 15px;
        border-left: 5px solid #0d6efd;
    }
</style>

<div class="dashboard-wrapper">
    <div class="container-fluid px-4">
        
        <div class="welcome-banner shadow-sm mb-4">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h2 class="text-white fw-bold mb-2">Welcome to NAPS Portal, <?= htmlspecialchars (ucfirst($username)) ?>!</h2>
                    <p class="text-white-50 mb-4">
                        Digital Transformation for National Services. Access all permits and authorization tools from your unified dashboard.
                    </p>
                    <div class="d-flex gap-2">
                        <span class="badge bg-primary px-3 py-2 rounded-pill shadow-sm text-uppercase">
                            <i class="bi bi-person-badge me-2"></i><?= $role ?> Account
                        </span>
                        <span class="badge bg-success px-3 py-2 rounded-pill shadow-sm">
                            <i class="bi bi-shield-check me-2"></i>Verified
                        </span>
                    </div>
                </div>
                <div class="col-md-4 d-none d-md-block text-end">
                    <i class="bi bi-shield-shaded text-white opacity-25" style="font-size: 8rem;"></i>
                </div>
            </div>
        </div>

        <div class="row g-4 mb-5">
            <div class="col-md-6 col-xl-3">
                <div class="card service-poster shadow-sm h-100 p-3">
                    <div class="card-body">
                        <div class="icon-shape bg-primary bg-opacity-10 text-primary mb-3">
                            <i class="bi bi-file-earmark-plus fs-4"></i>
                        </div>
                        <h5 class="fw-bold text-dark">New Permit</h5>
                        <p class="text-muted small">Start a new application for building, business, or operational permits.</p>
                        <a href="/naps/citizen/apply" class="btn btn-outline-primary btn-sm rounded-pill px-4 mt-2">Begin Now</a>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-xl-3">
                <div class="card service-poster shadow-sm h-100 p-3">
                    <div class="card-body">
                        <div class="icon-shape bg-success bg-opacity-10 text-success mb-3">
                            <i class="bi bi-clock-history fs-4"></i>
                        </div>
                        <h5 class="fw-bold text-dark">Track Status</h5>
                        <p class="text-muted small">Check the progress of your submitted applications in real-time.</p>
                        <a href="/naps/tracking" class="btn btn-outline-success btn-sm rounded-pill px-4 mt-2">View History</a>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-xl-3">
                <div class="card service-poster shadow-sm h-100 p-3">
                    <div class="card-body">
                        <div class="icon-shape bg-warning bg-opacity-10 text-warning mb-3">
                            <i class="bi bi-wallet2 fs-4"></i>
                        </div>
                        <h5 class="fw-bold text-dark">Payments</h5>
                        <p class="text-muted small">View control numbers and settle outstanding service fees securely.</p>
                        <a href="/naps/citizen/payments" class="btn btn-outline-warning btn-sm rounded-pill px-4 mt-2">Bills Portal</a>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-xl-3">
                <div class="card service-poster shadow-sm h-100 p-3">
                    <div class="card-body">
                        <div class="icon-shape bg-info bg-opacity-10 text-info mb-3">
                            <i class="bi bi-question-circle fs-4"></i>
                        </div>
                        <h5 class="fw-bold text-dark">Support Hub</h5>
                        <p class="text-muted small">Need help? Access documentation or message the technical desk.</p>
                        <a href="/naps/contact" class="btn btn-outline-info btn-sm rounded-pill px-4 mt-2">Contact Us</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4 p-4 h-100">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="fw-bold text-dark mb-0">System Notifications</h5>
                        <a href="#" class="small text-decoration-none">View All</a>
                    </div>
                    
                    <div class="d-flex p-3 border-bottom mb-2">
                        <div class="flex-shrink-0 text-primary">
                            <i class="bi bi-info-circle-fill fs-5"></i>
                        </div>
                        <div class="ms-3">
                            <h6 class="mb-1 fw-bold">Maintenance Schedule</h6>
                            <p class="text-muted small mb-0">The portal will undergo scheduled maintenance on Saturday, Feb 14th from 12:00 AM to 04:00 AM.</p>
                        </div>
                    </div>

                    <div class="d-flex p-3">
                        <div class="flex-shrink-0 text-success">
                            <i class="bi bi-check-circle-fill fs-5"></i>
                        </div>
                        <div class="ms-3">
                            <h6 class="mb-1 fw-bold">New Payment System Integrated</h6>
                            <p class="text-muted small mb-0">You can now settle permit fees using mobile money agents nationwide.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 p-4 h-100" style="background: #fff;">
                    <h5 class="fw-bold text-dark mb-4">Quick Shortcuts</h5>
                    <div class="list-group list-group-flush">
                        <a href="#" class="list-group-item list-group-item-action border-0 px-0 d-flex align-items-center">
                            <i class="bi bi-file-earmark-text me-3 text-muted"></i> User Manual (PDF)
                        </a>
                        <a href="#" class="list-group-item list-group-item-action border-0 px-0 d-flex align-items-center">
                            <i class="bi bi-key me-3 text-muted"></i> Change Password
                        </a>
                        <a href="#" class="list-group-item list-group-item-action border-0 px-0 d-flex align-items-center text-danger">
                            <i class="bi bi-box-arrow-right me-3"></i> Logout Account
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>