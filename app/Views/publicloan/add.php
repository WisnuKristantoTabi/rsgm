<?= $this->extend('layout/page_layout') ?>

<?= $this->section('content') ?>

<?php if (session()->getFlashdata('msg')) : ?>
    <div class="alert alert-danger" role="alert">
        <?= session()->getFlashdata('msg') ?>
    </div>
<?php endif; ?>

<form action="<?php echo base_url('/loanpublic/store'); ?>" method="post">
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
        <label class="mb-3" for="searchtid">Cari Data Peminjam</label>
        <select id="publicid" name="publicid" class="form-select">
            <option value=""></option>
        </select>
        <a class="mb-3" href="<?php echo base_url('public/add') ?>"> Tambahkan Data Peminjam</a>
    </div>
    <div class="form-floating mb-3">
        <input type="text" id="fullname" placeholder="Nama Lengkap " value="" class="form-control" readonly>
        <label for="fullname">Nama Lengkap</label>
    </div>
    <div class="form-floating mb-3">
        <input type="text" id="identitynumber" placeholder="Masukkan Nomor NIP/KTP" value="" class="form-control" readonly>
        <label for="identitynumber">Nomor Identitas</label>
    </div>
    <div class="form-floating mb-3">
        <input type="tel" id="phone" placeholder="Nomor Telpon" value="" class="form-control" readonly>
        <label for="phone">Nomor Telpon</label>
    </div>
    <div class="form-floating mb-3">
        <input type="text" id="address" placeholder="Alamat" value="" class="form-control" readonly>
        <label for="address">Alamat</label>
    </div>
    <div class="form-floating mb-3">
        <input type="text" id="servicename" value="" class="form-control" readonly>
        <label for="servicename">Nama Poli</label>
    </div>
    <div class="form-floating mb-3 dateformat">
        <input type="date" name="loandate" id="loandate" value="<?= date('Y-m-d'); ?>" class="inputdate form-control">
        <label for="loandate">Tanggal Peminjaman</label>
    </div>
    <div class="form-floating mb-3 dateformat">
        <input type="date" name="deadline" id="deadline" value="<?= date('Y-m-d', strtotime('+1 day')); ?>" class="inputdate form-control">
        <label for="deadline">Tanggal Batas Pengembalian</label>
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

<script>
    $(function() {
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
    });
</script>

<script>
    $(function() {
        $(document).ready(function() {
            $('#publicid').select2({
                placeholder: "Cari Peminjam",
                ajax: {
                    url: "<?php echo base_url('/loanpublic/searchcoass') ?>",
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
                    url: "<?php echo base_url('/loanpublic/showcoass/') ?>", // Ganti dengan URL yang sesuai
                    dataType: 'json',
                    type: 'POST',
                    data: {
                        id: selectedID
                    },
                    success: function(response) {
                        $('#fullname').val(response[0].fullname);
                        $('#address').val(response[0].address);
                        $('#phone').val(response[0].phone);
                        $('#identitynumber').val(response[0].identitynumber);
                        $('#servicename').val(response[0].servicename);

                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            });
        });
    });
</script>

<?= $this->endSection() ?>