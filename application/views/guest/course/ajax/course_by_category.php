<?php if (!empty($course)) { ?>
    <div class="row mt-md-4">
        <?php foreach ($course as $item) : ?>
            <?php if (!empty($this->session->userdata('ID_USER')) && $item['DATA_CHECKING'] == 1) { ?>
                <!-- VIEW SUDAH BAYAR -->
                <div class="col-12 col-lg-4 px-3 py-3 py-lg-0 pb-lg-3">
                    <div class="rounded-5 p-3 pb-4 h-100 w-100 shadow" onclick="location.href='<?= base_url('course/detail/' . preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $item['TITLE_ACTIVITY']))) . '?id_activity=' . $item['ID_ACTIVITY'] ?>'" style=" cursor: pointer">
                        <img src="<?= $item['IMAGE_ACTIVITY'] ?>" class="rounded-5" style="width: 100%; height: 300px; object-fit: cover">
                        <div class="px-3 py-3">
                            <span class="fw-semibold fs-5"><?= $item['TITLE_ACTIVITY'] ?></span>
                            <div class="text-muted m-0 pt-2 fs-6" style="overflow: hidden !important; text-overflow: ellipsis !important; display: -webkit-box !important; -webkit-line-clamp: 4 !important; -webkit-box-orient: vertical !important;"><?= $item['DESKRIPSI_COURSE'] ?> </div>
                        </div>
                        <div class="d-flex flex-row mt-1 align-items-center justify-content-between">
                            <div class="row px-2">
                                <!-- <div class="bg-primary rounded-circle photo-testimoni">
                                    <img src="<?= base_url('assets/images/home-4.png') ?>"
                                        class="d-block img-fluid h-100 w-100 rounded-5">
                                </div>
                                <div class="bg-primary rounded-circle position-relative photo-testimoni">
                                    <img src="<?= base_url('assets/images/home-4.png') ?>"
                                        class="d-block img-fluid h-100 w-100 rounded-5">
                                </div>
                                <div class="bg-primary rounded-circle position-relative photo-testimoni">
                                    <img src="<?= base_url('assets/images/home-4.png') ?>"
                                        class="d-block img-fluid h-100 w-100 rounded-5">
                                </div> -->
                            </div>
                            <div class="d-flex flex-column align-items-center gap-2 h-100">
                                <p class="fw-semibold fs-6 m-0 text-muted">
                                    &nbsp;
                                </p>
                                <?php if ($item['PROGRESS'] == 100) { ?>
                                    <p class="fw-semibold fs-5 m-0"><i class="bi bi-check-circle-fill text-success" style="font-size:24px; margin-top:2px"></i> Done</p>
                                <?php } else { ?>
                                    <p class="fw-semibold fs-5 m-0">Progress <?= ceil($item['PROGRESS']) ?>%</p>
                                <?php } ?>
                            </div>
                        </div>
                        <button type="button" class="btn btn-primary rounded-4 fw-semibold py-2 w-100 mt-4" style="--bs-btn-padding-x: 4.5rem;">Continue Course</button>
                    </div>
                </div>
            <?php } else { ?>
                <!-- VIEW BELUM BAYAR -->
                <div class="col-12 col-lg-4 px-3 py-3 py-lg-0 pb-lg-3 d-flex align-items-stretch">
                    <div class="rounded-5 p-3 pb-4 shadow h-100 w-100 d-flex flex-column">
                        <div class="d-flex justify-content-center">
                            <img src="<?= $item['IMAGE_ACTIVITY'] ?>" class="rounded-5" style="width: 100%; height: 300px; object-fit: cover;">
                        </div>
                        <div class="px-3 py-3">
                            <span class="fw-semibold fs-5"><?= $item['TITLE_ACTIVITY'] ?></span>
                            <div class="text-muted m-0 pt-2 fs-6" style="overflow: hidden !important; text-overflow: ellipsis !important; display: -webkit-box !important; -webkit-line-clamp: 4 !important; -webkit-box-orient: vertical !important;"><?= $item['DESKRIPSI_COURSE'] ?> </div>
                        </div>
                        <div class="d-flex flex-column mt-auto align-items-end justify-content-between">
                            <div class="row px-2">
                            </div>
                            <div class="d-flex flex-column align-items-end gap-2 h-100">
                                <p class="fw-semibold fs-6 m-0 text-muted">
                                    &nbsp;
                                </p>
                                <p class="fw-semibold fs-5 m-0" style="margin-top: -10px !important;">
                                    <?= ($item['PRICE_ACTIVITY'] == 0) ? "Free" : "Rp " . number_format($item['PRICE_ACTIVITY'], 2, ',', '.') ?>
                                </p>
                            </div>
                            <button type="button" onclick="location.href='<?= base_url('course/info/' . preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $item['TITLE_ACTIVITY'])) . '?id_activity=' . $item['ID_ACTIVITY']) ?>'" class="btn btn-primary rounded-4 fw-semibold py-2 w-100 mt-4" style="--bs-btn-padding-x: 4.5rem;">Order</button>
                        </div>
                    </div>
                </div>
            <?php } ?>
        <?php endforeach; ?>
    </div>
    <!-- <hr class="mt-5">
    <div class="px-3 d-grid d-md-flex text-center justify-content-md-between justify-content-center align-items-center">
        <div class="order-2 order-md-1 pt-3 pt-md-0">
            <span class="fs-8 pagination-text">Showing <span class="fw-bold"><?= (int)$page + 1 ?></span> to <span class="fw-bold"><?= ($page < $per_page) ? $total_data : (($per_page < $total_data) ? $total_data : $per_page) ?></span>
                of
                <span class="fw-bold"><?= $total_data ?></span> entries</span>
        </div>
        <div class="order-1 order-md-2">
            <?= $pagination; ?>
        </div>
    </div> -->
<?php } else { ?>
    <div class="col-12 col-lg-12 px-3 py-3 py-lg-0 pb-lg-3 d-flex justify-content-center">
        <div class=" rounded-5 p-3 pb-4 h-auto d-flex flex-column">
            <div class="d-flex justify-content-center">
                <img src="https://img.freepik.com/free-vector/empty-concept-illustration_114360-7416.jpg" width="350">
            </div>
            <div class="px-3 py-3 text-center">
                <span class="fw-semibold fs-5 text-muted">No Course</span>
            </div>
        </div>
    </div>
<?php } ?>