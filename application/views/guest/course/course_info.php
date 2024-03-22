<div class="container px-4 px-md-0 py-4 pb-6 pt-3">
    <div class="row mt-3 flex-column flex-lg-row-reverse ">
        <div class="col-12 col-lg-5 d-flex flex-column align-items-center align-items-lg-end mb-md-0">
            <div class="ps-0 ps-lg-2 d-flex flex-column justify-content-end">
                <img src="<?= $course['IMAGE_ACTIVITY'] ?>" class="d-block img-fluid rounded-5 " style="height: 265px;object-fit:cover">
                <div class="my-3 fw-bold d-flex align-self-end justify-content-end pe-0 pe-lg-4 align-items-center me-2 text-black">
                    Share :<span class="fs-5"> <i class="bi bi-facebook mx-2" style="cursor: pointer"></i><i class="bi bi-twitter me-2" style="cursor: pointer"></i><i class="bi bi-instagram" style="cursor: pointer"></i></span>
                </div>
            </div>

            <div class="col-md-6 align-self-end d-lg-block d-none">
                <div class="rounded-2 bg-secondary " style="background-color:#E9E9E9 !important">
                    <div class="col col-10 d-flex flex-column my-4 py-3 mx-4 h-100 align-items-end">
                        <!-- <span class="fw-semibold fs-2 m-0 text-muted text-decoration-line-through">
                            Rp190.000
                        </span> -->
                        <span class="fw-semibold fs-2 m-0">
                            <?= ($course['PRICE_ACTIVITY'] == 0) ? "Free" : "Rp " . number_format($course['PRICE_ACTIVITY'], 2, ',', '.') ?>
                        </span>
                    </div>
                </div>
                <div class="d-flex justify-content-end">
                    <form id="FormBuyNow-info" method="POST" action="<?= base_url('purchase') ?>">
                        <div id="data-input-info"></div>
                        <div class="col-12 btn btn-primary text-black fw-semibold fs-4 text-white px-5" onclick="BuyNow()">Buy Now</div>
                    </form>
                    <div class="ms-3 d-flex justify-content-between align-items-baseline">
                        <a data-id-activity="<?= $course['ID_ACTIVITY'] ?>" onclick="AddToCart(this)" href="javascript:void(0)">
                            <img src="<?= base_url('assets/images/shopping-cart-empty.svg') ?>" class="checkout" style="width:2.8rem;height:2.8rem"></img>
                        </a>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-12 col-lg-7">
            <div class="d-flex flex-column ">
                <div class="">
                    <div class="d-flex flex-row align-items-center gap-2">
                        <p class="fw-semibold px-1 fs-5 m-0 rounded" style="color:white; background-color:#47DE13">NEW
                        </p>
                    </div>
                    <span class="fw-semibold fs-1"><?= $course['TITLE_ACTIVITY'] ?></span>
                    <div class="col-12 col-sm-6 position-relative">
                        <div class="row mt-2" style="grid-gap:20px">
                            <div class="col rounded-4 py-3 d-flex flex-column align-items-center" style="background-color:#EDEDED">
                                <h6 class="fw-semibold text-muted">Total Bab</h6>
                                <h6 class="fw-semibold"><?= $total_item['materi'] ?></h6>
                            </div>
                            <div class="col rounded-4 py-3 d-flex flex-column align-items-center" style="background-color:#EDEDED">
                                <div>
                                    <h6 class="fw-semibold text-muted">Total Quiz</h6>
                                    <h6 class="fw-semibold text-center"><?= $total_item['quiz'] ?></h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-5">
                    <nav>
                        <div class=" nav nav-tabs" id="nav-tab" role="tablist">
                            <!-- <button class="nav-link active border-0 col col-lg-6 fs-5" id="nav-announcement-tab" data-bs-toggle="tab" data-bs-target="#nav-announcement" type="button" role="tab" aria-controls="nav-announcement" aria-selected="true">ABOUT COURSE</button> -->
                            <?php if (empty($this->session->userdata('ID_USER'))) { ?>
                                <button class="nav-link active border-0 col col-lg-6 fs-5" id="nav-announcement-tab" data-bs-toggle="tab" data-bs-target="#nav-announcement" type="button" role="tab" aria-controls="nav-announcement" aria-selected="true">ABOUT COURSE</button>
                            <?php } else { ?>
                                <button class="nav-link active border-0 col col-lg-6 fs-5" id="nav-course-tab" data-bs-toggle="tab" data-bs-target="#nav-course" type="button" role="tab" aria-controls="nav-course" aria-selected="true">COURSE TOPICS CONTENT</button>
                                <button class="nav-link border-0 col col-lg-6 fs-5" id="nav-announcement-tab" data-bs-toggle="tab" data-bs-target="#nav-announcement" type="button" role="tab" aria-controls="nav-announcement" aria-selected="false">ABOUT COURSE</button>
                            <?php } ?>
                        </div>
                    </nav>
                </div>
                <div class="tab-content" id="nav-tabContent">
                    <?php if (empty($this->session->userdata('ID_USER'))) { ?>
                        <div class="tab-pane fade show active" id="nav-announcement" role="tabpanel" aria-labelledby="nav-announcement-tab" tabindex="0">
                            <div class="row flex-row gap-3">
                                <div class="col-3 my-4 d-none d-lg-block">
                                    <button class="btn btn-primary bg-primary border-primary border border-2 px-4 py-3 mb-3 rounded-3 shadow fw-semibold w-100" id="description" data-type="description" onclick="ChangePageAbout(this)">
                                        Description
                                    </button>
                                    <button class="btn border-primary border border-2 px-4 py-3 mb-3 rounded-3 shadow fw-semibold w-100" id="learn" data-type="learn" onclick="ChangePageAbout(this)">
                                        What to learn?
                                    </button>
                                    <button class="btn border-primary border border-2 px-4 py-3 mb-3 rounded-3 shadow fw-semibold w-100" id="instructor" data-type="instructor" onclick="ChangePageAbout(this)">
                                        Instructor
                                    </button>
                                </div>
                                <div class="col mx-0 my-4 mx-md-4 bg-secondary rounded-3">
                                    <div class="mx-4 my-4">
                                        <p class="pt-2 text-muted" id="page-about-course">
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } else { ?>
                        <div class="tab-pane fade show active" id="nav-course" role="tabpanel" aria-labelledby="nav-course-tab" tabindex="0">
                            <div class="row flex-row gap-3">
                                <div class="col my-4 bg-secondary rounded-3">
                                    <div class="mx-4 my-4">
                                        <?php if (!empty($item_course)) { ?>
                                            <?php foreach ($item_course as $item) :  ?>
                                                <p class="text-muted">
                                                    <i class="bi bi-play-circle-fill"></i>&ensp; <?= $item['TITLE'] ?>
                                                </p>
                                            <?php endforeach; ?>
                                        <?php } else { ?>
                                            <div class="d-flex flex-column align-items-center">
                                                <img src="https://img.freepik.com/free-vector/empty-concept-illustration_114360-7416.jpg" width="320">
                                                <p class="text-muted mt-4">
                                                    Tidak ada bab
                                                </p>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="nav-announcement" role="tabpanel" aria-labelledby="nav-announcement-tab" tabindex="0">
                            <div class="row flex-row gap-3">
                                <div class="col-3 my-4 d-none d-lg-block">
                                    <button class="btn btn-primary bg-primary border-primary border border-2 px-4 py-3 mb-3 rounded-3 shadow fw-semibold w-100" id="description" data-type="description" onclick="ChangePageAbout(this)">
                                        Description
                                    </button>
                                    <button class="btn border-primary border border-2 px-4 py-3 mb-3 rounded-3 shadow fw-semibold w-100" id="learn" data-type="learn" onclick="ChangePageAbout(this)">
                                        What to learn?
                                    </button>
                                    <button class="btn border-primary border border-2 px-4 py-3 mb-3 rounded-3 shadow fw-semibold w-100" id="instructor" data-type="instructor" onclick="ChangePageAbout(this)">
                                        Instructor
                                    </button>
                                </div>
                                <div class="col mx-4 my-4 bg-secondary rounded-3">
                                    <div class="mx-4 my-4">
                                        <p class="pt-2 text-muted" id="page-about-course">
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    $("#description").trigger('click')
    $("document").ready(function() {
        $(".checkout").mouseenter(function() {
            $(this).attr('src', '<?= base_url('assets/images/shopping-cart.svg') ?>');
        });
        $(".checkout").mouseleave(function() {
            $(this).attr('src', '<?= base_url('assets/images/shopping-cart-empty.svg') ?>');
        });
    });


    function ChangePageAbout(e) {
        $("#description").removeClass("btn-primary bg-primary")
        $("#learn").removeClass("btn-primary bg-primary")
        $("#instructor").removeClass("btn-primary bg-primary")
        switch ($(e).data("type")) {
            case "description":
                $("#description").addClass("btn-primary bg-primary")
                $("#page-about-course").html('<?= str_replace('"', "", $course['DESKRIPSI_COURSE']) ?>')
                break;
            case "learn":
                $("#learn").addClass("btn-primary bg-primary")
                $("#page-about-course").html('<?= str_replace('"', "", $course['DESKRIPSI_COURSE_ITEM']) ?>')
                break;
            case "instructor":
                $("#instructor").addClass("btn-primary bg-primary")
                $("#page-about-course").html('<?= $course['NAME'] ?>')
                break;
            default:
                $("#description").addClass("btn-primary bg-primary")
                $("#page-about-course").html("Description")
                break;
        }
    }

    function AddToCart(e) {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 2000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            },
            didDestroy: (toast) => {
                location.reload();
            }
        })
        $.ajax({
            url: '<?= base_url('add/order') ?>',
            type: "GET",
            data: {
                id_activity: $(e).data("id-activity"),
                type: 1
            },
            dataType: 'json',
            success: function(data) {
                Toast.fire({
                    icon: (data.Status) ? 'success' : 'error',
                    title: data.Message
                })
            }
        });
    }

    function BuyNow() {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 2000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })
        <?php if (!empty($this->session->userdata('ID_USER'))) { ?>
            <?php if (!empty($checking_trans)) { ?>
                Toast.fire({
                    icon: 'error',
                    title: 'You have unfinished transactions!'
                })
            <?php } else { ?>
                $.ajax({
                    url: '<?= base_url('add/order') ?>',
                    type: "GET",
                    data: {
                        id_activity: '<?= $course['ID_ACTIVITY'] ?>',
                        type: 1
                    },
                    dataType: 'json',
                    success: function(data) {
                        let timerInterval
                        $('#data-input-info').append('<input type="hidden" name="id_order_purchase[0]" value="' + data.IdOrder + '" />')
                        Swal.fire({
                            title: 'Create Order!',
                            html: 'Please Wait ...',
                            timer: 2000,
                            timerProgressBar: false,
                            didOpen: () => {
                                Swal.showLoading()
                            },
                            willClose: () => {
                                clearInterval(timerInterval)
                            }
                        }).then((result) => {
                            if (result.dismiss === Swal.DismissReason.timer) {
                                $("#FormBuyNow-info").submit();
                            }
                        })
                    }
                });
            <?php } ?>
        <?php } else { ?>
            Toast.fire({
                icon: 'error',
                title: 'Please login first!'
            })
        <?php } ?>
    }
</script>