<?= $this->extend('layout/page_layout') ?>

<?= $this->section('content') ?>

<div class="d-grid gap-2 d-md-flex justify-content-md-end">
    <a class="btn btn-outline-info btn-sm me-md-2" href="<?php echo base_url('/serviceunit/add') ?>" role="button">Tambah</a>
</div>

<table class="table">
    <thead>
        <tr>
            <th scope="col">No</th>
            <th scope="col">Nama Poli</th>
            <th scope="col">Jumlah DRM</th>

        </tr>
    </thead>
    <tbody>
        <?php foreach ($serviceunits as $serviceunit) : ?>
            <tr>
                <th scope="row">-</th>
                <td><?= $serviceunit['service_name'] ?></td>
                <td><?= $serviceunit['amount'] ?></td>
                <td>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a role="button" href="<?php echo base_url("serviceunit/edit/") . $serviceunit['id'] ?>" class="btn btn-outline-warning btn-sm">Edit</a>
                        <a class="btn btn-outline-danger btn-sm" href="<?= base_url('serviceunit/delete/' . $serviceunit['id']); ?>" onclick="javascript:return confirm('Apakah ingin menghapus data ini ?')">
                            Hapus</a>
                    </div>
                </td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>

<?= $this->endSection() ?>