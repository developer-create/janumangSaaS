<?php
class District_model extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    // Get all districts
    public function get_districts() {
        $query = $this->db->get('district');
        return $query->result_array();
    }

    // Get a single district by ID
    public function get_district($id) {
        $query = $this->db->get_where('district', array('id' => $id));
        return $query->row_array();
    }

    // Insert a new district
    public function create_district($data) {
        return $this->db->insert('district', $data);
    }

    // Update a district
    public function update_district($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('district', $data);
    }

    // Delete a district
    public function delete_district($id) {
        return $this->db->delete('district', array('id' => $id));
    }
}
?>
