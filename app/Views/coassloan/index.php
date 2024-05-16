<?= $this->extend('layout/page_layout') ?>

<?= $this->section('content') ?>



<div class="mb-3 btn-group-sm btn-group">
    <a href="<?php echo base_url('/loanpublic?page_loanpublic=1') ?>" class="btn btn-outline-primary <?= ($type == 1) ? 'active' : '' ?>">UMUM</a>
    <a href="<?php echo base_url('/loancoass?page_loancoass=1') ?>" class="btn btn-outline-primary <?= ($type == 2) ? 'active' : '' ?> ">CO.ass</a>
</div>

<div class=" mb-5">
    <form class="input-group" method="get" action="<?php echo base_url('/f/coass/') ?>">
        <span class="input-group-text">Cari Data</span>
        <input type="text" name="id" class="form-control" placeholder="Masukkan ID Transaksi" aria-label="Recipient's username" aria-describedby="button-addon2">
        <button class="btn btn-outline-secondary" type="submit" id="button-addon2"> <i class="lni lni-search"></i> Cari</button>
    </form>
</div>

<div class="d-grid gap-2 mb-5 justify-content-md-end">
    <!-- <a class="btn btn-outline-info btn-sm me-md-2" href="<?php echo base_url('/loancoass/add') ?>" role="button">Tracer</a> -->
    <a class="btn btn-outline-info btn-sm me-md-2" href="<?php echo base_url('/loancoass/add') ?>" role="button"> <i class="lni lni-circle-plus"></i> Tambah</a>
</div>

<table class="table">
    <thead>
        <tr>
            <th scope="col">No</th>
            <th scope="col">Nama Pasien</th>
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
                <td><?= $coassmodel['patient'] ?></td>
                <td><?= $coassmodel['coass_name'] ?></td>
                <td><?= $coassmodel['coass_number'] ?></td>
                <td><?= $coassmodel['phone'] ?></td>
                <td>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a role="button" href="<?php echo base_url("/f/coass/?id=") . $coassmodel['transaction_id'] ?>" class="btn btn-outline-primary btn-sm"><i class="lni lni-eye"></i>Lihat</a>
                        <a role="button" href="<?php echo base_url("/loancoass/edit/") . $coassmodel['transaction_id'] ?>" class="btn btn-outline-warning btn-sm"><i class="lni lni-pencil-alt"></i>Edit</a>
                        <a class="btn btn-outline-danger btn-sm" href="<?= base_url('/loancoass/delete/' . $coassmodel['transaction_id']); ?>" onclick="javascript:return confirm('Apakah ingin menghapus data ini ?')">
                            <i class="lni lni-trash-can"></i>Hapus</a>
                    </div>
                </td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>

<?= $pager->links('loancoass', 'bootstrap_pagination') ?>

<?= $this->endSection() ?>