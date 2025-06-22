<?php if (isset($_SESSION['success'])): ?>
<script>
var successfuly = '<?php echo $_SESSION["success"]; ?>';
Swal.fire({
    title: 'Sukses!',
    text: successfuly,
    icon: 'success',
    confirmButtonText: 'OK'
}).then(function(result) {
    if (result.isConfirmed) {
        window.location.href = '';
    }
});
</script>
<?php unset($_SESSION['success']); // Menghapus session setelah ditampilkan ?>
<?php endif; ?>
<?php if (isset($_SESSION['error'])): ?>
<script>
Swal.fire({
    title: 'Error!',
    text: '<?php echo $_SESSION['error']; ?>',
    icon: 'error',
    confirmButtonText: 'OK'
}).then(function(result) {
    if (result.isConfirmed) {
        window.location.href = '';
    }
});
</script>
<?php unset($_SESSION['error']); // Menghapus session setelah ditampilkan ?>
<?php endif; ?>
<div class="container" style="font-family: 'Prompt', sans-serif">
    <div class="row">
        <div class="d-xxl-flex">
            <div class="col-xxl-3 mb-xxl-3 mt-5">
                <form action="<?=base_url('alternatif/add');?>" method="post" enctype="multipart/form-data">
                    <div class="card">
                        <div class="card-header bg-primary">
                            <h5 class="text-center text-white pt-2 col-12 btn-outline-primary">
                                Tambah Data
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3 mt-3">
                                <label for="nama_alternatif" class="form-label">Nama Alternatif</label>
                                <input type="text" autofocus name="nama_alternatif" class="form-control"
                                    id="nama_alternatif" required placeholder="Nama Alternatif" />
                            </div>
                            <div class="mb-3 mt-3">
                                <label for="latitude" class="form-label">Latitude</label>
                                <input type="text" name="latitude" required class="form-control" id="latitude"
                                    placeholder="Latitude" />
                            </div>
                            <div class="mb-3 mt-3">
                                <label for="longitude" class="form-label">Longitude</label>
                                <input type="text" name="longitude" required class="form-control" id="longitude"
                                    placeholder="Longitude" />
                            </div>
                            <div class="mb-3 mt-3">
                                <label for="alamat" class="form-label">Alamat</label>
                                <textarea class="form-control" required placeholder="Alamat..." name="alamat"
                                    id="alamat"></textarea>
                            </div>
                            <div class="mb-3 mt-3">
                                <label for="gambar" class="form-label">Gambar</label>
                                <input type="file" accept=".jpg, .jpeg, .png" name="gambar" required
                                    class="form-control" id="gambar" />
                            </div>
                            <?php foreach ($dataKriteria as $key => $kriteria) :?>
                            <div class="mb-3 mt-3">
                                <label for="<?=strtolower($kriteria['id_kriteria'])?>"
                                    class="form-label"><?=$kriteria['nama_kriteria'];?></label>
                                <select class="form-select" name="<?=strtolower($kriteria['id_kriteria'])?>" required
                                    aria-label="Default select example">
                                    <option value="">-- Pilih <?=$kriteria['nama_kriteria'];?> --</option>
                                    <?php foreach ($dataSubkriteria as $key => $subkriteria):?>
                                    <?php if($kriteria['id_kriteria'] == $subkriteria['f_id_kriteria']): ?>
                                    <option value="<?=$subkriteria['id_sub_kriteria'];?>">
                                        <?=$subkriteria['nama_sub_kriteria'];?></option>
                                    <?php endif; ?>
                                    <?php endforeach;?>
                                </select>
                            </div>
                            <?php endforeach; ?>
                            <button type="submit" name="simpan" class="btn col-12 btn-outline-primary">
                                Simpan
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-xxl-9 mt-5 ms-xxl-5">
                <div class="card">
                    <div class="card-header bg-primary text-white">DAFTAR ALTERNATIF</div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered nowrap" style="width:100%" id="table">
                                <thead>
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">Nama Alternatif</th>
                                        <th scope="col">Latitude</th>
                                        <th scope="col">Longitude</th>
                                        <th scope="col">Alamat</th>
                                        <th scope="col">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="table-group-divider">
                                    <?php foreach ($dataAlternatif as $i => $alternatif):?>
                                    <tr>
                                        <th scope="row"><?=$i+1;?></th>
                                        <td><?=$alternatif['nama_alternatif'];?></td>
                                        <td><?=$alternatif['latitude'];?></td>
                                        <td><?=$alternatif['longitude'];?></td>
                                        <td><?=$alternatif['alamat'];?></td>
                                        <td>

                                            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#edit<?=$alternatif['id_alternatif'];?>">
                                                Edit
                                            </button>
                                            <a href="https://www.google.com/maps/dir/?api=1&destination=<?=$alternatif['latitude'];?>,<?=$alternatif['longitude'];?>"
                                                title="Lokasi di MAPS" class="btn btn-sm btn-success">ke Maps</a>
                                            <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                                data-bs-target="#hapus<?=$alternatif['id_alternatif'];?>">
                                                Hapus
                                            </button>
                                        </td>
                                    </tr>
                                    <?php endforeach;?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php foreach ($dataAlternatif as $alternatif): ?>
