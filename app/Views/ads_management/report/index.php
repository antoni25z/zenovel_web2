
<?= $this->extend('layout/page_layout') ?>
<?= $this->section('content') ?>

<div class="col content-body">
    <div class="row justify-content-between m-2">
        <div class="col-auto size-12">Ads Management/Report</div>
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

    <div class="col-auto me-3 ms-3 p-1">
        <p class="col badge bg-warning"> <?= $date ?> </p>
        <div class="row">

            <div style="width: 150px" class="col-auto d-flex flex-column flex-xl-wrap bg-white rounded-2 m-2 pt-2 justify-content-center align-items-center">
                <p class="size-12 text-center">Daily Revenue</p>
                <p>$50.5</p>
            </div>

            <div style="width: 150px" class="col-1 d-flex flex-column bg-white rounded-2 m-2 pt-2 justify-content-center align-items-center">
                <p class="size-12 text-center">Monthly Revenue</p>
                <p>$50.5</p>
            </div>

            <div style="width: 150px" class="col-1 d-flex flex-column bg-white rounded-2 m-2 pt-2 justify-content-center align-items-center">
                <p class="size-12 text-center">Yearly Revenue</p>
                <p>$50.5</p>
            </div>
        </div>
    </div>



    <div class="col mx-2 mb-2 p-2">

        <div class="container-fluid bg-white p-4 radius-top">
                <div class="row align-items-center mb-2">
                    <div style="width: 180px" class="col-auto">
                        <div class="input-group">
                            <input type="text" class="form-control date_icon size-14" id="start_date" readonly value="2022-09-21">
                        </div>
                    </div>
                    <div class="col-auto">
                        <img src="<?= base_url('image/arrow-right.png') ?>">
                    </div>
                    <div style="width: 180px"  class="col-auto m-0">
                        <div class="input-group">
                            <input type="text" class="form-control date_icon size-14" id="end_date" readonly value="2022-09-21">
                        </div>
                    </div>
                </div>
            <div class="row align-items-center">
                <div class="col-auto me-1">
                    <select id="length_select" class="select_background" aria-label="Default select example">
                        <option selected value="10">10</option>
                        <option value="20">20</option>
                        <option value="30">30</option>
                    </select>
                </div>

                <div class="col-md-2 col m-0">
                    <div class="input-group">
                        <input type="text" class="form-control input_icon size-14" id="searchM">
                    </div>
                </div>
            </div>
        </div>

        <div class="table-responsive-xl">
            <table id="empTable" class="text-center table-borderless">

                <thead class="bg-white">
                <tr>
                    <th>Date</th>
                    <th>Application</th>
                    <th>Estimate Revenue</th>
                    <th>ecpm</th>
                    <th>Impressions</th>
                </tr>
                </thead>
                <tbody>

                </tbody>
            </table>

        </div>
    </div>
</div>

<script src="<?= base_url('jquery/jquery-3.7.1.min.js') ?>" type="text/javascript"></script>
<script src="<?= base_url('jquery-ui-1.13.2/jquery-ui.min.js') ?>"> </script>
<script src="<?= base_url('DataTables/datatables.min.js') ?>"></script>


<script type="text/javascript">

    $(document).ready(function () {

        const empTable =  $('#empTable').DataTable({
            "bLengthChange": false,
            'ajax': {
                "url" : '<?= site_url('report_revenue/get_report_revenue') ?>',
                "dataType": "json",
                "type": "POST",
                "data" : {
                    "start" : $('#start_date').val(),
                    "end" : $('#end_date').val(),
                },
                "dataSrc": "records",
            },
            "columns": [
                { "data" : "day" },
                { "data" : "application" },
                { "data" : "estimated_revenue" },
                { "data" : "ecpm" },
                { "data" : "impressions" },
            ],
            oLanguage: {
                oPaginate: {
                    sNext: '<span class="pagination-default"></span><span class="pagination-fa"><i class="fa fa-chevron-right" ></i></span>',
                    sPrevious: '<span class="pagination-default"></span><span class="pagination-fa"><i class="fa fa-chevron-left" ></i></span>'
                }
            }
        });

        $('#start_date').datepicker({
            dateFormat: "yy-mm-dd"
        });
        $('#end_date').datepicker({
            dateFormat: "yy-mm-dd"
        });

        $('#start_date, #end_date').change(function () {
            empTable.draw();
        });
    });





</script>

<?= $this->endSection() ?>
