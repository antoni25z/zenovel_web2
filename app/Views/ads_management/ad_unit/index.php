
<?= $this->extend('layout/page_layout') ?>
<?= $this->section('content') ?>

<div class="col content-body">
    <div class="row justify-content-between m-3">
        <div class="col-auto size-12">Ads Management/Ad Unit</div>
        <div class="col-auto">
            <a href="<?= base_url('ads_management/ads/add_ad_unit') ?>" class="btn btn-primary">Add Ad Unit</a>
        </div>
    </div>

    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Delete Novel</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="id" value="0"/>
                    <p>Are you sure want to delete this Novel ? All Page and chapter will be deleted</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button id="delete" type="button" class="btn btn-danger">Delete</button>
                </div>
            </div>
        </div>
    </div>

    <div class="col mb-2 p-2">

        <div class="container-fluid bg-white p-4 radius-top">
            <div class="row align-items-center">
                <div class="col-md-2 col m-0">
                    <div class="input-group">
                        <input type="text" class="form-control input_icon size-14" id="searchM">
                    </div>
                </div>
            </div>
        </div>

        <div class="table-responsive-xl">
            <table id="empTable" class="table-borderless table-striped">

                <thead class="bg-white">
                <tr>
                    <th>Package</th>
                    <th>Ad Unit</th>
                    <th>Ad Unit ID</th>
                    <th>Ad Type</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                </thead>
            </table>

        </div>
    </div>
</div>

<script src="<?= base_url('jquery/jquery-3.7.1.min.js') ?>" type="text/javascript"></script>
<script src="<?= base_url('jquery-ui-1.13.2/jquery-ui.min.js') ?>"> </script>
<script src="<?= base_url('DataTables/datatables.min.js') ?>"></script>


<script type="text/javascript">

    $(document).ready(function () {
        $('#empTable').DataTable({
            "bLengthChange": false,
            "order": [],
            "serverSide": true,
            'info': false, 'ordering': false, 'paging': false,
            'ajax': {
                "url" : '<?= site_url('ads_management/ad_units') ?>',
                "dataType": "json",
                "type": "POST",
                "data": {
                    'search': $('#searchM').val(),
                },
                "dataSrc": "records",
            },
            "columns": [
                { "data" : "package_name" },
                { "data" : "name" },
                { "data" : "id" },
                { "data" : "ad_format" },
                {
                    "data" : "disabled",
                    "render": function (data, type, row, meta) {
                        if (data === false) {
                            return "<span class='badge bg-success'>Active</span>"
                        } else {
                            return "<span class='badge bg-danger'>Disable</span>"
                        }
                    }
                },
                {
                    "data" : "id",
                    "render": function (data, type, row, meta) {
                        return '<a href="<?= base_url('ads_management/ads/edit_ad_unit/') ?>'+data+'" class="btn btn-success">Edit</a>'
                    }
                }
            ],
            oLanguage: {
                oPaginate: {
                    sNext: '<span class="pagination-default"></span><span class="pagination-fa"><i class="fa fa-chevron-right" ></i></span>',
                    sPrevious: '<span class="pagination-default"></span><span class="pagination-fa"><i class="fa fa-chevron-left" ></i></span>'
                }
            },
            "destroy" : true
        });

        const textInput = document.getElementById('searchM');
        textInput.addEventListener('keydown', (event) => {
            if (event.key === 'Enter') {
                $('#empTable').DataTable({
                    "bLengthChange": false,
                    "order": [],
                    "processing": true,
                    "serverSide": true,
                    'info': false, 'ordering': false, 'paging': false,
                    'ajax': {
                        "url" : '<?= site_url('ads_management/ad_units') ?>',
                        "dataType": "json",
                        "type": "POST",
                        "data": {
                            'search': $('#searchM').val(),
                        },
                        "dataSrc": "records",
                    },
                    "columns": [
                        { "data" : "package_name" },
                        { "data" : "name" },
                        { "data" : "id" },
                        { "data" : "ad_format" },
                        {
                            "data" : "disabled",
                            "render": function (data, type, row, meta) {
                                if (data) {
                                    return "<span class='badge bg-success'>Active</span>"
                                } else {
                                    return "<span class='badge bg-danger'>Disable</span>"
                                }
                            }
                        },
                    ],
                    "destroy" : true
                });
            }
        });
    });

</script>

<?= $this->endSection() ?>
