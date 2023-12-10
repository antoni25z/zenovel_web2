<?= $this->extend('layout/page_layout') ?>
<?= $this->section('content') ?>

<div class="col content-body">
    <div class="row justify-content-between m-3">
        <div class="col-2 size-12">Review Feedback/Report</div>
    </div>

    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Delete Report</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="id" value="0" />
                    <p>Are you sure want to delete this Report ?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button id="delete" type="button" class="btn btn-danger">Delete</button>
                </div>
            </div>
        </div>
    </div>

    <div class="col mx-2 mb-2 p-2">

        <div class="container-fluid d-flex flex-row bg-white p-4 radius-top">
            <div class="col-auto me-2">
                <select id="length_select" class="select_background" aria-label="Default select example">
                    <option selected value="10">10</option>
                    <option value="20">20</option>
                    <option value="30">30</option>
                </select>
            </div>

            <div class="col-md-2 col m-0">
                <div class="input-group">
                    <input type="text" class="form-control input_icon" id="searchM" placeholder="Search">
                </div>
            </div>
        </div>

        <div class="table-responsive-xl">
            <table id="empTable" class="text-center table-borderless">

                <thead class="bg-white">
                <tr>
                    <th>No Ticket</th>
                    <th>User</th>
                    <th>Message</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>

                <?php
                $i = 0;
                foreach ($report as $item) { $i++ ?>
                    <tr>
                        <td id="cm"><?= $item['id'] ?></td>
                        <td id="cm"><img width="50" height="50" class="rounded-circle" src="<?= base_url('image/user/'. $item['user_image']) ?>" alt=""><p><?= $item['user_name'] ?></p></td>
                        <td id="cm"><?= $item['message'] ?></td>
                        <td id="cm"><?= $item['created'] ?></td>
                        <td id="cm">
                            <div class="col">
                                <button id="showDelete" class="btn btn-danger size-14 my-1" data-id="<?= $item['id'] ?>" data-bs-toggle="modal" data-bs-target="#deleteModal">Delete</button>
                            </div>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>

        </div>
    </div>
</div>

<script src="<?= base_url('jquery/jquery-3.7.1.min.js') ?>" type="text/javascript"></script>
<script src="<?= base_url('DataTables/datatables.min.js') ?>"></script>


<script type="text/javascript">
    $(document).ready(function () {

        const empTable = $('#empTable').DataTable({
            "bLengthChange": false,
            oLanguage: {
                oPaginate: {
                    sNext: '<span class="pagination-default"></span><span class="pagination-fa"><i class="fa fa-chevron-right" ></i></span>',
                    sPrevious: '<span class="pagination-default"></span><span class="pagination-fa"><i class="fa fa-chevron-left" ></i></span>'
                }
            }
        });

        let row = $("#length_select").val();
        empTable.page.len(row).draw();

        $('#searchM').keyup(function () {
            empTable.search($('#searchM').val()).draw();
        });

        $('#length_select').on('change', function () {
            let row = $("#length_select").val()
            empTable.page.len(row).draw();
        });

        $('#deleteModal').on("show.bs.modal", function (event) {

            const id = $(event.relatedTarget).data('id');
            $('#id').val(id);
        });

        $('#delete').on('click', function(event) {
            event.preventDefault();

            $.ajax({
                url: '<?= base_url('review_feedback/report/delete_report') ?>',
                method: "POST",
                dataType: "json",
                data: {
                    'id': $('#id').val(),
                },
                success: function (response) {
                    console.log(response);
                    if (!response.error) {

                        $('#deleteModal').modal('hide');
                        window.location.reload()

                    }
                },
                error: function (response) {
                    console.log(response.responseText);
                    console.log($('#id').val())
                }
            })
        });
    });

</script>

<?= $this->endSection() ?>

