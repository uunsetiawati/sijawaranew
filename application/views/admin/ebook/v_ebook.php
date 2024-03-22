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
        <a class="btn btn-success btn-sm float-right" href="<?= base_url('manage/ebook/add') ?>"><i class="anticon anticon-plus-square"></i> Add Book</a>
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
                            <th>Judul</th>
                            <th>Harga</th>
                            <th>Genre</th>
                            <th>Author</th>
                            <th>Tahun</th>
                            <th hidden>Link</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 0;
                        foreach ($ebook as $item) {
                            $no++;
                        ?>
                            <tr>
                                <td><?= $no; ?></td>
                                <td><?= $item['JUDUL']; ?></td>
                                <td><?= ($item['PRICE'] == 0) ? '<span class="badge badge-pill badge-success">Free</span>' : $item['PRICE']; ?></td>
                                <td><?= $item['GENRE']; ?></td>
                                <td><?= $item['AUTHOR']; ?></td>
                                <td><?= $item['TAHUN']; ?></td>
                                <td hidden><?= $item['LINK_EBOOK']; ?></td>
                                </td>
                                <td>
                                    <div class="row">
                                        <a class="btn btn-success btn-sm col-md-5 mx-1" href="<?= base_url('manage/ebook/update/' . $item['ID_BUKU']) ?>"><i class="anticon anticon-edit"></i> edit</a>
                                        <a class="btn btn-danger btn-sm col-md-6 mx-1 delete-button" data-judul="<?= $item['JUDUL'] ?>" data-id="<?= $item['ID_BUKU'] ?>" href="javascript.void(0)" data-toggle="modal" data-target="#exampleModalCenter"><i class="anticon anticon-delete"></i> delete</a>
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

<div class="modal fade" id="mdlPreview">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Preview <?= $title; ?></h5>
                <button type="button" class="close" data-dismiss="modal">
                    <i class="anticon anticon-close"></i>
                </button>
            </div>
            <div class="modal-body" id="ModalPrev">
            </div>
            <div class="modal-footer">
                <a type="button" class="btn btn-default" data-dismiss="modal">Close</a>
            </div>
        </div>
    </div>
</div>

<script>
    $('.delete-button').click(function() {
        var id_buku = $(this).attr('data-id');
        var judul_buku = $(this).attr('data-judul'); -

        $('#modalDelete').attr('href', "ebook/delete/" + id_buku);
        document.getElementById("ModalDeleteTitle").innerHTML = "Apakah Kamu yakin ingin menghapus ebook dengan judul '<strong>" + judul_buku + "</strong>' ?";
    })
    
    $('.preview-button').click(function() {
        var id_buku = $(this).attr('data-id');
        var judul_buku = $(this).attr('data-judul');
        
        document.getElementById("ModalPrev").innerHTML = isi_buku;
    })
</script>