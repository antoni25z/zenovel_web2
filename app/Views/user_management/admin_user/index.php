<?= $this->extend('layout/page_layout') ?>
<?= $this->section('content') ?>

<div class="col content-body">
    <div class="row justify-content-between m-3">
        <div class="col-2 size-12">User Management/Admin Account</div>
        <div class="col-auto">
            <a href="<?= base_url('user_management/admin/add_user') ?>" class="btn btn-primary">Add Admin User</a>
        </div>
    </div>

    <div class="col bg-white mx-2 mb-2 p-2 rounded-3">

        <div class="row d-flex ms-3 my-3">
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

        <!--Change Password -->
        <div class="modal fade" id="changePasswordModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Change Password</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            </button>
                    </div>
                    <div class="modal-body">
                            <div class="form-group my-2">
                                <label class="size-14" for="password">New Password</label>
                                <input type="password" class="form-control size-14 mt-1" id="password" name="password"  placeholder="New Password">

                                <input class="mt-1" id="visible" type="checkbox" onclick="visiblePassword()">
                                <label class="size-14" for="visible">Show Password</label>
                            </div>
                        <input type="hidden" id="id_admin" value="0" />

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button id="changePassword" type="button" class="btn btn-primary">Save changes</button>
                    </div>
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
                        <input type="hidden" class="txt_unblock" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
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
                        <input type="hidden" class="txt_csrfdelete" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
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
                    <th>Username</th>
                    <th>Status</th>
                    <th>Created</th>
                    <th>Action</th>
                </tr>
                </thead>

                <tbody>
                <?php $i = 1;
                foreach ($pagination as $item) {?>
                    <tr>
                        <td><?=$i?></td>
                        <td><?=$item->username?></td>
                        <td><?= ($item->status == "1") ? 'Active' : 'Blocked'?></td>
                        <td><?=$item->created?></td>
                        <td class="w-25">
                                <div class="col-auto">
                                    <button class="btn btn-warning size-14 mx-1 mb-1" data-id="<?= $item->id_administrator ?>" data-bs-toggle="modal" data-bs-target="#changePasswordModal" >Change Password</button>
                                    <?php if($item->status == "1") { ?>
                                        <button  class="btn btn-danger size-14 mx-1 mb-1" data-id="<?= $item->id_administrator ?>" data-bs-toggle="modal" data-bs-target="#blockUserModal">Block</button>
                                    <?php } else { ?>
                                        <button class="btn btn-success size-14 mx-1 mb-1" data-id="<?= $item->id_administrator ?>" data-bs-toggle="modal" data-bs-target="#unblockUserModal">Unblock</button>
                                    <?php } ?>
                                    <button class="btn btn-danger size-14 mx-1 mb-1" data-id="<?= $item->id_administrator ?>" data-bs-toggle="modal" data-bs-target="#deleteUserModal">Delete</button>
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

<script src="<?= base_url('jquery/jquery-3.7.1.min.js') ?>" type="text/javascript"></script>
<script src="<?= base_url('DataTables/datatables.min.js') ?>"></script>


<script>
    $(document).ready(function(){

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
        });

        $('#length_select').on('change', function() {
            let row = $("#length_select").val()
            empTable.page.len(row).draw();
        });
    });

    $('#blockUser').on('click', function(event) {
        event.preventDefault();

        $.ajax({
            url: '<?= base_url('user_management/admin/block_user') ?>',
            method: "POST",
            dataType: "json",
            data: {
                'id': $('#id_admin').val()
            },
            success: function (response) {
                console.log(response);
                if (!response.error) {

                    $('#blockUserModal').modal('hide');
                    $('#success_modal').modal('show');
                } else {
                    $('#failed_modal').modal('show');
                }
            },
            error: function (response) {
                alert(response.responseText);
            }
        });
    });

    $('#success_modal').on('hide.bs.modal', function(event) {
        window.location.reload();
    });

    $('#failed_modal').on('hide.bs.modal', function(event) {
        window.location.reload();
    });

    $('#changePassword').on('click', function(event) {
        event.preventDefault();

        $.ajax({
            url: '<?= base_url('user_management/admin/change_password') ?>',
            data: {
                'id': $('#id_admin').val(),
                'password': $('#password').val(),
            },
            method: "POST",
            dataType: "json",
            success: function (response) {
                console.log(response);
                if (!response.error) {
                    $('#changePasswordModal').modal('hide');
                    $('#success_modal').modal('show');
                } else {
                    $('#failed_modal').modal('show');
                }
            },
            error: function (response) {
                alert(response.responseText);
            }
        });
    });



    $('#unblockUser').on('click', function(event) {
        event.preventDefault();

        $.ajax({
            url: '<?= base_url('user_management/admin/unblock_user') ?>',
            method: "POST",
            dataType: "json",
            data: {
                'id': $('#id_admin').val(),
            },
            success: function (response) {
                console.log(response);
                if (!response.error) {
                    $('#unblockUserModal').modal('hide');
                    $('#success_modal').modal('show');
                } else {
                    $('#failed_modal').modal('show');
                }
            },
            error: function (response) {
                alert(response.responseText);
            }
        });
    });

    $('#deleteUser').on('click', function(event) {
        event.preventDefault();

        $.ajax({
            url: '<?= base_url('user_management/admin/delete_user') ?>',
            method: "POST",
            dataType: "json",
            data: {
                'id': $('#id_admin').val(),
            },
            success: function (response) {
                console.log(response);
                if (!response.error) {
                    $('#deleteUserModal').modal('hide');
                    $('#success_modal').modal('show');
                } else {
                    $('#failed_modal').modal('show');
                }
            },
            error: function (response) {
                alert(response.responseText);
            }
        });
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
