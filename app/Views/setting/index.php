<?= $this->extend('layout/page_layout') ?>
<?= $this->section('content') ?>

<div class="col content-body h-100">
    <div class="col h-100">
        <div class="container p-0 bg-white rounded-2 h-100">

            <h4 class="content-title"><span><img class="me-3" src="<?= base_url('image/settings.png') ?>" alt=""></span> Setting</h4>
            <form action="<?= base_url('setting/update_setting') ?>" method="post" class="mx-3">
                <?= csrf_field(); ?>
                <div>Privacy and Policy</div>
                <div class="form-group my-2">
                    <textarea type="text" class="form-control size-14 mt-1" id="summernote" name="privacy" placeholder="Enter Content"><?= $setting->privacy ?></textarea>
                </div>
                <div>Terms and Conditions</div>
                <div class="form-group my-2">
                    <textarea type="text" class="form-control size-14 mt-1" id="summernote1" name="terms" placeholder="Enter Content"><?= $setting->terms ?></textarea>
                </div>
                <div class="d-flex flex-row justify-content-end me-0 mt-3">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>

    </div>
</div>
<script src="<?= base_url('jquery/jquery-3.7.1.min.js') ?>"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
<script>
    $(document).ready(function() {
        $('#summernote').summernote();
        $('#summernote1').summernote();
    })
</script>

<?= $this->endSection() ?>

