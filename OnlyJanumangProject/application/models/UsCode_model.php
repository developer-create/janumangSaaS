<?php
class UsCode_model extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    // Get all US codes
    public function get_all_codes() {
        $this->db->select('*');
        $this->db->from('us_code');
        $this->db->where('status', 1);
        $this->db->order_by('code', 'ASC');
        $query = $this->db->get();
        return $query->result_array();
    }

    // Get code by ID
    public function get_code($id) {
        $query = $this->db->get_where('us_code', array('id' => $id));
        return $query->row_array();
    }

    // Create new code
    public function create_code($data) {
        return $this->db->insert('us_code', $data);
    }

    // Update code
    public function update_code($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('us_code', $data);
    }

    // Delete code (soft delete)
    public function delete_code($id) {
        $data = array('status' => 0);
        $this->db->where('id', $id);
        return $this->db->update('us_code', $data);
    }

    // Get all codes with pagination
    public function get_codes_paginated($limit, $offset) {
        $this->db->select('*');
        $this->db->from('us_code');
        $this->db->limit($limit, $offset);
        $this->db->order_by('code', 'ASC');
        $query = $this->db->get();
        return $query->result_array();
    }

    // Get total count
    public function get_total_count() {
        return $this->db->count_all('us_code');
    }
}
?>
