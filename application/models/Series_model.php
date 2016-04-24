<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Series_model extends CI_Model {

    public function get_following() {
        $this->db->join('tracking_downloaded t', 's.id = t.id_serie', 'left');
        $this->db->where('status', 1);
        $this->db->order_by('day_new_episode', 'ASC');
        $query = $this->db->get('series s');

        if($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

    public function get_series() {
        $this->db->order_by('day_new_episode', 'ASC');
        $query = $this->db->get('series');
        if($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }


    public function increment_episode($id_serie) {
        $this->db->where('id_serie', $id_serie);
        $this->db->set('episode_downloaded', 'episode_downloaded+1', FALSE);
        $this->db->set('tstamp', date('Y-m-d H:i:s'));
        $this->db->set('next_episode_tstamp', NULL);
        return $this->db->update('tracking_downloaded');
    }

    public function postpone_episode($id_serie) {
        $this->db->where('id_serie', $id_serie);
        $this->db->set('next_episode_tstamp', date('Y-m-d H:i:s'));
        return $this->db->update('tracking_downloaded');
    }

    public function get_last_downloaded($id_serie) {
        $this->db->select('episode_downloaded');
        $this->db->where('id_serie', $id_serie);
        $result = $this->db->get('tracking_downloaded');
        return $result->row()->episode_downloaded;
    }

    public function exists_tracking($id_serie) {
        $this->db->select('COUNT(1) AS count');
        $this->db->where('id_serie', $id_serie);
        $result = $this->db->get('tracking_downloaded');

        return $result->row()->count;
    }

    public function start_tracking($id_serie) {
        $data = array(
            'id_serie' => $id_serie,
            'episode_downloaded' => 1,
        );
        return $this->db->insert('tracking_downloaded', $data);
    }

    public function edit_field_serie($id_serie, $field, $value) {
        $this->db->set($field, $value);
        $this->db->where('id', $id_serie);
        return $this->db->update('series');
    }

    public function add_serie($data) {
        return $this->db->insert('series', $data);
    }

    public function edit_serie($id_serie, $data) {
        $this->db->where('id', $id_serie);
        return $this->db->update('series', $data);
    }

    public function delete_serie($id_serie) {
        $this->db->where('id', $id_serie);
        return $this->db->delete('series');
    }
}
