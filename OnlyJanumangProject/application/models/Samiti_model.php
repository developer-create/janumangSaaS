<?php
class Samiti_model extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    // Get all samitis with optional filters
    public function get_samitis($block_id = null, $year = null, $month = null) {
        $this->db->select('s.*, b.name as block_name');
        $this->db->from('samiti s');
        $this->db->join('block b', 'b.id = s.block_id', 'left');
        
        // Apply filters
        if (!empty($block_id)) {
            $this->db->where('s.block_id', $block_id);
        }
        if (!empty($year)) {
            $this->db->where('s.year', $year);
        }
        if (!empty($month)) {
            $this->db->where('s.month', $month);
        }
        
        $this->db->order_by('s.id', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }

    // Get a single samiti by ID
    public function get_samiti($id) {
        $this->db->select('s.*, b.name as block_name');
        $this->db->from('samiti s');
        $this->db->join('block b', 'b.id = s.block_id', 'left');
        $this->db->where('s.id', $id);
        $query = $this->db->get();
        return $query->row_array();
    }

    // Insert a new samiti
    public function create_samiti($data) {
        return $this->db->insert('samiti', $data);
    }

    // Update a samiti
    public function update_samiti($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('samiti', $data);
    }

    // Delete a samiti
    public function delete_samiti($id) {
        return $this->db->delete('samiti', array('id' => $id));
    }

    // Get all blocks for filter dropdown
    public function get_blocks() {
        $query = $this->db->get('block');
        return $query->result_array();
    }
}
?>
