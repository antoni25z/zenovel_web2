<?= $this->extend('layout/page_layout') ?>
<?= $this->section('content') ?>

<div class="col content-body">
    <div class="row justify-content-between m-3">
        <div class="col-2 size-12">Content Management/Genre</div>
        <div class="col-auto">
            <a href="<?= base_url('content_management/genre/add_genre') ?>" class="btn btn-primary">Add Genre</a>
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

        <div class="modal fade" id="success_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Message</h5>
                    </div>
                    <div class="modal-body">
                        <p>Operation Success</p>
                    </div>
                    <div class="modal-footer">
                        <button id="success" type="button" class="btn btn-success" data-bs-dismiss="modal">Ok</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="failed_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Message</h5>
                    </div>
                    <div class="modal-body">
                        <p>Operation Failed</p>
                    </div>
                    <div class="modal-footer">
                        <button id="failed" type="button" class="btn btn-danger" data-bs-dismiss="modal">Ok</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Delete Genre</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="id" value="0" />
                        <p>Are you sure want to delete this Genre ?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button id="delete" type="button" class="btn btn-danger">Delete</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="table-responsive-xl">
            <table id="empTable" class="text-center table-borderless">

                <thead class="bg-white">
                <tr>
                    <th>No</th>
                    <th>Genre</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody >

                <?php
                $i = 0;
                foreach ($data as $item) {
                    $i++;
                    ?>
                    <tr>
                        <td id="cm"><?= $i ?></td>
                        <td id="cm"><?= $item->genre ?></td>
                        <td id="cm"><?= $item->status == 1 ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-danger">Non Active</span>' ?></span></td>
                        <td class="w-25" id="cm">
                            <a href="<?= base_url('content_management/genre/edit_genre/'.$item->id) ?>" class="btn btn-success size-14 mx-1 mb-1">Edit</a>
                            <button id="showDelete" class="btn btn-danger size-14 mx-1 mb-1" data-id="<?= $item->id ?>" data-bs-toggle="modal" data-bs-target="#deleteModal">Delete</button>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>

        </div>


    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.js" type="text/javascript"></script>
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
        $('#success_modal').on('hide.bs.modal', function(event) {
            window.location.reload();
        });

        $('#failed_modal').on('hide.bs.modal', function(event) {
            window.location.reload();
        });

        $('#delete').on('click', function(event) {
            event.preventDefault();

            $.ajax({
                url: '<?= base_url('content_management/genre/delete_genre') ?>',
                method: "POST",
                dataType: "json",
                data: {
                    'id': $('#id').val(),
                },
                success: function (response) {
                    console.log(response);
                    if (!response.error) {

                        $('#deleteModal').modal('hide');
                        $('#success_modal').modal('show');
                    } else {
                        $('#failed_modal').modal('show');
                    }
                },
                error: function (response) {
                    alert(response.responseText);
                }
            })
        });
    });

</script>

<?= $this->endSection() ?>
