<?= $this->extend('layout/page_layout') ?>
<?= $this->section('content') ?>

<div class="col content-body h-100">
    <div class="col h-100">
        <div class="container p-0 bg-white rounded-2 h-100">

            <h4 class="content-title"><span><img class="me-3" src="<?= base_url('image/genre.png') ?>" alt=""></span> Add User</h4>
            <form action="<?= base_url('content_management/genre/add_genre') ?>" method="post" class="mx-3">
                <?= csrf_field(); ?>
                <div class="form-group my-2">
                    <label class="size-14" for="genre_name">Genre Name</label>
                    <input type="text" class="form-control size-14 mt-1" id="genre_name" name="genre_name" placeholder="Enter Genre">
                </div>
                <div class="form-group my-2">
                    <label class="size-14" for="status">Status</label>
                    <select class="form-select size-14 mt-1" name="status" id="status">
                        <option value="1">Active</option>
                        <option value="0">Non Active</option>
                    </select>
                </div>
                <div class="d-flex flex-row justify-content-end me-0 mt-3">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>

    </div>
</div>

<?= $this->endSection() ?>

