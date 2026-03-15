<?php 
include 'layouts/header.php'; 
?>
<div class="container-fluid py-4">
    
    <div class="row mb-4 text-center">
        <div class="col-12">
            <h3 class="fw-bold text-dark">Help Center</h3>
            <p class="text-muted">Find answers to common questions and learn how to use NAPS.</p>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-md-5">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3 text-primary">How to use NAPS</h5>
                    <div class="instruction-step mb-3 d-flex">
                        <div class="step-num me-3 bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 30px; height: 30px; flex-shrink: 0;">1</div>
                        <p class="small"><strong>Complete your Profile:</strong> Ensure your NIDA information and contact details are up to date.</p>
                    </div>
                    <div class="instruction-step mb-3 d-flex">
                        <div class="step-num me-3 bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 30px; height: 30px; flex-shrink: 0;">2</div>
                        <p class="small"><strong>Apply for Service:</strong> Go to 'Service Applications' and select the service you need.</p>
                    </div>
                    <div class="instruction-step mb-3 d-flex">
                        <div class="step-num me-3 bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 30px; height: 30px; flex-shrink: 0;">3</div>
                        <p class="small"><strong>Make Payment:</strong> Use the generated Control Number in 'My Payments' to pay via Mobile Money or Bank.</p>
                    </div>
                    
                    <hr>
                    <h6 class="fw-bold text-dark mt-4">Emergency Contact</h6>
                    <p class="text-muted small">If you face technical issues, reach us via:</p>
                    <ul class="list-unstyled small">
                        <li class="mb-2"><i class="bi bi-telephone-fill text-primary me-2"></i> Toll Free: <strong>0800 110 000</strong></li>
                        <li class="mb-2"><i class="bi bi-envelope-at-fill text-primary me-2"></i> Email: <strong>support@naps.go.tz</strong></li>
                        <li><i class="bi bi-clock-fill text-primary me-2"></i> Mon - Fri: <strong>08:00 AM - 04:00 PM</strong></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-md-7">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4 text-primary">Frequently Asked Questions</h5>
                    
                    <div class="faq-container">
                        
                        <div class="faq-item border-bottom mb-2">
                            <button class="faq-question btn w-100 text-start py-3 d-flex justify-content-between align-items-center shadow-none border-0 px-0">
                                <span class="fw-semibold">How do I get my Control Number?</span>
                                <i class="bi bi-chevron-down transition-all"></i>
                            </button>
                            <div class="faq-answer pb-3 ps-2 text-muted small" style="display: none;">
                                After submitting a service application, navigate to the <strong>'My Payments'</strong> section. Your control number will be listed there under 'Pending Payments'.
                            </div>
                        </div>

                        <div class="faq-item border-bottom mb-2">
                            <button class="faq-question btn w-100 text-start py-3 d-flex justify-content-between align-items-center shadow-none border-0 px-0">
                                <span class="fw-semibold">Can I change my NIDA information?</span>
                                <i class="bi bi-chevron-down transition-all"></i>
                            </button>
                            <div class="faq-answer pb-3 ps-2 text-muted small" style="display: none;">
                                No. NIDA Bio-data is pulled directly from the National Database and is read-only. For any corrections, please visit the nearest NIDA office.
                            </div>
                        </div>

                        <div class="faq-item border-bottom mb-2">
                            <button class="faq-question btn w-100 text-start py-3 d-flex justify-content-between align-items-center shadow-none border-0 px-0">
                                <span class="fw-semibold">How long does application processing take?</span>
                                <i class="bi bi-chevron-down transition-all"></i>
                            </button>
                            <div class="faq-answer pb-3 ps-2 text-muted small" style="display: none;">
                                Standard processing takes 3 to 5 working days. You will receive a notification immediately once your application status changes.
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'layouts/footer.php'; ?>
<style>
    .faq-question:hover { color: #0d6efd; }
    .transition-all { transition: transform 0.3s ease; }
    .faq-question.active i { transform: rotate(180deg); }
    .faq-answer { line-height: 1.6; }
</style>

<script>
document.querySelectorAll('.faq-question').forEach(button => {
    button.addEventListener('click', () => {
        const faqAnswer = button.nextElementSibling;

        button.classList.toggle('active');

        if (button.classList.contains('active')) {
            faqAnswer.style.display = 'block';
        } else {
            faqAnswer.style.display = 'none';
        }
    });
});
</script>
