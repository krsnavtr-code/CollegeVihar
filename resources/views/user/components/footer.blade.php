<footer class="bg-blue py-2">
    <div class="container">
        <div class="row py-1 flex-wrap">
            <!-- Logo & Description -->
            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                <article class="text-center">
                    <figure class="rounded-1">
                        <img src="/images/web assets/logo_full.jpeg" alt="College Vihar" class="img-fluid rounded-1 mx-auto d-block"        style="max-width: 50%;">
                    </figure>
                    <p style="font-size: 0.7rem;">
                        College Vihar offers flexible and personalized online degree programs in partnership with top universities,         empowering students to learn anytime, anywhere, at their own pace — designed to fit their career goals and      lifestyle.
                    </p>
                </article>
            </div>


            <!-- Quick Links -->
            <div class="col-6 col-md-3 col-lg-2 p-2">
                <article>
                    <h5 style="font-size: 1rem;">Quick Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="/about">About Us</a></li>
                        <li><a href="/privacy-policy">Privacy Policy</a></li>
                        <li><a href="/refund-policy">Refund Policy</a></li>
                        <li><a href="/terms-of-use">Terms of Use</a></li>
                    </ul>
                </article>
            </div>

            <!-- Useful Links -->
            <div class="col-6 col-md-3 col-lg-2 p-2">
                <article>
                    <h5 style="font-size: 1rem;">Useful Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="/disclaimer">Disclaimer</a></li>
                        <li><a href="/faqs">FAQs</a></li>
                        <li><a href="/career">Career</a></li>
                        <li><a href="/contact">Contact</a></li>
                    </ul>
                </article>
            </div>

            <!-- Master's Courses -->
            <div class="col-6 col-md-3 col-lg-2 p-2">
                <article>
                    <h5 style="font-size: 1rem;">Master's Courses</h5>
                    <ul class="list-unstyled">
                        <li><a href="/course">M.B.A.</a></li>
                        <li><a href="/course">M.C.A.</a></li>
                        <li><a href="/course">M.M.C.</a></li>
                        <li><a href="/course">M.Arch.</a></li>
                        <li><a href="/course">M.Phil.</a></li>
                    </ul>
                </article>
            </div>

            <!-- Bachelor's Courses -->
            <div class="col-6 col-md-3 col-lg-2 p-2">
                <article>
                    <h5 style="font-size: 1rem;">Bachelor's Courses</h5>
                    <ul class="list-unstyled">
                        <li><a href="/course">B.B.A.</a></li>
                        <li><a href="/course">B.C.A.</a></li>
                        <li><a href="/course">B.M.C.</a></li>
                        <li><a href="/course">B.Arch.</a></li>
                        <li><a href="/course">B.Phil.</a></li>
                    </ul>
                </article>
            </div>
        </div>

        <!-- <div class="container-fluid">
            <div class="row justify-content-end">
                <div class="col-md-6 d-flex flex-column align-items-end text-end">
                    <p class="mb-0">Follow us on</p>
                    <ul class="list-unstyled d-flex gap-3 m-0">
                        <li><a href="#"><i class="fa-brands fa-facebook"></i></a></li>
                        <li><a href="#"><i class="fa-brands fa-whatsapp"></i></a></li>
                        <li><a href="#"><i class="fa-brands fa-instagram red"></i></a></li>
                        <li><a href="#"><i class="fa-brands fa-linkedin"></i></a></li>
                    </ul>
                </div>
            </div>
        </div> -->
    
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <p>&copy; <span id="year"></span> College Vihar Inc. All Rights Reserved.</p>
                </div>
            </div>
        </div>
    </div>
</footer>
<script>
    function sendMessage() {
        var phoneNumber = '+8755007608';
        var message = 'Hii Sir/Mam I have query regarding course..';

        var apiUrl = 'https://api.whatsapp.com/send?phone=' + phoneNumber + '&text=' + encodeURIComponent(message);

        var newTab = window.open(apiUrl, '_blank');

        if (!newTab || newTab.closed || typeof newTab.closed == 'undefined') {
            window.location.href = apiUrl;
        }
    }
</script>

<script>
    document.getElementById("year").textContent = new Date().getFullYear();
</script>



{{-- 
            <!-- <div class="col-md-3 p-2">
                <article>
                    <h5>Top Degree Courses</h5>
                    <ul>
                        <li><a href="/course">Master of Business Administration (M.B.A.)</a></li>
                        <li><a href="/course">Master of Computer Applications (M.C.A.)</a></li>
                        <li><a href="/course">Master of Laws (L.L.M.)</a></li>
                        <li><a href="/course">Master of Science (M.Sc.)</a></li>
                        <li><a href="/course">Master of Hotel Management (M.H.M.)</a></li>
                    </ul>
                </article>
            </div> -->
            <!-- <div class="col-md-3 col-6 p-2">
                <article>
                    <h5>Top Universities</h5>
                    <ul>
                        <li><a href="/university">Manipal University</a></li>
                        <li><a href="/university">Jain University</a></li>
                        <li><a href="/university">SRM University</a></li>
                        <li><a href="/university">D Y PATIL University</a></li>
                        <li><a href="/university">Lovely Professional University</a></li>
                    </ul>
                </article>
            </div> -->
            <!-- <div class="col-md-3 col-6 p-2">
                <article>
                    <h5>Study Abroad</h5>
                    <ul>
                        <li><a href="#">Australia</a></li>
                        <li><a href="#">New Zealand</a></li>
                        <li><a href="#">United Kingdom</a></li>
                        <li><a href="#">Germany</a></li>
                        <li><a href="#">South Africa</a></li>
                    </ul>
                </article>
            </div> -->
            --}}