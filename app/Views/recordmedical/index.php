<?= $this->extend('layout/page_layout') ?>

<?= $this->section('content') ?>

<div class="d-grid gap-2 d-md-flex justify-content-md-end">
  <a class="btn btn-outline-info btn-sm me-md-2" href="<?php echo base_url('/recordmedical/add') ?>" role="button">Tambah</a>
</div>

<table class="table">
  <thead>
    <tr>
      <th scope="col">No</th>
      <th scope="col">No.RM</th>
      <th scope="col">Nama</th>
      <th scope="col">Gender</th>
      <th scope="col">Aksi</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($recordmedicals as $recordmedical) : ?>
      <tr>
        <th scope="row">-</th>
        <td><?= $recordmedical['rm_id'] ?></td>
        <td><?= $recordmedical['fullname'] ?></td>
        <td><?= ($recordmedical['gender'] == 1) ? "Pria" : "Wanita" ?></td>
        <td>
          <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <a role="button" href="<?php echo base_url("recordmedical/show/") . $recordmedical['rm_id'] ?>" class="btn btn-outline-primary btn-sm me-md-2">Lihat</a>
            <a role="button" href="<?php echo base_url("recordmedical/edit/") . $recordmedical['id'] ?>" class="btn btn-outline-warning btn-sm">Edit</a>
            <a class="btn btn-outline-danger btn-sm" href="<?= base_url('recordmedical/delete/' . $recordmedical['id']); ?>" onclick="javascript:return confirm('Apakah ingin menghapus data ini ?')">
              Hapus</a>
          </div>
        </td>
      </tr>
    <?php endforeach ?>
  </tbody>
</table>

<?= $this->endSection() ?>