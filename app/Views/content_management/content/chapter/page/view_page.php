<?= $this->extend('layout/page_layout') ?>
<?= $this->section('content') ?>

<div class="col content-body h-100">
    <div class="col h-100">
        <div class="container p-0 bg-white rounded-2 h-100">
            <div class="col p-4">
                <p class="bold-10"><?=$chapter->chapter_name ?> <span class="size-14"></span></p>
                <div class="container-fluid">
                    <p><?= $chapter->content ?></p>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?= base_url('jquery/jquery-3.7.1.min.js') ?>"></script>
<?= $this->endSection() ?>

