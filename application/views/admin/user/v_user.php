<!-- Content Wrapper START -->
<div class="main-content">
    <div class="page-header">
        <h2 class="header-title"><?= $title; ?></h2>
        <div class="header-sub-title">
            <nav class="breadcrumb breadcrumb-dash">
                <a href="<?= base_url("admin") ?>" class="breadcrumb-item"><i class="anticon anticon-home m-r-5"></i>Home</a>
                <span class="breadcrumb-item active"><?= $title; ?></span>
            </nav>
        </div>
        <a class="btn btn-success btn-sm float-right" href="<?= base_url('manage/user/add') ?>"><i class="anticon anticon-plus-square"></i> Add User</a>
    </div>
    <?php if (!empty($this->session->flashdata('msg'))) { ?>
        <div class="alert alert-success">
            <div class="d-flex align-items-center justify-content-start">
                <span class="alert-icon">
                    <i class="anticon anticon-check-o"></i>
                </span>
                <span><?= $this->session->flashdata('msg'); ?></span>
            </div>
        </div>
    <?php } ?>
    <div class="card">
        <div class="card-body">
            <div class="m-t-25">
                <table id="data-table" class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama User</th>
                            <th>Email</th>
                            <th>No Telpon</th>
                            <th>Jenis Kelamin</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 0;
                        foreach ($user as $item) {
                            $no++;
                        ?>
                            <tr>
                                <td><?= $no; ?></td>
                                <td><?= $item['NAME']; ?></td>
                                <td><?= $item['EMAIL']; ?></td>
                                <td><?= $item['TELP']; ?></td>
                                <td><?= $item['JK']; ?></td>
                                <td>
                                    <div class="row">
                                        <a class="btn btn-success btn-sm col-md-5 mx-1" href="<?= base_url('manage/user/update/'.$item['ID_USER']) ?>"><i class="anticon anticon-edit"></i> edit</a>
                                        <a class="btn btn-danger btn-sm col-md-6 mx-1" href="<?= base_url('manage/user/delete/'.$item['ID_USER']) ?>"><i class="anticon anticon-delete"></i> delete</a>
                                    </div>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- Content Wrapper END -->