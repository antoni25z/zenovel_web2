<?= $this->extend('layout/page_layout') ?>
<?= $this->section('content') ?>

<div class="col content-body h-100">
    <div class="col h-100">
        <div class="container p-0 bg-white rounded-2 h-100">

            <h4 class="content-title"><span><img class="me-3" src="<?= base_url('image/ads.png') ?>" alt=""></span> Add Ad Unit</h4>
            <form action="<?= base_url('ads_management/ads/add_ad_unit') ?>" method="post" class="mx-3">
                <?= csrf_field(); ?>
                <div class="form-group my-2">
                    <label class="size-14" for="ad_unit_name">Ad Unit Name</label>
                    <input type="text" class="form-control size-14 mt-1" id="ad_unit_name" name="ad_unit_name" placeholder="Enter Ad Unit Name">
                </div>
                <div class="form-group my-2">
                    <label class="size-14" for="package_name">Package Name</label>
                    <input type="text" class="form-control size-14 mt-1" id="package_name" name="package_name" placeholder="Enter Ad Unit Name">
                </div>
                <div class="form-group my-2">
                    <label class="size-14" for="platform">Platform</label>
                    <select class="form-select size-14 mt-1" name="platform" id="platform">
                        <option>Select Platform</option>
                        <option value="android">Android</option>
                        <option value="ios">IOS</option>
                    </select>
                </div>
                <div class="form-group my-2">
                    <label class="size-14" for="ad_unit_type">Ad Unit Type</label>
                    <select class="form-select size-14 mt-1" onchange="showDiv('hide_template_select', this)" name="ad_unit_type" id="ad_unit_type">
                        <option selected>Select Ad Type</option>
                        <option value="APPOPEN">App Open</option>
                        <option value="BANNER">Banner</option>
                        <option value="INTER">Interstitial</option>
                        <option value="MREC">MREC</option>
                        <option value="NATIVE">Native</option>
                        <option value="REWARDED">Rewarded</option>
                    </select>
                </div>
                <div id="hide_template_select" class="form-group my-2">
                    <label class="size-14" for="template">Template</label>
                    <select class="form-select size-14 mt-1"  name="template" id="template">
                        <option value="small_template_1">Small</option>
                        <option value="medium_template_1">Medium</option>
                        <option value="custom_template_1">Manual</option>
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
    function showDiv(divId, element)
    {
        document.getElementById(divId).style.display = element.value === 'NATIVE' ? 'block' : 'none';
    }
</script>

<?= $this->endSection() ?>

