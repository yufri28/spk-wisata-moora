<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kriteria extends CI_Controller
{
    public function index()
    {
        $dataKriteria = $this->db->query("SELECT * FROM kriteria")->result_array();
        $data = [
            'menu' => 'kriteria',
            'dataKriteria' => $dataKriteria
        ];
        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/kriteria');
        $this->load->view('admin/templates/footer');
    }

    public function add()
    {
        $kode_kriteria = $this->input->post('kode_kriteria');
        $nama_kriteria = $this->input->post('nama_kriteria');
        $jenis_kriteria = $this->input->post('jenis_kriteria');

        // Cek duplikasi
        $cek = $this->db->get_where('kriteria', [
            'id_kriteria' => $kode_kriteria
        ])->num_rows();

        $cek_nama = $this->db->get_where('kriteria', [
            'nama_kriteria' => $nama_kriteria
        ])->num_rows();

        if ($cek > 0 || $cek_nama > 0) {
            $this->session->set_flashdata('error', 'Kode atau Nama Kriteria sudah ada.');
        } else {
            $this->db->insert('kriteria', [
                'id_kriteria' => $kode_kriteria,
                'nama_kriteria' => $nama_kriteria,
                'jenis_kriteria' => $jenis_kriteria
            ]);
            $this->session->set_flashdata('success', 'Kriteria berhasil ditambahkan.');
        }
        redirect('kriteria');
    }

    public function update()
    {
        $id_kriteria    = $this->input->post('kode_kriteria'); // Sama dengan kode_kriteria
        $nama_kriteria  = $this->input->post('nama_kriteria');
        $jenis_kriteria = $this->input->post('jenis_kriteria');

        // Cek apakah id_kriteria (kode) sudah dipakai oleh entri lain
        $cek_id = $this->db->where('id_kriteria', $id_kriteria)
                        ->get('kriteria')->num_rows();

        // Cek apakah nama_kriteria sudah dipakai oleh entri lain
        $cek_nama = $this->db->where('nama_kriteria', $nama_kriteria)
                            ->where('id_kriteria !=', $id_kriteria)
                            ->get('kriteria')->num_rows();

        if ($cek_id == 0) {
            $this->session->set_flashdata('error', 'ID/Kode Kriteria tidak ditemukan.');
        } elseif ($cek_nama > 0) {
            $this->session->set_flashdata('error', 'Nama Kriteria sudah digunakan oleh entri lain.');
        } else {
            $this->db->where('id_kriteria', $id_kriteria)->update('kriteria', [
                'nama_kriteria'  => $nama_kriteria,
                'jenis_kriteria' => $jenis_kriteria
            ]);
            $this->session->set_flashdata('success', 'Kriteria berhasil diupdate.');
        }

        redirect('kriteria');
    }


    public function delete()
    {
        $id_kriteria = $this->input->post('id_kriteria');
        $this->db->delete('kriteria', ['id_kriteria' => $id_kriteria]);
        $this->session->set_flashdata('success', 'Kriteria berhasil dihapus.');
        redirect('kriteria');
    }
}