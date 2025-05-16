<footer class="bg-primary text-white py-4">
    <div class="container">
        <div class="row g-4">

            <!-- Logo & Description -->
            <div class="col-12 col-sm-12 col-md-12 col-lg-4 text-center">
                <img src="/images/web assets/logo_full.jpeg" alt="College Vihar" class="img-fluid rounded-2 mb-2" style="max-width: 120px;">
                <p>
                    College Vihar offers flexible and personalized online degree programs in partnership with top universities, empowering students to learn anytime, anywhere, at their own pace.
                </p>
            </div>

            <!-- Company Links -->
            <div class="col-4 col-sm-4 col-md-3 col-lg-2 company_links">
                <h6 class="fw-bold" style="text-align: center;">Company</h6>
                <ul class="list-unstyled small " style="width: fit-content; margin: auto;">
                    <li><a href="/about" class="text-white text-decoration-none">About Us</a></li>
                    <li><a href="/privacy-policy" class="text-white text-decoration-none">Privacy Policy</a></li>
                    <li><a href="/refund-policy" class="text-white text-decoration-none">Refund Policy</a></li>
                    <li><a href="/terms-of-use" class="text-white text-decoration-none">Terms of Use</a></li>
                    <li><a href="/disclaimer" class="text-white text-decoration-none">Disclaimer</a></li>
                    <li><a href="/career" class="text-white text-decoration-none">Career</a></li>
                    <li><a href="/contact" class="text-white text-decoration-none">Contact</a></li>
                </ul>
            </div>

            <!-- Master's Courses -->
            <div class="col-4 col-sm-4 col-md-3 col-lg-2">
                <h6 class="fw-bold" style="text-align: center;">Master's</h6>
                <ul class="list-unstyled small" style="width: fit-content; margin: auto;">
                    <li><a href="/course" class="text-white text-decoration-none">M.B.A.</a></li>
                    <li><a href="/course" class="text-white text-decoration-none">M.C.A.</a></li>
                    <li><a href="/course" class="text-white text-decoration-none">M.M.C.</a></li>
                    <li><a href="/course" class="text-white text-decoration-none">M.Arch.</a></li>
                    <li><a href="/course" class="text-white text-decoration-none">M.Phil.</a></li>
                </ul>
            </div>

            <!-- Bachelor's Courses -->
            <div class="col-4 col-sm-4 col-md-3 col-lg-2">
                <h6 class="fw-bold" style="text-align: center;">Bachelor's</h6>
                <ul class="list-unstyled small" style="width: fit-content; margin: auto;">
                    <li><a href="/course" class="text-white text-decoration-none">B.B.A.</a></li>
                    <li><a href="/course" class="text-white text-decoration-none">B.C.A.</a></li>
                    <li><a href="/course" class="text-white text-decoration-none">B.M.C.</a></li>
                    <li><a href="/course" class="text-white text-decoration-none">B.Arch.</a></li>
                    <li><a href="/course" class="text-white text-decoration-none">B.Phil.</a></li>
                </ul>
            </div>

            <!-- Contact & Social -->
            <div class="col-12 col-sm-12 col-md-3 col-lg-2 contact_us">
                <div class="contact_details">
                    <h6 class="fw-bold" style="text-align: center;">Contact Us</h6>
                    <ul class="list-unstyled small mb-3" style="width: fit-content; margin: auto; text-align: center;">
                        <li><a href="tel:+919266585858" class="text-white text-decoration-none">+91 9266585858</a></li>
                        <li><a href="mailto:info@collegevihar.com" class="text-white text-decoration-none">info@collegevihar.com</a></li>
                    </ul>
                </div>
                <div class="footer_social">
                    <h6 class="fw-bold" style="text-align: center;">Follow Us</h6>
                    <ul class="list-inline" style="width: fit-content; margin: auto;">
                        <li class="list-inline-item">
                            <a href="#" class="text-white fs-5" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                        </li>
                        <li class="list-inline-item">
                            <a href="#" class="text-white fs-5" aria-label="WhatsApp"><i class="fab fa-whatsapp"></i></a>
                        </li>
                        <li class="list-inline-item">
                            <a href="#" class="text-white fs-5" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                        </li>
                        <li class="list-inline-item">
                            <a href="#" class="text-white fs-5" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Footer Bottom -->
        <div class="row mt-4">
            <div class="col text-center">
                <p class="small m-0">&copy; <span id="year"></span> College Vihar Inc. All Rights Reserved.</p>
            </div>
        </div>
    </div>
</footer>

<!-- WhatsApp Script -->
<script>
    function sendMessage() {
        var phoneNumber = '+8755007608';
        var message = 'Hi Sir/Mam, I have a query regarding the course.';
        var apiUrl = 'https://api.whatsapp.com/send?phone=' + phoneNumber + '&text=' + encodeURIComponent(message);

        var newTab = window.open(apiUrl, '_blank');

        if (!newTab || newTab.closed || typeof newTab.closed == 'undefined') {
            window.location.href = apiUrl;
        }
    }

    // Current Year Script
    document.getElementById("year").textContent = new Date().getFullYear();
</script>
