<!-- Content Wrapper START -->
<div class="main-content">
    <div class="page-header">
        <h2 class="header-title">Update <?= $title; ?></h2>
        <div class="header-sub-title">
            <nav class="breadcrumb breadcrumb-dash">
                <a href="<?= base_url('dashboard') ?>" class="breadcrumb-item"><i class="anticon anticon-home m-r-5"></i>Home</a>
                <a class="breadcrumb-item" href="<?= base_url('manage/activity/course') ?>"><?= $title; ?></a>
                <span class="breadcrumb-item active">Update <?= $title; ?></span>
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
                        <label class="col-sm-2 col-form-label control-label">Cover <span class="text-danger">*</span></label>
                        <div class="col-md-5">
                            <div class="custom-file">
                                <input type="file" name="cover" data-max-file-size="1M" class="custom-file-input dropify" accept=".jpg, .png" data-allowed-file-extensions="jpg png" data-default-file="<?= $event_data['IMAGE_ACTIVITY'] ?>">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label control-label">Title <span class="text-danger">*</span></label>
                        <div class="col-md-5">
                            <input type="text" class="form-control" name="title" placeholder="Title" value="<?= $event_data['TITLE_ACTIVITY'] ?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label control-label">Price <span class="text-danger">*</span></label>
                        <div class="col-md-5">
                            <input type="number" class="form-control CurrencyInput" name="price" value="<?= $event_data['PRICE_ACTIVITY'] ?>" <?= ($event_data['PRICE_ACTIVITY'] == 0) ? "readonly" : "" ?>>
                            <span class="d-flex align-items-center mt-2">
                                <div class="switch m-r-10">
                                    <input type="checkbox" id="setFree">
                                    <label for="setFree"></label>
                                </div>
                                Free
                            </span>
                            <?= ($event_data['PRICE_ACTIVITY'] == 0) ? "<script>$('#setFree').trigger('click')</script>" : "" ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label control-label">Date <span class="text-danger">*</span></label>
                        <div class="col-md-5">
                            <div class="d-flex align-items-center">
                                <input type="datetime-local" class="form-control" name="date_start" placeholder="Date Start" value="<?= $event_data['DATE_START'] ?>">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label control-label">Certificate Code<span class="text-danger">*</span></label>
                        <div class="col-md-5">
                            <input type="text" class="form-control" name="code_sertif" placeholder="Certificate Code" value="<?= $event_data['SERTIF_CODE'] ?>" style="text-transform: uppercase">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label control-label">Kategori <span class="text-danger">*</span></label>
                        <div class="col-md-5">
                            <div class="m-b-15">
                                <select class="select-category" name="category" onchange="zoomLinkCheck(this)">
                                    <option value="0" <?= ($event_data['CATEGORY_EVENT'] == 0) ? "selected" : ""; ?>>Hybrid</option>
                                    <option value="1" <?= ($event_data['CATEGORY_EVENT'] == 1) ? "selected" : ""; ?>>Online</option>
                                    <option value="2" <?= ($event_data['CATEGORY_EVENT'] == 2) ? "selected" : ""; ?>>Offline</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label control-label">Contact Person <span class="text-danger">*</span></label>
                        <div class="col-md-5">
                            <input type="text" class="form-control" name="contact" placeholder="+62 8765234765" value="<?= $event_data['CONTACT_CUSTOMER'] ?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label control-label">Penyelenggara  <span class="text-danger">*</span></label>
                        <div class="col-md-5">
                            <input type="text" class="form-control" name="organizer" placeholder="Penyelenggara" value="<?= $event_data['ORGANIZER'] ?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label control-label">Location  <span class="text-danger">*</span></label>
                        <div class="col-md-5">
                            <input type="text" class="form-control" name="location" placeholder="location" value="<?= $event_data['LOCATION'] ?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label control-label">Link Zoom</label>
                        <div class="col-md-5">
                            <input type="text" class="form-control" name="link" value="<?= $event_data['LINK_ZOOM'] ?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label control-label">Deskripsi Event</label>
                        <div class="col-md-5">
                            <textarea name="desc" id="editor">
                                <?= $event_data['DESKRIPSI_EVENT'] ?>
                            </textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label control-label">Status </label>
                        <div class="col-md-5 column">
                            <div class="switch m-r-10">
                                <input type="checkbox" id="switch-1" name="status" <?= ($event_data['STATUS'] == 1) ? "checked" : ""; ?>>
                                <label for="switch-1"></label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group text-right mt-5">
                        <button class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Content Wrapper END -->
<script>
    CKEDITOR.replace('desc');
    $('.select-category').select2();

    $('.datepicker-input').datepicker();

    $('select[name=category] option').filter(':selected').trigger('change')
    function zoomLinkCheck(e){
        if ($(e).val() == 2) {
            $('input[name="link"]').prop('disabled', true);
            $('input:text[name="link"]').val('')
        }else{
            $('input[name="link"]').prop('disabled', false);
        }
    }

    $("#form-validation").validate({
        ignore: ':hidden:not(:checkbox)',
        errorElement: 'label',
        errorClass: 'is-invalid',
        validClass: 'is-valid',
        rules: {
            title: {
                required: true
            },
            date_start: {
                required: true
            },
            price: {
                required: true
            },
            code_sertif: {
                required: true
            },
            location: {
                required: true
            },
            desc: {
                required: true
            },
            contact: {
                required: true
            },
            organizer: {
                required: true
            },
            desc: {
                required: true
            }
        },
        messages: {
            date_start: {
                required: ''
            },
            date_end: {
                required: ''
            }
        }
    });

    $('#setFree').change(function() {
        if ($(this).prop('checked')) {
            $('.CurrencyInput').prop('readonly', true)
            $('.CurrencyInput').val(0)
        } else {
            $('.CurrencyInput').prop('readonly', false)
            $('.CurrencyInput').val('<?= $event_data['PRICE_ACTIVITY'] ?>')
        }
    })

    $.validator.addMethod("notOnlyZero", function(value, element, param) {
        return this.optional(element) || parseInt(value) > 0;
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
</script>