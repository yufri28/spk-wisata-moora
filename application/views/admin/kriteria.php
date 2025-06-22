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
<div class="container mb-5" style="font-family: 'Prompt', sans-serif">
    <div class="row">
        <div class="d-xxl-flex">
            <div class="col-xxl-3 mb-xxl-3 mt-5">
                <form action="<?=base_url('kriteria/add');?>" method="post">
                    <div class="card">
                        <div class="card-header bg-primary">
                            <h5 class="text-center text-white pt-2 col-12 btn-outline-primary">
                                Tambah Data
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3 mt-3">
                                <label for="kode_kriteria" class="form-label">Kode Kriteria</label>
                                <input type="text" autofocus name="kode_kriteria" class="form-control"
                                    id="kode_kriteria" required placeholder="Cth: C1" />
                            </div>
                            <div class="mb-3 mt-3">
                                <label for="nama_kriteria" class="form-label">Nama Kriteria</label>
                                <input type="text" name="nama_kriteria" required class="form-control" id="nama_kriteria"
                                    placeholder="Nama Kriteria" />
                            </div>
                            <div class="mb-3 mt-3">
                                <label for="jenis_kriteria" class="form-label">Jenis Kriteria</label>
                                <select class="form-select" name="jenis_kriteria" required
                                    aria-label="Default select example">
                                    <option value="">-- Pilih Jenis Kriteria --</option>
                                    <option value="Cost">Cost</option>
                                    <option value="Benefit">Benefit</option>
                                </select>
                            </div>
                            <button type="submit" class="btn col-12 btn-outline-primary">
                                Simpan
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-xxl-9 mt-5 ms-xxl-5">
                <div class="card">
                    <div class="card-header bg-primary text-white">DAFTAR KRITERIA</div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered nowrap" style="width:100%" id="table">
                                <thead>
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">Kode Kriteria</th>
                                        <th scope="col">Nama Kriteria</th>
                                        <th scope="col">Jenis Kriteria</th>
                                        <th scope="col">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="table-group-divider">
                                    <?php foreach ($dataKriteria as $i => $kriteria):?>
                                    <tr>
                                        <th scope="row"><?=$i+1;?></th>
                                        <td><?=$kriteria['id_kriteria'];?></td>
                                        <td><?=$kriteria['nama_kriteria'];?></td>
                                        <td><?=$kriteria['jenis_kriteria'];?></td>
                                        <td>

                                            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#edit<?=$kriteria['id_kriteria'];?>">
                                                Edit
                                            </button>
                                            <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                                data-bs-target="#hapus<?=$kriteria['id_kriteria'];?>">
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

<?php foreach ($dataKriteria as $kriteria):?>
<div class="modal fade" id="edit<?=$kriteria['id_kriteria'];?>" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" action="<?=base_url('kriteria/update');?>">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Modal edit</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3 mt-3">
                        <label for="kode_kriteria" class="form-label">Kode Kriteria</label>
                        <input type="text" value="<?=$kriteria['id_kriteria'];?>" readonly name="kode_kriteria"
                            class="form-control" id="kode_kriteria" required placeholder="Cth: C1" />
                    </div>
                    <div class="mb-3 mt-3">
                        <label for="nama_kriteria" class="form-label">Nama Kriteria</label>
                        <input type="text" value="<?=$kriteria['nama_kriteria'];?>" name="nama_kriteria" required
                            class="form-control" id="nama_kriteria" placeholder="Nama Kriteria" />
                    </div>
                    <div class="mb-3 mt-3">
                        <label for="jenis_kriteria" class="form-label">Jenis Kriteria</label>
                        <select class="form-select" name="jenis_kriteria" required aria-label="Default select example">
                            <option value="">-- Pilih Jenis Kriteria --</option>
                            <option <?=$kriteria['jenis_kriteria'] == 'Cost'?'selected':'';?> value="Cost">Cost
                            </option>
                            <option <?=$kriteria['jenis_kriteria'] == 'Benefit'?'selected':'';?> value="Benefit">Benefit
                            </option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" name="edit" class="btn btn-outline-primary">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endforeach;?>
<?php foreach ($dataKriteria as $kriteria):?>
<div class="modal fade" id="hapus<?=$kriteria['id_kriteria'];?>" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" action="<?=base_url('kriteria/delete');?>">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Modal hapus</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <input type="hidden" name="id_kriteria" value="<?=$kriteria['id_kriteria'];?>">
                <div class="modal-body">
                    <p>Anda yakin ingin menghapus kriteria <strong>
                            <?=$kriteria['nama_kriteria'];?></strong> ?</p>
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