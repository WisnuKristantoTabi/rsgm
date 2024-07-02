<?= $this->extend('layout/page_layout') ?>

<?= $this->section('content') ?>

<?php if (session()->getFlashdata('msg')) : ?>
    <div class="alert alert-danger" role="alert">
        <?= session()->getFlashdata('msg') ?>
    </div>
<?php endif; ?>

<div class="mb-3">
    <a role="button" data-bs-toggle="modal" data-bs-target="#exampleModal" class="btn btn-outline-primary btn-sm me-md-2" href="">
        <i class="lni lni-plus"></i>
        Tambah Lewat Excel</a>
</div>
<div class="card">
    <div class="card-body">
        <form action="<?php echo base_url('/recordmedical/store'); ?>" method="post">

            <div class="form-floating mb-3">
                <input type="text" name="rmid" id="rmid" placeholder="RM.NO" value="" class="form-control">
                <label for="rmid">Nomor RM</label>
            </div>
            <div class="form-floating mb-3">
                <input type="text" name="fullname" id="fullname" placeholder="Nama Lengkap" value="" class="form-control">
                <label for="fullname">Nama Lengkap</label>
            </div>
            <div class="form-floating mb-3">
                <input type="text" name="identitynumber" id="identitynumber" placeholder="NIK" value="" class="form-control">
                <label for="identitynumber">NIK</label>
            </div>
            <div class="form-floating mb-5">
                <input type="text" name="address" id="address" placeholder="Alamat" value="" class="form-control">
                <label for="adress">Alamat</label>
            </div>
            <div class="form-group mb-5">
                <label for="inputPassword5" class="form-label">Jenis Kelamin</label>
                <input type="radio" class="btn-check" value="1" name="gender" id="option1" autocomplete="off" checked>
                <label class="btn btn-outline-primary btn-sm" for="option1">Laki-Laki</label>

                <input type="radio" class="btn-check" value="2" name="gender" id="option2" autocomplete="off">
                <label class="btn btn-outline-primary btn-sm" for="option2">Perempuan</label>
            </div>
            <div class="form-floating mb-3 dateformat">
                <input type="date" name="birthday" id="birthday" class="form-control">
                <label for="birthday">Tanggal Lahir</label>
            </div>
            <div class="form-floating mb-3 dateformat">
                <input type="text" name="birthplace" id="birthplace" placeholder="Tempat Lahir" class="form-control">
                <label for="birthday">Tempat Lahir</label>
            </div>
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <button type="submit" class="btn btn-primary">Tambah</button>
            </div>
        </form>

    </div>
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah File Excel</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="<?php echo base_url('/recordmedical/import'); ?>" enctype="multipart/form-data">
                <div class="form-group">
                    <label>Upload File Excel</label>
                    <input type="file" name="fileexcel" class="form-control" id="file" required accept=".xls" /></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button class="btn btn-primary" type="submit">Upload</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- 
<script>
    $("input").on("change", function() {
        this.setAttribute(
            "data-date",
            moment(this.value, "YYYY-MM-DD")
            .format(this.getAttribute("data-date-format"))
        )
    }).trigger("change")
</script> -->

<?= $this->endSection() ?>