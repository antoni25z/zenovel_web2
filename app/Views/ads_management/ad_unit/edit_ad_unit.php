<?= $this->extend('layout/page_layout') ?>
<?= $this->section('content') ?>

<div class="col content-body h-100">
    <div class="col h-100">
        <div class="container p-0 bg-white rounded-2 h-100">

            <h4 class="content-title"><span><img class="me-3" src="<?= base_url('image/ads.png') ?>" alt=""></span> Edit Ad Unit</h4>
            <form action="<?= base_url('ads_management/ads/edit_ad_unit/'.$response['id']) ?>" method="post" class="mx-3">
                <?= csrf_field(); ?>
                <div class="form-group my-2">
                    <label class="size-14" for="ad_unit_name">Ad Unit Name</label>
                    <input type="text" class="form-control size-14 mt-1" id="ad_unit_name" name="ad_unit_name" placeholder="Enter Ad Unit Name" value="<?= $response['name'] ?>">
                </div>
                <div class="form-group my-2">
                    <label class="size-14" for="package_name">Package Name</label>
                    <input type="text" class="form-control size-14 mt-1" id="package_name" name="package_name" placeholder="Enter Ad Unit Name" value="<?= $response['package_name'] ?>">
                </div>
                <div class="form-group my-2">
                    <label class="size-14" for="platform">Platform</label>
                    <select class="form-select size-14 mt-1" name="platform" id="platform">
                        <option <?php if ($response['platform'] == 'android') {?> selected <?php } ?> value="android">Android</option>
                        <option <?php if ($response['platform'] == 'ios') {?> selected <?php } ?> value="ios">IOS</option>
                    </select>
                </div>
                <div class="form-group my-2">
                    <label class="size-14" for="ad_unit_type">Ad Unit Type</label>
                    <select class="form-select size-14 mt-1" onchange="showDiv('hide_template_select', this)" name="ad_unit_type" id="ad_unit_type">
                        <option <?php if ($response['ad_format'] == 'APPOPEN') {?> selected <?php } ?> value="APPOPEN">App Open</option>
                        <option <?php if ($response['ad_format'] == 'BANNER') {?> selected <?php } ?> value="BANNER">Banner</option>
                        <option <?php if ($response['ad_format'] == 'INTER') {?> selected <?php } ?> value="INTER">Interstitial</option>
                        <option <?php if ($response['ad_format'] == 'MREC') {?> selected <?php } ?> value="MREC">MREC</option>
                        <option <?php if ($response['ad_format'] == 'NATIVE') {?> selected <?php } ?> value="NATIVE">Native</option>
                        <option <?php if ($response['ad_format'] == 'REWARDED') {?> selected <?php } ?> value="REWARDED">Rewarded</option>
                    </select>
                </div>
                <div id="hide_template_select" class="form-group my-2">
                    <label class="size-14" for="template">Template</label>
                    <select class="form-select size-14 mt-1"  name="template" id="template">
                        <option <?php if ($response['ad_format'] == 'NATIVE') {?> <?php if ($response['template_size'] == 'small_template_1') {?> selected <?php } ?> <?php } ?> value="small_template_1">Small</option>
                        <option <?php if ($response['ad_format'] == 'NATIVE') {?> <?php if ($response['template_size'] == 'medium_template_1') {?> selected <?php } ?> <?php } ?> value="medium_template_1">Medium</option>
                        <option <?php if ($response['ad_format'] == 'NATIVE') {?> <?php if ($response['template_size'] == 'custom_template_1') {?> selected <?php } ?> <?php } ?> value="custom_template_1">Manual</option>
                    </select>
                </div>
                <div class="d-flex flex-row justify-content-end me-0 mt-3">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>

    </div>
</div>

<script>
    document.getElementById('hide_template_select').style.display = document.getElementById('ad_unit_type').value === 'NATIVE' ? 'block' : 'none';
    function showDiv(divId, element)
    {
        document.getElementById(divId).style.display = element.value === 'NATIVE' ? 'block' : 'none';
    }
</script>

<?= $this->endSection() ?>

