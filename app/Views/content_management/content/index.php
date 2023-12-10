<?= $this->extend('layout/page_layout') ?>
<?= $this->section('content') ?>

<div class="col content-body">
    <div class="row justify-content-between m-3">
        <div class="col-2 size-12">Content Management/Content</div>
        <div class="col-auto">
            <a href="<?= base_url('content_management/content/add_novel') ?>" class="btn btn-primary">Add Novel</a>
        </div>
    </div>

    <div class="row m-3">
        <div class="content-container bg-white rounded-3">
            <div class="row">

                <div class="col-auto d-flex align-items-center justify-content-center">
                    <div class="image-container">
                        <img src="<?= base_url('image/publish.png') ?>" alt="">
                    </div>
                </div>

                <div class="col mt-3">
                    <p class="text-center">Published</p>
                    <p class="bold-10"><?= $published ?></p>
                </div>
            </div>
        </div>

        <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Delete Novel</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="id" value="0" />
                        <p>Are you sure want to delete this Novel ? All Page and chapter will be deleted</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button id="delete" type="button" class="btn btn-danger">Delete</button>
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
            <div class="modal-dialog modal-dialog-centered"  role="document">
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

        <div class="content-container bg-white rounded-3 ms-3">
            <div class="row">

                <div class="col-auto d-flex align-items-center justify-content-center">
                    <div class="image-container">
                        <img src="<?= base_url('image/unpublish.png') ?>" alt="">
                    </div>
                </div>

                <div class="col mt-3">
                    <p class="text-center">Unpublished</p>
                    <p class="bold-10"><?= $unpublished ?></p>
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
                    <th>No</th>
                    <th>Novel Image</th>
                    <th>Novel Title</th>
                    <th>Novel Summary</th>
                    <th>Novel Tag</th>
                    <th>Genre</th>
                    <th>Total Chapter</th>
                    <th>Rating</th>
                    <th>Novel Status</th>
                    <th>Status</th>
                    <th>Created</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>

                <?php
                $i = 0;
                foreach ($novel as $item) { $i++ ?>
                    <tr>
                        <td id="cm"><?= $i ?></td>
                        <td id="cm"><img width="110" height="150" class="rounded-2"
                                         src="<?= base_url('image/novel/'.$item['novel_image']) ?>"></td>
                        <td id="cm"><?= $item['novel_title'] ?></td>
                        <td id="cm"><?= $item['novel_summary'] ?></td>
                        <td id="cm">
                            <?php foreach ($item['novel_tag'] as $tag) { ?>
                                <span class="badge bg-success"><?= $tag->tag ?></span>
                            <?php } ?>
                        </td>
                        <td id="cm"><?= $item['genre'] ?></td>
                        <td id="cm"><?= $item['chapter'] ?></td>
                        <td id="cm">
                            <div class="col-auto d-flex flex-column align-items-center justify-content-center">
                                <img width="15px" height="15px" class="mb-1" src="<?= base_url('image/star.png') ?>" alt="">
                                <?= $item['rating']== null ? '0.0' : $item['rating'] ?>
                            </div>

                        </td>
                        <td id="cm"><?= $item['chapter_status'] == 1 ? '<span class="badge bg-black">Complete</span>' : '<span class="badge bg-black">Ongoing</span>' ?></td>
                        <td id="cm"><?= $item['status'] == 1 ? '<span class="badge bg-success">Published</span>' : '<span class="badge bg-danger">Unpublished</span>' ?></td>
                        <td id="cm"><?= $item['created'] ?></td>
                        <td id="cm">
                            <div class="col">
                                <a href="<?= base_url('content_management/content/edit_novel/'.$item['id']) ?>" class="btn btn-success size-14 my-1">Edit</a>
                                <a href="<?= base_url('content_management/content/chapter/all_chapter/'.$item['id']) ?>" class="btn btn-success size-14 my-1">Chapter</a>
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

        $('#success_modal').on('hide.bs.modal', function(event) {
            window.location.reload();
        });

        $('#failed_modal').on('hide.bs.modal', function(event) {
            window.location.reload();
        });


        $('#delete').on('click', function(event) {
            event.preventDefault();

            $.ajax({
                url: '<?= base_url('content_management/content/delete_novel') ?>',
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
                    console.log(response.responseText);
                    console.log($('#id').val())
                }
            })
        });
    });

</script>

<?= $this->endSection() ?>
