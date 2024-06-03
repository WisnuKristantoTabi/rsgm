<?= $this->extend('layout/page_layout') ?>

<?= $this->section('content') ?>

<?php if (session()->getFlashdata('msg')) : ?>
    <div class="alert alert-danger" role="alert">
        <?= session()->getFlashdata('msg') ?>
    </div>
<?php endif; ?>

<form action="<?php echo base_url('/loancoass/store'); ?>" method="post">
    <!-- <input type="hidden" class="txt_csrfname" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" /> -->
    <!-- <div class="form-floating mb-3"> -->
    <!-- <input type="text" name="rmid" id="rmid" placeholder="RM.NO" value="" class="form-control"> -->

    <div class="mb-5">
        <label class="mb-3" for="searchrm">Cari Nomor Rekam Medik</label>
        <select id="searchrm" name="rmid" class="form-select">
            <option value=""></option>
        </select>
    </div>
    <div class="mb-5">
        <label class="mb-3" for="searchtid">Cari Data Coass</label>
        <select id="coassid" name="coassid" class="form-select">
            <option value=""></option>
        </select>
    </div>
    <div class="form-floating mb-3">
        <input type="text" id="fullname" placeholder="Nama Lengkap Koass" class="form-control" readonly>
        <label for="fullname">Nama Koass</label>
    </div>
    <div class="form-floating mb-3">
        <input type="text" id="coassnumber" placeholder="NIM" value="" class="form-control" readonly>
        <label for="coassnumber">NIM</label>
    </div>
    <div class="form-floating mb-3">
        <input type="tel" id="phone" placeholder="Nomor Telpon Coass" value="" class="form-control" readonly>
        <label for="phone">Nomor Telpon Coass</label>
    </div>
    <div class="form-floating mb-3 dateformat">
        <input type="date" name="loandate" id="loandate" value="<?= date('Y-m-d'); ?>" class="inputdate form-control">
        <label for="loandate">Tanggal Peminjaman</label>
    </div>
    <div class="form-floating mb-3 dateformat">
        <input type="date" name="deadline" id="deadline" value="<?= date('Y-m-d', strtotime('+1 day')); ?>" class="inputdate form-control">
        <label for="deadline">Tanggal Batas Pengembalian</label>
    </div>
    <div class="mb-3">
        <label>Keperluan</label>
        <div class="form-check">
            <input name="loandesc[]" class="form-check-input" type="checkbox" value="Kerja," id="loandesc[]">
            <label class="form-check-label" for="loandesc[]">
                Kerja
            </label>
        </div>
        <div class="form-check">
            <input name="loandesc[]" class="form-check-input" type="checkbox" value="Nilai," id="loandesc[]">
            <label class="form-check-label" for="loandesc[]">
                Nilai
            </label>
        </div>
        <div class="form-check">
            <input name="loandesc[]" class="form-check-input" type="checkbox" value="Diskusi/Up," id="loandesc[]">
            <label class="form-check-label" for="loandesc[]">
                Diskusi/Up
            </label>
        </div>
        <div class="form-check mb-5">
            <label class="form-check-label" for="loandesc[]">
                Lainnya
            </label>
            <input name="loandesc[]" class="form-control" type="text" value="" id="loandesc[]">
        </div>
    </div>

    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
        <button type="submit" class="btn btn-primary">Tambah</button>
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

<!-- Data Rekam Medis -->

<script>
    $(function() {
        $('#searchrm').val("").trigger("change");
        $(document).ready(function() {
            $('#searchrm').select2({
                placeholder: "Cari Rekam Medik",
                allowClear: true,
                minimumInputLength: 2,
                ajax: {
                    url: "<?php echo base_url('/recordmedical/searchdata') ?>",
                    dataType: 'json',
                    type: 'POST',
                    delay: 500,
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
    });
</script>

<!-- Data Coass -->

<script>
    $(document).ready(function() {
        $('#coassid').select2({
            placeholder: "Cari Coass",
            ajax: {
                url: "<?php echo base_url('/loancoass/searchcoass') ?>",
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
        }).on('select2:select', function(e) {
            var selectedID = e.params.data.id;
            $.ajax({
                url: "<?php echo base_url('/loancoass/showcoass/') ?>", // Ganti dengan URL yang sesuai
                dataType: 'json',
                type: 'POST',
                data: {
                    id: selectedID
                },
                success: function(response) {
                    $('#fullname').val(response[0].coassname);
                    $('#coassnumber').val(response[0].coassnumber);
                    $('#phone').val(response[0].phone);
                    $('#onsitedate').val(response[0].coassdate);
                    $('#clinic').val(response[0].clinicname);
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        });
    });
</script>
<script src="<?php echo base_url('/select2/dist/js/select2.min.js') ?>" type='text/javascript' defer></script>

<?= $this->endSection() ?>