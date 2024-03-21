<?= $this->extend('layout/page_layout') ?>

<?= $this->section('content') ?>

<?php if (session()->getFlashdata('msg')) : ?>
    <div class="alert alert-danger" role="alert">
        <?= session()->getFlashdata('msg') ?>
    </div>
<?php endif; ?>

<form action="<?php echo base_url('/recordmedical/store'); ?>" method="post">
    <input type="hidden" class="txt_csrfname" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
    <!-- <div class="form-floating mb-3"> -->
    <!-- <input type="text" name="rmid" id="rmid" placeholder="RM.NO" value="" class="form-control"> -->

    <div class="mb-5">
        <label class="mb-3" for="searchrm">Cari Nomor Rekam Medik</label>
        <select id="searchrm" class="form-select">
            <option value=""></option>
        </select>

    </div>
    <!-- <label for="rmid">Nomor RM</label> -->
    <!-- </div> -->
    <div class="form-floating mt-3 mb-3">
        <input type="text" name="fullname" id="fullname" placeholder="Nama Klinik" value="" class="form-control">
        <label for="fullname">Nama Klinik</label>
    </div>
    <div class="form-floating mb-3">
        <input type="text" name="fullname" id="fullname" placeholder="Nama Koass" value="" class="form-control">
        <label for="fullname">Nama Koass</label>
    </div>
    <div class="form-floating mb-3">
        <input type="text" name="address" id="address" placeholder="NIM" value="" class="form-control">
        <label for="adress">NIM</label>
    </div>
    <div class="form-floating mb-3">
        <input type="tel" name="address" id="address" placeholder="Nomor Telpon Coass" value="" class="form-control">
        <label for="adress">Nomor Telpon Coass</label>
    </div>
    <!-- <div class="form-group mb-5">
        <label for="inputPassword5" class="form-label">Jenis Kelamin</label>
        <input type="radio" class="btn-check" value="1" name="gender" id="option1" autocomplete="off" checked>
        <label class="btn btn-outline-primary btn-sm" for="option1">Laki-Laki</label>

        <input type="radio" class="btn-check" value="0" name="gender" id="option2" autocomplete="off">
        <label class="btn btn-outline-primary btn-sm" for="option2">Perempuan</label>
    </div> -->
    <div class="form-floating mb-3 dateformat">
        <input type="date" name="birthday" id="birthday" placeholder="Tanggal Onsite" class="form-control">
        <label for="adress">Tanggal Onsite</label>
    </div>
    <div class="form-floating mb-3">
        <input type="tel" name="address" id="address" placeholder="Klinik" value="" class="form-control">
        <label for="adress">Klinik</label>
    </div>
    <div class="mb-3">
        <label>Keperluan</label>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
            <label class="form-check-label" for="flexCheckDefault">
                Kerja
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" checked>
            <label class="form-check-label" for="flexCheckChecked">
                Nilai
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
            <label class="form-check-label" for="flexCheckChecked">
                Diskusi/Up
            </label>
        </div>
    </div>

    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
        <button type="submit" class="btn btn-primary">Tambah</button>
    </div>
</form>

<script src="<?php echo base_url('/select2/dist/js/select2.min.js') ?>" type='text/javascript' defer></script>
<!-- <script>
    $("input").on("change", function() {
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

<script>
    $(document).ready(function() {
        $('#searchrm').select2({
            placeholder: "Cari Rekam Medik",
            ajax: {
                url: "<?php echo base_url('/recordmedical/searchdata') ?>",
                dataType: 'json',
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