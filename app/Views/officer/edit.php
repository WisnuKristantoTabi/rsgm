<?= $this->extend('layout/page_layout') ?>

<?= $this->section('content') ?>
<div class="mb-3">
    <form action="<?php echo base_url('/officer/update'); ?>" method="post">
        <input type="hidden" name="id" value="<?= $id ?>">
        <div class="form-floating mb-3">
            <input type="text" name="username" value="<?= $name ?>" placeholder="UserName" value="" class="form-control" disabled>
            <label for="username">Masukkan Username</label>
        </div>
        <div class="form-floating mb-3">
            <input type="text" name="fullname" value="<?= $fullname ?>" placeholder="Nama Lengkap" value="" class="form-control">
            <label for="fullname">Masukkan Nama Lengkap</label>
        </div>
        <div class="form-floating mb-3">
            <input type="email" name="email" value="<?= $email ?>" placeholder="Email" value="" class="form-control">
            <label for="email">Masukkan Email</label>
        </div>

        <div class="mb-3 ">
            <label for="">Status</label>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="role" value="1" <?= ($role == 1) ? "checked" : "" ?>>
                <label class="form-check-label" for="roleadmin">Admin</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="role" value="2" <?= ($role == 2) ? "checked" : "" ?>>
                <label class="form-check-label" for="rolepetugas">Petugas RM</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="role" value="3" <?= ($role == 3) ? "checked" : "" ?>>
                <label class="form-check-label" for="roleperawat">Perawat</label>
            </div>
        </div>
        <div class="float-end">
            <button type="submit" class="btn btn-primary">Edit</button>
        </div>
    </form>
</div>
<?= $this->endSection() ?>