<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Subkriteria extends CI_Controller
{
    public function index()
    {
        $dataKriteria = $this->db->query("SELECT * FROM kriteria")->result_array();
        $dataSubkriteria = $this->db->query("SELECT * FROM sub_kriteria JOIN kriteria ON sub_kriteria.f_id_kriteria = kriteria.id_kriteria")->result_array();
        
        $data = [
            'menu' => 'subkriteria',
            'dataKriteria' => $dataKriteria,
            'dataSubkriteria' => $dataSubkriteria
        ];
        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/subkriteria');
        $this->load->view('admin/templates/footer');
    }

    public function add()
    {
        $nama_sub_kriteria  = $this->input->post('nama_sub_kriteria');
        $bobot_sub_kriteria = $this->input->post('bobot_sub_kriteria');
        $spesifikasi = $this->input->post('spesifikasi');
        $f_id_kriteria      = $this->input->post('f_id_kriteria');

        $cek_nama = $this->db->get_where('sub_kriteria', [
            'nama_sub_kriteria' => $nama_sub_kriteria,
            'f_id_kriteria'     => $f_id_kriteria
        ])->num_rows();

        if ($cek_nama > 0) {
            $this->session->set_flashdata('error', 'Nama Sub Kriteria sudah ada.');
        } else {
            $this->db->insert('sub_kriteria', [
                'nama_sub_kriteria'  => $nama_sub_kriteria,
                'spesifikasi' => $spesifikasi,
                'bobot_sub_kriteria' => $bobot_sub_kriteria,
                'f_id_kriteria'      => $f_id_kriteria
            ]);
            $this->session->set_flashdata('success', 'Sub Kriteria berhasil ditambahkan.');
        }
        redirect('subkriteria');
    }

    public function update()
    {
        $id_sub_kriteria    = $this->input->post('id_sub_kriteria');
        $nama_sub_kriteria  = $this->input->post('nama_sub_kriteria');
        $spesifikasi  = $this->input->post('spesifikasi');
        $bobot_sub_kriteria = $this->input->post('bobot_sub_kriteria');
        $f_id_kriteria      = $this->input->post('f_id_kriteria');

        // Cek apakah nama_sub_kriteria sudah dipakai oleh entri lain
        $cek_nama = $this->db->where('nama_sub_kriteria', $nama_sub_kriteria)
                             ->where('f_id_kriteria', $f_id_kriteria)
                             ->where('id_sub_kriteria !=', $id_sub_kriteria)
                             ->get('sub_kriteria')->num_rows();

        if ($cek_nama > 0) {
            $this->session->set_flashdata('error', 'Nama Sub Kriteria sudah digunakan oleh entri lain.');
        } else {
            $this->db->where('id_sub_kriteria', $id_sub_kriteria)->update('sub_kriteria', [
                'nama_sub_kriteria'  => $nama_sub_kriteria,
                'spesifikasi'  => $spesifikasi,
                'bobot_sub_kriteria' => $bobot_sub_kriteria,
                'f_id_kriteria'      => $f_id_kriteria
            ]);
            $this->session->set_flashdata('success', 'Sub Kriteria berhasil diupdate.');
        }

        redirect('subkriteria');
    }

    public function delete()
    {
        $id_sub_kriteria = $this->input->post('id_sub_kriteria');
        $this->db->delete('sub_kriteria', ['id_sub_kriteria' => $id_sub_kriteria]);
        $this->session->set_flashdata('success', 'Sub Kriteria berhasil dihapus.');
        redirect('subkriteria');
    }
}