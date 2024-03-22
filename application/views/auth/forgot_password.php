<div class="mb-5">
    <div class="container d-grid d-md-flex p-4 p-md-0 position-relative">
        <div class="w-100">
            <div class="d-none d-lg-block">
                <img src="<?= base_url('assets/images/login-1.png') ?>" class="float-end d-block img-fluid rounded-5 rounded-start h-auto ">
            </div>
            <div class="col-12 col-lg-6 h-100 p-4 bg-white rounded-5 position-absolute" id="formLogin">
                <div class="d-flex ps-4 flex-column justify-content-center h-100">
                    <?= (!empty($msg) ? $msg : "") ?>
                    <h4 class="ps-1 fw-semibold">Reset Password</h4>
                    <h5 class="fw-normal mt-5">Please Enter Your Email Address To <br>Reset Your Password</h5>
                    <form class="fw-normal" action="<?= base_url('forgotPassword') ?>" method="POST">
                        <div class="my-4 float-label-control">
                            <input type="email" class="form-control border-bottom border-0 shadow-none rounded-0 ps-1" id="exampleInputEmail1" name="email" placeholder="Email" aria-describedby="emailHelp">
                        </div>
                        <div class="my-4">
                            <button type="submit" class="btn btn-primary w-100 rounded-3 fw-semibold py-2 text-black border-0">Reset Password</button>
                        </div>
                        <div class="my-4 text-center">
                            <a href="<?= base_url('login') ?>" class="text-decoration-none text-black">Back to Login</a>
                        </div>
                    </form>
                </div>

            </div>
        </div>

    </div>
</div>