<?= $this->extend('layout/page_layout') ?>
<?= $this->section('content') ?>

<div class="col content-body h-100">
    <div class="col h-100">
        <div class="container p-0 bg-white rounded-2 h-100">

            <h4 class="content-title"><span><img class="me-3" src="<?= base_url('image/chapter.png') ?>" alt=""></span> Add Page</h4>
            <form action="<?= base_url('content_management/content/chapter/page/add_page/'.$novel_id.'/'.$chapter_id) ?>" method="post" class="mx-3">
                <?= csrf_field(); ?>
                <div class="form-group my-2">
                    <label class="size-14" for="page_no">Page No</label>
                    <input type="number" class="form-control size-14 mt-1" id="page_no" name="page_no" placeholder="Enter Page No">
                </div>
                <div class="form-group my-2">
                    <textarea type="text" class="form-control size-14 mt-1" id="summernote" name="page_content" placeholder="Enter Content"></textarea>
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
    })
</script>

<?= $this->endSection() ?>

