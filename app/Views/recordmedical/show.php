<?= $this->extend('layout/page_layout') ?>

<?= $this->section('content') ?>

<div class=" mb-3">
    <a href="<?php echo base_url('print/recordmedical/') . $profile->rm_id ?>" class="btn btn-outline-info">
        <i class="lni lni-printer"></i>
        Print</a>
</div>

<div class="card">
    <div class="card-header">
        No. Rekam Medis: <?= $profile->rm_id ?>
    </div>
    <div class="card-body mb-5">
        <blockquote class="blockquote mb-0">
            <p>Nama Lengkap</p>
            <h2 class="blockquote-footer"> <?= $profile->fullname ?></h2>
        </blockquote>
        <blockquote class="blockquote mb-0">
            <p>NIK</p>
            <h2 class="blockquote-footer"> <?= $profile->identity_number ?></h2>
        </blockquote>
        <blockquote class="blockquote mb-0">
            <p>Alamat</p>
            <h2 class="blockquote-footer"> <?= $profile->address ?></h2>
        </blockquote>
        <blockquote class="blockquote mb-0">
            <p>Jenis Kelamin</p>
            <h2 class="blockquote-footer"> <?= ($profile->gender == 1) ? "Pria" : "Wanita" ?></h2>
        </blockquote>
        <blockquote class="blockquote mb-0">
            <p>Tanggal Lahir</p>
            <h2 class="blockquote-footer"> <?= $profile->birth_date ?></h2>
        </blockquote>
        <blockquote class="blockquote mb-0">
            <p>Tempat Lahir</p>
            <h2 class="blockquote-footer"> <?= $profile->birth_place ?></h2>
        </blockquote>

    </div>
    <div class="container-sm my-5">
        <?= $barcode ?>
    </div>
</div>

<div>

</div>


<?= $this->endSection() ?>