<?= $this->extend('layout/page_layout') ?>
<?= $this->section('content') ?>

<div class="col content-body h-100">
    <div class="col h-100">
        <div class="container p-0 bg-white rounded-2 h-100">

            <h4 class="content-title"><span><img class="me-3" src="<?= base_url('image/team.png') ?>" alt=""></span>Change Password</h4>
            <form action="<?= base_url('admin/change_password/'. $id) ?>" method="post" class="mx-3">
                <?= csrf_field(); ?>
                <div class="form-group my-2">
                    <label class="size-14" for="password">New Password</label>
                    <input type="password" class="form-control size-14 mt-1" id="password" name="password" placeholder="Password">

                    <input class="mt-1" id="visible" type="checkbox" onclick="visiblePassword()">
                    <label class="size-14" for="visible">Show Password</label>
                </div>
                <div class="d-flex flex-row justify-content-end me-0 mt-3">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>

    </div>
</div>

<script>
    function visiblePassword() {
        const x = document.getElementById("password");
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
    }
</script>

<?= $this->endSection() ?>
