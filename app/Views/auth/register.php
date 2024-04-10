<?= $this->extend('layout/page_layout') ?>

<?= $this->section('content') ?>
<div class="mb-3">
    <form action="<?php echo base_url('/register'); ?>" method="post">
        <div class="form-floating mb-3">
            <input type="text" name="username" placeholder="UserName" value="" class="form-control">
            <label for="username">Masukkan Username</label>
        </div>
        <div class="form-floating mb-3">
            <input type="text" name="fullname" placeholder="Nama Lengkap" value="" class="form-control">
            <label for="fullname">Masukkan Nama Lengkap</label>
        </div>
        <div class="form-floating mb-3">
            <input type="email" name="email" placeholder="Email" value="" class="form-control">
            <label for="email">Masukkan Email</label>
        </div>
        <div class="form-floating mb-3">
            <input type="password" name="password" placeholder="Password" class="form-control">
            <label for="password">Masukkan Password</label>
        </div>
        <div class="form-floating mb-3">
            <input type="password" name="confirmpassword" placeholder="Confirm Password" class="form-control">
            <label for="confirmpassword">Konfirmasi Ulang Password</label>
        </div>
        <div class="mb-3 ">
            <label for="">Status</label>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="role" value="1">
                <label class="form-check-label" for="roleadmin">Admin</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="role" value="2">
                <label class="form-check-label" for="rolepetugas">Petugas RM</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="role" value="3">
                <label class="form-check-label" for="roleperawat">Perawat</label>
            </div>
        </div>
        <div class="float-end">
            <button type="submit" class="btn btn-primary">Daftar</button>
        </div>
    </form>
</div>
<?= $this->endSection() ?>