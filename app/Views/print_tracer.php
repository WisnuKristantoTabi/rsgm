<style>
    h1 {
        font-family: helvetica;
        font-size: 10pt;
    }
</style>
</p> No. Rekam Medis: <?= $tracer->rm_id ?> </p>
<p>Nama Pasien</p>
<p> <?= $tracer->fullname ?> </p>
<p>Poli Pelayanan</p>
<p> <?= $tracer->service_name ?> </p>
<p>Tanggal Peminjaman</p>
<p> <?= $tracer->loan_date ?> </p>
<p>Keterangan</p>
<b>
    <p> <?= $tracer->loan_desc ?> </p>
</b>
</br>