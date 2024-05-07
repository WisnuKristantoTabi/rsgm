<?= $this->extend('layout/page_layout') ?>

<?= $this->section('content') ?>

<div class="mb-3 btn-group-sm btn-group">
    <a href="<?php echo base_url('/returndoc') ?>" class="btn btn-outline-primary <?= ($type == 1) ? 'active' : '' ?>">UMUM</a>
    <a href="<?php echo base_url('/returndocoass') ?>" class="btn btn-outline-primary <?= ($type == 2) ? 'active' : '' ?> ">CO.ass</a>
</div>

<div class=" mb-5">
    <form class="input-group" method="post" action="<?php echo base_url('/returndoc/find/') ?>">
        <span class="input-group-text">Cari Data</span>
        <input type="text" name="id" class="form-control" placeholder="Masukkan ID Transaksi" aria-label="Recipient's username" aria-describedby="button-addon2">
        <button class="btn btn-outline-secondary" type="submit" id="button-addon2"> <i class="lni lni-search"></i> Cari</button>
    </form>
</div>

<div class="d-grid gap-2 d-md-flex justify-content-md-end">
    <a class="btn btn-outline-info btn-sm me-md-2" href="<?php echo base_url('/returndoc/add') ?>" role="button">Tambah</a>
</div>

<table class="table">
    <thead>
        <tr>
            <th scope="col">No</th>
            <!-- <th scope="col">No.RM</th> -->
            <th scope="col">Nama Coass</th>
            <th scope="col">Poli</th>
            <th scope="col">Tanggal Pinjam</th>
            <th scope="col">Tanggal Kembali</th>
            <th scope="col">Keterangan</th>
            <th scope="col">Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($trasactions as $trasaction) : ?>
            <tr>
                <th scope="row"><?= $nomor++; ?></th>
                <!-- <td><?= $trasaction['idrm'] ?></td> -->
                <td><?= $trasaction['coass_name'] ?></td>
                <td><?= $trasaction['service_name'] ?></td>
                <td><?= $trasaction['loan_date'] ?></td>
                <td><?= $trasaction['return_date'] ?></td>
                <td><?= ($trasaction['return_date'] > $trasaction['deadline']) ? "Terlambat" : "-"; ?></td>
                <td>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a role="button" data-phone="<?= $trasaction['phone'] ?>" data-name="<?= $trasaction['coass_name'] ?>" data-idrm="<?= $trasaction['idrm'] ?>" data-bs-toggle="modal" data-bs-target="#exampleModal" class="wa btn btn-outline-success btn-sm me-md-2" href="">

                            <i class="lni lni-whatsapp"></i>
                            WA</a>
                        <a role="button" href="<?php echo base_url("/returndoc/show/") . $trasaction['tid'] ?>" class="btn btn-outline-primary btn-sm me-md-2"> <i class="lni lni-eye"></i> Lihat</a>
                        <!-- <a role="button" href="<?php echo base_url("returndoc/edit/") . $trasaction['tid'] ?> " class="btn btn-outline-warning btn-sm"> <i class="lni lni-pencil-alt"></i> Edit</a>
                        <a class="btn btn-outline-danger btn-sm" href="<?= base_url('/returndoc/delete/' . $trasaction['tid']); ?>" onclick="javascript:return confirm('Apakah ingin menghapus data ini ?')">
                            <i class="lni lni-trash-can"></i>Hapus</a> -->
                    </div>
                </td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Pesan Notif WA</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?php echo base_url("/returndoc/sendmessage"); ?>" method="GET">
                <div class="modal-body">
                    <div class="form-floating">
                        <input id="phone" name="phone" type="hidden">
                        <textarea id="message" name="message" class="form-control" id="floatingTextarea2" style="height: 100px">
                    </textarea>
                        <label for="floatingTextarea2">Pesan</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Kirim</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(".wa").on("click", function() {
        var name = $(this).data('name');
        var idrm = $(this).data('idrm');
        var phone = $(this).data('phone');
        document.getElementById("message").textContent = "Kepada YTH, " +
            name + " Pengembalian dokumen dengan Nomor Rekam Medis " +
            idrm + " Mengalami Keterlambatan. Silahkan Menghubungi Admin Untuk Konfirmasi Lebih Lanjut.";

        document.getElementById("phone").value = phone
    });
</script>

<?= $pager->links('returndoc', 'bootstrap_pagination') ?>

<?= $this->endSection() ?>