<!-- Footer -->
<footer class="bg-footer text-white footer w-100" id="footer">
    <div class="container pt-5 pb-4 px-md-0">
        <div class="row pb-lg-5 pb-2 justify-content-between" style="font-size: 0.9rem !important;">
            <div class="col-lg-3 pb-4">
                <img src="<?= base_url('assets/images/new/NAV-LOGO.png') ?>" class="img-fluid">
                <div class="mt-lg-4 mt-3">
                    <!-- <span>Everyone can share and learn</span> -->
                </div>
            </div>
            <div class="col-lg-2 pb-4">
                <span class="fw-semibold" style="font-size: 1.1rem;">Pages</span>
                <div class="vstack mt-lg-4 mt-3 gap-1">
                    <a href="<?= base_url('') ?>" class="text-decoration-none text-white">Home</a>
                    <!-- <a href="<?= base_url('register') ?>" class="text-decoration-none text-white">Teach with us!</a> -->
                    <a href="<?= base_url('course') ?>""#" class="text-decoration-none text-white">Courses</a>
                    <a href="<?= base_url('event') ?>" class="text-decoration-none text-white">Events</a>
                    <!-- <a href="<?= base_url('ebook') ?>" class="text-decoration-none text-white">E-Books</a> -->
                    <a href="<?= base_url('about') ?>" class="text-decoration-none text-white">About</a>
                </div>
            </div>
            <div class="col-lg-3 pb-4 ">
                <span class="fw-semibold" style="font-size: 1.1rem;">Contact</span>
                <div class="d-grid mt-lg-4 mt-3 gap-2">
                    <div class="">
                        <i class="bi bi-telephone-fill fs-5"></i>
                        <span class="ms-3">+62 899-2876-420</span>
                    </div>
                    <div class="">
                        <i class="bi bi-envelope fs-5"></i>
                        <span class="ms-3">inbis@stiki.ac.id</span>
                    </div>
                    <div class="d-inline-flex">
                        <i class="bi bi-geo-alt fs-5"></i>
                        <span class="ms-3" style="margin-left:1.2rem !important">Jl. Raya Tidar No.100,<br> Karangbesuki,
                            Kec. Sukun, <br>
                            Kota Malang, <br> East Java 65146,
                            13910</span>
                    </div>
                </div>

            </div>
            <div class="col-lg-3 pb-4">
                <span class="fw-semibold" style="font-size: 1.1rem;">Get in Touch</span>
                <div class="mt-lg-4 mt-3">
                    <div class="input-group rounded-5 bg-white p-1">
                        <input type="text" class="form-control border-0 rounded-end rounded-5 shadow-none me-1" placeholder="Your Email" aria-label="Your Email" aria-describedby="button-addon2">
                        <button class="btn bg-footer text-white rounded-circle" type="button" id="button-addon2"><i class="bi bi-send-fill"></i></button>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex flex-column-reverse flex-md-row align-items-end justify-content-between">
            <div class="mb-2 fw-light ">
                <small>Copyright © 2022 The Brain & Heart. All Rights Reserved.</small>
            </div>
            <div class="d-flex gap-3 mb-4 mb-md-0">
                <!-- <img src="<?= base_url('assets/images/logo_startic.svg') ?>" style="width:30% !important">
                <img src="<?= base_url('assets/images/logo_assembly.svg') ?>" style="width:30% !important">
                <img src=" <?= base_url('assets/images/logo_stiki.svg') ?>" syle=" width:15% !important"> -->
            </div>
        </div>
</footer>
<a href="https://api.whatsapp.com/send?phone=+6281340214485&text=Hai%2C%20saya%20ingin%20bertanya%20%3F" target="_blank" class="floating-whatsapp-button">
    <i class="fa-brands fa-whatsapp"></i>
</a>
</div>
<style>
    .floating-whatsapp-button {
        position: fixed;
        bottom: 20px;
        right: 20px;
        background-color: #25d366;
        z-index: 100;
        color: #fff;
        border: none;
        border-radius: 50%;
        padding: 10px 15px;
        font-size: 24px;
        cursor: pointer;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.3);
    }
</style>

<!-- End Footer -->
</body>


</html>