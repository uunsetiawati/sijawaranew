<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?= $title ?> - TBH Academy</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="<?= base_url('assets/images/logo_colored.svg') ?>">
    <!-- Select2 css -->
    <link href="<?= base_url('assets_admin/vendors/select2/select2.css') ?>" rel="stylesheet">
    <!-- DatePicker css -->
    <link href="<?= base_url('assets_admin/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css') ?>" rel="stylesheet">
    <!-- page css -->
    <link href="<?= base_url('assets_admin/vendors/datatables/dataTables.bootstrap.min.css') ?>" rel="stylesheet">
    <!-- Dropify css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css" />
    <!-- Core css -->
    <link href="<?= base_url('assets_admin/css/app.min.css'); ?>" rel="stylesheet">

    <!-- Core Vendors JS -->
    <script src="<?= base_url('assets_admin/js/vendors.min.js') ?>"></script>
    <!-- Select2 JS -->
    <script src="<?= base_url('assets_admin/vendors/select2/select2.min.js') ?>"></script>
    <!-- Dropify JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js"></script>
    <!-- DatePicker JS -->
    <script src="<?= base_url('assets_admin/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js') ?>"></script>
    <!-- Validate JS -->
    <script src="<?= base_url('assets_admin/vendors/jquery-validation/jquery.validate.min.js') ?>"></script>
    <!-- CKEditor 4 Basic -->
    <script src="//cdn.ckeditor.com/4.20.0/basic/ckeditor.js"></script>
    <!-- Core JS -->
    <script src="<?= base_url('assets_admin/js/app.min.js') ?>"></script>
    <!-- Vendor Chart -->
    <script src="<?= base_url('assets_admin/vendors/chartjs/Chart.min.js') ?>"></script>
    <!-- Dashboard JS -->
    <script src="<?= base_url('assets_admin/js/pages/dashboard-default.js') ?>"></script>
    <!-- DataTable JS -->
    <script src="<?= base_url('assets_admin/vendors/datatables/jquery.dataTables.min.js') ?>"></script>
    <!-- Core Bootstrap JS -->
    <script src="<?= base_url('assets_admin/vendors/datatables/dataTables.bootstrap.min.js') ?>"></script>
    <!-- Sweet Alert -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.6/dist/sweetalert2.all.min.js"></script>

</head>

