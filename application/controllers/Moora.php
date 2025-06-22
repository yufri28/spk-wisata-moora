<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Moora extends CI_Controller {

    public function index() {

        $bobot_kriteria = $this->input->post('bobot');
        // Misal koordinat user (bisa dari POST atau fixed)
        $userLat = $this->input->post('userLat');
        $userLng = $this->input->post('userLng');
        
        $pengunjung = $this->input->post('pengunjung');
        
        // Gunakan default jika tidak ada input
        $userLat = $userLat !== null ? floatval($userLat) : -10.1646336;
        $userLng = $userLng !== null ? floatval($userLng) : 123.6271104;

        // Validasi bahwa hasil akhir adalah angka
        if (!is_numeric($userLat) || !is_numeric($userLng)) {
            die("Koordinat user tidak tersedia atau tidak valid.");
        }

        if (empty($bobot_kriteria)) {
            echo "<script>
                alert('Silakan isi semua bobot kriteria sebelum melanjutkan.');
                window.location.href = '" . base_url('pages/rekomendasi') . "';
            </script>";
            exit; // menghentikan proses selanjutnya
        }

        // Ambil semua sub_kriteria C4 (rule jarak)
        $subKriteriaC4 = [];
        $subKriteriaC4 = $this->db
            ->where('f_id_kriteria', 'C4')
            ->get('sub_kriteria')
            ->result_array();

        // 1. Ambil data
        $data['alternatif'] = $this->db->get('alternatif')->result();
        $data['kriteria']   = $this->db->get('kriteria')->result();
        $arr_kriteria   = $this->db->get('kriteria')->result_array();

        // Ambil bobot sub-kriteria untuk tiap alternatif dan kriteria
        $this->db->select('kec_alt_kriteria.f_id_alternatif, kec_alt_kriteria.f_id_kriteria, sub_kriteria.bobot_sub_kriteria');
        $this->db->from('kec_alt_kriteria');
        $this->db->join('sub_kriteria', 'kec_alt_kriteria.f_id_sub_kriteria = sub_kriteria.id_sub_kriteria');
        $query = $this->db->get()->result();

        // Hitung jarak realtime tiap alternatif ke lokasi user
        $jarakRealtime = [];
        foreach ($data['alternatif'] as $idAlt => $dataAlt) {
            if (!empty($dataAlt->latitude) && !empty($dataAlt->longitude)) {
                $jarakRealtime[$dataAlt->id_alternatif] = round($this->hitungJarakKm($userLat, $userLng, $dataAlt->latitude, $dataAlt->longitude), 2);
            } else {
                $jarakRealtime[$dataAlt->id_alternatif] = null; // data koordinat alternatif kosong
            }
        }

        // 2. Matriks Keputusan: nilai[alternatif][kriteria] = bobot_sub_kriteria
        $nilai = [];
        foreach ($query as $row) {
            $nilai[$row->f_id_alternatif][$row->f_id_kriteria] = $row->bobot_sub_kriteria;
        }

        // Ubah bobot sub kriteria jarak
        if($data['kriteria'][3]->id_kriteria){
            // Update nilai C4 pada $nilai berdasarkan jarak realtime dan rule sub_kriteria
            foreach ($jarakRealtime as $idAlt => $jarak) {
                if ($jarak === null) continue;
                $subTerpilih = $this->cariSubKriteriaByJarak($jarak, $subKriteriaC4);
                if ($subTerpilih) {
                    $nilai[$idAlt]['C4'] = $subTerpilih['bobot_sub_kriteria'];
                } else {
                    // fallback jika tidak cocok rule, bisa set 0 atau nilai default
                    $nilai[$idAlt]['C4'] = 0;
                }
            }
        }

        // Ubah jenis kriteria dari jumlah pengunjung
        if($data['kriteria'][5]->jenis_kriteria){
            $data['kriteria'][5]->jenis_kriteria = $pengunjung == 'Tidak'?'Cost':'Benefit';
        }

        $proses = [];

        // ✅ (1) Bobot Kriteria (dari sub_kriteria)
        $bobot = [];
        foreach ($data['kriteria'] as $kri) {
            // Ambil bobot tertinggi (atau bisa rata-rata, tergantung skema)
            $this->db->select_avg('bobot_sub_kriteria');
            $this->db->where('f_id_kriteria', $kri->id_kriteria);
            $avg = $this->db->get('sub_kriteria')->row()->bobot_sub_kriteria;
            $bobot[$kri->id_kriteria] = $avg;
        }
        
        foreach ($data['kriteria'] as $krit) {
            $bobot[$krit->id_kriteria] = $bobot_kriteria[$krit->id_kriteria]/100;
        }
        // $bobot = [0.25, 0.2, 0.15, 0.15, 0.15, 0.1];
        
        $proses['bobot_kriteria'] = $bobot;

        // ✅ (2) Matriks Keputusan
        $proses['matriks_keputusan'] = $nilai;

        // ✅ (3) Normalisasi Matriks
        $normalisasi = [];
        $denominator = [];

        foreach ($data['kriteria'] as $kri) {
            $sum = 0;
            foreach ($data['alternatif'] as $alt) {
                $val = $nilai[$alt->id_alternatif][$kri->id_kriteria] ?? 0;
                $sum += pow($val, 2);
            }
            $denominator[$kri->id_kriteria] = sqrt($sum);
        }

        foreach ($data['alternatif'] as $alt) {
            foreach ($data['kriteria'] as $kri) {
                $val = $nilai[$alt->id_alternatif][$kri->id_kriteria] ?? 0;
                $norm = $denominator[$kri->id_kriteria] != 0 ? $val / $denominator[$kri->id_kriteria] : 0;
                $normalisasi[$alt->id_alternatif][$kri->id_kriteria] = $norm;
            }
        }

        $proses['normalisasi'] = $normalisasi;

        // ✅ (4) Hitung Optimalisasi Atribut
        $optimalisasi_atribut = [];
        foreach ($data['alternatif'] as $alt) {
            foreach ($data['kriteria'] as $kri) {
                $optimalisasi_atribut[$alt->id_alternatif][$kri->id_kriteria] = $normalisasi[$alt->id_alternatif][$kri->id_kriteria] * $bobot[$kri->id_kriteria];
            }
        }

        $proses['optimalisasi_atribut'] = $optimalisasi_atribut;


        // ✅ (5) Hitung Nilai Yi (𝑦𝑖)
        $yi = [];
        foreach ($data['alternatif'] as $alt) {
            $benefit = 0;
            $cost = 0;
            foreach ($data['kriteria'] as $kri) {
                $norm = $optimalisasi_atribut[$alt->id_alternatif][$kri->id_kriteria] ?? 0;
                $bobot_kri = $bobot[$kri->id_kriteria] ?? 1;

                if ($kri->jenis_kriteria == 'Benefit') {
                    $benefit += $norm;
                } else {
                    $cost += $norm;
                }
                
            }
            
            $yi[$alt->id_alternatif] = $benefit - $cost;

        }
        
        $proses['nilai_yi'] = $yi;

        // ✅ (6) Perangkingan
        arsort($yi);
        
        $ranking = [];
        $rank = 1;
        foreach ($yi as $id => $nilaiYi) {
            $alt = array_values(array_filter($data['alternatif'], fn($a) => $a->id_alternatif == $id))[0];
            $ranking[] = [
                'id' => $id,
                'nama' => $alt->nama_alternatif,
                'gambar' => $alt->gambar, // pastikan field ini ada di tabel
                'latitude' => $alt->latitude, // pastikan field ini ada di tabel
                'longitude' => $alt->longitude, // pastikan field ini ada di tabel
                'yi' => round($nilaiYi, 3),
                'peringkat' => $rank++
            ];
        }

        $proses['ranking'] = $ranking;

        // Kirim ke view
        $data['proses'] = $proses;
        $data['listKriteria'] = $arr_kriteria;
        $data['menu'] = 'rekomendasi';
        
        $this->load->view('pages/templates/header', $data);
		$this->load->view('pages/hasil_rekomendasi');
		$this->load->view('pages/templates/footer');
    }
    
    // Fungsi hitung jarak Haversine (dalam km)
    public function hitungJarakKm($lat1, $lon1, $lat2, $lon2) {
        $radius = 6371; // km
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat/2) * sin($dLat/2) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
            sin($dLon/2) * sin($dLon/2);
        $c = 2 * atan2(sqrt($a), sqrt(1-$a));
        return $radius * $c;
    }

    // Fungsi cari sub_kriteria sesuai jarak
    public function cariSubKriteriaByJarak($jarak, $subKriteriaC4) {
        foreach ($subKriteriaC4 as $sub) {
            $spec = $sub['spesifikasi'];

            // Cek pola spesifikasi
            if (preg_match('/≤\s*(\d+)/', $spec, $m)) {
                $max = (float)$m[1];
                if ($jarak <= $max) return $sub;
            } elseif (preg_match('/>\s*(\d+)\s*-\s*≤\s*(\d+)/', $spec, $m)) {
                $min = (float)$m[1];
                $max = (float)$m[2];
                if ($jarak > $min && $jarak <= $max) return $sub;
            } elseif (preg_match('/>\s*(\d+)\s*Km/', $spec, $m)) {
                $min = (float)$m[1];
                if ($jarak > $min) return $sub;
            }
        }
        return null;
    }

}