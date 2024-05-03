<div>
    <H1>Tracer</H1>
</div>
<hr>
<br>
<div>
    No. Rekam Medis: <?= $tracer->rm_id ?>
</div>
<div>
    <p>Nama Pasien</p>
    <h2> <?= $tracer->fullname ?> </h2>
    <p>Poli Pelayanan</p>
    <h2> <?= $tracer->service_name ?> </h2>
    </br>
    <p>Tanggal Peminjaman</p>
    <h2> <?= $tracer->loan_date ?> </h2>
    </br>
    <p>Keterangan</p>
    <h2> <?= $tracer->loan_desc ?> </h2>
    </br>
</div>