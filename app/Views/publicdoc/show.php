<?= $this->extend('layout/page_layout') ?>

<?= $this->section('content') ?>

<?php if (session()->getFlashdata('msg')) : ?>
    <div class="alert alert-danger" role="alert">
        <?= session()->getFlashdata('msg') ?>
    </div>
<?php endif; ?>

<div class="form-floating mb-3">
    <input type="text" value="<?= $publicdata['fullname'] ?>" class="form-control" readonly>
    <label for="fullname">Nama Lengkap</label>
</div>
<div class="form-floating mb-3">
    <input type="text" value="<?= $publicdata['identity_number'] ?>" class="form-control" readonly>
    <label for="coassnumber">NIK</label>
</div>
<div class="form-floating mb-3">
    <input type="text" value="<?= $publicdata['address'] ?>" class="form-control" readonly>
    <label for="phone">Alamat</label>
</div>
<div class="form-floating mb-3">
    <input type="tel" value="<?= $publicdata['phone'] ?>" class="form-control" readonly>
    <label for="phone">Nomor HP</label>
</div>



<script src="<?php echo base_url('/select2/dist/js/select2.min.js') ?>" type='text/javascript' defer></script>
<script>
    $(".inputdate").on("change", function() {
        this.setAttribute(
            "data-date",
            moment(this.value, "YYYY-MM-DD")
            .format(this.getAttribute("data-date-format"))
        )
    }).trigger("change")
</script>


<?= $this->endSection() ?>