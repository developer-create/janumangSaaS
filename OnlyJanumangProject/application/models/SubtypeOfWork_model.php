<?php
class SubtypeOfWork_model extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    // Get all subtype of work with work type name
    public function get_all_subtype_of_work() {
        $this->db->select('sow.*, wt.name as work_type_name');
        $this->db->from('subtype_of_work sow');
        $this->db->join('workType wt', 'wt.id = sow.work_type_id', 'left');
        $this->db->order_by('sow.id', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }

    // Get a single subtype of work by ID
    public function get_subtype_of_work($id) {
        $query = $this->db->get_where('subtype_of_work', array('id' => $id));
        return $query->row_array();
    }

    // Insert a new subtype of work
    public function create_subtype_of_work($data) {
        $this->db->insert('subtype_of_work', $data);
        return $this->db->insert_id();
    }

    // Update a subtype of work
    public function update_subtype_of_work($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('subtype_of_work', $data);
    }

    // Delete a subtype of work
    public function delete_subtype_of_work($id) {
        return $this->db->delete('subtype_of_work', array('id' => $id));
    }
}

