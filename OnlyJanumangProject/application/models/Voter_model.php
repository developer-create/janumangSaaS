<?php
class Voter_model extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    // Get all voters
    public function get_voters() {
        $this->db->select('voter.*, block.name as block_name, booth.name as booth_name, booth.bnumber as booth_number, panchayat.name as panchayat_name, village.name as village_name');
        $this->db->from('voter');
        $this->db->join('block', 'block.id = voter.block_id', 'left');
        $this->db->join('booth', 'booth.id = voter.booth_id', 'left');
        $this->db->join('panchayat', 'panchayat.id = voter.panchayat_id', 'left');
        $this->db->join('village', 'village.id = voter.village_id', 'left');
        $this->db->order_by('voter.id', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }
    
    // Get all cast options
    public function get_cast_options() {
        $this->db->select('*');
        $this->db->from('cast_master');
        $this->db->where('status', 1);
        $this->db->order_by('cast_name', 'ASC');
        $query = $this->db->get();
        return $query->result_array();
    }
    
    // Get sub-cast options by cast ID
    public function get_sub_cast_options($cast_id = null) {
        $this->db->select('*');
        $this->db->from('sub_cast_master');
        $this->db->where('status', 1);
        if ($cast_id) {
            $this->db->where('cast_id', $cast_id);
        }
        $this->db->order_by('sub_cast_name', 'ASC');
        $query = $this->db->get();
        return $query->result_array();
    }

    // Get a single voter by ID
    public function get_voter($id) {
        $query = $this->db->get_where('voter', array('id' => $id));
        return $query->row_array();
    }

    // Insert a new voter
    public function create_voter($data) {
        if ($this->db->insert('voter', $data)) {
            return $this->db->insert_id();
        }
        return false;
    }

    // Update a voter
    public function update_voter($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('voter', $data);
    }

    // Delete a voter
    public function delete_voter($id) {
        return $this->db->delete('voter', array('id' => $id));
    }
}
?>

