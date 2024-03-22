<!-- Content Wrapper START -->
<div class="main-content">
    <div class="page-header">
        <h2 class="header-title"><?= $title; ?></h2>
        <div class="header-sub-title">
            <nav class="breadcrumb breadcrumb-dash">
                <a href="<?= base_url("admin") ?>" class="breadcrumb-item"><i class="anticon anticon-home m-r-5"></i>Home</a>
                <span class="breadcrumb-item active"><?= $title; ?></span>
            </nav>
        </div>
        <button type="button" class="btn btn-success btn-sm float-right" data-toggle="modal" data-target="#InsertModalCenter"><i class="anticon anticon-plus-square"></i> Add Category</button>
    </div>
    <?php if (!empty($this->session->flashdata('msg'))) { ?>
        <div class="alert alert-success">
            <div class="d-flex align-items-center justify-content-start">
                <span class="alert-icon">
                    <i class="anticon anticon-check-o"></i>
                </span>
                <span><?= $this->session->flashdata('msg'); ?></span>
            </div>
        </div>
    <?php } ?>
    <div class="card">
        <div class="card-body">
            <div class="m-t-25">
                <table id="data-table" class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th style="width: 60%;">Kategori</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 0;
                        foreach ($kategori as $item) {
                            $no++;
                        ?>
                            <tr>
                                <td><?= $no; ?></td>
                                <td><?= $item['KATEGORI']; ?></td>
                                </td>
                                <td>
                                    <div class="row">
                                        <a class="btn btn-success btn-sm col-md-5 mx-1 update-button" data-category="<?= $item['KATEGORI'] ?>" data-id="<?= $item['ID_KATEGORI'] ?>" href="javascript:void(0)" data-toggle="modal" data-target="#EditModalCenter"><i class="anticon anticon-edit"></i> edit</a>
                                        <a class="btn btn-danger btn-sm col-md-6 mx-1 delete-button" data-category="<?= $item['KATEGORI'] ?>" data-id="<?= $item['ID_KATEGORI'] ?>" href="javascript:void(0)" data-toggle="modal" data-target="#DeleteModalCenter"><i class="anticon anticon-delete"></i> delete</a>
                                    </div>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- Content Wrapper END -->
<div class="modal fade" id="InsertModalCenter">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Insert <?= $title; ?></h5>
                <button type="button" class="close" data-dismiss="modal">
                    <i class="anticon anticon-close"></i>
                </button>
            </div>
            <form action="<?= base_url('manage/category/add') ?>" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label control-label">Category</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" name="category-title">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="javascript:void(0)" class="btn btn-default" data-dismiss="modal">Close</a>
                    <button type="submit" class="btn btn-success">Insert</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="EditModalCenter">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Edit <?= $title; ?></h5>
                <button type="button" class="close" data-dismiss="modal">
                    <i class="anticon anticon-close"></i>
                </button>
            </div>
            <form action="<?= base_url('manage/category/update') ?>" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label control-label">Category</label>
                        <div class="col-md-9">
                            <input type="hidden" class="form-control" name="category-id" id="category-id-update">
                            <input type="text" class="form-control" name="category-title" id="category-title-update">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="javascript:void(0)" class="btn btn-default" data-dismiss="modal">Close</a>
                    <button type="submit" class="btn btn-success">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="DeleteModalCenter">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Delete <?= $title; ?></h5>
                <button type="button" class="close" data-dismiss="modal">
                    <i class="anticon anticon-close"></i>
                </button>
            </div>
            <form action="<?= base_url('manage/category/delete') ?>" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group row">
                        <div class="col-md-12">
                        <h6 id="ModalDeleteTitle"></h6>
                            <input type="hidden" class="form-control" name="category-id" id="category-id-delete">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="javascript:void(0)" class="btn btn-default" data-dismiss="modal">Close</a>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $('.delete-button').click(function() {
        var idKATEGORI = $(this).attr('data-id');
        var category = $(this).attr('data-category');

        $('#category-id-delete').val(idKATEGORI)
        $('#ModalDeleteTitle').html()
        $('#ModalDeleteTitle').html("Apakah Kamu yakin ingin menghapus kategori '<strong>" + category + "</strong>' ?")
    })

    $('.update-button').click(function() {
        var idKATEGORI = $(this).attr('data-id');
        var category = $(this).attr('data-category');

        $('#category-id-update').val(idKATEGORI)
        $('#category-title-update').val(category)
    })
</script>