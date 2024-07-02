<?= $this->extend('layout/page_layout') ?>

<?= $this->section('content') ?>

<div class="mb-3 btn-group-sm btn-group">
    <a href="<?php echo base_url('/returndoc') ?>" class="btn btn-outline-primary <?= ($type == 1) ? 'active' : '' ?>">UMUM/BPJS/JKN</a>
    <a href="<?php echo base_url('/returndocoass') ?>" class="btn btn-outline-primary <?= ($type == 2) ? 'active' : '' ?> ">CO.ass</a>
</div>
<div class="mb-5">
    <label class="mb-3" for="searchrm">Cari Data</label>
    <select id="searchdata" name="tid" class="form-select">
        <option value=""></option>
    </select>
</div>

<!-- <div class="d-grid gap-2 d-md-flex justify-content-md-end">
    <a class="btn btn-outline-info btn-sm me-md-2" href="<?php echo base_url('/returndoc/add') ?>" role="button">Tambah</a>
</div> -->

<table class="table">
    <thead>
        <tr>
            <th scope="col">No</th>
            <!-- <th scope="col">No.RM</th> -->
            <th scope="col">Nama Peminjam</th>
            <th scope="col">Poli</th>
            <th scope="col">Tanggal Pinjam</th>
            <th scope="col">Tanggal Kembali</th>
            <th scope="col">Keterangan</th>
            <th scope="col">Status</th>
            <th scope="col">Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($trasactions as $trasaction) : ?>
            <tr>
                <th scope="row"><?= $nomor++; ?></th>
                <!-- <td><?= $trasaction['idrm'] ?></td> -->
                <td><?= $trasaction['fullname'] ?></td>
                <td><?= $trasaction['service_name'] ?></td>
                <td><?= $trasaction['loan_date'] ?></td>
                <td><?= $trasaction['return_date'] ?></td>
                <td><?= ($trasaction['return_date'] > $trasaction['deadline']) ? "Terlambat" : "-"; ?></td>
                <td><?= ($trasaction['is_return'] == 2) ? "Sudah Kembali" : "Belum Kembali" ?></td>
                <td>
                    <div class="btn-group-vertical">
                        <?php if ($role != 3) : ?>
                            <a role="button" data-phone="<?= $trasaction['phone'] ?>" data-name="<?= $trasaction['fullname'] ?>" data-idrm="<?= $trasaction['idrm'] ?>" data-bs-toggle="modal" data-bs-target="#exampleModal" class="wa btn btn-outline-success btn-sm me-md-2" href="">
                                <i class="lni lni-whatsapp"></i>
                                WA</a>
                        <?php endif ?>
                        <a role="button" href="<?php echo base_url("/returndoc/show/") . $trasaction['tid'] ?>" class="btn btn-outline-primary btn-sm me-md-2"> <i class="lni lni-eye"></i> Lihat</a>
                        <!-- <a role="button" href="<?php echo base_url("returndoc/edit/") . $trasaction['tid'] ?>" class="btn btn-outline-warning btn-sm"> <i class="lni lni-pencil-alt"></i> Edit</a>
                        <a class="btn btn-outline-danger btn-sm" href="<?= base_url('/returndoc/delete/' . $trasaction['tid']); ?>" onclick="javascript:return confirm('Apakah ingin menghapus data ini ?')">
                            <i class="lni lni-trash-can"></i>Hapus</a> -->
                        <?php if ($trasaction['is_return'] == 2) : ?>
                        <?php if ($role != 3) : ?>
                            <a class="btn btn-outline-secondary btn-sm" href="#" style="pointer-events: none">
                                <i class="lni lni-checkmark"></i>Sudah Verifikasi</a>
                        <?php endif ?>
                            <?php else : ?>
                        <?php if ($role != 3) : ?>
                            <a class="btn btn-outline-info btn-sm" href="<?= base_url('/returndoc/verif/' . $trasaction['tid'] . '/' . $trasaction['idrm']); ?>" onclick="javascript:return confirm('Apakah Ingin Verifikasi Peminjaman ini ?')">
                                <i class="lni lni-checkmark"></i>Verifikasi</a>
                        <?php endif ?>
                        <?php endif ?>
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

<script>
    $(function() {
        $('#searchdata').val("").trigger("change");
        $(document).ready(function() {
            $('#searchdata').select2({
                placeholder: "Cari Nama/RM ID",
                allowClear: true,
                minimumInputLength: 2,
                ajax: {
                    url: "<?php echo base_url('/returndoc/find/') ?>",
                    dataType: 'json',
                    type: 'POST',
                    delay: 500,
                    data: function(params) {
                        return {
                            searchTerm: params.term
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: data
                        };
                    },
                    cache: true
                }
            }).on("select2:select", function(e) {
                window.location.href = '<?php echo base_url('/returndoc/show/') ?>' + e.params.data.id;
            });
        });
    });
</script>

<?= $pager->links('returndoc', 'bootstrap_pagination') ?>

<script src="<?php echo base_url('/select2/dist/js/select2.min.js') ?>" type='text/javascript' defer></script>

<?= $this->endSection() ?>