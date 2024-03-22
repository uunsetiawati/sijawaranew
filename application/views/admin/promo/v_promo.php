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
        <button type="button" class="btn btn-success btn-sm float-right" data-toggle="modal" data-target="#InsertModalCenter"><i class="anticon anticon-plus-square"></i> Add Promo</button>
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
                            <th>Name</th>
                            <th>Discount</th>
                            <th>Expired Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 0;
                        foreach ($promo as $item) {
                            $no++;
                        ?>
                            <tr>
                                <td><?= $no; ?></td>
                                <td><?= $item['PROMO_NAME']; ?></td>
                                <td><?= $item['AMMOUNT']; ?></td>
                                <td><?= $item['EXP_DATE']; ?></td>
                                </td>
                                <td>
                                    <div class="row">
                                        <a class="btn btn-success btn-sm col-md-5 mx-1 update-button" data-promo="<?= $item['PROMO_NAME'] ?>" data-ammount="<?= $item['AMMOUNT'] ?>" data-exp="<?= $item['EXP_DATE'] ?>" data-id="<?= $item['ID_PROMO'] ?>" href="javascript:void(0)" data-toggle="modal" data-target="#EditModalCenter"><i class="anticon anticon-edit"></i> edit</a>
                                        <a class="btn btn-danger btn-sm col-md-6 mx-1 delete-button" data-promo="<?= $item['PROMO_NAME'] ?>" data-id="<?= $item['ID_PROMO'] ?>" href="javascript:void(0)" data-toggle="modal" data-target="#DeleteModalCenter"><i class="anticon anticon-delete"></i> delete</a>
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
            <form action="<?= base_url('manage/promo/add') ?>" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label control-label">Promo Name</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" name="promo-title" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label control-label">Ammount(%)</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" name="promo-ammount" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label control-label">Date Expired</label>
                        <div class="col-md-9">
                            <input type="datetime-local" class="form-control" name="promo-exp" required>
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
            <form action="<?= base_url('manage/promo/update') ?>" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label control-label">Promo Name</label>
                        <div class="col-md-9">
                            <input type="hidden" class="form-control" name="promo-id" id="promo-id-update">
                            <input type="text" class="form-control" name="promo-title" id="promo-title-update">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label control-label">Ammount(%)</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" name="promo-ammount" id="promo-ammount-update">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label control-label">Date Expired</label>
                        <div class="col-md-9">
                            <input type="datetime-local" class="form-control" name="promo-exp" id="promo-exp-update">
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
            <form action="<?= base_url('manage/promo/delete') ?>" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group row">
                        <div class="col-md-12">
                        <h6 id="ModalDeleteTitle"></h6>
                            <input type="hidden" class="form-control" name="promo-id" id="promo-id-delete">
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
        var idPROMO = $(this).attr('data-id');
        var promo_name = $(this).attr('data-promo');

        $('#promo-id-delete').val(idPROMO)
        $('#ModalDeleteTitle').html()
        $('#ModalDeleteTitle').html("Apakah Kamu yakin ingin menghapus kategori '<strong>" + promo_name + "</strong>' ?")
    })

    $('.update-button').click(function() {
        var idPROMO = $(this).attr('data-id');
        var promo_name = $(this).attr('data-promo');
        var promo_amm = $(this).attr('data-ammount');
        var promo_exp = $(this).attr('data-exp');

        $('#promo-id-update').val(idPROMO)
        $('#promo-title-update').val(promo_name)
        $('#promo-ammount-update').val(promo_amm)
        $('#promo-exp-update').val(promo_exp)
    })
</script>