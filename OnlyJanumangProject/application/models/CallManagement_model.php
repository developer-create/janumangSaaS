<?php
class CallManagement_model extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    // Get all call management records
    public function get_all_calls() {
        $query = $this->db->get('call_management');
        return $query->result();
    }

    // Get a single call by ID
    public function get_call_by_id($id) {
        $query = $this->db->get_where('call_management', array('id' => $id));
        return $query->row();
    }

    // Insert a new call
    public function insert_call($data) {
        $this->db->insert('call_management', $data);
        return $this->db->insert_id();
    }

    // Update a call
    public function update_call($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('call_management', $data);
    }

    // Delete a call
    public function delete_call($id) {
        return $this->db->delete('call_management', array('id' => $id));
    }

    public function get_calls_by_category($category) {
        $this->db->select('*');
        $this->db->from('call_management');
        $this->db->where('category', $category);
        $this->db->where('status !=', 'Deleted');
        $this->db->order_by('date_time', 'DESC');
        $query = $this->db->get();
        return $query->result();
    }

    public function get_calls_by_date_range($start_date, $end_date) {
        $this->db->select('*');
        $this->db->from('call_management');
        $this->db->where('DATE(date_time) >=', $start_date);
        $this->db->where('DATE(date_time) <=', $end_date);
        $this->db->where('status !=', 'Deleted');
        $this->db->order_by('date_time', 'DESC');
        $query = $this->db->get();
        return $query->result();
    }

    public function get_pending_calls() {
        $this->db->select('*');
        $this->db->from('call_management');
        $this->db->where('assign_date >=', date('Y-m-d'));
        $this->db->where('status', 'Active');
        $this->db->order_by('assign_date', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }
}