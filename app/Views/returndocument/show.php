<?= $this->extend('layout/page_layout') ?>

<?= $this->section('content') ?>

<?php if (session()->getFlashdata('msg')) : ?>
    <div class="alert alert-danger" role="alert">
        <?= session()->getFlashdata('msg') ?>
    </div>
<?php endif; ?>


<div class="mb-5">
    <label class="mb-3" for="searchtid">Nomor Transaksi</label>
    <select id="searchid" class="form-select" disabled>
        <option value="<?= $transaction->id ?>">ID : <?= $transaction->id ?></option>
    </select>
</div>
<div class="form-floating mb-3">
    <input type="text" class="form-control" value="<?= $transaction->rm_id ?>" readonly>
    <label for="rmid">RM.ID</label>
</div>
<div class="form-floating mb-3">
    <input type="text" class="form-control" value="<?= $transaction->fullname ?>" readonly>
    <label for="patientname">Nama Pasien</label>
</div>
<div class="form-floating mb-3">
    <input type="text" class="form-control" value="<?= $transaction->service_name ?>" readonly>
    <label for="poli">Poli</label>
</div>
<div class="form-floating mb-3 dateformat">
    <input type="text" value="<?= $transaction->loan_date ?>" class="inputdate form-control" readonly>
    <label for="loandate">Tanggal Pinjam</label>
</div>
<input type="hidden" name="tid" id="tid">
<div class="form-floating mb-3 dateformat">
    <input type="text" value="<?= $transaction->return_date ?>" class="inputdate form-control" readonly>
    <label for="returndate">Tanggal Pengembalian</label>
</div>
<div class="form-floating mb-3">
    <input type="text" value="<?= $transaction->return_desc ?>" class="form-control" readonly>
    <label for="returndesc">Keterangan</label>
</div>



<!-- <script>
    $(".inputdate").on("change", function() {
        this.setAttribute(
            "data-date",
            moment(this.value, "YYYY-MM-DD")
            .format(this.getAttribute("data-date-format"))
        )
    }).trigger("change")
</script> -->
<!-- <script type='text/javascript'>
    $(document).ready(function() {
        $('#search').select2({
            placeholder: "Pilih Rekam Medik"
        });
    });
</script> -->

<?= $this->endSection() ?>