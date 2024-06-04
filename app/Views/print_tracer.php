<style>
    h1 {
        font-family: helvetica;
        font-size: 10pt;
    }
</style>
</p> <b>No. Rekam Medis: </b></p>
<p> <?= $tracer->rm_id ?></p>
<p></p>
<p><b>Nama Pasien</b></p>
<p> <?= $tracer->fullname ?> </p>
<p></p>
<p><b>Poli Pelayanan</b></p>
<p> <?= $tracer->service_name ?> </p>
<p></p>
<p><b>Tanggal Peminjaman</b></p>
<p> <?= $tracer->loan_date ?> </p>
<p></p>
<p><b>Keterangan</b></p>
<p><b> <?= $tracer->loan_desc ?> </b></p>
<p></p>