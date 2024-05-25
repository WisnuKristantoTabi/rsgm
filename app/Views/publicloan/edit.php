<?= $this->extend('layout/page_layout') ?>

<?= $this->section('content') ?>

<?php if (session()->getFlashdata('msg')) : ?>
    <div class="alert alert-danger" role="alert">
        <?= session()->getFlashdata('msg') ?>
    </div>
<?php endif; ?>

<form action="<?php echo base_url('loanpublic/update') ?>" method="post">
    <!-- <input type="hidden" class="txt_csrfname" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" /> -->
    <!-- <div class="form-floating mb-3"> -->
    <!-- <input type="text" name="rmid" id="rmid" placeholder="RM.NO" value="" class="form-control"> -->
    <input type="hidden" name="tid" value="<?= $transaction->tid ?>">
    <input type="hidden" name="rmidold" value="<?= $transactions->rm_id ?>">
    <div class="mb-5">
        <label class="mb-3" for="searchrm">Cari Nomor Rekam Medik</label>
        <select id="searchrm" name="rmid" class="form-select">
            <option value="<?= $transaction->rm_id ?>"><?= $transaction->fullname ?> - <?= $transaction->rm_id ?></option>
        </select>
    </div>
    <div class="mb-5">
        <label class="mb-3" for="searchtid">Cari Data Peminjam</label>
        <select id="publicid" name="publicid" class="form-select">
            <option value="<?= $transaction->pid ?>"><?= $transaction->patientname ?> - <?= $transaction->identity_number ?></option>
        </select>
        <a class="mb-3" href="<?php echo base_url('public/add') ?>"> Tambahkan Data Peminjam</a>
    </div>
    <div class="form-floating mb-3">
        <input type="text" id="fullname" placeholder="Nama Lengkap " value="<?= $transaction->patientname ?>" class="form-control" readonly>
        <label for="fullname">Nama Lengkap</label>
    </div>
    <div class="form-floating mb-3">
        <input type="text" id="identitynumber" placeholder="Masukkan Nomor NIP/KTP" value="<?= $transaction->identity_number ?>" class="form-control" readonly>
        <label for="identitynumber">Nomor Identitas</label>
    </div>
    <div class="form-floating mb-3">
        <input type="tel" id="phone" placeholder="Nomor Telpon" value="<?= $transaction->phone ?>" class="form-control" readonly>
        <label for="phone">Nomor Telpon</label>
    </div>
    <div class="form-floating mb-3">
        <input type="text" id="address" placeholder="Alamat" value="<?= $transaction->address ?>" class="form-control" readonly>
        <label for="address">Alamat</label>
    </div>
    <div class="form-floating mb-3 dateformat">
        <input type="date" name="loandate" id="loandate" placeholder="Tanggal Peminjaman" value="<?= $transaction->loan_date ?>" class="inputdate form-control">
        <label for="loandate">Tanggal Peminjaman</label>
    </div>
    <div class="form-floating mb-3 dateformat">
        <input type="date" name="deadline" id="deadline" placeholder="Tanggal Batas Pengembalian" value="<?= $transaction->deadline ?>" class="inputdate form-control">
        <label for="deadline">Tanggal Batas Pengembalian</label>
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

<script>
    $(document).ready(function() {
        $('#searchrm').select2({
            placeholder: "Cari Rekam Medik",
            ajax: {
                url: "<?php echo base_url('/recordmedical/searchdata') ?>",
                dataType: 'json',
                type: 'POST',
                delay: 250,
                data: function(params) {
                    return {
                        searchTerm: params.term
                    };
                },
                processResults: function(data) {
                    return {
                        results: data.data
                    };
                },
                cache: true
            }
        });
    });
</script>

<?= $this->endSection() ?>