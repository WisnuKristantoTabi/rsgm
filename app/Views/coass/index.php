<?= $this->extend('layout/page_layout') ?>

<?= $this->section('content') ?>


<div class="d-grid gap-2 mb-5 justify-content-md-end">
    <!-- <a class="btn btn-outline-info btn-sm me-md-2" href="<?php echo base_url('/loancoass/add') ?>" role="button">Tracer</a> -->
    <a class="btn btn-outline-info btn-sm me-md-2" href="<?php echo base_url('/coass/add') ?>" role="button"> <i class="lni lni-circle-plus"></i> Tambah</a>
</div>

<table class="table">
    <thead>
        <tr>
            <th scope="col">No</th>
            <th scope="col">Nama Coass</th>
            <th scope="col">NIM</th>
            <th scope="col">Nomor HP</th>
            <th scope="col">Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($coassmodels as $coassmodel) : ?>
            <tr>
                <th scope="row"><?= $nomor++; ?></th>
                <td><?= $coassmodel['coass_name'] ?></td>
                <td><?= $coassmodel['clinic_name'] ?></td>
                <td><?= $coassmodel['coass_number'] ?></td>
                <td><?= $coassmodel['phone'] ?></td>
                <td>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a role="button" href="<?php echo base_url("/coass/show/") . $coassmodel['id'] ?>" class="btn btn-outline-primary btn-sm"><i class="lni lni-eye"></i>Lihat</a>
                        <a role="button" href="<?php echo base_url("/coass/edit/") . $coassmodel['id'] ?>" class="btn btn-outline-warning btn-sm"><i class="lni lni-pencil-alt"></i>Edit</a>
                        <a class="btn btn-outline-danger btn-sm" href="<?= base_url('/coass/delete/' . $coassmodel['id']); ?>" onclick="javascript:return confirm('Apakah ingin menghapus data ini ?')">
                            <i class="lni lni-trash-can"></i>Hapus</a>
                    </div>
                </td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>

<?= $pager->links('coass', 'bootstrap_pagination') ?>

<?= $this->endSection() ?>