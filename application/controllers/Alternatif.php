<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Alternatif extends CI_Controller {

	public function index()
	{
        $dataAlternatif = $this->db->get('alternatif')->result_array();
		$dataKriteria = $this->db->get('kriteria')->result_array();
		$dataSubkriteria = $this->db->query("
			SELECT sub_kriteria.*, kriteria.nama_kriteria 
			FROM sub_kriteria 
			JOIN kriteria ON sub_kriteria.f_id_kriteria = kriteria.id_kriteria
		")->result_array();
        
        $data = [
			'menu' => 'alternatif',
            'dataKriteria' => $dataKriteria,
            'dataSubkriteria' => $dataSubkriteria,
            'dataAlternatif' => $dataAlternatif
        ];
		$this->load->view('admin/templates/header', $data);
		$this->load->view('admin/alternatif');
		$this->load->view('admin/templates/footer');
	}

	public function add()
	{
		$nama_alternatif = $this->input->post('nama_alternatif');
		$latitude = $this->input->post('latitude');
		$longitude = $this->input->post('longitude');
		$alamat = $this->input->post('alamat');

		$config['upload_path']   = FCPATH.'uploads/';
		$config['allowed_types'] = 'jpg|jpeg|png';
		$config['max_size']      = 2048;

		$this->load->library('upload', $config);

		if (!empty($_FILES['gambar']['name'])) {
			// Enkripsi nama file
			$ext = pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION);
			$encryptedName = md5(time() . $_FILES['gambar']['name']) . '.' . $ext;
			$_FILES['gambar']['name'] = $encryptedName;

			if (!$this->upload->do_upload('gambar')) {
				$this->session->set_flashdata('error', $this->upload->display_errors());
				redirect('alternatif');
				return;
			}

			$uploadData = $this->upload->data();
			$gambar = $uploadData['file_name'];
		} else {
			$gambar = null;
		}

		$this->db->insert('alternatif', [
			'nama_alternatif' => $nama_alternatif,
			'latitude' => $latitude,
			'longitude' => $longitude,
			'alamat' => $alamat,
			'gambar' => $gambar
		]);
		$id_alternatif = $this->db->insert_id();

		$dataKriteria = $this->db->get('kriteria')->result_array();
		foreach ($dataKriteria as $kriteria) {
			$id_kriteria = $kriteria['id_kriteria'];
			$id_subkriteria = $this->input->post(strtolower($id_kriteria));
			$this->db->insert('kec_alt_kriteria', [
				'f_id_alternatif' => $id_alternatif,
				'f_id_kriteria' => $id_kriteria,
				'f_id_sub_kriteria' => $id_subkriteria
			]);
		}

		$this->session->set_flashdata('success', 'Data berhasil ditambahkan.');
		redirect('alternatif');
	}

	public function edit($id)
	{
		if ($this->input->post()) {
			$nama_alternatif = $this->input->post('nama_alternatif');
			$latitude = $this->input->post('latitude');
			$longitude = $this->input->post('longitude');
			$alamat = $this->input->post('alamat');

			$data_update = [
				'nama_alternatif' => $nama_alternatif,
				'latitude' => $latitude,
				'longitude' => $longitude,
				'alamat' => $alamat
			];

			if (!empty($_FILES['gambar']['name'])) {
				$config['upload_path']   = FCPATH.'uploads/';
				$config['allowed_types'] = 'jpg|jpeg|png';
				$config['max_size']      = 2048;

				$this->load->library('upload', $config);

				$ext = pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION);
				$encryptedName = md5(time() . $_FILES['gambar']['name']) . '.' . $ext;
				$_FILES['gambar']['name'] = $encryptedName;

				if ($this->upload->do_upload('gambar')) {
					$uploadData = $this->upload->data();
					$data_update['gambar'] = $uploadData['file_name'];

					$lama = $this->db->get_where('alternatif', ['id_alternatif' => $id])->row();
					if ($lama && $lama->gambar && file_exists('./uploads/' . $lama->gambar)) {
						unlink('./uploads/' . $lama->gambar);
					}
				} else {
					$this->session->set_flashdata('error', $this->upload->display_errors());
					redirect('alternatif');
					return;
				}
			}

			$this->db->where('id_alternatif', $id)->update('alternatif', $data_update);

			$this->db->where('f_id_alternatif', $id)->delete('kec_alt_kriteria');
			$dataKriteria = $this->db->get('kriteria')->result_array();
			foreach ($dataKriteria as $kriteria) {
				$id_kriteria = $kriteria['id_kriteria'];
				$id_subkriteria = $this->input->post(strtolower($id_kriteria));
				$this->db->insert('kec_alt_kriteria', [
					'f_id_alternatif' => $id,
					'f_id_kriteria' => $id_kriteria,
					'f_id_sub_kriteria' => $id_subkriteria
				]);
			}

			$this->session->set_flashdata('success', 'Data berhasil diperbarui.');
			redirect('alternatif');
		}
	}

	public function delete()
	{
		$id = $this->input->post('id_alternatif');
		$alternatif = $this->db->get_where('alternatif', ['id_alternatif' => $id])->row();

		if ($alternatif && $alternatif->gambar && file_exists(FCPATH.'uploads/' . $alternatif->gambar)) {
			unlink(FCPATH.'uploads/' . $alternatif->gambar);
		}

		$this->db->where('f_id_alternatif', $id)->delete('kec_alt_kriteria');
		$this->db->where('id_alternatif', $id)->delete('alternatif');

		$this->session->set_flashdata('success', 'Data berhasil dihapus.');
		redirect('alternatif');
	}
}