<?= $this->extend('layout/page_layout') ?>

<?= $this->section('content') ?>

<form action="<?php echo base_url('/serviceunit/update'); ?>" method="post">
    <input type="hidden" name="recordId" value="<?= $serviceunits->id ?>">
    <div class="form-floating mb-5">
        <input type="text" name="servicename" id="servicename" placeholder="Nama Unit Pelayanan" value="<?= $serviceunits->service_name ?>" class="form-control">
        <label for="servicename">Nama Poli</label>
    </div>
    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
        <button type="submit" class="btn btn-primary">Edit</button>
    </div>
</form>

<?= $this->endSection() ?>