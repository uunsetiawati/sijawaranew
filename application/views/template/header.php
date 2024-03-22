<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>
        <?= $title ?>
    </title>
    <link rel="shortcut icon" href="<?= base_url('assets/images/new/logo.png') ?>">
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/scss/custom.css') ?>" />
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/jquery-ui.min.css') ?>" />
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.5.2/css/fileinput.min.css" />


    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.plyr.io/3.6.3/plyr.js"></script>
    <script type="text/javascript" src="<?= base_url('assets/js/jquery.inputmask.bundle.min.js') ?>"></script>
    <script type="text/javascript" src="<?= base_url('assets/js/jquery-ui.min.js') ?>"></script>
    <script type="text/javascript" src="<?= base_url('assets/js/bootstrap.bundle.min.js') ?>"></script>
    <script type="text/javascript" src="<?= base_url('assets/js/custom.js') ?>"></script>
    <script type="text/javascript" src="<?= base_url('assets_admin/vendors/chartjs/Chart.min.js') ?>"></script>
    <script type="text/javascript" src="https://www.google.com/recaptcha/api.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.6/dist/sweetalert2.all.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/js/all.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.5.2/js/fileinput.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/sticky-sidebar/3.3.1/sticky-sidebar.min.js"></script>
    <script src="https://www.youtube.com/iframe_api"></script>

    <script src="https://cdn.jsdelivr.net/npm/intro.js@7.2.0/intro.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/intro.js@7.2.0/minified/introjs.min.css" rel="stylesheet">

</head>
<!-- oncontextmenu="return false" -->

