<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class InwardRegister_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    // Get all inward registers
    public function get_all_registers() {
        $this->db->where('is_deleted', 0);
        $this->db->order_by('created_at', 'DESC');
        $query = $this->db->get('inward_register');
        return $query->result_array();
    }

    // Get register by ID
    public function get_register_by_id($id) {
        $this->db->where('id', $id);
        $this->db->where('is_deleted', 0);
        $query = $this->db->get('inward_register');
        return $query->row_array();
    }

    // Add new inward register
    public function add_register($data) {
        return $this->db->insert('inward_register', $data);
    }

    // Update inward register
    public function update_register($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('inward_register', $data);
    }

    // Delete inward register (soft delete)
    public function delete_register($id) {
        $data = array('is_deleted' => 1);
        $this->db->where('id', $id);
        return $this->db->update('inward_register', $data);
    }

    // Get last unique ID number
    public function get_last_unique_id() {
        $this->db->select('unique_id');
        $this->db->where('is_deleted', 0);
        $this->db->order_by('id', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get('inward_register');
        
        if ($query->num_rows() > 0) {
            $row = $query->row_array();
            $unique_id = $row['unique_id'];
            // Extract number from format like "IR/1"
            $parts = explode('/', $unique_id);
            if (isset($parts[1])) {
                return (int)$parts[1];
            }
        }
        return 0;
    }
}
