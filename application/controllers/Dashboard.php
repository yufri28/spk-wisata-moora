<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public function index()
	{
		$data = [
			'menu' => 'beranda',
        ];

		$this->load->view('admin/templates/header', $data);
		$this->load->view('admin/index');
		$this->load->view('admin/templates/footer');
	}
}