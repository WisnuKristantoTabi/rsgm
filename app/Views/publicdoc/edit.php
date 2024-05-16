<?= $this->extend('layout/page_layout') ?>

<?= $this->section('content') ?>

<?php if (session()->getFlashdata('msg')) : ?>
    <div class="alert alert-danger" role="alert">
        <?= session()->getFlashdata('msg') ?>
    </div>
<?php endif; ?>

<form action="<?php echo base_url('/public/update'); ?>" method="post">
    <input type="hidden" name="id" value="<?= $publicdata['id'] ?>">
    <div class="form-floating mb-3">
        <input type="text" name="fullname" id="fullname" placeholder="Nama Lengkap" class="form-control" value="<?= $publicdata['fullname'] ?>">
        <label for="fullname">Nama Lengkap</label>
    </div>
    <div class="form-floating mb-3">
        <input type="text" name="identitynumber" id="identitynumber" placeholder="NIK" class="form-control" value="<?= $publicdata['identity_number'] ?>">
        <label for="coassnumber">NIK</label>
    </div>
    <div class="form-floating mb-3">
        <input type="text" name="address" id="address" placeholder="Alamat" class="form-control" value="<?= $publicdata['address'] ?>">
        <label for="phone">Alamat</label>
    </div>
    <div class="form-floating mb-3">
        <input type="tel" name="phone" id="phone" placeholder="Nomor Telpon Coass" class="form-control" value="<?= $publicdata['phone'] ?>">
        <label for="phone">Nomor HP</label>
    </div>
    <div class="mb-3">
        <label for="searchrm">Pilih Poli</label>
        <select name="service" id="serivce" class="form-select">
            <?php foreach ($serviceunits as $serviceunit) : ?>
                <option value="<?= $serviceunit['id'] ?>" <?= ($serviceunit['id']  == $publicdata['service_id']) ? 'selected' : '' ?>><?= $serviceunit['service_name'] ?></option>
            <?php endforeach ?>

        </select>
    </div>
    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
        <button type="submit" class="btn btn-primary">Edit</button>
    </div>
</form>

<script src="<?php echo base_url('/select2/dist/js/select2.min.js') ?>" type='text/javascript' defer></script>

<?= $this->endSection() ?>