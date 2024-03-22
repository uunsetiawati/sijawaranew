<div class="container px-4 px-md-0 py-4 pb-6 pt-3">
    <h5 class="py-2 fw-semibold">Event</h5>
    <hr class="opacity-25">
    <?php if ($event['EXPIRED'] == 1) { ?>
        <div class="alert alert-danger" role="alert">
            <div class="position-relative">
                <div class="position-absolute top-50 start-50 translate-middle">
                    This event has been expired
                </div>
            </div>
        </div>
    <?php } ?>
    <div class="d-flex flex-lg-row flex-column mx-4 mx-lg-6 mt-5">
        <div class="col-lg-6 align-self-center align-self-lg-start">

            <div class="blurred-image <?= ($event['EXPIRED'] == 1) ? "cover" : "" ?>">
                <img src="<?= $event['IMAGE_ACTIVITY'] ?>" class="d-block img-fluid h-auto w-75">
            </div>

            <div class="my-3 fw-bold d-flex align-items-center text-black">
                Share :<span class="fs-5">
                    <i class="bi bi-facebook mx-2" style="cursor: pointer"></i>
                    <i class="bi bi-twitter me-2" style="cursor: pointer"></i>
                    <i class="bi bi-instagram" style="cursor: pointer"></i>
                </span>
            </div>
        </div>
        <div class="col-lg-6 ps-4 pe-3 py-2">
            <div class="d-flex flex-row align-items-center gap-2">
                <p class="text-muted m-0 pt-2 pb-2 fs-6"><?= date_format(date_create($event['DATE_START']), 'j F Y') ?></p>
                <p class="fw-semibold px-3 fs-8 m-0 rounded-5" style="color:white; background-color:<?= ($event['PRICE_ACTIVITY'] == 0) ? "#47DE13" : "#5580E9" ?>">
                    <?= ($event['PRICE_ACTIVITY'] == 0) ? "FREE" : "PAID" ?>
                </p>
            </div>
            <span class="fw-semibold fs-2 mt-2"><?= $event['TITLE_ACTIVITY'] ?></span>

            <div class="accordion" id="accordion-default">
                <div class="shadow my-2 mt-3 rounded-4">
                    <div class="mx-4 py-3 bg-white mb-0">
                        <div class="fw-semibold fs-6" data-bs-toggle="collapse" data-bs-target="#collapseExample" role="button" aria-expanded="true" aria-controls="collapseExample">
                            <i class="icon-bi bi-plus-lg " style="font-size: 1rem;-webkit-text-stroke: 1px;margin-right:0.5rem"></i>Keterangan
                        </div>
                        <div class="mt-3 collapse show" id="collapseExample" data-bs-parent="#accordion-default">
                            <table class="table table-striped text-muted">
                                <hr class="m-0">
                                <tbody>
                                    <tr>
                                        <td class="text-muted ps-4">Tempat</td>
                                        <td class="text-muted text-end">:</td>
                                        <td class="text-muted "><?= $event['LOCATION'] ?></td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted ps-4">Tanggal</td>
                                        <td class="text-muted text-end">:</td>
                                        <td class="text-muted "><?= date_format(date_create($event['DATE_START']), 'j F Y') ?></td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted ps-4">Waktu</td>
                                        <td class="text-muted text-end">:</td>
                                        <td class="text-muted "><?= date_format(date_create($event['DATE_START']), 'H:i') ?></td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted ps-4">Penyelenggara</td>
                                        <td class="text-muted text-end">:</td>
                                        <td class="text-muted "><?= $event['ORGANIZER'] ?></td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted ps-4">Narahubung</td>
                                        <td class="text-muted text-end">:</td>
                                        <td class="text-muted "><?= $event['CONTACT_CUSTOMER'] ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="shadow my-2 mt-3 rounded-4">
                    <div class="mx-4 py-3 bg-white">
                        <div class="fw-semibold fs-6" data-bs-toggle="collapse" data-bs-target="#collapseExample2" role="button" aria-expanded="false" aria-controls="collapseExample2">
                            <i class="icon-bi bi-plus-lg" style="font-size: 1rem;-webkit-text-stroke: 1px;margin-right:0.5rem"></i>Deskripsi
                        </div>

                        <div class="my-2 ms-4 collapse" id="collapseExample2" data-bs-parent="#accordion-default">
                            <hr class="mt-0 mb-2">
                            <span class="text-muted pe-4">
                                <?= ($event['DESKRIPSI_EVENT'] <> NULL || $event['DESKRIPSI_EVENT'] <> "") ? $event['DESKRIPSI_EVENT'] : "Tidak Ada Deskripsi" ?>
                            </span>
                        </div>
                    </div>
                </div>
                <?php if (!empty($this->session->userdata('ID_USER')) && $event['DATA_CHECKING'] <> 0) { ?>
                    <div class="shadow my-2 mt-3 rounded-4">
                        <div class="mx-4 py-3 bg-white">
                            <div class="fw-semibold fs-6" data-bs-toggle="collapse" data-bs-target="#collapseExample3" role="button" aria-expanded="false" aria-controls="collapseExample3">
                                <i class="icon-bi bi-plus-lg" style="font-size: 1rem;-webkit-text-stroke: 1px;margin-right:0.5rem"></i>Link Video Conference
                            </div>
                            <div class="my-2 ms-4 collapse" id="collapseExample3" data-bs-parent="#accordion-default">
                                <hr class="mt-0 mb-2">
                                <a class="pe-4" href="#" style="color: #000EFF; word-wrap: break-word;">
                                    <?= ($event['LINK_ZOOM'] <> NULL || $event['LINK_ZOOM'] <> "") ? $event['LINK_ZOOM'] : "Tidak Ada Deskripsi" ?>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="shadow my-2 mt-3 rounded-4">
                        <div class="mx-4 py-3 bg-white">
                            <div class="fw-semibold fs-6 collapseExampleSertif" data-bs-toggle="collapse" data-bs-target="#collapseExampleSertif" role="button" aria-expanded="false" aria-controls="collapseExampleSertif">
                                <i class="icon-bi bi-plus-lg" style="font-size: 1rem;-webkit-text-stroke: 1px;margin-right:0.5rem"></i>Sertifikat
                            </div>
                            <div class="my-2 ms-4 collapse" id="collapseExampleSertif" data-bs-parent="#accordion-default">
                                <hr class="mt-0 mb-2">
                                <div class="row">
                                    <?php if (date('Y-m-d h:i:s') > $event['DATE_END']) { ?>
                                        <div class="blurred-image" style="pointer-events: none">
                                            <embed class="overlay" style="width:482px; height:352px; pointer-events: none;" src="<?= $sertif['FILE_SERTIFIKAT'] ?>#toolbar=0&navpanes=0&scrollbar=0&statusbar=0&messages=0&scrollbar=0" type="text/plain"></embed>
                                        </div>
                                        <div class="mt-3 rounded-4 d-flex align-items-center">
                                            <div class="mx-4 py-3 bg-white">
                                                <label>Sertificate Code</label>
                                                <input type="text" class="form-control mb-4" name="" id="input-code">
                                                <button type="button" class="btn btn-primary col-md-12 my-3" onclick="DownloadPdf(this)">Download PDF</button>
                                            </div>
                                        </div>
                                    <?php } else if (date('Y-m-d h:i:s') < $event['DATE_START']) { ?>
                                        <label>Event belum dimulai</label>
                                    <?php } else { ?>
                                        <label>Event sedang berlangsung</label>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } else { ?>
                    <?php if ($event['EXPIRED'] == 0) { ?>
                        <div class="row col-12 mx-4 py-3 px-4 d-flex align-items-center">
                            <div class="fw-semibold fs-6 col-md-5">
                                <?= ($event['PRICE_ACTIVITY'] == 0) ? "" : "Price : Rp " . number_format($event['PRICE_ACTIVITY'], 2, ',', '.') ?>
                            </div>
                            <div class="col-md-7 d-flex justify-content-end">
                                <form id="FormBuyNow-info" method="POST" action="<?= base_url('purchase') ?>">
                                    <div id="data-input-info"></div>
                                    <div class="col-12 btn btn-primary text-black fw-semibold fs-4 text-white px-5" onclick="BuyNow()">Buy Now</div>
                                </form>
                                <div class="ms-3 d-flex justify-content-between align-items-baseline">
                                    <a data-id-activity="<?= $event['ID_ACTIVITY'] ?>" onclick="AddToCart(this)" href="javascript:void(0)">
                                        <img src="<?= base_url('assets/images/shopping-cart-empty.svg') ?>" class="checkout" style="width:2.8rem;height:2.8rem"></img>
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                <?php } ?>
            </div>
        </div>
    </div>
    <h5 class="py-2 fw-semibold">Event Lainnya</h5>
    <hr class="opacity-25">
    <div class="row gap-3">
        <div class="col-12 col-lg bg-white row">
            <?php foreach ($other_event as $item) : ?>
                <div class="col-md-4 p-3 pb-4" onclick="location.href='<?= base_url('event/detail/' . preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $item['TITLE_ACTIVITY']))) . '?id_activity=' . $item['ID_ACTIVITY'] ?>'" style="cursor: pointer">
                    <div class=" rounded-5 shadow">
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
                            <p class="text-muted m-0 pt-2 pb-2 fs-6"><?= date_format(date_create($item['LOG_TIME']), 'j F Y') ?></p>
                            <span class="fw-semibold fs-5 mt-2"><?= $item['TITLE_ACTIVITY'] ?></span>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<style>
    .blurred-image {
        overflow: hidden;
    }

    .overlay {
        -webkit-filter: blur(4px);
        filter: blur(4px);
        pointer-events: none;
    }

    .box-input {
        max-height: 250px;
    }
</style>

<script>
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 1000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    })

    function AddToCart(e) {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 2000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            },
            didDestroy: (toast) => {
                location.reload();
            }
        })
        $.ajax({
            url: '<?= base_url('add/order') ?>',
            type: "GET",
            data: {
                id_activity: $(e).data("id-activity"),
                type: 1
            },
            dataType: 'json',
            success: function(data) {
                Toast.fire({
                    icon: (data.Status) ? 'success' : 'error',
                    title: data.Message
                })
            }
        });
    }

    function BuyNow() {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 2000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })
        <?php if (!empty($this->session->userdata('ID_USER'))) { ?>
            <?php if (!empty($checking_trans)) { ?>
                Toast.fire({
                    icon: 'error',
                    title: 'You have unfinished transactions!'
                })
            <?php } else { ?>
                $.ajax({
                    url: '<?= base_url('add/order') ?>',
                    type: "GET",
                    data: {
                        id_activity: '<?= $event['ID_ACTIVITY'] ?>',
                        type: 2
                    },
                    dataType: 'json',
                    success: function(data) {
                        let timerInterval
                        $('#data-input-info').append('<input type="hidden" name="id_order_purchase[0]" value="' + data.IdOrder + '" />')
                        Swal.fire({
                            title: 'Create Order!',
                            html: 'Please Wait ...',
                            timer: 2000,
                            timerProgressBar: false,
                            didOpen: () => {
                                Swal.showLoading()
                            },
                            willClose: () => {
                                clearInterval(timerInterval)
                            }
                        }).then((result) => {
                            if (result.dismiss === Swal.DismissReason.timer) {
                                $("#FormBuyNow-info").submit();
                            }
                        })
                    }
                });
            <?php } ?>
        <?php } else { ?>
            Toast.fire({
                icon: 'error',
                title: 'Please Login First!'
            })
        <?php } ?>
    }
    <?php if (!empty($this->session->userdata('ID_USER')) && $event['DATA_CHECKING'] <> 0) { ?>

        function DownloadPdf(e) {
            if ($('#input-code').val() == '<?= $event['SERTIF_CODE'] ?>') {
                fetch('<?= $sertif['FILE_SERTIFIKAT'] ?>')
                    .then(resp => resp.blob())
                    .then(blob => {
                        const url = window.URL.createObjectURL(blob);
                        const a = document.createElement('a');
                        a.style.display = 'none';
                        a.href = url;
                        a.download = filename('<?= $sertif['FILE_SERTIFIKAT'] ?>');
                        document.body.appendChild(a);
                        a.click();
                        window.URL.revokeObjectURL(url);
                    })
                    .catch((e) => alert(e));
            } else {
                Toast.fire({
                    icon: 'error',
                    title: 'Wrong Code!'
                })
            }
        }

        function filename(path) {
            path = path.substring(path.lastIndexOf("/") + 1);
            return (path.match(/[^.]+(\.[^?#]+)?/) || [])[0];
        }
    <?php } ?>
</script>