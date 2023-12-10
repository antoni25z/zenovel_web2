<?= $this->extend('layout/page_layout') ?>
<?= $this->section('content') ?>

<div class="col content-body h-100">
    <div class="col h-100">
        <div class="container p-0 bg-white rounded-2 h-100">

            <h4 class="content-title"><span><img class="me-3" src="<?= base_url('image/research.png') ?>" alt=""></span> Add Novel To <span class="badge bg-success"><?= $discover->discover_name ?></span></h4>
            <form action="<?= base_url('content_management/discover/add_discover_novel/'.$discover->id) ?>" method="post" class="mx-3">
                <?= csrf_field(); ?>
                <div class="col d-flex flex-column">
                    <label class="size-14 my-2" for="select_novel">Select Novel</label>
                    <select id="select_novel" name="select_novel[]" class="selectpicker w-100" multiple data-live-search="true">
                        <?php foreach ($novel as $item) { ?>
                            <option value="<?= $item['novel_id'] ?>" data-content="<span class='badge bg-success'><?= $item['novel_name'] ?></span>"></option>
                        <?php } ?>

                    </select>
                </div>
                <div class="d-flex flex-row justify-content-end me-0 mt-3">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>

    </div>
</div>

<script src="<?= base_url('popper/popper.min.js') ?>"></script>
<script defer src="<?= base_url('bootstrap-select-1.14.0-beta2/js/bootstrap-select.min.js') ?>"></script>
<script src="<?= base_url('jquery/jquery-3.7.1.min.js') ?>" type="text/javascript"></script>

<?= $this->endSection() ?>

