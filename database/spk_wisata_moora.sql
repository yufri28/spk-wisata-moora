-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 23 Jun 2025 pada 03.20
-- Versi server: 10.4.24-MariaDB
-- Versi PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `spk_wisata_moora`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `admin`
--

INSERT INTO `admin` (`id_admin`, `username`, `password`) VALUES
(5, 'admin', '$2y$10$dsXm7.sZPZlcMeF71lQxkuqPMRYwqeLXCxpZn1VRFavgk3a8Yu87e');

-- --------------------------------------------------------

--
-- Struktur dari tabel `alternatif`
--

CREATE TABLE `alternatif` (
  `id_alternatif` int(11) NOT NULL,
  `nama_alternatif` varchar(255) NOT NULL,
  `gambar` varchar(255) NOT NULL,
  `alamat` text NOT NULL,
  `latitude` varchar(255) NOT NULL,
  `longitude` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `alternatif`
--

INSERT INTO `alternatif` (`id_alternatif`, `nama_alternatif`, `gambar`, `alamat`, `latitude`, `longitude`) VALUES
(598, 'Puncak waringin', 'c83398536ae3e5d8c7e5c33c5b1bd0ce.png', 'Labuan Bajo, Kec. Komodo, Kabupaten Manggarai Barat, Nusa Tenggara Tim.', '-8.494352976127216', '119.87952337026982'),
(599, 'Batu Cermin', 'be647299c775f4796dcceb33d3ab2077.png', 'Kecamatan Komodo, kabupaten Manggarai Barat, provinsi Nusa Tenggara Timur', '-8.47702547646911', '119.89929335994263'),
(600, 'P. Kanawa', '6f9fa94cda44eb7ff97da15a97d6ed44.png', 'Kanawah Island, Pasir Putih, Komodo, West Manggarai Regency, East Nusa Tenggara', '-8.494545750454503', '119.75847490026202'),
(601, 'Cunca Wulang', 'eb8bfca66d7fe6b6a9f53e6e2f86ce6d.png', 'Kecamatan Mbeliling, Kabupaten Manggarai Barat, Nusa Tenggara Timur', '-8.542075113956736', '119.99459717306505'),
(602, 'Danau Sano  Nggoang', 'ce5787b56e6cd8583638d89afeb78882.png', '7XQR+P78 Nunang, Desa, Wae Sano, Kec. Sano Nggoang, Kabupaten Manggarai Barat, Nusa Tenggara Tim.', '-8.70920670991831', '119.99082712471329'),
(603, 'Poco Rutang', '9959cc530d6ccea8991c51fbff605095.png', 'Kecamatan Lembor, kabupaten Manggarai Barat, provinsi Nusa Tenggara Timur', '-8.700812154058005', '120.18272714680154'),
(604, 'Istana Ular', '109faf24849db6419b54a3bba3499553.png', '85JX+7XW, Weto, Galang, Kabupaten Manggarai Barat, Nusa Tenggara Tim. 86762', '-8.668992238743197', '120.19998777958186'),
(605, 'Mberenang', '00a8c5ef922f6f353d41121499e522d1.png', '6575+PW, Nanga Lili, Kec. Lembor Selatan, Kabupaten Manggarai Barat, Nusa Tenggara Tim.', '-8.784447979325641', '120.16894925784563'),
(606, 'Watu Timbang Raung', '51e802c862cbc50def50fe35421a4634.png', 'H69X+R5W, Rego, Kec. Macang Pacar, Kabupaten Manggarai Barat, Nusa Tenggara Tim.', '-8.430174331704134', '120.24795933573274'),
(607, 'Gua Rangko', '57e8b595f3860e6c669edbfc68bf2e18.png', 'Tj. Boleng, Kec. Boleng, Kabupaten Manggarai Barat, Nusa Tenggara Tim.', '-8.433421', '119.963532');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kec_alt_kriteria`
--

CREATE TABLE `kec_alt_kriteria` (
  `id_alt_kriteria` int(11) NOT NULL,
  `f_id_alternatif` int(11) NOT NULL,
  `f_id_kriteria` char(3) NOT NULL,
  `f_id_sub_kriteria` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `kec_alt_kriteria`
--

INSERT INTO `kec_alt_kriteria` (`id_alt_kriteria`, `f_id_alternatif`, `f_id_kriteria`, `f_id_sub_kriteria`) VALUES
(13709, 598, 'C1', 79),
(13710, 598, 'C2', 83),
(13711, 598, 'C3', 88),
(13712, 598, 'C4', 91),
(13713, 598, 'C5', 96),
(13714, 598, 'C6', 102),
(13715, 599, 'C1', 79),
(13716, 599, 'C2', 82),
(13717, 599, 'C3', 89),
(13718, 599, 'C4', 91),
(13719, 599, 'C5', 96),
(13720, 599, 'C6', 101),
(13721, 600, 'C1', 80),
(13722, 600, 'C2', 82),
(13723, 600, 'C3', 88),
(13724, 600, 'C4', 91),
(13725, 600, 'C5', 96),
(13726, 600, 'C6', 101),
(13727, 601, 'C1', 79),
(13728, 601, 'C2', 83),
(13729, 601, 'C3', 89),
(13730, 601, 'C4', 92),
(13731, 601, 'C5', 96),
(13732, 601, 'C6', 102),
(13733, 602, 'C1', 79),
(13734, 602, 'C2', 83),
(13735, 602, 'C3', 88),
(13736, 602, 'C4', 93),
(13737, 602, 'C5', 96),
(13738, 602, 'C6', 102),
(13739, 603, 'C1', 79),
(13740, 603, 'C2', 85),
(13741, 603, 'C3', 87),
(13742, 603, 'C4', 93),
(13743, 603, 'C5', 96),
(13744, 603, 'C6', 102),
(13745, 604, 'C1', 79),
(13746, 604, 'C2', 83),
(13747, 604, 'C3', 87),
(13748, 604, 'C4', 93),
(13749, 604, 'C5', 96),
(13750, 604, 'C6', 103),
(13751, 605, 'C1', 79),
(13752, 605, 'C2', 83),
(13753, 605, 'C3', 89),
(13754, 605, 'C4', 94),
(13755, 605, 'C5', 96),
(13756, 605, 'C6', 101),
(13757, 606, 'C1', 79),
(13758, 606, 'C2', 84),
(13759, 606, 'C3', 88),
(13760, 606, 'C4', 94),
(13761, 606, 'C5', 97),
(13762, 606, 'C6', 103),
(13763, 607, 'C1', 80),
(13764, 607, 'C2', 82),
(13765, 607, 'C3', 88),
(13766, 607, 'C4', 91),
(13767, 607, 'C5', 96),
(13768, 607, 'C6', 102);

-- --------------------------------------------------------

--
-- Struktur dari tabel `kriteria`
--

CREATE TABLE `kriteria` (
  `id_kriteria` char(3) NOT NULL,
  `nama_kriteria` varchar(255) NOT NULL,
  `jenis_kriteria` enum('Cost','Benefit') NOT NULL,
  `bobot` decimal(11,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `kriteria`
--

INSERT INTO `kriteria` (`id_kriteria`, `nama_kriteria`, `jenis_kriteria`, `bobot`) VALUES
('C1', 'Akses Jalan Masuk', 'Benefit', '0.00'),
('C2', 'Fasilitas', 'Benefit', '0.00'),
('C3', 'Biaya Masuk', 'Cost', '0.00'),
('C4', 'Jarak', 'Cost', '0.00'),
('C5', 'Rating', 'Benefit', '0.00'),
('C6', 'Jumlah Pengunjung', 'Benefit', '0.00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `sub_kriteria`
--

CREATE TABLE `sub_kriteria` (
  `id_sub_kriteria` int(11) NOT NULL,
  `nama_sub_kriteria` varchar(255) NOT NULL,
  `spesifikasi` text DEFAULT NULL,
  `bobot_sub_kriteria` int(11) NOT NULL,
  `f_id_kriteria` char(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `sub_kriteria`
--

INSERT INTO `sub_kriteria` (`id_sub_kriteria`, `nama_sub_kriteria`, `spesifikasi`, `bobot_sub_kriteria`, `f_id_kriteria`) VALUES
(79, 'Akses Darat', '-', 2, 'C1'),
(80, 'Akses Laut', '-', 1, 'C1'),
(81, 'Sangat lengkap', 'Jika memenuhi ≥ 5  item dari fasilitas berikut ini: \r\nToilet, TIC, Fasilitas  sanitasi dan kebersihan, \r\nListrik, Fasilitas keamanan, Fasilitas Parkir, \r\nFasilitas ibadah', 4, 'C2'),
(82, 'Lengkap', 'Jika memenuhi 4 item dari fasilitas berikut ini: \r\nToilet, TIC, Fasilitas  sanitasi dan kebersihan, \r\nListrik, Fasilitas keamanan, Fasilitas Parkir, \r\nFasilitas ibadah', 4, 'C2'),
(83, 'Cukup lengkap', 'Jika memenuhi 3 item dari fasilitas berikut \r\nini:Toilet, TIC, Fasilitas  sanitasi dan kebersihan, \r\nListrik, Fasilitas keamanan, Fasilitas Parkir, \r\nFasilitas ibadah', 3, 'C2'),
(84, 'Kurang lengkap', 'Jika memenuhi 2 item dari fasilitas berikut ini: \r\nToilet, TIC, Fasilitas  sanitasi dan kebersihan, Listrik, Fasilitas keamanan, Fasilitas Parkir, \r\nFasilitas ibadah', 2, 'C2'),
(85, 'Tidak Lengkap', 'Jika memenuhi 1 item dari fasilitas berikut ini: \r\nToilet, TIC, Fasilitas  sanitasi dan kebersihan, \r\nListrik, Fasilitas keamanan, Fasilitas Parkir, \r\nFasilitas ibadah', 1, 'C2'),
(86, 'Sangat Murah', 'Rp. 0 - 10.000', 5, 'C3'),
(87, 'Murah', 'Rp. 11.000 - 25.000', 4, 'C3'),
(88, 'Cukup Murah', 'Rp. 26.000 - 50.000', 3, 'C3'),
(89, 'Mahal', 'Rp. 51.000 - 100.000', 2, 'C3'),
(90, 'Sangat Mahal', '> Rp.100.000', 1, 'C3'),
(91, 'Sangat dekat', '0 - 25 Km', 5, 'C4'),
(92, 'Dekat', '26 - 50 Km', 4, 'C4'),
(93, 'Sedang', '51 - 75 Km', 3, 'C4'),
(94, 'Jauh', '76 - 100 Km', 2, 'C4'),
(95, 'Sangat jauh', '> 100Km', 1, 'C4'),
(96, 'Sangat Baik', '4 sampai 5', 5, 'C5'),
(97, 'Baik', '3 sampai 4', 4, 'C5'),
(98, 'Cukup Baik', '2 sampai 3', 3, 'C5'),
(99, 'Buruk', '1 sampai 2', 2, 'C5'),
(100, 'Sangat Buruk', '0 sampai 1', 1, 'C5'),
(101, 'Banyak', '>100 orang', 3, 'C6'),
(102, 'Sedang', '50 - 100 Orang', 2, 'C6'),
(103, 'Sedikit', '<50 Orang', 1, 'C6');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indeks untuk tabel `alternatif`
--
ALTER TABLE `alternatif`
  ADD PRIMARY KEY (`id_alternatif`);

--
-- Indeks untuk tabel `kec_alt_kriteria`
--
ALTER TABLE `kec_alt_kriteria`
  ADD PRIMARY KEY (`id_alt_kriteria`),
  ADD KEY `f_id_alternatif` (`f_id_alternatif`),
  ADD KEY `f_id_sub_kriteria` (`f_id_sub_kriteria`),
  ADD KEY `f_id_kriteria` (`f_id_kriteria`);

--
-- Indeks untuk tabel `kriteria`
--
ALTER TABLE `kriteria`
  ADD PRIMARY KEY (`id_kriteria`);

--
-- Indeks untuk tabel `sub_kriteria`
--
ALTER TABLE `sub_kriteria`
  ADD PRIMARY KEY (`id_sub_kriteria`),
  ADD KEY `f_id_kriteria` (`f_id_kriteria`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `alternatif`
--
ALTER TABLE `alternatif`
  MODIFY `id_alternatif` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=608;

--
-- AUTO_INCREMENT untuk tabel `kec_alt_kriteria`
--
ALTER TABLE `kec_alt_kriteria`
  MODIFY `id_alt_kriteria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13769;

--
-- AUTO_INCREMENT untuk tabel `sub_kriteria`
--
ALTER TABLE `sub_kriteria`
  MODIFY `id_sub_kriteria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=104;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `kec_alt_kriteria`
--
ALTER TABLE `kec_alt_kriteria`
  ADD CONSTRAINT `kec_alt_kriteria_ibfk_3` FOREIGN KEY (`f_id_sub_kriteria`) REFERENCES `sub_kriteria` (`id_sub_kriteria`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `kec_alt_kriteria_ibfk_4` FOREIGN KEY (`f_id_alternatif`) REFERENCES `alternatif` (`id_alternatif`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `kec_alt_kriteria_ibfk_5` FOREIGN KEY (`f_id_kriteria`) REFERENCES `kriteria` (`id_kriteria`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `sub_kriteria`
--
ALTER TABLE `sub_kriteria`
  ADD CONSTRAINT `sub_kriteria_ibfk_1` FOREIGN KEY (`f_id_kriteria`) REFERENCES `kriteria` (`id_kriteria`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
