<div class="col ms-4 px-5 py-5 shadow rounded-3 overflow-hidden bg-white">
    <h3 class="fw-bold pb-4" style="color:#5580E9">My Events</h3>
    <table class="table" style="color: #8A8A8E">
        <thead>
            <tr class="fw-normal text-black">
                <td scope="col" class="fw-semibold fs-5" width="60%">Event</td>
                <td scope="col" class="fw-semibold fs-5" width="20%">Date</td>
                <td scope="col" class="fw-semibold fs-5" width="20%">Time</td>
            </tr>
        </thead>
        <tbody class="table-group-divider text-black" style="border-color:#C8C8C8; border-top-width: 2px !important">
            <?php foreach ($event as $item) : ?>
                    <tr onclick="location.href='<?= base_url('event/detail/' . preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $item['TITLE_ACTIVITY']))) . '?id_activity=' . $item['ID_ACTIVITY'] ?>'" style="cursor:pointer">
                        <td class="py-3">
                            <div class="d-flex align-items-center">
                                <img src="<?= $item['IMAGE_ACTIVITY'] ?>" class="d-block img-fluid rounded-2" style="width: 80px; height: 80px; object-fit: cover">
                                <span class="ms-2"><?= $item['TITLE_ACTIVITY'] ?></span>
                            </div>
                        </td>
                        <td class="py-3"><?= date('j F Y', strtotime($item['DATE_START'])) ?></td>
                        <td class="py-3">
                            <?= date('H:i A', strtotime($item['DATE_START'])) ?>
                        </td>
                    </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php
    if (empty($event)) {
        echo "<div class='text-center fs-4 fw-semibold h-75 d-flex align-items-center justify-content-center'>No Event Available</div>";
    }
    ?>
</div>