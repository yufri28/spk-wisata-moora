<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kontak extends CI_Controller
{
    public function index()
    {
        // Ambil semua data dari tabel kontak
        $dataKontak = $this->db->get('kontak')->result_array();
        $data = [
            'menu' => 'kontak',
            'dataKontak' => $dataKontak
        ];
        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/kontak');
        $this->load->view('admin/templates/footer');
    }

    public function delete()
    {
        $id_kontak = $this->input->post('id_kontak');
        $this->db->delete('kontak', ['id' => $id_kontak]);
        $this->session->set_flashdata('success', 'Pesan berhasil dihapus.');
        redirect('kontak');
    }
}