<?= $this->extend('layout/page_layout') ?>
<?= $this->section('content') ?>

<div class="col content-body h-100">
    <div class="col h-100">
        <div class="container p-0 bg-white rounded-2 h-100">

            <h4 class="content-title"><span><img class="me-3" src="<?= base_url('image/novel.png') ?>" alt=""></span> Add Novel</h4>
            <form action="<?= base_url('content_management/content/edit_novel/'.$novel->id) ?>" method="post" enctype="multipart/form-data" class="mx-3">
                <?= csrf_field(); ?>

                <div class="row">
                    <label class="size-14 picker_image mx-3" for="novel_img">
                        <img id="pick_image" src="<?= base_url('image/novel/'.$novel->novel_image) ?>" alt="">
                    </label>
                    <input accept="image/*" type="file" id="novel_img" name="novel_img" onchange="showPreview(event)">

                    <div class="col">
                        <div class="form-group">
                            <label class="size-14" for="novel_title">Novel Title</label>
                            <input type="text" class="form-control size-14 mt-1" id="novel_title" name="novel_title" placeholder="Novel Title" value="<?= $novel->novel_title ?>">
                        </div>
                        <div class="form-group my-2">
                            <label class="size-14" for="novel_summary">Summary</label>
                            <textarea type="text" class="form-control size-14 mt-1" id="novel_summary" name="novel_summary" placeholder="Novel Summary"><?= $novel->novel_summary ?></textarea>
                        </div>

                        <div class="col d-flex flex-column">
                            <label class="size-14 my-2" for="select_cat">Select Novel Genre</label>
                            <select id="select_genre" name="select_genre" class="form-select" aria-label="Default select example">
                                <option selected>Nothing selected</option>
                                <?php foreach ($genre as $item) { ?>
                                    <option <?php if ($item->id == $novel->genre_id) { ?>selected<?php } ?> value=<?= $item->id ?>><?= $item->genre ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="col d-flex flex-column">
                            <label class="size-14 my-2" for="select_tag">Select Novel Tag</label>
                            <select id="select_tag" name="select_tag[]" class="selectpicker w-100" multiple>
                                <?php foreach ($tag as $item) { ?>
                                    <option <?php foreach ($novel_tag as $i) { ?>
                                        <?php if ($item->id == $i->tag_id) { ?> selected <?php } ?>
                                    <?php } ?> data-content="<span class='badge bg-success'><?= $item->tag ?></span>" value=<?= $item->id ?>><?= $item->tag ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="col d-flex flex-column">
                            <label class="size-14 my-2" for="chapter_status">Novel Status</label>
                            <select id="chapter_status" name="chapter_status" class="form-select" aria-label="Default select example">
                                <option <?php if ($novel->chapter_status == 1) { ?>selected<?php } ?> value='1'>Complete</option>
                                <option <?php if ($novel->chapter_status == 0) { ?>selected<?php } ?> value='0'>Ongoing</option>
                            </select>
                        </div>

                        <div class="col d-flex flex-column">
                            <label class="size-14 my-2" for="select_status">Status</label>
                            <select id="select_status" name="select_status" class="form-select" aria-label="Default select example">
                                <option <?php if ($novel->status == 1) { ?>selected<?php } ?> value='1'>Published</option>
                                <option <?php if ($novel->status == 0) { ?>selected<?php } ?> value='0'>Unpublished</option>
                            </select>
                        </div>

                        <div class="d-flex flex-row justify-content-end me-0 mt-3">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>

                </div>

            </form>
        </div>

    </div>
</div>
<script src="<?= base_url('popper/popper.min.js') ?>"></script>
<script defer src="<?= base_url('bootstrap-select-1.14.0-beta2/js/bootstrap-select.min.js') ?>"></script>
<script src="<?= base_url('jquery/jquery-3.7.1.min.js') ?>" type="text/javascript"></script>
<script>
    function showPreview(event){
        if(event.target.files.length > 0){
            const src = URL.createObjectURL(event.target.files[0]);
            const preview = document.getElementById("pick_image");
            preview.src = src;
        }
    }
</script>

<?= $this->endSection() ?>

