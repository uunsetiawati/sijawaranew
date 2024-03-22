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
                            <th>Nama User</th>
                            <th>University</th>
                            <th>Study</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 0;
                        foreach ($instructor as $item) {
                            $no++;
                        ?>
                            <tr>
                                <td><?= $no; ?></td>
                                <td><?= $item['NAME']; ?></td>
                                <td><?= $item['UNIV']; ?></td>
                                <td><?= $item['DEGREE'] . ' - ' . $item['STUDY']; ?></td>
                                <?php if ($item['STATUS'] == 0) { ?>
                                    <td><span class="badge badge-warning text-dark">Need Verify</span></td>
                                <?php } else if ($item['STATUS'] == 1) { ?>
                                    <td><span class="badge badge-success">Instructor</span></td>
                                <?php } else { ?>
                                    <td><span class="badge badge-danger">Rejected</span></td>
                                <?php } ?>
                                <td>
                                    <div class="row">
                                        <button type="button" class="btn btn-info btn-sm col-md-5 mx-1 btn-detail-<?= $no; ?>">Detail</button>
                                        <script>
                                            $('.btn-detail-' + <?= $no; ?>).on('click', function() {
                                                var item = <?= json_encode($item) ?>;
                                                OpenModal(item);
                                            });
                                        </script>
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
<div class="modal fade" id="ModalDetailIns">
    <div class="modal-dialog modal-xl modal-dialog-scrollable modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalDetailInsTitle">Instructor Request Detail</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <i class="anticon anticon-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table">
                        <tbody>
                            <tr>
                                <th scope="row">NAME</th>
                                <td colspan="2" id="NAME">Larry the Bird</td>
                            </tr>
                            <tr>
                                <th scope="row">UNIV</th>
                                <td colspan="2" id="UNIV">Larry the Bird</td>
                            </tr>
                            <tr>
                                <th scope="row">NIM</th>
                                <td colspan="2" id="NIM">Larry the Bird</td>
                            </tr>
                            <tr>
                                <th scope="row">STUDY</th>
                                <td colspan="2" id="STUDY">Larry the Bird</td>
                            </tr>
                            <tr>
                                <th scope="row">DEGREE</th>
                                <td colspan="2" id="DEGREE">Larry the Bird</td>
                            </tr>
                            <tr class="col-semester">
                                <th scope="row">SEMESTER</th>
                                <td colspan="2" id="SEMESTER">Larry the Bird</td>
                            </tr>
                            <tr>
                                <th scope="row">GRADUATED</th>
                                <td colspan="2" id="IS_GRADUATED">Larry the Bird</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="card">
                    <div class="card-body ">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <strong>CV Document</strong>
                                    <hr>
                                    <div id="doc_cv" class="row"></div>
                                </div>
                                <div class="mb-3">
                                    <hr>
                                    <strong>Portofolio Document</strong>
                                    <hr>
                                    <div id="doc_porto" class="row"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <strong>Certificate Document</strong>
                                    <hr>
                                    <div id="doc_cert" class="row"></div>
                                </div>
                                <div class="mb-3">
                                    <hr>
                                    <strong>Recomendation Letter Document</strong>
                                    <hr>
                                    <div id="doc_letter" class="row"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <form action="<?= base_url('manage/instructor/verify') ?>" method="post" id="formVerify">
                    <input type="hidden" name="id_user" id="id_user" required>
                    <input type="hidden" name="type" id="type" required>
                </form>
                <button type="button" class="btn btn-danger btn-reject">Reject</button>
                <button type="button" class="btn btn-success btn-accept">Accept</button>
            </div>
        </div>
    </div>
</div>
<script>
    function OpenModal(data) {
        resetDoc()
        $('#NAME').html(': ' + data.NAME)
        $('#UNIV').html(': ' + data.UNIV)
        $('#NIM').html(': ' + data.NIM)
        $('#STUDY').html(': ' + data.STUDY)
        $('#DEGREE').html(': ' + data.DEGREE)
        $('#SEMESTER').html(': ' + data.SEMESTER)
        $('#IS_GRADUATED').html(': ' + (data.IS_GRADUATED == 1 ? '<span class="badge badge-success">Yes</span>' : '<span class="badge badge-danger">No</span>'))

        $('#doc_cv').html(`
            <object style="width: 100%; height: 309px;" id="" data='` + data.CV + `'>
                Error: Embedded data could not be displayed in mobile mode change it to dekstop mode to show the file.
            </object>
        `)
        $('#doc_porto').html(`
            <object style="width: 100%; height: 309px;" id="" data='` + data.PORTOFOLIO + `'>
                Error: Embedded data could not be displayed in mobile mode change it to dekstop mode to show the file.
            </object>
        `)

        var cert = data.SERTIFIKAT.split(';')
        cert.forEach(function(item) {
            $('#doc_cert').append(`
                <div class="col-md-4">
                    <object style="width: 100%; height: 309px;" data='` + item + `'>
                        Error: Embedded data could not be displayed in mobile mode change it to dekstop mode to show the file.
                    </object>
                </div>
            `)
        })

        $('#doc_letter').html(`
            <object style="width: 100%; height: 309px;" id="" data='` + data.SURAT_RECOM + `'>
                Error: Embedded data could not be displayed in mobile mode change it to dekstop mode to show the file.
            </object>
        `)

        if (data.IS_GRADUATED == 1) {
            $('.col-semester').toggleClass('d-none')
        }

        $('.btn-reject').click(function() {
            $('#id_user').val(data.ID_USER)
            $('#type').val(2)
            $('#formVerify').submit()
        })

        $('.btn-accept').click(function() {
            $('#id_user').val(data.ID_USER)
            $('#type').val(1)
            $('#formVerify').submit()
        })

        $('#ModalDetailIns').modal('show')
    }

    function resetDoc() {
        $('#doc_cv').html('')
        $('#doc_porto').html('')
        $('#doc_cert').html('')
        $('#doc_letter').html('')
    }
</script>