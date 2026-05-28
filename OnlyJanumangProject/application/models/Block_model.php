<?php
class Block_model extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    // Get all blocks with district information
    public function get_blocks() {
        $this->db->select('block.*, district.name as district_name');
        $this->db->from('block');
        $this->db->join('district', 'district.id = block.district_id', 'left');
        $this->db->order_by('block.id', 'desc');
        $query = $this->db->get();
        return $query->result_array();
    }

    // Get a single block by ID with district information
    public function get_block($id) {
        $this->db->select('block.*, district.name as district_name');
        $this->db->from('block');
        $this->db->join('district', 'district.id = block.district_id', 'left');
        $this->db->where('block.id', $id);
        $query = $this->db->get();
        return $query->row_array();
    }

    // Insert a new block
    public function create_block($data) {
        return $this->db->insert('block', $data);
    }

    // Update a block
    public function update_block($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('block', $data);
    }

    // Delete a block
    public function delete_block($id) {
        return $this->db->delete('block', array('id' => $id));
    }

    // Get all districts for dropdown
    public function get_districts() {
        $query = $this->db->get('district');
        return $query->result_array();
    }
}
?>
