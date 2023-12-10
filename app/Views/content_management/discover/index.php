<?= $this->extend('layout/page_layout') ?>
<?= $this->section('content') ?>

<div class="col content-body">
    <div class="row justify-content-between m-3">
        <div class="col-2 size-12">Content Management/Discover</div>
        <div class="col-auto">
            <a href="<?= base_url('content_management/discover/add_discover') ?>" class="btn btn-primary">Add Discover</a>
        </div>
    </div>

    <div class="col">
        <div class="header_container main_bg_color mx-3 rounded-2">
            <h5 class="m-2">Most Popular</h5>
        </div>
        <div class="row row-cols-auto my-3 mx-1">
            <?php if (empty($most_popular)) { ?>
                <div class="container-fluid">
                    <p>No data available</p>
                </div>
            <?php } ?>
            <?php foreach ($most_popular as $it) {?>

                <div class="col m-1">
                    <div class="novel_container">
                        <img id="novel_image" src="<?= base_url('image/novel/'. $it->novel_image) ?>" alt="">
                        <div class="row d-flex justify-content-between align-items-center">
                            <div class="col">
                                <p class="mt-2 size-14 two-line"><?= $it['novel_name'] ?></p>
                            </div>
                        </div>
                    </div>
                </div>

            <?php } ?>
        </div>
    </div>

    <div class="col">
        <div class="header_container main_bg_color mx-3 rounded-2">
            <h5 class="m-2">New</h5>
        </div>
        <div class="row row-cols-auto my-3 mx-1">
            <?php if (empty($new)) { ?>
                <div class="container-fluid">
                    <p>No data available</p>
                </div>
            <?php } ?>
            <?php foreach ($new as $it) {?>

                <div class="col m-1">
                    <div class="novel_container">
                        <img id="novel_image" src="<?= base_url('image/novel/'. $it->novel_image) ?>" alt="">
                        <div class="row d-flex justify-content-between align-items-center">
                            <div class="col">
                                <p class="mt-2 size-14 two-line"><?= $it->novel_title ?></p>
                            </div>
                        </div>
                    </div>
                </div>

            <?php } ?>
        </div>
    </div>

    <?php foreach ($discover as $item) { ?>
        <div class="col">
            <div class="header_container main_bg_color mx-3 rounded-2">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <h5 class="m-2"><?= $item->discover_name ?> <?= ($item->status == 1) ? '<span class="badge bg-success size-12 ms-3">Active</span>' : '<span class="ms-3 badge bg-danger size-12">Non Active</span>' ?> </h5>
                    </div>
                    <div class="col-auto d-flex flex-row">
                        <div class="col mx-1">
                            <a href="<?= base_url('content_management/discover/add_discover_novel/'.$item->id) ?>" class="btn btn-success size-12">Add</a>
                        </div>
                        <div class="col mx-1">
                            <a href="<?= base_url('content_management/discover/edit_discover/'.$item->id) ?>" class="btn btn-success size-12">Edit</a>
                        </div>
                        <div class="col mx-1">
                            <a href="<?= base_url('content_management/discover/delete_discover/'.$item->id) ?>" class="btn btn-danger size-12">Delete</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row row-cols-auto my-3 mx-1">
            <?php foreach ($novel as $it) {?>
                    <?php if ($it['discover_id'] == $item->id) { ?>
                    <div class="col-auto m-1">
                        <div class="novel_container">
                            <img id="novel_image" src="<?= base_url('image/novel/'. $it['novel_image']) ?>" alt="">
                            <div class="row justify-content-between align-items-center">
                                <div class="col">
                                    <p class="mt-2 mb-2 size-14 two-line"><?= $it['novel_title'] ?></p>
                                </div>
                                <div class="col-auto">
                                    <a href="<?= base_url('content_management/discover/delete_discover_novel/'.$it['id']) ?>"><img src="<?= base_url('image/bin.png') ?>" alt=""></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
            <?php } ?>
        </div>
    <?php } ?>

</div>

<script src="<?= base_url('jquery/jquery-3.7.1.min.js') ?>" type="text/javascript"></script>

<script type="text/javascript">
    $(document).ready(function () {


    });

</script>

<?= $this->endSection() ?>

