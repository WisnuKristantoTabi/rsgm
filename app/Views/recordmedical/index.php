<?= $this->extend('layout/page_layout') ?>

<?= $this->section('content') ?>
<?php if ($role == 1 || $role == 2) : ?>
  <div class="d-grid gap-2 d-md-flex justify-content-md-end">
    <a class="btn btn-outline-info btn-sm me-md-2" href="<?php echo base_url('/recordmedical/add') ?>" role="button"><i class="lni lni-circle-plus"></i>Tambah</a>
  </div>
<?php endif ?>
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
        <th scope="row"><?= $nomor++; ?></th>
        <td><?= $recordmedical['rm_id'] ?></td>
        <td><?= $recordmedical['fullname'] ?></td>
        <td><?= ($recordmedical['gender'] == 1) ? "Pria" : "Wanita" ?></td>
        <td>
          <div class="btn-group-vertical">
            <a role="button" href="<?php echo base_url("recordmedical/show/") . $recordmedical['rm_id'] ?>" class="btn btn-outline-primary btn-sm me-md-2"><i class="lni lni-eye"></i> Lihat</a>
            <a role="button" href="<?php echo base_url("recordmedical/edit/") . $recordmedical['id'] ?>" class="btn btn-outline-warning btn-sm"><i class="lni lni-pencil-alt"></i>Edit</a>
            <a class="btn btn-outline-danger btn-sm" href="<?= base_url('recordmedical/delete/' . $recordmedical['id']); ?>" onclick="javascript:return confirm('Apakah ingin menghapus data ini ?')">
              <i class="lni lni-trash-can"></i>Hapus</a>
          </div>
        </td>
      </tr>
    <?php endforeach ?>
  </tbody>
</table>


<?= $pager->links('recordmedicals', 'bootstrap_pagination') ?>

<?= $this->endSection() ?>