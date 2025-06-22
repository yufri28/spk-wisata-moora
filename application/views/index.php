<h3>1. Bobot Kriteria</h3>
<pre><?php print_r($proses['bobot_kriteria']); ?></pre>
<h3>2. Matriks Keputusan</h3>
<pre><?php print_r($proses['matriks_keputusan']); ?></pre>
<?php 
    foreach ($proses['matriks_keputusan'] as $key => $value) {
        foreach ($value as $key => $values) {
            echo $values." ";
        }
        echo "<br>";
    }
?>

<h3>3. Normalisasi Matriks</h3>
<pre><?php print_r($proses['normalisasi']); ?></pre>

<?php 
    foreach ($proses['normalisasi'] as $key => $value) {
        foreach ($value as $key => $values) {
            echo round($values,2)." ";
        }
        echo "<br>";
    }
?>

<h3>4. Optimalisasi Atribut</h3>
<pre><?php print_r($proses['optimalisasi_atribut']); ?></pre>

<?php 
    foreach ($proses['optimalisasi_atribut'] as $key => $value) {
        foreach ($value as $key => $values) {
            echo round($values, 4)." ";
        }
        echo "<br>";
    }
?>


<h3>5. Nilai Yi</h3>
<pre><?php print_r($proses['nilai_yi']); ?></pre>
<?php 
    foreach ($proses['nilai_yi'] as $key => $value) {
        echo round($value, 2)." ";
    }
    echo "<br>";
?>

<h3>6. Hasil Ranking</h3>
<table border="1">
    <tr>
        <th>Alternatif</th>
        <th>Yi</th>
        <th>Rank</th>
    </tr>
    <?php foreach ($proses['ranking'] as $r): ?>
    <tr>
        <td><?= $r['nama'] ?></td>
        <td><?= $r['yi'] ?></td>
        <td><?= $r['peringkat'] ?></td>
    </tr>
    <?php endforeach ?>
</table>