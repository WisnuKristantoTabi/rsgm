<?= $this->extend('layout/page_layout') ?>

<?= $this->section('content') ?>

<div class="d-grid gap-2 d-md-flex justify-content-md-end">
    <a class="btn btn-outline-info btn-sm me-md-2" href="<?php echo base_url('/returndoc/add') ?>" role="button">Tambah</a>
</div>

<table class="table">
    <thead>
        <tr>
            <th scope="col">No</th>
            <!-- <th scope="col">No.RM</th> -->
            <th scope="col">Nama Pasien</th>
            <th scope="col">Poli</th>
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
                <!-- <td><?= $trasaction['idrm'] ?></td> -->
                <td><?= $trasaction['fullname'] ?></td>
                <td><?= $trasaction['service_name'] ?></td>
                <td><?= $trasaction['loan_date'] ?></td>
                <td><?= $trasaction['return_date'] ?></td>
                <td><?php $trasaction['return_date'] ?></td>
                <td>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a role="button" class="btn btn-outline-success btn-sm me-md-2" href=""><i class="lni lni-whatsapp"></i>WA</a>
                        <a role="button" href="<?php echo base_url("/") . $trasaction['tid'] ?>" class="btn btn-outline-primary btn-sm me-md-2"> <i class="lni lni-eye"></i> Lihat</a>
                        <a role="button" href="" class="btn btn-outline-warning btn-sm"> <i class="lni lni-pencil-alt"></i> Edit</a>
                        <a class="btn btn-outline-danger btn-sm" href="<?= base_url('/' . $trasaction['tid']); ?>" onclick="javascript:return confirm('Apakah ingin menghapus data ini ?')">
                            <i class="lni lni-trash-can"></i>Hapus</a>
                    </div>
                </td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>

<?= $pager->links('returndoc', 'bootstrap_pagination') ?>

<?= $this->endSection() ?>