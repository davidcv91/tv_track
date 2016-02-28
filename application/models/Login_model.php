<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Login_model extends CI_Model {

    public function check_user_password($username, $password) {
        $this->db->select('COUNT(1) AS count');
        $this->db->where('username', $username);
        $this->db->where('password', sha1($password));
        $result = $this->db->get('login');

        return (bool) $result->row()->count;
    }

    public function login_attempts($username, $password) {
        $data = array(
            'username' => $username,
            'password' => $password
        );
        $this->db->insert('login_attempts', $data);
    }

}
