<?php foreach ($data_search as $item) { ?>
    <a class="d-flex flex-row align-items-center dropdown-item py-3" href="<?= base_url('event/detail/' . preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $item['TITLE_ACTIVITY']))) . '?id_activity=' . $item['ID_ACTIVITY'] ?>">
        <img src="<?= $item['IMAGE_ACTIVITY'] ?>" class="rounded-2" style="width: 50px; height: 50px; object-fit: cover; object-position: -50% 0%;">
        <div class="text-wrap mx-3">
            <?= $item['TITLE_ACTIVITY'] ?>
        </div>
    </a>
<?php } ?>