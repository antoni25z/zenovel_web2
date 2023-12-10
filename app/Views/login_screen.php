<!DOCTYPE html>
<html lang="en">
<head>
    <title>Selamat Datang Di Zenovel</title>
    <link rel="stylesheet" href="<?= base_url('css/bootstrap.min.css') ?>"/>
    <link rel="stylesheet" href="<?= base_url('custom_css/custom.css') ?>"/>
    <link rel="stylesheet" type="text/css" href="<?= base_url('toastr/toastr.min.css') ?>">
</head>
<body class="h-100 w-100">
<img src="<?= base_url('image/bg.jpg') ?> " class="position-fixed z-1 img-fluid w-100" alt="">
<div class="w-100 vh-100 d-flex align-items-center justify-content-center">
    <div class="z-2 d-flex align-items-center justify-content-center rounded-4 bg-light-subtle" style="width: 1000px; height: 600px">
        <div class="col d-flex  justify-content-evenly ">
            <div class="d-none d-xl-block col-3">
                <img src="<?= base_url('image/main_icon.png') ?>" class="card-img-top" alt="">
            </div>
            <div class="card border-0 rounded-3" style="width: 18rem">
                <div class="card-body">

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

                    <form action="admin/login" method="post">
                        <?= csrf_field(); ?>
                        <div class="mb-3">
                            <label for="user_name" class="form-label">Username</label>
                            <input type="text"  name="user_name" class="form-control" id="user_name" required autofocus>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" id="password" required>
                        </div>
                        <div class="row m-auto">
                            <button type="submit" name="Submit" value="Submit" class="btn btn-primary rounded-3">Masuk</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?= base_url('toastr/toastr.min.js') ?>"></script>
<script src="<?= base_url('js/jquery.min.js') ?>"></script>
<script src="<?= base_url('js/bootstrap.min.js') ?>"></script>

</body>
</html>
