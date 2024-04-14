    <div>
        No. Rekam Medis: <?= $profile->rm_id ?>
    </div>
    <div>
        <p>Nama Lengkap</p>
        <h2> <?= $profile->fullname ?></h2>
        </br>
        <p>Alamat</p>
        <h2> <?= $profile->address ?></h2>
        </br>
        <p>Jenis Kelamin</p>
        <h2> <?= ($profile->gender == 1) ? "Pria" : "Wanita" ?></h2>
        </br>
        <p>Tanggal Lahir</p>
        <h2> <?= $profile->birth_date ?></h2>
        </br>
        <p>Unit Pelayanan</p>
        <h2> <?= $profile->service_name ?></h2>
    </div>