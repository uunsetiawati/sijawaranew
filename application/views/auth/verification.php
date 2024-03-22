<!-- Login -->
<div class="mb-5">
    <div class="container d-grid d-md-flex p-4 p-md-0 position-relative">
        <div class="w-100">
            <div class="d-none d-lg-block">
                <img src="<?= base_url('assets/images/login-1.png') ?>"
                    class="float-end d-block img-fluid rounded-5 rounded-start h-auto ">
            </div>
            <div class="col-12 col-lg-6 h-100 p-4 bg-white rounded-5 position-absolute" id="formLogin">
                <div class="d-flex ps-4 flex-column justify-content-center h-100">
                    <h4 class="ps-1 fw-semibold">Verification</h4>
                    <p class="ps-1 pt-5 fs-5 pe-7 text-decoration-none text-black">Please Enter The Validation Code
                        That Get From Your Email</p>
                    <form class="fw-normal">
                        <div id="otp" class="inputs d-flex flex-row me-5 justify-content-center my-2 mb-3">
                            <input class="m-2 text-center otp form-control rounded" type="number" id="first"
                                maxlength="1" />
                            <input class="m-2 text-center otp form-control rounded" type="number" id="second"
                                maxlength="1" />
                            <input class="m-2 text-center otp form-control rounded" type="number" id="third"
                                maxlength="1" />
                            <input class="m-2 text-center otp form-control rounded" type="number" id="fourth"
                                maxlength="1" />
                            <input class="m-2 text-center otp form-control rounded" type="number" id="fifth"
                                maxlength="1" />
                            <input class="m-2 text-center otp form-control rounded" type="number" id="sixth"
                                maxlength="1" />
                        </div>
                        <div class="my-4 mt-5">
                            <button type="submit"
                                class="btn btn-primary w-100 rounded-3 fw-semibold py-2 text-black border-0">Verification</button>
                        </div>
                        <div class="my-4 text-center">
                            <span>Didn't get the code? <a href="<?= base_url('register') ?>"
                                    class="text-decoration-none fw-bold text-black">Resend</a></span>
                        </div>
                    </form>
                </div>

            </div>
        </div>

    </div>
</div>
<!-- End Login -->

<script>
document.addEventListener("DOMContentLoaded", function(event) {

    function OTPInput() {
        const inputs = document.querySelectorAll('#otp > *[id]');
        for (let i = 0; i < inputs.length; i++) {
            inputs[i].addEventListener('keydown', function(event) {
                if (event.key === "Backspace") {
                    inputs[i].value = '';
                    if (i !== 0) inputs[i - 1].focus();
                } else {
                    if (i === inputs.length - 1 && inputs[i].value !== '') {
                        return true;
                    } else if (event.keyCode > 47 && event.keyCode < 58) {
                        inputs[i].value = event.key;
                        if (i !== inputs.length - 1) inputs[i + 1].focus();
                        event.preventDefault();
                        if (i == 5) {
                            inputs[i].blur();
                        }
                    } else if (event.keyCode > 64 && event.keyCode < 91) {
                        event.preventDefault();
                    }
                }
            });
        }
    }
    OTPInput();
});
</script>