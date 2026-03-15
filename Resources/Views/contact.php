<?php 
$title = "Contact Us - NAPS Support";
include 'layouts/header.php'; 
?>

<style>
    .contact-wrapper {
        background-color: #f8fafc;
        min-height: 100vh;
    }
    .hero-mini {
        padding-top: 80px; 
        padding-bottom: 40px;
        background: linear-gradient(135deg, #0a2351 0%, #0d6efd 100%);
        border-radius: 0 0 40px 40px;
    }
    .contact-card {
        border-radius: 16px;
        transition: 0.3s;
        border: none;
    }
    .form-compact .form-control, .form-compact .form-select {
        padding: 0.6rem 1rem;
        font-size: 0.95rem;
        border-radius: 10px;
        background-color: #f1f5f9;
        border: 1px solid transparent;
    }
    .form-compact .form-control:focus {
        background-color: #fff;
        border-color: #0d6efd;
        box-shadow: 0 0 0 4px rgba(13, 110, 253, 0.1);
    }
    .icon-box {
        width: 45px;
        height: 45px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
    }
</style>

<div class="contact-wrapper">
    <section class="hero-mini text-center text-white mb-5 shadow-sm">
        <div class="container">
            <h1 class="fw-bold mb-2">Contact Support</h1>
            <p class="opacity-75 small mx-auto" style="max-width: 500px;">
                Our team is here to help with your technical and permit inquiries.
            </p>
        </div>
    </section>

    <div class="container pb-5">
        <div class="row g-4 justify-content-center">
            
            <div class="col-lg-4">
                <div class="card shadow-sm p-4 h-100 contact-card bg-white">
                    <h5 class="fw-bold mb-4">Get in Touch</h5>
                    
                    <div class="d-flex align-items-center mb-4">
                        <div class="icon-box bg-primary text-white shadow-sm">
                            <i class="bi bi-envelope-at"></i>
                        </div>
                        <div class="ms-3">
                            <p class="small text-muted mb-0 text-uppercase" style="font-size: 0.7rem; letter-spacing: 1px;">Email Support</p>
                            <span class="fw-bold small">support@naps.go.tz</span>
                        </div>
                    </div>

                    <div class="d-flex align-items-center mb-4">
                        <div class="icon-box bg-success text-white shadow-sm">
                            <i class="bi bi-telephone-inbound"></i>
                        </div>
                        <div class="ms-3">
                            <p class="small text-muted mb-0 text-uppercase" style="font-size: 0.7rem; letter-spacing: 1px;">Call Center</p>
                            <span class="fw-bold small">+255 628 275 455</span>
                        </div>
                    </div>

                    <div class="d-flex align-items-center mb-4">
                        <div class="icon-box bg-warning text-white shadow-sm">
                            <i class="bi bi-geo-alt"></i>
                        </div>
                        <div class="ms-3">
                            <p class="small text-muted mb-0 text-uppercase" style="font-size: 0.7rem; letter-spacing: 1px;">Location</p>
                            <span class="fw-bold small">Gov Building, Dar es Salaam</span>
                        </div>
                    </div>

                    <hr class="text-muted opacity-25">
                    <p class="text-muted italic" style="font-size: 0.8rem;">Available Mon - Fri, 08:00 AM - 05:00 PM</p>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card shadow-sm p-4 p-md-5 contact-card bg-white">
                    <h5 class="fw-bold text-dark mb-1">Send a Message</h5>
                    <p class="text-muted small mb-4">We usually respond within 24 hours.</p>

                    <form id="contactForm" method="POST" action="process_contact.php" class="form-compact">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-secondary">Full Name</label>
                                <input type="text" class="form-control" name="full_name" placeholder="Hemedi M." required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-secondary">Email Address</label>
                                <input type="email" class="form-control" name="email" placeholder="hemedi@example.com" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label small fw-bold text-secondary">Inquiry Category</label>
                                <select class="form-select" name="subject" required>
                                    <option value="">Choose one...</option>
                                    <option value="technical">Technical Support</option>
                                    <option value="billing">Payments & Control Numbers</option>
                                    <option value="status">Application Status</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label small fw-bold text-secondary">Your Message</label>
                                <textarea class="form-control" name="message" rows="3" placeholder="Describe your issue..." required></textarea>
                            </div>
                            <div class="col-12 pt-2">
                                <button type="submit" class="btn btn-primary w-100 fw-bold py-2 shadow-sm rounded-3">
                                    <i class="bi bi-send-fill me-2"></i>Send Message
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="row mt-5 justify-content-center">
            <div class="col-lg-10">
                <div class="text-center mb-4">
                    <h6 class="fw-bold text-primary">Frequently Asked Questions</h6>
                </div>
                <div class="accordion accordion-flush" id="faqAccordion">
                    <div class="accordion-item border rounded-4 mb-2 overflow-hidden shadow-sm">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed fw-semibold small py-3" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                <i class="bi bi-question-circle me-2 text-primary"></i> How do I get my Control Number?
                            </button>
                        </h2>
                        <div id="faq1" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body text-muted small py-3">
                                Control numbers are automatically generated upon application submission and can be found in your Dashboard under 'My Payments'.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'layouts/footer.php'; ?>