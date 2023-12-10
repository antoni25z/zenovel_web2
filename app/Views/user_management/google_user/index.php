<?= $this->extend('layout/page_layout') ?>
<?= $this->section('content') ?>

<div class="col content-body">
    <div class="row justify-content-start m-3">
        <div class="col-2 size-12">User Management/User Account</div>
    </div>
    <div class="col bg-white mx-2 mb-2 p-2 rounded-3">

        <div class="row d-flex justify-content-start align-content-center ms-3 my-3">
            <div class="col-auto">
                <select id="length_select" class="select_background" aria-label="Default select example">
                    <option selected value="10">10</option>
                    <option value="20">20</option>
                    <option value="30">30</option>
                </select>
            </div>

            <div class="col-md-2 col d-flex flex-row">
                <div class="input-group mb-3">
                    <input type="text" class="form-control input_icon" id="searchM" placeholder="Username">
                </div>
            </div>
        </div>
        <!--Block User -->
        <div class="modal fade" id="blockUserModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Block User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="id_admin" value="0" />

                        <p>Are you sure want to block this user ?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button id="blockUser" type="button" class="btn btn-danger">Block</button>
                    </div>
                </div>
            </div>
        </div>

        <!--UnBlock User -->
        <div class="modal fade" id="unblockUserModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Unblock User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="id_admin" value="0" />
                        <p>Are you sure want to unblock this user ?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button id="unblockUser" type="button" class="btn btn-success">Unblock</button>
                    </div>
                </div>
            </div>
        </div>

        <!--Delete User -->
        <div class="modal fade" id="deleteUserModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Delete User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="id_admin" value="0" />
                        <p>Are you sure want to delete this user ?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button id="deleteUser" type="button" class="btn btn-danger">Delete</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="table-responsive-xl">
            <table id="empTable" class="table-borderless table-striped">

                <thead>
                <tr>
                    <th>No</th>
                    <th>Image</th>
                    <th>Email</th>
                    <th>Full Name</th>
                    <th>Status</th>
                    <th>Created</th>
                    <th>Action</th>
                </tr>
                </thead>

                <tbody>
                <?php $i = 1;
                foreach ($data as $item) {?>
                    <tr>
                        <td><?=$i?></td>
                        <td><img width="50" height="50" class="rounded-circle" src="<?= base_url('image/user/'. $item->user_image) ?>" alt=""></td>
                        <td><?= $item->email ?></td>
                        <td><?= $item->full_name ?></td>
                        <td><?= ($item->status == "1") ? 'Active' : 'Blocked'?></td>
                        <td><?= $item->created ?></td>
                        <td class="w-25">
                            <div class="col-auto">
                                <?php if($item->status == "1") { ?>
                                    <button  class="btn btn-danger size-14 mx-1 mb-1" data-id="<?= $item->id ?>" data-bs-toggle="modal" data-bs-target="#blockUserModal">Block</button>
                                <?php } else { ?>
                                    <button class="btn btn-success size-14 mx-1 mb-1" data-id="<?= $item->id ?>" data-bs-toggle="modal" data-bs-target="#unblockUserModal">Unblock</button>
                                <?php } ?>
                            </div>

                        </td>
                    </tr>
                    <?php $i++;
                } ?>
                </tbody>
            </table>

        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.js" type="text/javascript"></script>
<script src="<?= base_url('DataTables/datatables.min.js') ?>"></script>


<script type="text/javascript">
    $(document).ready(function(){

        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 2000,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });

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

        $('#searchM').keyup(function(){
            empTable.search($('#searchM').val()).draw() ;
        })

        $('#length_select').on('change', function() {
            let row = $("#length_select").val()
            empTable.page.len(row).draw();
        });

        $('#blockUser').on('click', function(event) {
            event.preventDefault();

            $.ajax({
                url: '<?= base_url('user_management/user/block_user') ?>',
                method: "POST",
                dataType: "json",
                data: {
                    'id': $('#id_admin').val()
                },
                success: function (response) {
                    console.log(response);
                    if (!response.error) {

                        $('#blockUserModal').modal('hide');
                        <?php session()->setFlashdata('success', "success") ?>;

                        window.location.href = "http://localhost:8080/";

                    } else {

                    }
                },
                error: function (response) {
                    alert(response.responseText);
                }
            })
        });
    });



    $('#unblockUser').on('click', function(event) {
        event.preventDefault();

        $.ajax({
            url: '<?= base_url('user_management/user/unblock_user') ?>',
            method: "POST",
            dataType: "json",
            data: {
                'id': $('#id_admin').val(),
            },
            success: function (response) {
                console.log(response);
                if (!response.error) {
                    $('#unblockUserModal').modal('hide');
                    <?php session()->setFlashdata('success', "<script>response.message</script>"); ?>
                    location.reload();
                } else {
                    <?php session()->setFlashdata('error', "<script>response.message </script>"); ?>
                }
            },
            error: function (response) {
                alert(response.responseText);
            }
        })
    });

    $('#deleteUser').on('click', function(event) {
        event.preventDefault();

        $.ajax({
            url: '<?= base_url('user_management/user/delete_user') ?>',
            method: "POST",
            dataType: "json",
            data: {
                'id': $('#id_admin').val(),
            },
            success: function (response) {
                console.log(response);
                if (!response.error) {
                    $('#deleteUserModal').modal('hide');
                    <?php session()->setFlashdata('success', "<script>response.message </script>"); ?>
                    location.reload();
                } else {
                    <?php session()->setFlashdata('error', "<script>response.message </script>"); ?>
                }
            },
            error: function (response) {
                alert(response.responseText);
            }
        })
    });

    $('#changePasswordModal').on("show.bs.modal", function (event) {

        const id = $(event.relatedTarget).data('id');
        $('#id_admin').val(id);
    });

    $('#deleteUserModal').on("show.bs.modal", function (event) {

        const id = $(event.relatedTarget).data('id');
        $('#id_admin').val(id);
    });

    $('#blockUserModal').on("show.bs.modal", function (event) {

        const id = $(event.relatedTarget).data('id');
        $('#id_admin').val(id);
    });

    $('#unblockUserModal').on("show.bs.modal", function (event) {

        const id = $(event.relatedTarget).data('id');
        $('#id_admin').val(id);
    });

    function visiblePassword() {
        const x = document.getElementById("password");
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
    }

</script>

<?= $this->endSection() ?>