<div class="modal fade" id="edit<?=$alternatif['id_alternatif'];?>" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" action="<?=base_url('alternatif/edit/'.$alternatif['id_alternatif'])?>"
                enctype="multipart/form-data">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Alternatif</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Alternatif</label>
                        <input type="text" class="form-control" name="nama_alternatif" required
                            value="<?=htmlspecialchars($alternatif['nama_alternatif']);?>" />
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Latitude</label>
                        <input type="text" class="form-control" name="latitude" required
                            value="<?=htmlspecialchars($alternatif['latitude']);?>" />
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Longitude</label>
                        <input type="text" class="form-control" name="longitude" required
                            value="<?=htmlspecialchars($alternatif['longitude']);?>" />
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Alamat</label>
                        <textarea class="form-control" name="alamat"
                            required><?=htmlspecialchars($alternatif['alamat']);?></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Gambar (opsional)</label>
                        <input type="file" accept=".jpg,.jpeg,.png" name="gambar" class="form-control" />
                        <?php if (!empty($alternatif['gambar'])): ?>
                        <img src="<?= base_url('uploads/'.$alternatif['gambar']) ?>" width="100" class="mt-2">
                        <?php endif; ?>
                    </div>

                    <?php foreach ($dataKriteria as $kriteria): ?>
                    <?php
                            $selectedSub = '';
                            foreach ($dataSubkriteria as $sub) {
                                if ($sub['f_id_kriteria'] == $kriteria['id_kriteria']) {
                                    // Cek nilai terpilih untuk alternatif ini dari tabel relasi
                                    $selected = $this->db->get_where('kec_alt_kriteria', [
                                        'f_id_alternatif' => $alternatif['id_alternatif'],
                                        'f_id_kriteria' => $kriteria['id_kriteria']
                                    ])->row();
                                    if ($selected) {
                                        $selectedSub = $selected->f_id_sub_kriteria;
                                    }
                                    break;
                                }
                            }
                        ?>
                    <div class="mb-3">
                        <label class="form-label"><?=$kriteria['nama_kriteria'];?></label>
                        <select class="form-select" name="<?=strtolower($kriteria['id_kriteria']);?>" required>
                            <option value="">-- Pilih <?=$kriteria['nama_kriteria'];?> --</option>
                            <?php foreach ($dataSubkriteria as $sub): ?>
                            <?php if ($sub['f_id_kriteria'] == $kriteria['id_kriteria']): ?>
                            <option value="<?=$sub['id_sub_kriteria'];?>"
                                <?=($selectedSub == $sub['id_sub_kriteria']) ? 'selected' : ''; ?>>
                                <?=$sub['nama_sub_kriteria'];?>
                            </option>
                            <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <?php endforeach; ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endforeach; ?>
<?php foreach ($dataAlternatif as $alternatif):?>
<div class="modal fade" id="hapus<?=$alternatif['id_alternatif'];?>" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" action="<?=base_url('alternatif/delete');?>">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Modal hapus</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <input type="hidden" name="id_alternatif" value="<?=$alternatif['id_alternatif'];?>">
                <div class="modal-body">
                    <p>Anda yakin ingin menghapus alternatif <strong>
                            <?=$alternatif['nama_alternatif'];?></strong> ?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" name="hapus" class="btn btn-outline-primary">
                        Hapus
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endforeach;?>