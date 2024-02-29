<?= $this->extend('layout/page_layout') ?>

<?= $this->section('content') ?>

<form action="<?php echo base_url('/recordmedical/update'); ?>" method="post">
    <input type="hidden" name="recordId" value="<?= $recordmedicals->id ?>">
    <div class="form-floating mb-3">
        <input type="text" name="rmid" id="rmid" placeholder="RM.NO" value="<?= $recordmedicals->rm_id ?>" class="form-control">
        <label for="rmid">Nomor RM</label>
    </div>
    <div class="form-floating mb-3">
        <input type="text" name="fullname" id="fullname" placeholder="Nama Lengkap" value="<?= $recordmedicals->fullname ?>" class="form-control">
        <label for="fullname">Nama Lengkap</label>
    </div>
    <div class="form-floating mb-5">
        <input type="text" name="address" id="address" placeholder="Alamat" value="<?= $recordmedicals->address ?>" class="form-control">
        <label for="adress">Alamat</label>
    </div>
    <div class="form-group mb-5">
        <label for="inputPassword5" class="form-label">Jenis Kelamin</label>
        <input type="radio" class="btn-check" value="1" name="gender" id="option1" autocomplete="off" <?php echo ($recordmedicals->gender == 1) ? "checked" : "" ?>>
        <label class="btn btn-outline-primary btn-sm" for="option1">Laki-Laki</label>

        <input type="radio" class="btn-check" value="0" name="gender" id="option2" autocomplete="off" <?php echo ($recordmedicals->gender == 0) ? "checked" : "" ?>>
        <label class="btn btn-outline-primary btn-sm" for="option2">Perempuan</label>
    </div>
    <div class="form-floating mb-3 dateformat">
        <input type="date" name="birthdate" id="birthdate" value="<?= $recordmedicals->birth_date ?>" placeholder="Confirm Password" class="form-control">
        <label for="adress">Tanggal Lahir</label>
    </div>
    <div class="form-floating mb-3">
        <select class="form-select" name="serviceunit" id="floatingSelect" aria-label="Floating label select example">
            <?php foreach ($serviceunits as $serviceunit) : ?>
                <option value=<?= $serviceunit['id'] ?> <?php echo ($recordmedicals->service_unit == $serviceunit['id']) ? "selected" : "" ?>><?= $serviceunit['service_name'] ?></option>
            <?php endforeach ?>
        </select>
        <label for="floatingSelect">Unit Pelayanan</label>
    </div>
    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
        <button type="submit" class="btn btn-primary">Edit</button>
    </div>
</form>

<script>
    $("input").on("change", function() {
        this.setAttribute(
            "data-date",
            moment(this.value, "YYYY-MM-DD")
            .format(this.getAttribute("data-date-format"))
        )
    }).trigger("change")
</script>

<?= $this->endSection() ?>