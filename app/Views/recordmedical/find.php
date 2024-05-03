<?= $this->extend('layout/page_layout') ?>

<?= $this->section('content') ?>

<div class=" mb-3">
    <a href="<?php echo base_url('/print/tracer/') . $data->tid ?>" class="btn btn-outline-info">
        <i class="lni lni-printer"></i>
        Print</a>
</div>
<div class="card">
    <div class="card-header">
        No. Rekam Medis: <?= $data->id_rekam_medik ?>
    </div>
    <div class="card-body mb-5">
        <blockquote class="blockquote mb-0">
            <p>Nama Lengkap Pasien</p>
            <h2 class="blockquote-footer"> <?= $data->fullname ?></h2>
        </blockquote>
        <blockquote class="blockquote mb-0">
            <p>Poli Pelayanan</p>
            <h2 class="blockquote-footer"> <?= $data->service_name ?></h2>
        </blockquote>
        <blockquote class="blockquote mb-0">
            <p>Tanggal Peminjaman</p>
            <h2 class="blockquote-footer"> <?= $data->loan_date ?></h2>
        </blockquote>
        <blockquote class="blockquote mb-0">
            <p>Deskripsi Peminjaman</p>
            <h2 class="blockquote-footer"> <?= $data->loan_desc ?></h2>
        </blockquote>

    </div>
    <div class="container-sm my-5">
        <?= $barcode ?>
        <p class="h6 mt-3">ID Transaksi : <?= $data->tid ?></p>
    </div>

</div>

<div>

</div>


<?= $this->endSection() ?>