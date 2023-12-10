<?= $this->extend('layout/page_layout') ?>
<?= $this->section('content') ?>

<div class="col content-body h-100">
    <div class="col h-100">
        <div class="container p-0 bg-white rounded-2 h-100">

            <h4 class="content-title"><span><img class="me-3" src="<?= base_url('image/chapter.png') ?>" alt=""></span> Edit Chapter</h4>
            <form action="<?= base_url('content_management/content/chapter/edit_chapter/'.$chapter->id.'/'.$chapter->novel_id) ?>" method="post" class="mx-3">
                <?= csrf_field(); ?>
                <div class="form-group my-2">
                    <label class="size-14" for="chapter_no">Chapter Name</label>
                    <input type="text" class="form-control size-14 mt-1" id="chapter_name" name="chapter_name" placeholder="Enter Chapter Name" value="<?= $chapter->chapter_name ?>">
                </div>
                <div class="form-group my-2">
                    <textarea style="height: 500px" type="text" class="form-control size-14 mt-1" id="summernote" name="content" placeholder="Enter Content"><?= $chapter->content ?></textarea>
                </div>
                <div class="d-flex flex-row justify-content-end me-0 mt-3">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>

    </div>
</div>

<script src="<?= base_url('jquery/jquery-3.7.1.min.js') ?>"></script>


<?= $this->endSection() ?>

