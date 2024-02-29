<?= $this->extend('layout/page_layout') ?>

<?= $this->section('content') ?>
<div class="col-9">
    <form action="<?php echo base_url('/register'); ?>" method="post">
        <div class="form-group mb-3">
            <input type="text" name="username" placeholder="UserName" value="" class="form-control">
        </div>
        <div class="form-group mb-3">
            <input type="text" name="fullname" placeholder="Nama Lengkap" value="" class="form-control">
        </div>
        <div class="form-group mb-3">
            <input type="email" name="email" placeholder="Email" value="" class="form-control">
        </div>
        <div class="form-group mb-3">
            <input type="password" name="password" placeholder="Password" class="form-control">
        </div>
        <div class="form-group mb-3">
            <input type="password" name="confirmpassword" placeholder="Confirm Password" class="form-control">
        </div>
        <div class="d-grid">
            <button type="submit" class="btn btn-primary">Daftar</button>
        </div>
    </form>
</div>
<?= $this->endSection() ?>