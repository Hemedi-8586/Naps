<footer class="naps-footer mt-auto">
    <div class="container-fluid px-lg-5">
        <?php if (!isset($isDashboard) || !$isDashboard): ?>
        <div class="footer-top py-4">
            <div class="row g-4">
                <div class="col-lg-4">
                    <div class="footer-brand-box">
                        <h5 class="fw-bold text-white mb-3">
                            <i class="bi bi-shield-shaded text-primary me-2"></i>NAPS PORTAL
                        </h5>
                        <p class="text-white-50 small mb-4">
                            The official digital gateway for government authorizations and permits. Streamlining public services through transparency and innovation.
                        </p>
                        <div class="d-flex gap-2">
                            <a href="#" class="social-btn"><i class="bi bi-facebook"></i></a>
                            <a href="#" class="social-btn"><i class="bi bi-twitter-x"></i></a>
                            <a href="#" class="social-btn"><i class="bi bi-linkedin"></i></a>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-2 col-md-4">
                    <h6 class="text-white fw-bold mb-3 small text-uppercase tracking-wider">Resources</h6>
                    <ul class="list-unstyled footer-links">
                        <li><a href="/naps/about">About NAPS</a></li>
                        <li><a href="/naps/services">Our Services</a></li>
                        <li><a href="/naps/help">Help Center</a></li>
                    </ul>
                </div>

                <div class="col-lg-2 col-md-4">
                    <h6 class="text-white fw-bold mb-3 small text-uppercase tracking-wider">Legal</h6>
                    <ul class="list-unstyled footer-links">
                        <li><a href="/naps/privacy">Privacy Policy</a></li>
                        <li><a href="/naps/terms">Terms of Use</a></li>
                    </ul>
                </div>

                <div class="col-lg-4 col-md-4">
                    <h6 class="text-white fw-bold mb-3 small text-uppercase tracking-wider">Contact Support</h6>
                    <div class="contact-pill mb-2">
                        <i class="bi bi-envelope-fill me-2"></i> support@naps.go.tz
                    </div>
                    <div class="contact-pill">
                        <i class="bi bi-telephone-fill me-2"></i> +255 628 275 455
                    </div>
                </div>
            </div>
        </div>
        <hr class="footer-divider">
        <?php endif; ?>

        <div class="footer-bottom py-3">
            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-start">
                    <span class="footer-copy text-white-50">
                        &copy; <?= date('Y') ?> <span class="text-white fw-medium">NAPS Portal</span>. Official Government System.
                    </span>
                </div>
                <div class="col-md-6 text-center text-md-end mt-2 mt-md-0">
                    <span class="footer-dev text-white-50">
                        Powered by <span class="text-primary fw-semibold"><a href="/UniTech Innovators /index.html">UniTech Innovators</a></span> 
                        <i class="bi bi-lightbulb-fill text-warning ms-1"></i>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <button id="scrollToTop" class="btn-scroll-top shadow-lg border-0" title="Back to top">
        <i class="bi bi-chevron-up"></i>
    </button>
</footer>

<style>
    .naps-footer { background-color: #0f172a; color: rgba(255, 255, 255, 0.7); }
    .footer-divider { border-top: 1px solid rgba(255, 255, 255, 0.08); }
    .footer-links a { text-decoration: none; color: rgba(255, 255, 255, 0.5); font-size: 0.85rem; transition: 0.2s; }
    .footer-links a:hover { color: #3b82f6; padding-left: 5px; }
    .social-btn { width: 36px; height: 36px; background: rgba(255, 255, 255, 0.05); display: inline-flex; align-items: center; justify-content: center; border-radius: 8px; color: white; text-decoration: none; }
    .social-btn:hover { background: #3b82f6; transform: translateY(-3px); }
    .contact-pill { background: rgba(255, 255, 255, 0.03); padding: 8px 15px; border-radius: 10px; font-size: 0.85rem; border: 1px solid rgba(255, 255, 255, 0.05); }
    .btn-scroll-top { position: fixed; bottom: 25px; right: 25px; width: 42px; height: 42px; background: #3b82f6; color: white; border-radius: 12px; display: none; align-items: center; justify-content: center; z-index: 1050; transition: 0.3s; }
    .btn-scroll-top.show { display: flex; }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const scrollBtn = document.getElementById('scrollToTop');
    window.addEventListener('scroll', () => {
        if (window.scrollY > 400) { scrollBtn.classList.add('show'); } 
        else { scrollBtn.classList.remove('show'); }
    });
    scrollBtn.addEventListener('click', () => { window.scrollTo({ top: 0, behavior: 'smooth' }); });
});
</script>

<script src="/naps/Public/Assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>