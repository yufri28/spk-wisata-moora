<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AuthModel extends CI_Model {

    public function get_user_by_username($username) {
        return $this->db->get_where('admin', ['username' => $username])->row_array();
    }
    
    public function get_user() {
        $this->db->where('username !=', 'admin');
        $query = $this->db->get('admin');
        return $query->result_array();
    }

    public function add_default_admin() {
        $data = array(
            'username' => 'admin',
            'password' => password_hash("admin", PASSWORD_DEFAULT),
        );
        $this->db->insert('admin', $data);
    }

    public function cek_default_admin() {
        $get_data = $this->db->get_where('admin', ['username' => 'admin'])->num_rows();
        return $get_data > 0;
    }
}