<body>
    <?= $this->session->flashdata('msg_auth') ?>
    <div class="app">
        <div class="layout">
            <!-- Header START -->
            <div class="header">
                <div class="logo logo-dark logo logo-dark">
                    <a href="<?php base_url() ?>" class="d-flex justify-content-center mt-3">
                        <img src="<?= base_url('assets/images/logo.svg') ?>" alt="Logo">
                        <img class="logo-fold justify-content-center w-50" src="<?= base_url('assets/images/logo_colored.svg') ?>" alt="Logo">
                    </a>
                </div>
                <div class="nav-wrap">
                    <ul class="nav-left">
                        <li class="desktop-toggle">
                            <a href="javascript:void(0);">
                                <i class="anticon"></i>
                            </a>
                        </li>
                        <li class="mobile-toggle">
                            <a href="javascript:void(0);">
                                <i class="anticon"></i>
                            </a>
                        </li>
                    </ul>
                    <ul class="nav-right">
                        <li class="dropdown dropdown-animated scale-left">
                            <div class="pointer" data-toggle="dropdown">
                                <div class="avatar avatar-image  m-h-10 m-r-15">
                                    <img src="<?= (!empty($this->session->userdata('PICT')) ? $this->session->userdata('PICT') : base_url('assets_admin/images/avatars/thumb-3.jpg')) ?>" alt="">
                                </div>
                            </div>
                            <div class="p-b-15 p-t-20 dropdown-menu pop-profile">
                                <div class="p-h-20 p-b-15 m-b-10 border-bottom">
                                    <div class="d-flex m-r-50">
                                        <div class="avatar avatar-lg avatar-image">
                                            <img src="<?= (!empty($this->session->userdata('PICT')) ? $this->session->userdata('PICT') : base_url('assets_admin/images/avatars/thumb-3.jpg')) ?>" alt="">
                                        </div>
                                        <div class="m-l-10">
                                            <p class="m-b-0 text-dark font-weight-semibold"><?= $this->session->userdata('NAME') ?></p>
                                            <p class="m-b-0 opacity-07"><?= ($this->session->userdata('ID_ROLE') == 1) ? "Admin" : (($this->session->userdata('ID_ROLE') == 2) ? "Instructor" : "") ?></p>
                                        </div>
                                    </div>
                                </div>
                                <a href="<?= base_url() ?>" class="dropdown-item d-block p-h-15 p-v-10">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div>
                                            <i class="anticon opacity-04 font-size-16 anticon-laptop"></i>
                                            <span class="m-l-10">Front Page</span>
                                        </div>
                                        <i class="anticon font-size-10 anticon-right"></i>
                                    </div>
                                </a>
                                <a href="<?= base_url('AuthController/logout') ?>" class="dropdown-item d-block p-h-15 p-v-10">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div>
                                            <i class="anticon opacity-04 font-size-16 anticon-logout"></i>
                                            <span class="m-l-10">Logout</span>
                                        </div>
                                        <i class="anticon font-size-10 anticon-right"></i>
                                    </div>
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- Header END -->

            <!-- Side Nav START -->
            <div class="side-nav">
                <div class="side-nav-inner">
                    <ul class="side-nav-menu scrollable">
                        <li class="nav-item dropdown">
                            <a class="dropdown-toggle" href="<?= base_url('dashboard') ?>" style="<?= ($title == "Dashboard") ? "color: #4b94f7 ; background-color: #e2edfe" : ""; ?>;">
                                <span class="icon-holder">
                                    <i class="anticon anticon-dashboard" style="<?= ($title == "Dashboard") ? "color: #4b94f7;" : ""; ?>;"></i>
                                </span>
                                <span class="title">Dashboard</span>
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="dropdown-toggle" href="javascript:void(0);" style="<?= ($title == "Course" || $title == "Event") ? "color: #4b94f7 ; background-color: #e2edfe" : ""; ?>;">
                                <span class="icon-holder">
                                    <i class="anticon anticon-project" style="<?= ($title == "Course" || $title == "Event") ? "color: #4b94f7;" : ""; ?>;"></i>
                                </span>
                                <span class="title">Activity</span>
                                <span class="arrow">
                                    <i class="arrow-icon"></i>
                                </span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="<?= ($title == "Course") ? "active" : ""; ?>">
                                    <a href="<?= base_url('manage/activity/course') ?>">Course</a>
                                </li>
                                <li class="<?= ($title == "Event") ? "active" : ""; ?>">
                                    <a href="<?= base_url('manage/activity/event') ?>">Event</a>
                                </li>
                            </ul>
                        </li>
                        <?php if ($this->session->userdata('ID_ROLE') == 1) { ?>
                            <li class="nav-item dropdown">
                                <a class="dropdown-toggle" href="<?= base_url('manage/ebook') ?>" style="<?= ($title == "Ebook") ? "color: #4b94f7 ; background-color: #e2edfe" : ""; ?>;">
                                    <span class="icon-holder">
                                        <i class="anticon anticon-book" style="<?= ($title == "Ebook") ? "color: #4b94f7;" : ""; ?>;"></i>
                                    </span>
                                    <span class="title">E-Book</span>
                                    <span class="arrow">
                                    </span>
                                </a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="dropdown-toggle" href="<?= base_url('manage/promo') ?>" style="<?= ($title == "Promo") ? "color: #4b94f7 ; background-color: #e2edfe" : ""; ?>;">
                                    <span class="icon-holder">
                                        <i class="anticon anticon-tag" style="<?= ($title == "Promo") ? "color: #4b94f7;" : ""; ?>;"></i>
                                    </span>
                                    <span class="title">Promo Code</span>
                                </a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="dropdown-toggle" href="<?= base_url('manage/category') ?>" style="<?= ($title == "Category") ? "color: #4b94f7 ; background-color: #e2edfe" : ""; ?>;">
                                    <span class="icon-holder">
                                        <i class="anticon anticon-gold" style="<?= ($title == "Category") ? "color: #4b94f7;" : ""; ?>;"></i>
                                    </span>
                                    <span class="title">Category</span>
                                    <span class="arrow">
                                    </span>
                                </a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="dropdown-toggle" href="<?= base_url('manage/user') ?>" style="<?= ($title == "User") ? "color: #4b94f7 ; background-color: #e2edfe" : ""; ?>;">
                                    <span class="icon-holder">
                                        <i class="anticon anticon-user" style="<?= ($title == "User") ? "color: #4b94f7;" : ""; ?>;"></i>
                                    </span>
                                    <span class="title">User</span>
                                </a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="dropdown-toggle" href="<?= base_url('manage/instructor') ?>" style="<?= ($title == "Instructor") ? "color: #4b94f7 ; background-color: #e2edfe" : ""; ?>;">
                                    <span class="icon-holder">
                                        <i class="anticon anticon-audit" style="<?= ($title == "Instructor") ? "color: #4b94f7;" : ""; ?>;"></i>
                                    </span>
                                    <span class="title">Instructor</span>
                                </a>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
            <!-- Side Nav END -->

            <!-- Page Container START -->
            <div class="page-container">