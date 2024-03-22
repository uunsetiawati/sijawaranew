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
        <a class="btn btn-success btn-sm float-right" href="<?= base_url('manage/activity/course/add') ?>"><i class="anticon anticon-plus-square"></i> Add <?= $title; ?></a>
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
                            <th>Nama <?= $title; ?></th>
                            <th>Status</th>
                            <th>Price <?= $title; ?></th>
                            <th>Date Start</th>
                            <th>Date End</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 0;
                        foreach ($course as $item) {
                            $no++;
                        ?>
                            <tr>
                                <td><?= $no; ?></td>
                                <td><?= word_limiter($item['TITLE_ACTIVITY'], 3, " ..."); ?></td>
                                <td><?= ($item['STATUS'] == 1) ? '<span class="badge badge-pill badge-success">Enable</span>' : '<span class="badge badge-pill badge-danger">Disable</span>'; ?></td>
                                <td><?= ($item['PRICE_ACTIVITY'] == 0) ? '<span class="badge badge-pill badge-success">Free</span>' : "Rp " . number_format($item['PRICE_ACTIVITY'], 0, ",", "."); ?></td>
                                <td><?= date_format(date_create($item['DATE_START']), 'j F Y H:i:s') ?></td>
                                <td><?= date_format(date_create($item['DATE_END']), 'j F Y H:i:s') ?></td>
                                <td>
                                    <div class="row">
                                        <div class="d-flex justify-content-center">
                                            <a class="btn btn-success btn-sm col-md-5 ml-1" href="<?= base_url('manage/activity/course/update/' . $item['ID_ACTIVITY']) ?>">
                                                <i class="anticon anticon-edit"></i>
                                                edit
                                            </a>
                                            <a class="btn btn-danger btn-sm col-md-6 ml-1 delete-button" data-judul="<?= $item['TITLE_ACTIVITY'] ?>" data-id="<?= $item['ID_ACTIVITY'] ?>" href="javascript.void(0)" data-toggle="modal" data-target="#exampleModalCenter">
                                                <i class="anticon anticon-delete"></i>
                                                delete
                                            </a>
                                        </div>
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
<div class="modal fade" id="exampleModalCenter">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Delete <?= $title; ?></h5>
                <button type="button" class="close" data-dismiss="modal">
                    <i class="anticon anticon-close"></i>
                </button>
            </div>
            <div class="modal-body" id="ModalDeleteTitle">
            </div>
            <div class="modal-footer">
                <a type="button" class="btn btn-default" data-dismiss="modal">Close</a>
                <a href="" class="btn btn-danger" id="modalDelete">Delete</a>
            </div>
        </div>
    </div>
</div>
<script>
    $('.delete-button').click(function() {
        var id_course = $(this).attr('data-id');
        var title_course = $(this).attr('data-judul');

        $('#modalDelete').attr('href', "course/delete/" + id_course);
        document.getElementById("ModalDeleteTitle").innerHTML = "Apakah Kamu yakin ingin menghapus course dengan nama course '<strong>" + title_course + "</strong>' ?";
    })
</script>