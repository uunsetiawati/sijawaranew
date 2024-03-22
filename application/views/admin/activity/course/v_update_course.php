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
                <div class="notification-toast top-right" id="notification-toast"></div>
                <form id="form-course" action="" method="POST" enctype="multipart/form-data">
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label control-label">Cover</label>
                        <div class="col-md-5">
                            <div class="custom-file">
                                <input type="file" name="course_cover" data-max-file-size="1M" class="custom-file-input dropify" accept=".jpg, .png" data-allowed-file-extensions="jpg png" data-default-file="<?= $course_data['IMAGE_ACTIVITY'] ?>">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label control-label">Title Course</label>
                        <div class="col-md-5">
                            <input type="text" class="form-control" name="title" placeholder="Title Course" value="<?= $course_data['TITLE_ACTIVITY'] ?>" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label control-label">Price Course</label>
                        <div class="col-md-5">
                            <input type="number" class="form-control CurrencyInput" name="price" value="<?= $course_data['PRICE_ACTIVITY'] ?>" <?= ($course_data['PRICE_ACTIVITY'] == 0) ? "readonly" : "" ?>>
                            <span class="d-flex align-items-center mt-2">
                                <div class="switch m-r-10">
                                    <input type="checkbox" id="setFree">
                                    <label for="setFree"></label>
                                </div>
                                Free
                            </span>
                            <?= ($course_data['PRICE_ACTIVITY'] == 0) ? "<script>$('#setFree').trigger('click')</script>" : "" ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label control-label">Date Course</label>
                        <div class="col-md-5">
                            <div class="d-flex align-items-center">
                                <input type="datetime-local" class="form-control" name="date_start" placeholder="Date Start" value="<?= $course_data['DATE_START'] ?>" required>
                                <span class="p-h-10">to</span>
                                <input type="datetime-local" class="form-control" name="date_end" placeholder="Date End" value="<?= $course_data['DATE_END'] ?>" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label control-label">Announcement</label>
                        <div class="col-md-5">
                            <textarea name="announcement" id="editor">
                                <?= $course_data['PENGUMUMAN'] ?>
                            </textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label control-label">Description Course</label>
                        <div class="col-md-5">
                            <textarea name="desc" id="editor" rows=11 cols=50 maxlength=250 required>
                                <?= $course_data['DESKRIPSI_COURSE'] ?>
                            </textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label control-label">What to Learn ?</label>
                        <div class="col-md-5">
                            <textarea name="desc_item" id="editor" rows=11 cols=50 maxlength=250 required>
                                <?= $course_data['DESKRIPSI_COURSE_ITEM'] ?>
                            </textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label control-label">Certificate Code<span class="text-danger">*</span></label>
                        <div class="col-md-5">
                            <input type="text" class="form-control" name="code_sertif" placeholder="Certificate Code" value="<?= $course_data['SERTIF_CODE'] ?>" style="text-transform: uppercase" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label control-label">Category</label>
                        <div class="col-md-5">
                            <select class="select2" name="category" required>
                                <?php foreach ($kategori as $item_kategori) : ?>
                                    <option value="<?= $item_kategori['ID_KATEGORI'] ?>" <?= ($item_kategori['KATEGORI'] == $course_data['KATEGORI']) ? "selected" : "" ?>><?= $item_kategori['KATEGORI'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label control-label">Status</label>
                        <div class="col-md-5 column">
                            <div class="switch m-r-10">
                                <input type="checkbox" id="switch-1" name="status" <?= ($course_data['STATUS'] == 1) ? "checked" : ""; ?>>
                                <label for="switch-1"></label>
                            </div>
                        </div>
                    </div>
                    <div class="accordion materi_form" id="accordion-default">
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                            <div data-toggle="modal" id="add_item" data-target="#exampleModalCenter" class="btn btn-primary m-r-5 col-md-12" style="cursor: pointer;">
                                <i class="anticon anticon-loading m-r-5"></i>
                                <span class="col-md-12">Add Materi / Quiz</span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group text-right mt-5">
                        <button type="submit" class="btn btn-primary btn-submit-form">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Modal  -->
<div class="modal fade" id="exampleModalCenter">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Add Materi or Quiz ?</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <i class="anticon anticon-close"></i>
                </button>
            </div>
            <div class="modal-body row">
                <div class="col-md-12 text-center d-flex justify-content-around">
                    <a href="javascript.void(0)" id="add_materi" data-dismiss="modal" class="btn btn-success col-md-5 py-5 h-100">
                        <h1><i class="anticon anticon-book text-white"></i></h1> MATERI
                    </a>
                    <a href="javascript.void(0)" id="add_quiz" data-dismiss="modal" class="btn btn-danger col-md-5 py-5 h-100">
                        <h1><i class="anticon anticon-trophy text-white"></i></h1> QUIZ
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Content Wrapper END -->
<script>
    var i = 1;
    var limit = 0;
    CKEDITOR.replace('announcement');
    CKEDITOR.replace('desc');
    CKEDITOR.replace('desc_item');

    $('#add_item').click(function() {
        if (limit == 0) {
            $('#add_quiz').hide()
        } else {
            $('#add_quiz').show()
        }
    })

    $('#setFree').change(function() {
        if ($(this).prop('checked')) {
            $('.CurrencyInput').prop('readonly', true)
            $('.CurrencyInput').val(0)
        } else {
            $('.CurrencyInput').prop('readonly', false)
            $('.CurrencyInput').val('<?= $course_data['PRICE_ACTIVITY'] ?>')
        }
    })

    $('.datepicker-input').datepicker();

    $(document).ready(function() {
        $('.dropify').dropify({
            messages: {
                default: 'Drag or Drop to Choose Image',
                replace: 'Change',
                remove: 'Delete',
                error: 'Error'
            },
            error: {
                'fileSize': 'The file size is too big (1MB max).'
            }
        });
    });

    $('#add_materi').click(function(e) {
        $("#add_item").toggleClass("is-loading");
        $.ajax({
            url: '<?= base_url('admin_controller/CourseController/add_course_materi/') ?>' + i,
            success: function(html) {
                $(".materi_form").append(html);
                $("#add_item").removeClass("is-loading");
                i++;
                limit++;
            }
        });
        e.preventDefault();
    });

    $('#add_quiz').click(function(e) {
        $("#add_item").toggleClass("is-loading");
        $.ajax({
            url: '<?= base_url('admin_controller/CourseController/add_course_quiz/') ?>' + i,
            success: function(html) {
                $(".materi_form").append(html);
                $("#add_item").removeClass("is-loading");
                i++;
                limit++;
            }

        });
        e.preventDefault();
    });

    $.ajax({
        url: '<?= base_url('admin_controller/CourseController/get_course_item?ID_COURSE=' . $course_data['ID_COURSE'] . '&ID_MATERI=') ?>' + i,
        type: "GET",
        beforeSend: function() {
            $('#add_item').toggleClass("is-loading");
        },
        success: function(html) {
            $("#add_item").removeClass("is-loading");
            $(".materi_form").append(html);
            i += <?= count($course_item) ?>;
            limit = i;
        }
    });

    $('#form-course').on('submit', function(e) {
        if (i > 1) {
            e.submit()
        } else {
            const Toast = Swal.mixin({
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.onmouseenter = Swal.stopTimer;
                    toast.onmouseleave = Swal.resumeTimer;
                }
            });
            Toast.fire({
                icon: "error",
                title: "add item course at least one item."
            });
            e.preventDefault()
        }
    })
</script>