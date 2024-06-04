    <p> <b>No. Rekam Medis:</b> </p>
    <p><?= $profile->rm_id ?></p>
    <p></p>
    <p><b>Nama Lengkap</b></p>
    <p> <?= $profile->fullname ?></p>
    <p></p>
    <p><b>Alamat</b></p>
    <p> <?= $profile->address ?></p>
    <p></p>
    <p><b>Jenis Kelamin</b></p>
    <p> <?= ($profile->gender == 1) ? "Pria" : "Wanita" ?></p>
    <p></p>
    <p><b>Tanggal Lahir</b></p>
    <p> <?= $profile->birth_date ?></p>
    <p></p>