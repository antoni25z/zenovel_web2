<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Selamat Datang Di Zenovel</title>
    <link rel="stylesheet" href="<?= base_url('css/bootstrap.min.css') ?>"/>
    <link rel="stylesheet" href="<?= base_url('custom_css/custom.css') ?>"/>

    <link rel="stylesheet" href="<?= base_url('font-awesome/css/font-awesome.min.css') ?>">

    <link rel="stylesheet" href="<?= base_url('DataTables/datatables.min.css') ?>" />
    <link rel="stylesheet" href="<?= base_url('bootstrap-select-1.14.0-beta2/css/bootstrap-select.min.css') ?>">
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    <link href="<?= base_url('jquery-ui-1.13.2/jquery-ui.min.css') ?>" rel="stylesheet">


</head>
<body style="background: #dfe9f1">

<?php if (session()->getFlashdata('error')) : ?>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 2000,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })

        Toast.fire({
            icon: 'warning',
            title: '<?= session()->getFlashdata('error') ?>'
        })
    </script>
<?php endif ?>
<?php if (session()->getFlashdata('success')) : ?>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 2000,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })

        Toast.fire({
            icon: 'success',
            title: '<?= session()->getFlashdata('success') ?>'
        })
    </script>
<?php endif ?>

<div class="container-fluid vh-100">
    <div class="row h-100 ">
        <section class="col-auto p-0 h-100  position-fixed z-2">
            <nav id="sidebar" class="h-100 collapse bg-white d-lg-block">
                <div class="list-group py-2 mx-1 mb-2">
                    <a href="#" class="list-group-item border-0 rounded-3 bg-transparent mb-3 mt-2 py-3">
                        <img class="z-3" src="<?= base_url('image/horizontal_logo.png') ?>" alt="">
                    </a>
                    <a href="#submenu2" class="list-group-item border-0 pb-0 mt-2 " data-bs-toggle="collapse">
                        <div class="row align-items-center justify-content-between">
                            <div class="col-auto">
                                <img class="me-2" src="<?= base_url('image/user_management.png') ?>" alt=""/>
                                <span>User Management</span>
                            </div>
                            <div class="col-auto">
                                <img src="<?= base_url('image/down_arrow.png') ?>" aria-hidden="true" alt=""/>
                            </div>
                        </div>

                        <div class="collapse list-group margin-submenu" id="submenu2" data-bs-parent="#menu">
                            <a href="<?= base_url('/') ?>" class="list-group-item list-group-item-action border-0 ">
                                <span class="size-14">Admin</span>
                            </a>
                            <a href="<?= base_url('user_management/user') ?>" class="list-group-item list-group-item-action border-0 my-2">
                                <span class="size-14">User</span>
                            </a>
                            <a></a>
                        </div>
                    </a>
                    <a href="#contentManagementSub" class="list-group-item border-0 pb-0 mt-3" data-bs-toggle="collapse">
                        <div class="row justify-content-between">
                            <div class="col-auto">
                                <img class="me-2" src="<?= base_url('image/content_management.png') ?>" alt=""/>
                                <span>Content Management</span>
                            </div>
                            <div class="col-auto">
                                <img src="<?= base_url('image/down_arrow.png') ?>" aria-hidden="true" alt=""/>
                            </div>
                        </div>
                        <div class="collapse list-group margin-submenu" id="contentManagementSub" data-bs-parent="#menu">
                            <a href="<?= base_url('content_management/all_novel') ?>" class="list-group-item list-group-item-action border-0">
                                <span class="size-14">All Novel</span>
                            </a>
                            <a href="<?= base_url('content_management/genre') ?>" class="list-group-item list-group-item-action border-0 my-2">
                                <span class="size-14">Genres</span>
                            </a>
                            <a href="<?= base_url('content_management/tag') ?>" class="list-group-item list-group-item-action border-0 my-2">
                                <span class="size-14">Tag</span>
                            </a>
                            <a href="<?= base_url('content_management/discover') ?>" class="list-group-item list-group-item-action border-0 my-2">
                                <span class="size-14">Discover</span>
                            </a>
                        </div>
                    </a>
                    <a href="#adsSub" class="list-group-item border-0 pb-0 mt-3" data-bs-toggle="collapse">
                        <div class="row justify-content-between">
                            <div class="col-auto">
                                <img class="me-2" src="<?= base_url('image/ads_management.png') ?>" alt=""/>
                                <span>Ads Management</span>
                            </div>
                            <div class="col-auto">
                                <img src="<?= base_url('image/down_arrow.png') ?>" alt=""/>
                            </div>
                        </div>
                        <div class="collapse list-group margin-submenu" id="adsSub" data-bs-parent="#menu">
                            <a href="<?= base_url('ads_management/report_revenue') ?>" class="list-group-item list-group-item-action border-0">
                                <span class="size-14">Revenue Report</span>
                            </a>
                            <a href="<?= base_url('ads_management/ad_unit') ?>" class="list-group-item list-group-item-action border-0">
                                <span class="size-14">Ad Unit</span>
                            </a>
                        </div>
                    </a>
                    <a href="#reviewFeedbackSub" class="list-group-item border-0 pb-0 mt-3" data-bs-toggle="collapse">
                        <div class="row justify-content-between">
                            <div class="col-auto">
                                <img class="me-2" src="<?= base_url('image/review_feedback.png') ?>" alt=""/>
                                <span>Review & Feedback</span>
                            </div>
                            <div class="col-auto">
                                <img src="<?= base_url('image/down_arrow.png') ?>" alt=""/>
                            </div>
                        </div>
                        <div class="collapse list-group margin-submenu" id="reviewFeedbackSub" data-bs-parent="#menu">
                            <a href="<?= base_url('review_feedback/report') ?>" class="list-group-item list-group-item-action border-0">
                                <span class="size-14">Report</span>
                            </a>
                        </div>
                    </a>
                    <a href="<?= base_url('notification_marketing/notification') ?>" class="list-group-item list-group-item-action border-0  mt-3">
                        <div class="row justify-content-between">
                            <div class="col-auto">
                                <img class="me-2" src="<?= base_url('image/notification_marketing.png') ?>" alt=""/>
                                <span>Notification & Marketing</span>
                            </div>
                        </div>
                    </a>
                    <a href="<?= base_url('setting') ?>" class="list-group-item list-group-item-action border-0  mt-3">
                        <div class="row justify-content-between">
                            <div class="col-auto">
                                <img class="me-2" src="<?= base_url('image/settingss.png') ?>" alt="" width="24" height="24"/>
                                <span>Setting</span>
                            </div>
                        </div>
                    </a>
                </div>
            </nav>
        </section>
        <header class="col p-0">
            <div class="col bg-white fixed-top z-1">
                <nav id="main-navbar" class="navbar navbar-expand-lg">
                    <div class="container-fluid">
                        <a class="navbar-toggler border-0"
                           type="button"
                           data-bs-toggle="collapse"
                           data-bs-target="#sidebar"
                           aria-controls="sidebar"
                           aria-expanded="false"
                           aria-label="Toggle navigation">
                            <img src="<?= base_url('image/menus.png') ?>">
                        </a>

                        <ul class="navbar-nav ms-auto">
                            <li class="nav-item dropdown">
                                <a class="nav-link my-dropdown-toggle dropdown-toggle d-flex align-items-center"
                                   href="#"
                                   id="navbarDropdownMenuLink"
                                   role="button"
                                   data-bs-toggle="dropdown"
                                   aria-expanded="false">
                                    <span class="me-3 text-black"><?= session()->get('username') ?></span>
                                    <img src="<?= base_url('image/profile.png') ?>"
                                         class="rounded-circle"
                                         height="40"
                                         alt=""/>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenuLink">
                                    <li><a class="dropdown-item" href="<?= base_url('admin/change_password') ?>">Change Password</a></li>
                                    <li><a class="dropdown-item" href="<?= base_url('admin/logout') ?>">Logout</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
            <?= $this->renderSection('content') ?>
        </header>
    </div>
</div>

<script src="<?= base_url('js/bootstrap.bundle.js') ?>"></script>
</body>
</html>
