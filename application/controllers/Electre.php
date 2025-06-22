<?php
class Electre extends CI_Controller
{
    public function index()
    {
        $bobot_kriteria = $this->input->post('bobot');

        if (empty($bobot_kriteria)) {
            echo "<script>
                alert('Silakan isi semua bobot kriteria sebelum melanjutkan.');
                window.location.href = '" . base_url('pages/rekomendasi') . "';
            </script>";
            exit; // menghentikan proses selanjutnya
        }

        $dataAlternatif = $this->db->get('alternatif')->result();
        $dataKriteria = $this->db->get('kriteria')->result();
        $listKriteria = $this->db->get('kriteria')->result_array();

        $X = [];
        foreach ($dataAlternatif as $alt) {
            $row = [];
            foreach ($dataKriteria as $krit) {
                $nilai = $this->db->select('sk.bobot_sub_kriteria AS nilai')
                    ->from('kec_alt_kriteria kak')
                    ->join('sub_kriteria sk', 'sk.id_sub_kriteria = kak.f_id_sub_kriteria')
                    ->where('kak.f_id_alternatif', $alt->id_alternatif)
                    ->where('kak.f_id_kriteria', $krit->id_kriteria)
                    ->get()->row();
                $row[$krit->id_kriteria] = $nilai ? $nilai->nilai : 0;
            }
            $X[$alt->id_alternatif] = $row;
        }

        // Normalisasi Matriks Keputusan
        $R = [];
        foreach ($dataKriteria as $krit) {
            $id_krit = $krit->id_kriteria;
            $column = array_column($X, $id_krit);
            if ($krit->jenis_kriteria == 'Cost') {
                $maxVal = max($column);
                foreach ($X as $id_alt => $row) {
                    $R[$id_alt][$id_krit] = $maxVal / ($row[$id_krit] ?: 1);
                }
            } else {
                $denom = sqrt(array_sum(array_map(fn($v) => pow($v, 2), $column)));
                foreach ($X as $id_alt => $row) {
                    $R[$id_alt][$id_krit] = $row[$id_krit] / ($denom ?: 1);
                }
            }
        }

        // Matriks Terbobot V
        $bobot = [];
        // foreach ($dataKriteria as $krit) {
        //     $bobot[$krit->id_kriteria] = $krit->bobot;
        // }
        foreach ($dataKriteria as $krit) {
            $bobot[$krit->id_kriteria] = $bobot_kriteria[$krit->id_kriteria]/100;
        }

        $V = [];
        foreach ($R as $id_alt => $row) {
            foreach ($row as $id_krit => $val) {
                $V[$id_alt][$id_krit] = $val * $bobot[$id_krit];
            }
        }

        $alt_ids = array_keys($V);
        $n = count($alt_ids);

        // Matriks Concordance dan Discordance
        $C = $D = [];
        for ($i = 0; $i < $n; $i++) {
            for ($j = 0; $j < $n; $j++) {
                if ($i == $j) continue;

                $alt_i = $alt_ids[$i];
                $alt_j = $alt_ids[$j];

                $C_set = [];
                $D_num = 0;
                $D_denom = 0;
                foreach ($V[$alt_i] as $id_krit => $v_i) {
                    $v_j = $V[$alt_j][$id_krit];
                    if ($v_i >= $v_j) {
                        $C_set[] = $bobot[$id_krit];
                    }
                    $diff = abs($v_i - $v_j);
                    $D_num = max($D_num, $diff);
                    $D_denom = max($D_denom, $diff);
                }

                $C[$alt_i][$alt_j] = array_sum($C_set);
                $D[$alt_i][$alt_j] = $D_denom > 0 ? $D_num / $D_denom : 0;
            }
        }

        // Threshold C dan D
        $C_avg = array_sum(array_map('array_sum', $C)) / ($n * ($n - 1));
        $D_avg = array_sum(array_map('array_sum', $D)) / ($n * ($n - 1));

        // Matriks Dominan Concordance dan Discordance
        $F = [];
        for ($i = 0; $i < $n; $i++) {
            for ($j = 0; $j < $n; $j++) {
                if ($i == $j) continue;
                $a = $alt_ids[$i];
                $b = $alt_ids[$j];
                $F[$a][$b] = ($C[$a][$b] >= $C_avg && $D[$a][$b] <= $D_avg) ? 1 : 0;
            }
        }

        // Ranking berdasarkan jumlah dominasi
        $ranking = [];
        foreach ($F as $id_alt => $rows) {
            $ranking[$id_alt] = array_sum($rows);
        }
        arsort($ranking);

        $infoAlternatif = [];
        foreach ($dataAlternatif as $alt) {
            $infoAlternatif[$alt->id_alternatif] = [
                'nama' => $alt->nama_alternatif,
                'gambar' => $alt->gambar,
                'alamat' => $alt->alamat,
                'latitude' => $alt->latitude,
                'longitude' => $alt->longitude
            ];
        }

        $matix_X = [];
        foreach ($dataAlternatif as $alt) {
            $matix_X[$alt->id_alternatif] = [
                'nama' => $alt->nama_alternatif
            ];
        }
        
        $matrix_R = [];
        foreach ($dataAlternatif as $alt) {
            $matrix_R[$alt->id_alternatif] = [
                'nama' => $alt->nama_alternatif
            ];
        }

        $matrix_V = [];
        foreach ($dataAlternatif as $alt) {
            $matrix_V[$alt->id_alternatif] = [
                'nama' => $alt->nama_alternatif
            ];
        }


        $data = [
            'matriks_X' => $X,
            'matriks_R' => $R,
            'matriks_V' => $V,
            'concordance' => $C,
            'discordance' => $D,
            'threshold_C' => $C_avg,
            'threshold_D' => $D_avg,
            'dominasi' => $F,
            'ranking' => $ranking,
            'bobot_kriteria' => $bobot_kriteria,
            'info_alternatif' => $infoAlternatif,
            'listKriteria' => $listKriteria,
			'menu' => 'rekomendasi'
        ];

        // $this->load->view('electre_hasil', $data);
        

        // foreach ($data['matriks_X'] as $key => $value) {
        //     foreach ($value as $key => $values) {
        //         echo $values." ";
        //     }
        //     echo "</br>";
        // }
        // foreach ($data['matriks_R'] as $key => $value) {
        //     foreach ($value as $key => $values) {
        //         echo $values." ";
        //     }
        //     echo "</br>";
        // }
        // echo "</br>";
        // foreach ($data['matriks_V'] as $key => $value) {
        //     foreach ($value as $key => $values) {
        //         echo $values." ";
        //     }
        //     echo "</br>";
        // }
        // echo "</br>";
        // foreach ($data['concordance'] as $key => $value) {
        //     foreach ($value as $key => $values) {
        //         echo $values." ";
        //     }
        //     echo "</br>";
        // }
        // echo "</br>";
        // foreach ($data['discordance'] as $key => $value) {
        //     foreach ($value as $key => $values) {
        //         echo $values." ";
        //     }
        //     echo "</br>";
        // }
        // echo "</br>";
        // foreach ($data['dominasi'] as $key => $value) {
        //     foreach ($value as $key => $values) {
        //         echo $values." ";
        //     }
        //     echo "</br>";
        // }
        // echo "</br>";
        // $i = 1;
        // foreach ($data['ranking'] as $key => $value) {
        //     echo $i++.'. ';
        //     echo $key.' - '.$value;
        //     echo "</br>";
        // }
        
        // foreach ($ranking as $id => $score){
        //     echo "<tr>
        //         <td>". $infoAlternatif[$id]['nama']."</td>
        //         <td>". $score ."</td>
        //     </tr> </br>";
        // }        
        
		$this->load->view('pages/templates/header', $data);
		$this->load->view('pages/hasil_rekomendasi');
		$this->load->view('pages/templates/footer');
    }
}