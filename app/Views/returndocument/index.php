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
            <th scope="col">Nama Pasien</th>
            <th scope="col">Unit Pelayanan</th>
            <th scope="col">Tanggal Pinjam</th>
            <th scope="col">Tanggal Kembali</th>
            <th scope="col">Keterangan</th>
            <th scope="col">Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($trasactions as $trasaction) : ?>
            <tr>
                <th scope="row"><?= $nomor++; ?></th>
                <td><?= $trasaction['idrm'] ?></td>
                <td><?= $trasaction['fullname'] ?></td>
                <td><?= $trasaction['service_name'] ?></td>
                <td><?= $trasaction['loan_date'] ?></td>
                <td><?= $trasaction['return_date'] ?></td>
                <td>-</td>
                <td>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a role="button" href="<?php echo base_url("recordmedical/show/") . $trasaction['tid'] ?>" class="btn btn-outline-primary btn-sm me-md-2">Lihat</a>
                        <a role="button" href="<?php echo base_url("recordmedical/edit/") . $trasaction['tid'] ?>" class="btn btn-outline-warning btn-sm">Edit</a>
                        <a class="btn btn-outline-danger btn-sm" href="<?= base_url('recordmedical/delete/' . $trasaction['tid']); ?>" onclick="javascript:return confirm('Apakah ingin menghapus data ini ?')">
                            Hapus</a>
                    </div>
                </td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>

<?= $pager->links('returndoc', 'bootstrap_pagination') ?>

<?= $this->endSection() ?>