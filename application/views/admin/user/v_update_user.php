<!-- Content Wrapper START -->
<div class="main-content">
    <div class="page-header">
        <h2 class="header-title">Update User</h2>
        <div class="header-sub-title">
            <nav class="breadcrumb breadcrumb-dash">
                <a href="<?= base_url('dashboard') ?>" class="breadcrumb-item"><i class="anticon anticon-home m-r-5"></i>Home</a>
                <a class="breadcrumb-item" href="<?= base_url('manage/user') ?>">User</a>
                <span class="breadcrumb-item active">Update User</span>
            </nav>
        </div>
    </div>
    <?php if (!empty(validation_errors())) { ?>
        <div class="alert alert-warning">
            <div class="d-flex align-items-center justify-content-start">
                <span class="alert-icon">
                    <i class="anticon anticon-exclamation-o"></i>
                </span>
                <span><?= validation_errors(); ?></span>
            </div>
        </div>
    <?php } ?>
    <div class="card">
        <div class="card-body">
            <div class="m-t-25">
                <form id="form-validation" action="" method="POST" enctype="multipart/form-data">
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label control-label">Foto Profile</label>
                        <div class="col-md-5">
                            <div class="custom-file">
                                <input type="file" name="foto_profile" class="custom-file-input dropify" data-default-file="<?= $user_data['FOTO_PROFILE'] ?>">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label control-label">Nama Lengkap</label>
                        <div class="col-md-5">
                            <input type="text" class="form-control" name="name" placeholder="Name User" value="<?= $user_data['NAME'] ?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label control-label">Jenis Kelamin</label>
                        <div class="col-md-5">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="jk" id="inlineRadio1" value="Laki-Laki" <?= strtolower($user_data['JK']) === 'laki-laki' ? "checked" : ""; ?>>
                                <label class="form-check-label" for="inlineRadio1">Laki-laki</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="jk" id="inlineRadio2" value="Perempuan" <?= strtolower($user_data['JK']) == 'perempuan' ? "checked" : ""; ?>>
                                <label class="form-check-label" for="inlineRadio2">Perempuan</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label control-label">Email</label>
                        <div class="col-md-5">
                            <input type="text" class="form-control" name="email" placeholder="Email" value="<?= $user_data['EMAIL'] ?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label control-label">Nomor HP</label>
                        <div class="col-md-5">
                            <input type="text" class="form-control" name="no_hp" placeholder="Nomor HP" value="<?= $user_data['TELP'] ?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label control-label">Password</label>
                        <div class="col-md-5">
                            <input type="password" class="form-control" id="registerPassword1" placeholder="Buat Password" name="password" aria-describedby="passwordHelp">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label control-label">CV</label>
                        <div class="col-md-5">
                            <div class="custom-file">
                                <input type="file" name="cv" class="custom-file-input dropify" data-default-file="<?= (!empty($user_data['CV']) ? $user_data['CV'] : '') ?>">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label control-label">PORTOFOLIO</label>
                        <div class="col-md-5">
                            <div class="custom-file">
                                <input type="file" name="portofolio" class="custom-file-input dropify" data-default-file="<?= (!empty($user_data['PORTOFOLIO']) ? $user_data['PORTOFOLIO'] : '') ?>">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label control-label">SERTIFIKAT</label>
                        <div class="col-md-5">
                            <div class="custom-file">
                                <input type="file" name="sertifikat" class="custom-file-input dropify" data-default-file="<?= (!empty($user_data['SERTIFIKAT']) ? $user_data['SERTIFIKAT'] : '') ?>">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label control-label">SURAT REKOMENDASI</label>
                        <div class="col-md-5">
                            <div class="custom-file">
                                <input type="file" name="surat_recom" class="custom-file-input dropify" data-default-file="<?= (!empty($user_data['SURAT_RECOM']) ? $user_data['SURAT_RECOM'] : '') ?>">
                            </div>
                        </div>
                    </div>
                    <div class="form-group text-right">
                        <button class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Content Wrapper END -->
<script>
    $("#form-validation").validate({
        ignore: ':hidden:not(:checkbox)',
        errorElement: 'label',
        errorClass: 'is-invalid',
        validClass: 'is-valid',
        rules: {
            name: {
                required: true
            },
            jk: {
                required: true
            },
            email: {
                required: true
            },
            no_hp: {
                required: true
            }
        },
        messages: {
            email: {
                required: ''
            },
            password: {
                required: ''
            },
            no_hp: {
                notOnlyZero: 'This field should be filled more than 0'
            }
        }
    });

    $.validator.addMethod("notOnlyZero", function(value, element, param) {
        return this.optional(element) || parseInt(value) > 0;
    });

    $(document).ready(function() {
        $('.dropify').dropify({
            messages: {
                default: 'Drag atau drop untuk memilih file',
                replace: 'Ganti',
                remove: 'Hapus',
                error: 'error'
            }
        });
    });
</script>