
<div class="container px-4 px-md-0 py-4 pb-6 pt-3">
    <div class="position-relative ">
        <h5 class="py-2 fw-semibold">Event</h5>
        <hr class="opacity-25">

        <div class="d-flex align-items-center justify-content-center">
            <div class="search-bar bg-white start-25 end-25 bottom-0 top-0 mb-2">
                <div class="input-group shadow rounded-pill border px-4 py-2">
                    <input class="form-control shadow-none border-0 rounded-pill search" type="text" placeholder="Search" id="search-form">
                    <div class="vr" style="margin-top:8px;margin-bottom:8px;margin-right:2px"></div>
                    <span class=" input-group-append">
                        <button class="btn btn-outline-black bg-white  rounded-pill" style type="button">
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
    <div class="row gap-3">
        <div class="col-12 col-lg bg-white row">
            <?php foreach ($event as $item) : ?>
                <div class="col-4 p-3 pb-4">
                    <div class="bg-white" onclick="location.href='<?= base_url('event/detail/' . preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $item['TITLE_ACTIVITY']))) . '?id_activity=' . $item['ID_ACTIVITY'] ?>'" style="cursor: pointer">
                        <div class=" rounded-5 shadow p-3">
                            <div class="d-flex justify-content-center">
                                <img src="<?= $item['IMAGE_ACTIVITY'] ?>" class="rounded-5" style="width: 100%; height: 350px; object-fit: cover; object-position: -50% 0%;">
                            </div>
                            <div class="px-3 py-3">
                                <div class="d-flex flex-row align-items-center gap-2">
                                    <p class="fw-semibold px-3 fs-8 m-0 rounded-5" style="color:white; background-color:<?= ($item['PRICE_ACTIVITY'] == 0) ? "#47DE13" : "#5580E9" ?>">
                                        <?= ($item['PRICE_ACTIVITY'] == 0) ? "FREE" : "PAID" ?>
                                    </p>

                                    <p class="fw-semibold px-3 fs-8 m-0 rounded-5" style="color:white; background-color: red;">
                                        <?= ($item['EXPIRED'] == 1) ? "EXPIRED" : "" ?>
                                    </p>
                                </div>
                                <p class="text-muted m-0 pt-2 pb-2 fs-6"><?= date_format(date_create($item['DATE_START']), 'j F Y') ?></p>
                                <span class="fw-semibold fs-5 mt-2" style="overflow: hidden !important;
                            text-overflow: ellipsis !important;
                            display: -webkit-box !important;
                            -webkit-line-clamp: 1 !important;
                            -webkit-box-orient: vertical !important;"><?= $item['TITLE_ACTIVITY'] ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <hr class="mt-5">
    <div class="px-3 d-grid d-md-flex text-center justify-content-md-between justify-content-center align-items-center">
        <div class="order-2 order-md-1 pt-3 pt-md-0">
            <span class="fs-8 pagination-text">Showing <span class="fw-bold"><?= $page + 1 ?></span> to <span class="fw-bold"><?= ($page > $per_page) ? $total_data : (($per_page >= $total_data) ? $total_data : $per_page); ?></span>
                of
                <span class="fw-bold"><?= $total_data ?></span> entries</span>
        </div>
        <div class="order-1 order-md-2">
            <?= $pagination; ?>
        </div>
    </div>
</div>
<style>
    a {
        text-decoration: none;
    }
</style>
<script>
    document.onkeydown = (e) => {
        if (e.key == 123) {
            e.preventDefault();
        }
        if (e.ctrlKey && e.shiftKey && e.key == 'I') {
            e.preventDefault();
        }
        if (e.ctrlKey && e.shiftKey && e.key == 'C') {
            e.preventDefault();
        }
        if (e.ctrlKey && e.shiftKey && e.key == 'J') {
            e.preventDefault();
        }
        if (e.ctrlKey && e.key == 'U') {
            e.preventDefault();
        }
    };

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
            url: "<?= base_url('event/search') ?>",
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

                // show results if not empty
                if ($('#search-result').html() != "") {
                    $('#search-result').show();
                }
            }
        });
    }
</script>