<?= $this->extend('layout/page_layout') ?>
<?= $this->section('content') ?>

<div class="col content-body h-100">
    <div class="col h-100">
        <div class="container p-0 bg-white rounded-2 h-100">

            <h4 class="content-title"><span><img class="me-3" src="<?= base_url('image/notification.png') ?>" alt=""></span> Send Notification</h4>
            <form action="<?= base_url('notification_marketing/notification/send_notification') ?>" method="post" class="mx-3">
                <?= csrf_field(); ?>
                <div class="form-group my-2">
                    <label class="size-14" for="genre_name">Title</label>
                    <input type="text" class="form-control size-14 mt-1" id="title" name="title" placeholder="Enter Title">
                </div>
                <div class="form-group my-2">
                    <label class="size-14" for="message">Message</label>
                    <textarea type="text" class="form-control size-14 mt-1" id="message" name="message" placeholder="Enter Message"></textarea>
                </div>
                <div class="form-group my-2 d-flex flex-column">
                    <label class="size-14" for="status">Select User Or Topic</label>
                    <select class="selectpicker size-14 mt-1" name="topic_token" id="user" data-live-search="true">
                        <option value="all_user">All User</option>
                        <?php foreach ($user as $item) { ?>
                            <option value="<?= $item->token_fcm ?>"><?= $item->full_name ?></option>
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

