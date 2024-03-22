<!-- Content Wrapper START -->
<div class="main-content">
    <div class="page-header">
        <h2 class="header-title">Add Book</h2>
        <div class="header-sub-title">
            <nav class="breadcrumb breadcrumb-dash">
                <a href="<?= base_url('dashboard') ?>" class="breadcrumb-item"><i class="anticon anticon-home m-r-5"></i>Home</a>
                <a class="breadcrumb-item" href="<?= base_url('manage/ebook') ?>">Ebook</a>
                <span class="breadcrumb-item active">Add Book</span>
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
                        <label class="col-sm-2 col-form-label control-label">Cover</label>
                        <div class="col-md-5">
                            <div class="custom-file">
                                <input type="file" name="cover" accept=".jpg, .png" data-max-file-size="1M" data-allowed-file-extensions="jpg png" class="custom-file-input dropify" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label control-label">Judul Buku</label>
                        <div class="col-md-5">
                            <input type="text" class="form-control" name="judul" placeholder="Judul Buku">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label control-label">Price <?= $title; ?></label>
                        <div class="col-md-5">
                            <input type="text" class="form-control CurrencyInput" name="price" value="0">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label control-label">Genre</label>
                        <div class="col-md-5">
                            <input type="text" class="form-control" name="genre" placeholder="Genre">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label control-label">Author</label>
                        <div class="col-md-5">
                            <input type="text" class="form-control" name="author" placeholder="Author">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label control-label">Tahun</label>
                        <div class="col-md-5">
                            <input type="text" class="form-control" name="tahun" placeholder="Tahun Buku">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label control-label">Link Ebook Flipbook</label>
                        <div class="col-md-5">
                            <input type="text" class="form-control" name="link" placeholder="Link Buku">
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
            price: {
                required: true
            },
            genre: {
                required: true
            },
            author: {
                required: true
            },
            tahun: {
                required: true
            },
            link: {
                required: true
            }
        },
        messages: {
            price: {
                notOnlyZero: 'This field should be filled more than 0'
            },
            tahun: {
                notOnlyZero: 'This field should be filled more than 0'
            }
        }
    });

    $(document).ready(function() {
        $('.dropify').dropify({
            messages: {
                default: 'Drag atau drop untuk memilih gambar',
                replace: 'Ganti',
                remove: 'Hapus',
                error: 'error'
            },
            error: {
                'fileSize': 'The file size is too big (1MB max).'
            }
        });
    });

    $.validator.addMethod("notOnlyZero", function(value, element, param) {
        return this.optional(element) || parseInt(value) > 0;
    });
</script>