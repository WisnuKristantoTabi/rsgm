<?= $this->extend('layout/page_layout') ?>

<?= $this->section('content') ?>

<div class="d-grid gap-2 d-md-flex justify-content-md-end">
    <a class="btn btn-outline-info btn-sm me-md-2" href="<?php echo base_url('/signup') ?>" role="button"><i class="lni lni-circle-plus"></i>Tambah</a>
</div>

<table class="table">
    <thead>
        <tr>
            <th scope="col">No</th>
            <th scope="col">Nama Petugas</th>
            <th scope="col">Email</th>
            <th scope="col"> Status </th>
            <th scope="col">Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($officers as $key => $officer) : ?>
            <tr>
                <td><?= $key + 1 ?></td>
                <td><?= $officer['fullname'] ?></td>
                <td><?= $officer['email'] ?></td>
                <td><?php if ($officer['role'] == 1) {
                        echo "Admin";
                    } elseif ($officer['role'] == 2) {
                        echo "Petugas RM";
                    } elseif ($officer['role'] == 3) {
                        echo "Perawat";
                    } ?></td>
                <td>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a class="btn btn-outline-warning btn-sm" href="<?= base_url('officer/edit/' . $officer['id']); ?>">
                                <i class="lni lni-pencil-alt"></i>Edit</a>
                        </div>
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a class="btn btn-outline-danger btn-sm" href="<?= base_url('officer/delete/' . $officer['id']); ?>" onclick="javascript:return confirm('Apakah ingin menghapus data ini ?')">
                                <i class="lni lni-trash-can"></i>Hapus</a>
                        </div>
                    </div>
                </td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>

<?= $this->endSection() ?>