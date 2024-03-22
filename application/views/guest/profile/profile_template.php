<div class="container px-4 px-md-0 py-4 pb-6 pt-3">
    <h5 class="py-2 fw-semibold">Profile</h5>
    <hr class="opacity-25">
    <div class="container-fluid">
        <div class="row main-content">
            <div class="col-md-3 sidebar">
                <div class="sidebar__inner">
                    <div class="px-0" style="z-index: 0;">
                        <div class="bg-white shadow rounded-2 overflow-hidden" style="height:max-content">
                            <div class="d-flex flex-column align-items-center align-items-sm-start text-white">
                                <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start w-100" id="menu">
                                    <li class="nav-item w-100">
                                        <a href="<?= base_url('profile') ?>" class="<?= (($this->uri->segment(1) == "profile") && ($this->uri->segment(2) == "")) ? "active" : ""  ?>  nav-link d-flex align-middle px-4 py-3 rounded-0">
                                            <i class="fs-6 d-flex align-items-center bi bi-person-square"></i> <span class="ms-1 ps-2 fs-6 align-self-center d-none d-sm-inline">Personal
                                                Data</span>
                                        </a>
                                    </li>
                                    <li class="w-100">
                                        <hr class="my-0 border border-1 mx-3">
                                    </li>

                                    <!-- INSTRUCTOR SIDEBAR START -->
                                    <!-- if(instructor) -->
                                    <?php if ($this->session->userdata('ID_ROLE') == 2) { ?>
                                        <li class="nav-item w-100">
                                            <a href="<?= base_url('profile/overview') ?>" class="<?= check_active('overview') ?>  nav-link d-flex align-middle px-4 py-3 rounded-0">
                                                <i class="fs-6 d-flex align-items-center bi bi-bookmark-check"></i> <span class="ms-1 ps-2 fs-6 align-self-center d-none d-sm-inline">Sale Overview</span>
                                            </a>
                                        </li>
                                        <li class="w-100">
                                            <hr class="my-0 border border-1 mx-3">
                                        </li>
                                        <li class="nav-item w-100">
                                            <a href="<?= base_url('dashboard') ?>" class="<?= check_active('courses') ?>  nav-link d-flex align-middle px-4 py-3 rounded-0">
                                                <i class="fs-6 d-flex align-items-center bi bi-journal-bookmark"></i> <span class="ms-1 ps-2 fs-6 align-self-center d-none d-sm-inline">Create Activity</span>
                                            </a>
                                        </li>
                                        <li class="w-100">
                                            <hr class="my-0 border border-1 mx-3">
                                        </li>
                                    <?php } ?>

                                    <!-- endif -->
                                    <!-- INSTRUCTOR SIDEBAR END -->

                                    <li class="nav-item w-100">
                                        <a href="#" data-toggle="collapse" data-target="#submenu" class="accordion-heading nav-link <?= check_active('mycourses') ?> <?= check_active('myevents') ?> d-flex align-middle px-4 py-3 rounded-0">
                                            <i class="fs-6 d-flex align-items-center bi bi-bookmark-dash"></i> <span class="ms-1 ps-2 fs-6 align-self-center d-none d-sm-inline">My Activities</span>
                                            <?php if ($title == 'My Courses') { ?>
                                                <i class="fas fa-chevron-up ms-auto"></i>
                                            <?php } else { ?>
                                                <i class="fas fa-chevron-down ms-auto"></i>
                                            <?php } ?>
                                        </a>
                                        <ul class="nav nav-list collapse <?= show_menu('mycourses') ?> <?= show_menu('myevents') ?>" id="submenu">
                                            <li class="nav-item w-100">
                                                <a href="<?= base_url('profile/mycourses') ?>" class="nav-link  d-flex align-middle px-4 py-3 rounded-0">
                                                    <span class="ms-3 ps-3 fs-6 align-self-center d-none d-sm-inline">My Courses</span>
                                                </a>
                                            </li>
                                            <li class="w-100">
                                                <hr class="my-0 border border-1 mx-3">
                                            </li>
                                            <li class="nav-item w-100">
                                                <a href="<?= base_url('profile/myevents') ?>" class="nav-link d-flex align-middle px-4 py-3 rounded-0">
                                                    <span class="ms-3 ps-3 fs-6 align-self-center d-none d-sm-inline">My Events</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="w-100">
                                        <hr class="my-0 border border-1 mx-3">
                                    </li>
                                    <li class="nav-item w-100">
                                        <a href="<?= base_url('profile/myebook') ?>" class="nav-link <?= check_active('myebook') ?> d-flex align-middle px-4 py-3 rounded-0">
                                            <i class="fs-6 d-flex align-items-center bi bi-book"></i> <span class="ms-1 ps-2 fs-6 align-self-center d-none d-sm-inline">My Ebook</span>
                                        </a>
                                    </li>
                                    <li class="w-100">
                                        <hr class="my-0 border border-1 mx-3">
                                    </li>
                                    <li class="nav-item w-100">
                                        <a href="<?= base_url('profile/academic') ?>" class="nav-link <?= check_active('academic') ?> d-flex align-middle px-4 py-3 rounded-0">
                                            <i class="fs-6 d-flex align-items-center bi bi-file-text"></i> <span class="ms-1 ps-2 fs-6 align-self-center d-none d-sm-inline">Academic Data</span>
                                        </a>
                                    </li>
                                    <li class="w-100">
                                        <hr class="my-0 border border-1 mx-3">
                                    </li>
                                    <li class="nav-item w-100">
                                        <a href="<?= base_url('profile/document') ?>" class="nav-link <?= check_active('document') ?> d-flex align-middle px-4 py-3 rounded-0">
                                            <i class="fs-6 d-flex align-items-center bi bi-building"></i> <span class="ms-1 ps-2 fs-6 align-self-center d-none d-sm-inline">Supporting Documents</span>
                                        </a>
                                    </li>
                                    <li class="w-100">
                                        <hr class="my-0 border border-1 mx-3">
                                    </li>
                                    <li class="nav-item w-100">
                                        <a href="<?= base_url('forgotPassword') ?>" class="nav-link <?= check_active('password') ?> d-flex align-middle px-4 py-3 rounded-0">
                                            <i class="fs-6 d-flex align-items-center bi bi-lock"></i> <span class="ms-1 ps-2 fs-6 align-self-center d-none d-sm-inline">Reset Password</span>
                                        </a>
                                    </li>
                                    <li class="w-100">
                                        <hr class="my-0 border border-1 mx-3">
                                    </li>
                                    <li class="nav-item w-100 pb-3">
                                        <a href="<?= base_url('AuthController/logout') ?>" class="nav-link d-flex align-middle px-4 py-3 rounded-0">
                                            <i class="fs-6 d-flex align-items-center bi bi-box-arrow-left"></i> <span class="ms-1 ps-2 fs-6 align-self-center d-none d-sm-inline">Log out</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="bg-white shadow rounded-2 overflow-hidden p-3 mt-3" style="height:max-content">
                            <div class="d-flex flex-column align-items-center align-items-sm-start">
                                <?php $totDoc = (!empty($document)) ? count(array_filter($document)) : 0; ?>
                                <?php if ($this->session->userdata('ID_ROLE') == 3) { ?>
                                    <?php if ($totDoc === 11) { ?>
                                        <div class="col-md-12">
                                            <button type="button" class="btn btn-primary rounded-4 fw-semibold w-100 btn-instructor">Apply as an Instructor</button>
                                        </div>
                                    <?php } else { ?>
                                        <div class="row">
                                            <button type="button" class="btn btn-muted rounded-4 fw-semibold w-100 mb-3" disabled>Apply as an Instructor</button>
                                            <span class="text-danger" style="text-align: justify;">* Complete academic data and supporting documents to apply as an instructor at "The Brain & Heart Academy".</span>
                                        </div>
                                    <?php } ?>
                                <?php } else { ?>
                                    <?php if ($document['STATUS'] == 1) { ?>
                                        <div class="row">
                                            <button type="button" class="btn btn-muted rounded-4 fw-semibold w-100 mb-3" disabled>Apply as an Instructor</button>
                                            <span class="text-success" style="text-align: justify;">You are now part of our instructor team. Thank you for your participation. Make sure you login again to access the instructor menu.</span>
                                        </div>
                                    <?php } else if ($document['STATUS'] == 2) { ?>
                                        <div class="row">
                                            <button type="button" class="btn btn-primary rounded-4 fw-semibold w-100 mb-3 btn-instructor">Apply as an Instructor</button>
                                            <span class="text-danger" style="text-align: justify;">We are sorry to reject your application because there is a discrepancy between the standard
                                                documents you submitted and our standard documents. Please correct your data again and click the button above to submit again..</span>
                                        </div>
                                    <?php } else if($document['STATUS'] == 0) { ?>
                                        <div class="row">
                                            <button type="button" class="btn btn-muted rounded-4 fw-semibold w-100 mb-3" disabled>Apply as an Instructor</button>
                                            <span style="color: #edab00; text-align: justify;">Please be patient as we are still evaluating your personal data and documents.</span>
                                        </div>
                                    <?php } ?>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-9 content">
                <!-- Page -->
                <?php $this->load->view($page); ?>
            </div>
        </div>
    </div>
</div>

<style>
    .rotate180 {
        transform: rotate(180deg);
        transition: transform 0.3s ease;
    }
</style>

<script type="text/javascript">
    $(document).ready(function() {
        $('#submenu').on('show.bs.collapse', function() {
            $('.fa-chevron-down').addClass('rotate180');
        });

        $('#submenu').on('hide.bs.collapse', function() {
            $('.fa-chevron-down').removeClass('rotate180');
        });
    });

    var sidebar = new StickySidebar('.sidebar', {
        topSpacing: 20,
        bottomSpacing: 20,
        containerSelector: '.main-content',
        innerWrapperSelector: '.sidebar__inner'
    });

    $('.btn-instructor').click(function() {
        Swal.fire({
            title: '<strong class="h4">Are you sure you want to apply as an intructor ?</strong>',
            showDenyButton: true,
            showCancelButton: false,
            allowOutsideClick: false,
            confirmButtonText: 'Yes',
            denyButtonText: `No`,
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '<?= base_url("profile/apply/instructor?location=" . $this->uri->segment(1) . "/" . $this->uri->segment(2) . "/" . $this->uri->segment(3)) ?>';
            }
        })
    })
</script>