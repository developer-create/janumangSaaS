<?php
class panchayat_model extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    // Get all panchayats
public function get_panchayats() {
    $this->db->select('panchayat.*, block.name as block_name, booth.name as booth_name, booth.year'); // Select columns from all tables
    $this->db->from('panchayat');
    $this->db->join('block', 'block.id = panchayat.blockid', 'left'); // Join block table on blockid
    $this->db->join('booth', 'booth.id = panchayat.boothid', 'left'); // Join booth table on boothid
    $query = $this->db->get();
    return $query->result_array();
}


    // Get a single panchayat by ID
    public function get_panchayat($id) {
        $query = $this->db->get_where('panchayat', array('id' => $id));
        return $query->row_array();
    }

    // Insert a new panchayat
    public function create_panchayat($data) {
        return $this->db->insert('panchayat', $data);
    }

    // Update a panchayat
    public function update_panchayat($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('panchayat', $data);
    }

    // Delete a panchayat
    public function delete_panchayat($id) {
        return $this->db->delete('panchayat', array('id' => $id));
    }

    // Get panchayats by block ID
    public function get_panchayats_by_block($block_id) {
        $this->db->select('*');
        $this->db->from('panchayat');
        $this->db->where('blockid', $block_id);
        $query = $this->db->get();
        return $query->result_array();
    }

    // Get panchayats with filters (block and year)
    public function get_panchayats_filtered($block_id = null, $year = null) {
        $this->db->select('panchayat.*, block.name as block_name, booth.name as booth_name, booth.year');
        $this->db->from('panchayat');
        $this->db->join('block', 'block.id = panchayat.blockid', 'left');
        $this->db->join('booth', 'booth.id = panchayat.boothid', 'left');
        
        // Apply block filter if provided
        if (!empty($block_id) && $block_id != 'all') {
            $this->db->where('panchayat.blockid', $block_id);
        }
        
        // Apply year filter if provided
        if (!empty($year) && $year != 'all') {
            $this->db->where('booth.year', $year);
        }
        
        $this->db->order_by('panchayat.id', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }

    // Get distinct years from booth table
    public function get_years() {
        $this->db->distinct();
        $this->db->select('booth.year');
        $this->db->from('booth');
        $this->db->where('booth.year IS NOT NULL', null, false);
        $this->db->order_by('booth.year', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }
}
