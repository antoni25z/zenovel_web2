<?= $this->extend('layout/page_layout') ?>
<?= $this->section('content') ?>

<div class="col content-body h-100">
    <div class="col h-100">
        <div class="container p-0 bg-white rounded-2 h-100">

            <h4 class="content-title"><span><img class="me-3" src="<?= base_url('image/tag.png') ?>" alt=""></span>Edit Tag</h4>
            <form action="<?= base_url('content_management/tag/edit_tag/'.$data->id) ?>" method="post" class="mx-3">
                <?= csrf_field(); ?>
                <div class="form-group my-2">
                    <label class="size-14" for="tag">Genre Name</label>
                    <input type="text" class="form-control size-14 mt-1" id="tag" name="tag" placeholder="Enter Tag" value="<?= $data->tag ?>">
                </div>
                <div class="d-flex flex-row justify-content-end me-0 mt-3">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>

    </div>
</div>

<?= $this->endSection() ?>
