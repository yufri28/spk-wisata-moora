<?php
class Moora_model extends CI_Model
{
    public function get_alternatif()
    {
        return $this->db->get('alternatif')->result();
    }

    public function get_kriteria()
    {
        return $this->db->get('kriteria')->result();
    }

    public function get_kecocokan()
    {
        $this->db->select('kec_alt_kriteria.f_id_alternatif, kec_alt_kriteria.f_id_kriteria, sub_kriteria.bobot_sub_kriteria');
        $this->db->from('kec_alt_kriteria');
        $this->db->join('sub_kriteria', 'sub_kriteria.id_sub_kriteria = kec_alt_kriteria.f_id_sub_kriteria');
        $query = $this->db->get();

        $data = [];
        foreach ($query->result() as $row) {
            $data[$row->f_id_alternatif][$row->f_id_kriteria] = $row->bobot_sub_kriteria;
        }
        return $data;
    }
}