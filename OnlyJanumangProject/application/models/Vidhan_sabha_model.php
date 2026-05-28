<?php
class Vidhan_sabha_model extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    // Get all vidhan sabha records (with district name)
    public function get_vidhan_sabhas() {
        $this->db->select('vs.id, vs.vidhan_sabha_name, vs.district_id, vs.created_by, vs.added_by, vs.created_time, vs.updated_time, vs.year, d.name as district_name, u1.name as created_by_name, u2.name as added_by_name');
        $this->db->from('vidhan_sabha vs');
        $this->db->join('district d', 'd.id = vs.district_id', 'left');
        $this->db->join('tbl_users u1', 'vs.created_by = u1.userId', 'left');
        $this->db->join('tbl_users u2', 'vs.added_by = u2.userId', 'left');
        $this->db->order_by('vs.id', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }

    // Get vidhan sabhas by district_id (for dropdown when district is selected)
    public function get_vidhan_sabhas_by_district($district_id) {
        if (empty($district_id)) {
            return array();
        }
        $this->db->select('id, vidhan_sabha_name, district_id');
        $this->db->from('vidhan_sabha');
        $this->db->where('district_id', $district_id);
        $this->db->order_by('vidhan_sabha_name', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }

    // Get a single vidhan sabha by ID
    public function get_vidhan_sabha($id) {
        $this->db->select('vs.*, d.name as district_name, u1.name as created_by_name, u2.name as added_by_name');
        $this->db->from('vidhan_sabha vs');
        $this->db->join('district d', 'd.id = vs.district_id', 'left');
        $this->db->join('tbl_users u1', 'vs.created_by = u1.userId', 'left');
        $this->db->join('tbl_users u2', 'vs.added_by = u2.userId', 'left');
        $this->db->where('vs.id', $id);
        $query = $this->db->get();
        return $query->row_array();
    }

    // Insert a new vidhan sabha
    public function create_vidhan_sabha($data) {
        return $this->db->insert('vidhan_sabha', $data);
    }

    // Update a vidhan sabha
    public function update_vidhan_sabha($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('vidhan_sabha', $data);
    }

    // Delete a vidhan sabha
    public function delete_vidhan_sabha($id) {
        return $this->db->delete('vidhan_sabha', array('id' => $id));
    }

}
?>
