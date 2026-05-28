<?php
class Worktype_model extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    // Get all worktypes
    public function get_worktypes() {
         $this->db->order_by('id', 'DESC');
        $query = $this->db->get('workType');
        return $query->result_array();
    }

    // Get a single worktype by ID
    public function get_worktype($id) {
        $query = $this->db->get_where('workType', array('id' => $id));
        return $query->row_array();
    }

    // Insert a new worktype
    public function create_worktype($data) {
        return $this->db->insert('workType', $data);
    }

    // Update a worktype
    public function update_worktype($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('workType', $data);
    }

    // Delete a worktype
    public function delete_worktype($id) {
        return $this->db->delete('workType', array('id' => $id));
    }
}
?>
