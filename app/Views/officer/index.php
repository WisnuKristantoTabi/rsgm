<?= $this->extend('layout/page_layout') ?>

<?= $this->section('content') ?>

<div class="d-grid gap-2 d-md-flex justify-content-md-end">
    <a class="btn btn-outline-info btn-sm me-md-2" href="<?php echo base_url('/signup') ?>" role="button">Tambah</a>
</div>

<table class="table">
    <thead>
        <tr>
            <th scope="col">No</th>
            <th scope="col">Nama Petugas</th>
            <th scope="col">Email</th>
            <th scope="col">Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($officers as $officer) : ?>
            <tr>
                <th scope="row">-</th>
                <td><?= $officer['fullname'] ?></td>
                <td><?= $officer['email'] ?></td>
                <td>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a class="btn btn-outline-danger btn-sm" href="<?= base_url('officer/delete/' . $officer['id']); ?>" onclick="javascript:return confirm('Apakah ingin menghapus data ini ?')">
                            Hapus</a>
                    </div>
                </td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>

<?= $this->endSection() ?>