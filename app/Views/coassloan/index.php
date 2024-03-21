<?= $this->extend('layout/page_layout') ?>

<?= $this->section('content') ?>

<div class="d-grid gap-2 d-md-flex justify-content-md-end">
    <a class="btn btn-outline-info btn-sm me-md-2" href="<?php echo base_url('/recordmedical/add') ?>" role="button">Tambah</a>
</div>

<table class="table">
    <thead>
        <tr>
            <th scope="col">No</th>
            <th scope="col">No.RM</th>
            <th scope="col">Nama</th>
            <th scope="col">Gender</th>
            <th scope="col">Aksi</th>
            <th scope="col">Aksi</th>
            <th scope="col">Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($coassmodels as $coassmodel) : ?>
            <tr>
                <th scope="row">-</th>
                <td><?= $coassmodel['rm_id'] ?></td>
                <td><?= $coassmodel['clinic_name'] ?></td>
                <td><?= $coassmodel['coass_number'] ?></td>
                <td><?= $coassmodel['coass_date'] ?></td>
                <td><?= $coassmodel['coass_phone'] ?></td>
                <td>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a role="button" href="<?php echo base_url("recordmedical/show/") . $coassmodel['rm_id'] ?>" class="btn btn-outline-primary btn-sm me-md-2">Lihat</a>
                        <a role="button" href="<?php echo base_url("recordmedical/edit/") . $coassmodel['id'] ?>" class="btn btn-outline-warning btn-sm">Edit</a>
                        <a class="btn btn-outline-danger btn-sm" href="<?= base_url('recordmedical/delete/' . $coassmodel['id']); ?>" onclick="javascript:return confirm('Apakah ingin menghapus data ini ?')">
                            Hapus</a>
                    </div>
                </td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>



<?= $this->endSection() ?>