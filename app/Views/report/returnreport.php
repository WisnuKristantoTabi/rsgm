<?= $this->extend('layout/page_layout') ?>

<?= $this->section('content') ?>

<div class="card">
    <form action="<?php echo base_url('reportreturnexcel') ?>" method="post">
        <div class="card-header">

        </div>
        <div class="card-body mb-5">
            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1">Pilih Bulan</span>
                <select class="form-select" name="month">
                    <option value="1" selected>Januari</option>
                    <option value="2">Februari</option>
                    <option value="3">Maret</option>
                    <option value="4">April</option>
                    <option value="5">Mei</option>
                    <option value="6">Juni</option>
                    <option value="7">Juli</option>
                    <option value="8">Agustus</option>
                    <option value="9">September</option>
                    <option value="10">Oktober</option>
                    <option value="11">November</option>
                    <option value="12">Desember</option>
                </select>
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1">Pilih Tahun</span>
                <select class="form-select" name="year">
                    <option value="2021">2021</option>
                    <option value="2022">2022</option>
                    <option value="2023">2023</option>
                    <option value="2024" selected>2024</option>
                </select>
            </div>
        </div>
        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <button type="submit" class="btn btn-primary me-md-2">
                <i class="lni lni-search"></i>
                Cari
            </button>
        </div>
    </form>
</div>

<div>

</div>


<?= $this->endSection() ?>