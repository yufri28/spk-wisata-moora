<!-- Flash messages -->
<?php if (isset($_SESSION['success'])): ?>
<script>
Swal.fire({
    title: 'Sukses!',
    text: '<?= $_SESSION["success"]; ?>',
    icon: 'success',
    confirmButtonText: 'OK'
}).then(() => window.location.href = '');
</script>
<?php unset($_SESSION['success']); ?>
<?php endif; ?>
<?php if (isset($_SESSION['error'])): ?>
<script>
Swal.fire({
    title: 'Error!',
    text: '<?= $_SESSION["error"]; ?>',
    icon: 'error',
    confirmButtonText: 'OK'
}).then(() => window.location.href = '');
</script>
<?php unset($_SESSION['error']); ?>
<?php endif; ?>

<div class="container mb-5" style="font-family: 'Prompt', sans-serif">
    <div class="row">
        <div class="d-xxl-flex">
            <div class="col-xxl-3 mb-xxl-3 mt-5">
                <form action="<?=base_url('subkriteria/add');?>" method="post">
                    <div class="card">
                        <div class="card-header bg-primary text-white text-center">
                            Tambah Sub Kriteria
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="nama_sub_kriteria" class="form-label">Nama Sub Kriteria</label>
                                <input autofocus type="text" name="nama_sub_kriteria" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="spesifikasi" class="form-label">Spesifikasi</label>
                                <textarea name="spesifikasi" id="spesifikasi" class="form-control"></textarea>
                                <small><i>Jika tidak ada spesifikasi, isi dengan (-)</i></small>
                            </div>
                            <div class="mb-3">
                                <label for="bobot_sub_kriteria" class="form-label">Bobot Sub Kriteria</label>
                                <input type="number" step="any" name="bobot_sub_kriteria" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Kriteria</label>
                                <select class="form-control" name="f_id_kriteria">
                                    <option value="">-- Pilih --</option>
                                    <?php foreach ($dataKriteria as $key => $kriteria):?>
                                    <option value="<?=$kriteria['id_kriteria'];?>"><?=$kriteria['nama_kriteria'];?>
                                    </option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-outline-primary col-12">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="col-xxl-9 mt-5 ms-xxl-5">
                <div class="card">
                    <div class="card-header bg-primary text-white">DAFTAR SUB KRITERIA</div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered nowrap" style="width:100%"
                                id="table-subkriteria">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Sub Kriteria</th>
                                        <th>Spesifikasi</th>
                                        <th>Bobot</th>
                                        <th>Kriteria</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($dataSubkriteria as $i => $row): ?>
                                    <tr>
                                        <td><?= $i+1; ?></td>
                                        <td><?= $row['nama_sub_kriteria']; ?></td>
                                        <td><?= $row['spesifikasi']; ?></td>
                                        <td><?= $row['bobot_sub_kriteria']; ?></td>
                                        <td><?= $row['nama_kriteria']; ?></td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#edit<?= $row['id_sub_kriteria']; ?>">Edit</button>
                                            <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                                data-bs-target="#hapus<?= $row['id_sub_kriteria']; ?>">Hapus</button>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit -->
<?php foreach ($dataSubkriteria as $row): ?>
<div class="modal fade" id="edit<?= $row['id_sub_kriteria']; ?>" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?=base_url('subkriteria/update');?>" method="post">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Sub Kriteria</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id_sub_kriteria" value="<?= $row['id_sub_kriteria']; ?>">
                    <div class="mb-3">
                        <label class="form-label">Nama Sub Kriteria</label>
                        <input type="text" name="nama_sub_kriteria" class="form-control"
                            value="<?= $row['nama_sub_kriteria']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="spesifikasi" class="form-label">Spesifikasi</label>
                        <textarea name="spesifikasi" id="spesifikasi"
                            class="form-control"><?= $row['nama_sub_kriteria']; ?></textarea>
                        <small><i>Jika tidak ada spesifikasi, isi dengan (-)</i></small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Bobot Sub Kriteria</label>
                        <input type="number" step="any" name="bobot_sub_kriteria" class="form-control"
                            value="<?= $row['bobot_sub_kriteria']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kriteria</label>
                        <select class="form-control" name="f_id_kriteria">
                            <option value="">-- Pilih --</option>
                            <?php foreach ($dataKriteria as $key => $kriteria):?>
                            <option <?= $kriteria['id_kriteria'] == $row['f_id_kriteria'] ?'selected':''?>
                                value="<?=$kriteria['id_kriteria'];?>"><?=$kriteria['nama_kriteria'];?></option>
                            <?php endforeach;?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-outline-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endforeach; ?>

<!-- Modal Hapus -->
<?php foreach ($dataSubkriteria as $row): ?>
<div class="modal fade" id="hapus<?= $row['id_sub_kriteria']; ?>" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?=base_url('subkriteria/delete');?>" method="post">
                <input type="hidden" name="id_sub_kriteria" value="<?= $row['id_sub_kriteria']; ?>">
                <div class="modal-header">
                    <h5 class="modal-title">Hapus Sub Kriteria</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Yakin ingin menghapus sub kriteria <strong><?= $row['nama_sub_kriteria']; ?></strong>?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-outline-danger">Hapus</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endforeach; ?>