<div class="container px-4 px-md-0 py-4 pb-6 pt-3">
    <div class="position-relative ">
        <h5 class="py-2 fw-semibold">Course</h5>
        <hr class="opacity-25">

        <div class="d-flex align-items-center justify-content-center">
            <div class="search-bar bg-white start-25 end-25 bottom-0 top-0 mb-2">
                <div class="input-group shadow rounded-pill border px-4 py-2">
                    <input class="form-control shadow-none border-0 rounded-pill search" type="text" placeholder="Search" id="search-form">
                    <div class="vr" style="margin-top:8px;margin-bottom:8px;margin-right:2px"></div>
                    <span class=" input-group-append">
                        <button class="btn btn-outline-black bg-white rounded-pill" style type="button">
                            <i class="bi bi-search"></i>
                        </button>
                    </span>
                </div>
                <div class="dropdown mt-2">
                    <div id="search-result" class="col-12 dropdown-menu rounded-2 custom-scrollbar-js dropdown-primary" style="height: 512px; overflow-y:scroll;">
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="row project-tab mt-4">
        <div class="col-md-12">
            <nav class="tabbable">
                <div class="nav nav-tabs" id="nav-tab" role="tablist" style="--bs-nav-tabs-border-width: 0px;">
                    <button class="nav-link border-0 col col-lg-2 fs-5" data-value="" id="nav-all" onclick="ChangeNav(this)">All</button>
                    <?php foreach ($kategori as $item_kategori) : ?>
                        <button class="nav-link border-0 col col-lg-2 fs-5" data-value="<?= $item_kategori['ID_KATEGORI'] ?>" id="nav-<?= $item_kategori['ID_KATEGORI'] ?>" onclick="ChangeNav(this)"><?= $item_kategori['KATEGORI'] ?></button>
                    <?php endforeach; ?>
                </div>
            </nav>
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show pt-4 active show" id="nav-content" role="tabpanel" aria-labelledby="nav-content-tab" tabindex="0">
                    <div class="row" id="nav-content-item">
                        <div class="text-center">No Course</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $('#search-form').focusout(function() {
        $('#search-result').hide()
    })

    $('#search-form').keyup(function(e) {
        if (e.which == 13) {
            $('#search-result').html("");
            getData($(this).val())
        }
    });

    function getData(key) {
        $.ajax({
            url: "<?= base_url('course/search') ?>",
            method: 'GET',
            data: {
                keyword: key
            },
            success: function(result) {
                if (result != "") {
                    $('#search-result').append(result)
                } else {
                    $('#search-result').append(" <a class='dropdown-item'>No matching records found</a>")
                }

                if ($('#search-result').html() != "") {
                    $('#search-result').show();
                }
            }
        });
    }

    $("#nav-all").trigger('click')

    function ChangeNav(e) {
        $("#nav-all").removeClass("active")
        <?php foreach ($kategori as $item_kategori) : ?>
            $("#nav-<?= $item_kategori['ID_KATEGORI'] ?>").removeClass("active")
        <?php endforeach; ?>
        $(e).addClass("active")
        GetCourse($(e).data('value'))
    }

    function GetCourse(category) {
        $('#nav-content-item').html(`<div class="col-12 col-lg-12 px-3 py-3 py-lg-0 pb-lg-3 d-flex justify-content-center">
        <div class=" rounded-5 p-3 pb-4 h-auto d-flex flex-column">
            <div class="d-flex justify-content-center">
                <img src="<?= base_url() ?>/assets/images/loading-2.svg" alt="Loader.gif" style="max-width: 50%;"/>
            </div>
        </div>
    </div>`)
        $.ajax({
            url: "<?= base_url('course/category') ?>",
            method: 'POST',
            data: {
                category: category
            },
            success: function(result) {
                $('#nav-content-item').html()
                $('#nav-content-item').html(result)
            }
        });
    }
</script>