<!-- Page Title -->
<div class="page-title dark-background" data-aos="fade"
    style="background-image: url('<?= base_url('assets/img/timor_megah.jpg') ?>');">
    <div class="container position-relative">
        <h1>Rekomendasi Wisata</h1>
    </div>
</div><!-- End Page Title -->

<!-- Section Bobot Kriteria -->
<section class="section">
    <div class="container">
        <div class="alert alert-warning" role="alert">
            Silakan masukkan bobot untuk setiap kriteria sesuai tingkat kepentingan Anda.
            Bobot menunjukkan seberapa penting kriteria tersebut dalam pengambilan keputusan.
        </div>
        <form id="bobotForm" action="<?= base_url('moora'); ?>" method="post">
            <input type="hidden" name="user_lat" id="user_lat">
            <input type="hidden" name="user_lng" id="user_lng">
            <div class="row gy-4 d-flex justify-content-center">
                <?php foreach ($listKriteria as $key => $kriteria):
                    $id = $kriteria['id_kriteria'];
                    $value = isset($_POST['bobot'][$id]) ? $_POST['bobot'][$id] : 0;
                ?>
                <div class="col-md-6">
                    <label for="bobot_<?= $id; ?>">
                        <?= $kriteria['nama_kriteria']; ?>:
                        <span id="bobot_val_<?= $id; ?>"><?= $value; ?></span>
                    </label>
                    <input type="range" value="<?= $value; ?>" class="form-range bobot-input" name="bobot[<?= $id; ?>]"
                        id="bobot_<?= $id; ?>" min="0" max="100" required
                        oninput="document.getElementById('bobot_val_<?= $id; ?>').textContent = this.value">
                </div>
                <?php endforeach; ?>
            </div>
            <div class="row gy-4 d-flex justify-content-center">
                <p class="text-center">Apakah Anda suka tempat yang ramai? </p>
                <div class="col-auto">
                    <div class="form-check">
                        <input class="form-check-input" <?=$_POST['pengunjung'] == 'Ya'?'checked':''?> type="radio"
                            name="pengunjung" id="ramaiYa" value="Ya">
                        <label class="form-check-label" for="ramaiYa">
                            Ya
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" <?=$_POST['pengunjung'] == 'Tidak'?'checked':''?>
                            name="pengunjung" id="ramaiTidak" value="Tidak">
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

<!-- Section Proses MOORA -->
<section class="section bg-light">
    <div class="container">
        <h3 class="mb-4 text-center">Proses Perhitungan MOORA</h3>
        <?php
function renderTable($title, $matrix, $alternatifList, $round = true, $decimals = 3) {

    
            echo "<h5 class='mt-4'>$title</h5>";
            echo "<div class='table-responsive'>";
            echo "<table class='table table-bordered table-striped'>";
            echo "<thead class='table-dark'><tr><th>Alternatif</th>";

            if (!empty($matrix)) {
                $headers = array_keys(reset($matrix));
                foreach ($headers as $key => $col) {
                    echo "<th>C" . ($key + 1) . "</th>";
                }
            }

            echo "</tr></thead><tbody>";
            $i = 0;
            foreach ($matrix as $alt_id => $values) {
                if($i < count($alternatifList)){
                    echo "<tr><td>{$alternatifList[$i]->nama_alternatif}</td>";
                    foreach ($values as $val) {
                        echo "<td>" . ($round ? round($val, $decimals) : $val) . "</td>";
                    }
                    echo "</tr>";
                }
                $i++;
            }
            echo "</tbody></table></div>";
        }

        renderTable('Matriks Keputusan (X)', $proses['matriks_keputusan'], $alternatif);
        renderTable('Normalisasi (R)', $proses['normalisasi'], $alternatif);
        renderTable('Optimalisasi Atribut (V)', $proses['optimalisasi_atribut'], $alternatif);
        ?>
    </div>
</section>

<!-- Section Ranking -->
<section class="section">
    <div class="container">
        <h3 class="mb-4 text-center">Hasil Rekomendasi Wisata</h3>
        <div class="table-responsive">
            <table class="table table-bordered table-striped text-center">
                <thead class="table-dark">
                    <tr>
                        <th>Peringkat</th>
                        <th>Nama Wisata</th>
                        <th>Gambar</th>
                        <th>Skor (Yi)</th>
                        <th>Lokasi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($proses['ranking'] as $row): ?>
                    <tr>
                        <td><?= $row['peringkat']; ?></td>
                        <td>
                            <a href="<?= base_url('pages/detail_rekomendasi/' . $row['id']); ?>">
                                <?= $row['nama']; ?>
                            </a>
                        </td>
                        <td>
                            <img src="<?= base_url('uploads/' . $alternatif[array_search($row['id'], array_column($alternatif, 'id_alternatif'))]->gambar); ?>"
                                width="100">
                        </td>
                        <td><?= $row['yi']; ?></td>
                        <td>
                            <a class="btn btn-sm btn-success" target="_blank"
                                href="https://www.google.com/maps/dir/?api=1&destination=<?= $alternatif[array_search($row['id'], array_column($alternatif, 'id_alternatif'))]->latitude; ?>,<?= $alternatif[array_search($row['id'], array_column($alternatif, 'id_alternatif'))]->longitude; ?>">
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
<script>
navigator.geolocation.getCurrentPosition(function(position) {
    document.getElementById('user_lat').value = position.coords.latitude;
    document.getElementById('user_lng').value = position.coords.longitude;
}, function(error) {
    alert("Gagal mendapatkan lokasi. Pastikan izin lokasi diaktifkan.");
});
</script>