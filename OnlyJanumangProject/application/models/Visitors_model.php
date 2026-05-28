<?php
class Visitors_model extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    // Get all visitors with optional filters
    public function get_visitors($filters = array()) {
    // $blockid = $this->session->userdata('blockId');

    // if ($blockid != 0) {
    //     // Convert the comma-separated string into an array
    //     $blockid_array = explode(',', $blockid);
 
    //     // Apply the where_in condition before executing the query
    //     $this->db->where_in('visitors.block', $blockid_array);
    // }

    // Apply filters if provided
    if (!empty($filters['year'])) {
        $this->db->where('YEAR(visitors.date)', $filters['year']);
    }
    
    if (!empty($filters['month'])) {
        $this->db->where('MONTH(visitors.date)', $filters['month']);
    }

    if (!empty($filters['date'])) {
        $this->db->where('DATE(visitors.date)', $filters['date']);
    }

    if (!empty($filters['district'])) {
        $this->db->where('LOWER(visitors.district)', strtolower($filters['district']));
    }

    if (!empty($filters['vidhan_sabha'])) {
        $this->db->where('LOWER(visitors.vidhan_sabha)', strtolower($filters['vidhan_sabha']));
    }

    if (!empty($filters['block'])) {
        $this->db->where('LOWER(visitors.block)', strtolower($filters['block']));
    }

    $this->db->order_by('visitors.date', 'DESC');
    $query = $this->db->get('visitors');
    return $query->result_array();
}

    // Get all districts from district table
    public function get_all_districts() {
        $this->db->select('id, name');
        $this->db->from('district');
        $this->db->order_by('name', 'ASC');
        $query = $this->db->get();
        return $query->result_array();
    }

    // Get vidhan sabhas by district
    public function get_vidhan_sabhas_by_district($district_id) {
        if (empty($district_id)) {
            return array();
        }
        $this->db->select('id, vidhan_sabha_name');
        $this->db->from('vidhan_sabha');
        $this->db->where('district_id', $district_id);
        $this->db->order_by('vidhan_sabha_name', 'ASC');
        $query = $this->db->get();
        return $query->result_array();
    }

   

   

    // Get a single visitor by ID
    public function get_visitor($id) {
        $query = $this->db->get_where('visitors', array('id' => $id));
        return $query->row_array();
    }

    // Insert a new visitor
    public function create_visitor($data) {
        return $this->db->insert('visitors', $data);
    }

    // Update a visitor
    public function update_visitor($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('visitors', $data);
    }

    // Delete a visitor
    public function delete_visitor($id) {
        return $this->db->delete('visitors', array('id' => $id));
    }
}
?>
