<div class="card" id="materi_item_<?= $no; ?>">
    <div class="card-header">
        <h5 class="card-title d-flex align-items-center row">
            <a data-toggle="collapse" href="#collapse<?= $no; ?>" class="col-md-12">
                <span class="col-md-11">Detail - Materi</span>
                <input type="hidden" class="form-control" name="order_list[]" value="<?= $no; ?>" required>
                <input type="hidden" class="form-control" name="type[]" value="1" required>
                <div id="delete_materi_<?= $no; ?>" class="btn btn-danger px-1 py-0 float-right" style="cursor: pointer;">
                    <i class="anticon anticon-loading"></i>
                    <span><i class="anticon anticon-close"></i> </span>
                </div>
            </a>
        </h5>
    </div>
    <div id="collapse<?= $no; ?>" class="collapse show" data-parent="#accordion-default">
        <div class="card-body">
            <div class="form-group row">
                <label class="col-sm-2 col-form-label control-label">File Materi</label>
                <div class="col-md-5">
                    <div class="custom-file">
                        <input type="file" name="materi_file[]" accept=".pdf" data-allowed-file-extensions="pdf" class="custom-file-input file_materi" required required>
                    </div>
                </div> 
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label control-label" required>Nama Materi</label>
                <div class="col-md-5">
                    <input type="text" class="form-control" name="materi_title[]" required>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label control-label">Link Youtube</label>
                <div class="col-md-5">
                    <input type="text" class="form-control" name="materi_link[]" required>
                    <span class="text-danger">* Upload link video in google drive and submit the link in this field. Example link must contain d/your_id_video like this https://drive.google.com/file/d/1fTx7Ij-ora0xIFAWU0Gz4Ej8kJZh1tgs/view?usp=sharing</span>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label control-label">Deskripsi Materi</label>
                <div class="col-md-5">
                    <textarea name="desc_materi[]" id="mytextarea_<?= $no; ?>" required></textarea>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var textarea = document.getElementById('mytextarea_<?= $no; ?>');
    CKEDITOR.replace(textarea);
    $(document).ready(function() {
        $('.file_materi').dropify({
            messages: {
                default: 'Drag atau drop untuk memilih gambar',
                replace: 'Ganti',
                remove: 'Hapus',
                error: 'error'
            }
        });
    });

    $('#collapse<?= $no; ?>').collapse('hide')

    $('#delete_materi_<?= $no; ?>').click(function(e) {
        $(this).toggleClass("is-loading");
        $.ajax({
            url: '<?= base_url('admin_controller/CourseController/remove_course_materi/') ?>' + <?= $no; ?>,
            success: function() {
                $("#delete_materi_<?= $no; ?>").removeClass("is-loading")
                $("#materi_item_<?= $no; ?>").remove();
                i--;
            }
        });
        e.preventDefault();
    });
</script>