<body style="<?= $title == "TBHAcademy" ? "background-image: url(assets/images/new/bg.png);" : "" ?>">
    <?= $this->session->flashdata('msg_auth') ?>
    <div id="page-container">
        <!-- Navbar -->
        <nav class=" navbar sticky-top shadow navbar-expand-lg navbar-main" style="background-color: transparent;">
            <div class="container px-2 px-lg-0 ">
                <a class="navbar-brand fw-semibold" href="<?= base_url('') ?>">
                    <img src="<?= base_url('assets/images/new/NAV-LOGO.png') ?>" class="w-75 img-fluid" style="height:45%">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
                    <div class="offcanvas-header">
                        <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Sijawara+</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body">
                        <div class="navbar-nav flex-grow-1 d-flex" id="navbarNav">
                            <ul class="navbar-nav col-md-9 justify-content-center ms-lg-auto gap-2 fw-medium">
                                <li class="nav-item hint-course">
                                    <a class="nav-link" href="<?= base_url('/') ?>"><?= ($title == "TBHAcademy") ? "<strong style='color:#45B104'>Beranda</strong>" : "Beranda" ?></a>
                                </li>
                                <li class="nav-item hint-course">
                                    <a class="nav-link" href="<?= base_url('course') ?>"><?= ($title == "Course") ? "<strong style='color:#45B104'>Pelatihan Mandiri</strong>" : "Pelatihan Mandiri" ?></a>
                                </li>
                                <li class="nav-item hint-event">
                                    <a class="nav-link" href="<?= base_url('event') ?>"><?= ($title == "Event") ? "<strong style='color:#45B104'>Webinar</strong>" : "Webinar" ?></a>
                                </li>
                                <!-- <li class="nav-item">
                                    <a class="nav-link" href="<?= base_url('ebook') ?>"><?= ($title == "Ebook") ? "<strong style='color:#8860D0'>E-Book</strong>" : "E-Book" ?></a>
                                </li> -->
                                <!-- <li class="nav-item">
                                    <a class="nav-link" href="<?= base_url('instructor') ?>"><?= ($this->uri->segment(1) == "instructor") ? "<strong style='color:#8860D0'>Teach with us</strong>" : "Teach with us" ?></a>
                                </li> -->
                                <!-- <li class="nav-item">
                                    <a class="nav-link" href="<?= base_url('about') ?>">About</a>
                                </li> -->
                                <!-- <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                        data-bs-toggle="dropdown" aria-expanded="false">Became a</a>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="#">Leader</a></li>
                                        <li><a class="dropdown-item" href="#">Designer</a></li>
                                        <li><a class="dropdown-item" href="#">Administrasi</a></li>
                                        <li><a class="dropdown-item" href="#">Programmer</a></li>
                                        <li><a class="dropdown-item" href="#">Management</a></li>
                                    </ul>
                                </li> -->
                            </ul>
                            <ul class="navbar-nav col-md-3 justify-content-end ms-lg-auto fw-semibold">

                                <?php if (!empty($this->session->userdata('ID_USER'))) {
                                ?>
                                    <!-- Cart Start -->
                                    <li class="nav-item me-2 dropdown dropdown-profile hint-cart">
                                        <a class="nav-link w-100 h-100 d-flex align-items-center position-relative rounded-circle" style="padding-left:12px;padding-right:12px;background-color:#F4F7FA;right:0;margin-right:1px" href="<?= base_url('checkout') ?>">
                                            <i class="bi bi-cart" style="-webkit-text-stroke: 0.2px;"></i>
                                            <?php $totCheckout = (!empty($checkout) ? count($checkout) : 0);
                                            if ($totCheckout > 0) { ?>
                                                <span class="badge bg-danger rounded-circle position-absolute" style="top: 0px; right: -5px;"><?= count($checkout) ?></span>
                                            <?php } ?>
                                        </a>
                                        <?php if ($title != 'Checkout') { ?>
                                            <div class="dropdown-menu dropdown-menu-lg-end" style="width:400px">
                                                <div class="title mx-3 fs-5">Cart</div>
                                                <hr class="dropdown-divider">
                                                <ul class="p-0 m-2 overflow-auto" style="max-height:300px">
                                                    <?php if (!empty($checkout)) { ?>
                                                        <?php foreach ($checkout as $item) : ?>
                                                            <li class="dropdown-item" style="pointer-events: none;">
                                                                <div class="d-flex dropdown-item align-items-center">
                                                                    <div class="img col-2">
                                                                        <img src="<?= (!empty($item['IMAGE_ACTIVITY'])) ? $item['IMAGE_ACTIVITY'] : $item['IMAGE_EBOOK']; ?>" alt="Image" class="img-fluid" style="width:50px;height:50px" />
                                                                    </div>
                                                                    <div class="col-7 ms-2" style="white-space:normal">
                                                                        <?= (!empty($item['TITLE_ACTIVITY'])) ? $item['TITLE_ACTIVITY'] : $item['JUDUL']; ?>
                                                                    </div>
                                                                    <div class="col-3 ms-2" style="white-space:normal">
                                                                        <?= ($item['PRICE_ORDER'] <> 0) ? "Rp " . number_format($item['PRICE_ORDER'], 2, ',', '.') : 'Free' ?>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                        <?php endforeach; ?>
                                                    <?php } else { ?>
                                                        <tr>
                                                            <td colspan="5">
                                                                <div class="d-flex justify-content-center">
                                                                    <img src="https://img.freepik.com/free-vector/empty-concept-illustration_114360-1253.jpg" height="210">
                                                                </div>
                                                                <p class="text-center">No Product</p>
                                                            </td>
                                                        </tr>
                                                    <?php } ?>
                                                </ul>
                                                <hr class="dropdown-divider">
                                                <p class="text-center m-0 p-0 mt-2"><a href="<?= base_url('checkout') ?>" class="small">View All</a>
                                                </p>
                                            </div>
                                        <?php } ?>
                                    </li>
                                    <!-- Cart End -->

                                    <!-- Notification Start -->
                                    <!-- <li class="nav-item me-2 dropdown dropdown-profile">
                                        <a class="nav-link w-100 h-100 d-flex align-items-center position-relative rounded-circle" style="padding-left:12px;padding-right:12px;background-color:#F4F7FA;" href="#" data-bs-toggle="dropdown">
                                            <i class="bi bi-bell" style="-webkit-text-stroke: 0.2px;"></i>
                                            <span class="position-absolute top-25 start-75 translate-middle rounded-circle" style="padding:0.3rem;top:28%;background-color:#FF0000;right:0;margin-right:1px">
                                            </span>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-lg-end" style="width:400px">
                                            <div class="title mx-3 fs-5">Notifications</div>
                                            <hr class="dropdown-divider">
                                            <ul class="p-0 m-2 overflow-auto" style="max-height:300px">
                                                <li class="dropdown-item">
                                                    <a href="#" class="d-flex flex-column dropdown-item">
                                                        <div class="" style="white-space:normal">
                                                            <strong>Alex Stafford</strong> marked the
                                                            task to done and review
                                                            done
                                                        </div>
                                                        <div class="" style=" font-size:0.8rem">
                                                            2 day ago
                                                        </div>
                                                    </a>
                                                </li>
                                            </ul>
                                            <hr class="dropdown-divider">
                                            <p class="text-center m-0 p-0 mt-2"><a href="#" class="small">View All</a>
                                            </p>
                                        </div>
                                    </li> -->
                                    <!-- Notification End -->

                                    <!-- Pict profile start -->
                                    <li class="nav-item dropdown dropdown-profile hint-profile">
                                        <div class="d-flex align-items-center h-100" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <?php if (empty($this->session->userdata('PICT'))) { ?>
                                                <i class="bi bi-person-circle"></i>
                                            <?php } else { ?>
                                                <img class="nav-link rounded-circle " style="height:40px;width:40px;background-size:cover;background-image: url('<?= $this->session->userdata('PICT') ?>')">
                                                </img>
                                            <?php } ?>
                                            <span class="d-inline-block text-truncate mx-2"><?= $this->session->userdata('NAME') ?></span>
                                        </div>
                                        <ul class="dropdown-menu">
                                            <?php if ($this->session->userdata('ID_ROLE') == 1) { ?>
                                                <li><a class="dropdown-item" href="<?= base_url('dashboard') ?>">Dashboard</a></li>
                                            <?php } else { ?>
                                                <li><a class="dropdown-item" href="<?= base_url('profile') ?>">Profile</a></li>
                                                <li><a class=" dropdown-item" href="<?= base_url('profile/mycourses') ?>">My Courses</a></li>
                                                <li><a class="dropdown-item" href="<?= base_url('profile/myevents') ?>">My Events</a></li>
                                                <li><a class="dropdown-item" href="<?= base_url('profile/myebook') ?>">My Ebook</a></li>
                                            <?php } ?>
                                            <hr>
                                            <li><a class="dropdown-item text-danger" href="<?= base_url('AuthController/logout') ?>">Keluar</a></li>
                                        </ul>
                                    </li>
                                <?php
                                } else { ?>
                                    <div class="d-flex gap-2">
                                        <a href="<?= base_url('register') ?>">
                                            <button class="btn btn-primary w-100 rounded-3 fw-semibold ms-2 text-black border-0">Daftar</button>
                                        </a>
                                        <a href="<?= base_url('login') ?>">
                                            <button class="btn btn-outline-secondary w-100 rounded-3 fw-semibold ms-2 text-black border-0">Masuk</button>
                                        </a>
                                    </div>

                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                </div>

            </div>
        </nav>
        <!-- End Navbar-->

        <script>
            window.addEventListener('scroll', function() {
                if (window.scrollY > 50) {
                    $('.navbar-main').addClass('bg-white');
                } else {
                    $('.navbar-main').removeClass('bg-white');
                }
            });
        </script>