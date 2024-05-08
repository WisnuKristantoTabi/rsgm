<?= $this->extend('layout/page_layout') ?>

<?= $this->section('content') ?>

<?php if (session()->getFlashdata('msg')) : ?>
    <div class="alert alert-danger" role="alert">
        <?= session()->getFlashdata('msg') ?>
    </div>
<?php endif; ?>

<form action="<?php echo base_url('/coass/update/'); ?>" method="POST">
    <input type="hidden" name="id" value="<?= $coass['id'] ?>">
    <div class="form-floating mb-3">
        <input type="text" name="fullname" id="fullname" placeholder="Nama Lengkap Koass" value="<?= $coass['coass_name'] ?>" class="form-control">
        <label for="fullname">Nama Koass</label>
    </div>
    <div class="form-floating mb-3">
        <input type="text" name="coassnumber" id="coassnumber" placeholder="NIM" value="<?= $coass['coass_number'] ?>" class="form-control">
        <label for="coassnumber">NIM</label>
    </div>
    <div class="form-floating mb-3">
        <input type="tel" name="phone" id="phone" placeholder="Nomor Telpon Coass" value="<?= $coass['phone'] ?>" class="form-control">
        <label for="phone">Nomor Telpon Coass</label>
    </div>
    <div class="form-floating mb-3 dateformat">
        <input type="date" name="onsitedate" id="onsitedate" value="<?= $coass['coass_date'] ?>" placeholder="Tanggal Onsite" class="inputdate form-control">
        <label for="onsitedate">Tanggal Onsite</label>
    </div>
    <div class="form-floating mb-3">
        <input type="text" name="clinic" id="clinic" placeholder="Nama Klinik" value="<?= $coass['clinic_name'] ?>" class="form-control">
        <label for="clinic">Klinik</label>
    </div>
    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
        <button type="submit" class="btn btn-primary">Edit</button>
    </div>
</form>


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
<!-- <script type='text/javascript'>
    $(document).ready(function() {
        $('#search').select2({
            placeholder: "Pilih Rekam Medik"
        });
    });
</script> -->

<?= $this->endSection() ?>