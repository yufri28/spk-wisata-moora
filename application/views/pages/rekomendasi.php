<!-- Page Title -->
<div class="page-title dark-background" data-aos="fade"
    style="background-image: url(<?=base_url()?>assets/img/hero.jpg);">
    <div class="container position-relative">
        <h1>Rekomendasi Wisata</h1>
    </div>
</div><!-- End Page Title -->

<section class="section">
    <div class="container">
        <div class="alert alert-warning" role="alert">
            Silakan masukkan bobot untuk setiap kriteria sesuai tingkat kepentingan Anda.
            Bobot menunjukkan seberapa penting kriteria tersebut dalam pengambilan keputusan.
        </div>
        <form id="bobotForm" action="<?= base_url('moora');?>" method="post">
            <!-- <div class="row gy-4 d-flex justify-content-center">
                <?php foreach ($listKriteria as $key => $kriteria) :?>
                <div class="col-6">
                    <label for="bobot_<?=$kriteria['id_kriteria'];?>"><?=$kriteria['nama_kriteria'];?></label>
                    <input type="range" class="form-range bobot-input" name="bobot[<?=$kriteria['id_kriteria'];?>]"
                        id="bobot_<?=$kriteria['id_kriteria'];?>" min="0" max="100" required>
                </div>
                <?php endforeach; ?>
            </div> -->
            <input type="hidden" name="user_lat" id="user_lat">
            <input type="hidden" name="user_lng" id="user_lng">
            <div class="row gy-4 d-flex justify-content-center">
                <?php foreach ($listKriteria as $key => $kriteria) :?>
                <div class="col-6">
                    <label for="bobot_<?=$kriteria['id_kriteria'];?>">
                        <?=$kriteria['nama_kriteria'];?>:
                        <span id="bobot_val_<?=$kriteria['id_kriteria'];?>">0</span>
                    </label>
                    <input type="range" class="form-range bobot-input" name="bobot[<?=$kriteria['id_kriteria'];?>]"
                        id="bobot_<?=$kriteria['id_kriteria'];?>" min="0" max="100" value="0" required
                        oninput="document.getElementById('bobot_val_<?=$kriteria['id_kriteria'];?>').textContent = this.value">
                </div>
                <?php endforeach; ?>
            </div>
            <div class="row gy-4 d-flex justify-content-center">
                <p class="text-center">Apakah Anda suka tempat yang ramai?</p>
                <div class="col-auto">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="pengunjung" id="ramaiYa" value="Ya">
                        <label class="form-check-label" for="ramaiYa">
                            Ya
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="pengunjung" id="ramaiTidak" value="Tidak">
                        <label class="form-check-label" for="ramaiTidak">
                            Tidak
                        </label>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12 mt-4 d-flex justify-content-center">
                    <button class="btn text-white" style="background:#009991" type="submit">Rekomendasi</button>
                </div>
            </div>
        </form>
    </div>
</section>

<!-- <script>
document.getElementById('bobotForm').addEventListener('submit', function(event) {
    const inputs = document.querySelectorAll('.bobot-input');
    let total = 0;
    let valid = true;

    inputs.forEach(input => {
        const value = input.value.trim();
        if (value === '' || isNaN(value)) {
            valid = false;
        } else {
            total += parseFloat(value);
        }
    });

    if (!valid) {
        alert('Semua kolom bobot harus diisi.');
        event.preventDefault();
        return;
    }

    if (total !== 100) {
        alert(`Total bobot saat ini adalah ${total}. Total bobot harus tepat 100.`);
        event.preventDefault();
    }
});
</script> -->
<section id="blog-posts" class="blog-posts section">
    <div class="container">
        <h2 class="mb-4 text-center">Daftar Wisata</h2>
        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle text-center">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Nama Wisata</th>
                        <th>Gambar</th>
                        <th>Lokasi (Google Maps)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($listWisata as $key => $wisata) : ?>
                    <tr>
                        <td><?= $key + 1; ?></td>
                        <td>
                            <a href="<?= base_url('pages/detail_rekomendasi/'.$wisata['id_alternatif']); ?>">
                                <?= $wisata['nama_alternatif']; ?>
                            </a>
                        </td>
                        <td>
                            <img src="<?= base_url('uploads/').$wisata['gambar']; ?>" alt="Gambar Wisata" width="100">
                        </td>
                        <td>
                            <a target="_blank" class="btn btn-sm text-white" style="background:#009991"
                                href="https://www.google.com/maps/dir/?api=1&destination=<?= $wisata['latitude']; ?>,<?= $wisata['longitude']; ?>">
                                Google Maps
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>
<script>
navigator.geolocation.getCurrentPosition(function(position) {
    document.getElementById('user_lat').value = position.coords.latitude;
    document.getElementById('user_lng').value = position.coords.longitude;
}, function(error) {
    alert("Gagal mendapatkan lokasi. Pastikan izin lokasi diaktifkan.");
});
</script>