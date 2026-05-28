<?php
class Mp_vidhan_sabha_member_model extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    // Get all MP Vidhan Sabha Member records
    public function get_members() {
        $this->db->select('m.*, d.name as district_name, b.name as block_name, p.name as panchayat_name, v.name as village_name, vs.vidhan_sabha_name, u1.name as created_by_name, u2.name as added_by_name');
        $this->db->from('mp_vidhan_sabha_member m');
        $this->db->join('district d', 'd.id = m.district_id', 'left');
        $this->db->join('block b', 'b.id = m.block_id', 'left');
        $this->db->join('panchayat p', 'p.id = m.panchayat_id', 'left');
        $this->db->join('village v', 'v.id = m.village_id', 'left');
        $this->db->join('vidhan_sabha vs', 'vs.id = m.vidhan_sabha_id', 'left');
        $this->db->join('tbl_users u1', 'm.created_by = u1.userId', 'left');
        $this->db->join('tbl_users u2', 'm.added_by = u2.userId', 'left');
        $this->db->order_by('m.id', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }

    // Get a single member by ID
    public function get_member($id) {
        $this->db->select('m.*, d.name as district_name, b.name as block_name, p.name as panchayat_name, v.name as village_name, vs.vidhan_sabha_name, u1.name as created_by_name, u2.name as added_by_name');
        $this->db->from('mp_vidhan_sabha_member m');
        $this->db->join('district d', 'd.id = m.district_id', 'left');
        $this->db->join('block b', 'b.id = m.block_id', 'left');
        $this->db->join('panchayat p', 'p.id = m.panchayat_id', 'left');
        $this->db->join('village v', 'v.id = m.village_id', 'left');
        $this->db->join('vidhan_sabha vs', 'vs.id = m.vidhan_sabha_id', 'left');
        $this->db->join('tbl_users u1', 'm.created_by = u1.userId', 'left');
        $this->db->join('tbl_users u2', 'm.added_by = u2.userId', 'left');
        $this->db->where('m.id', $id);
        $query = $this->db->get();
        return $query->row_array();
    }

    // Insert a new member
    public function create_member($data) {
        return $this->db->insert('mp_vidhan_sabha_member', $data);
    }

    // Update a member
    public function update_member($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('mp_vidhan_sabha_member', $data);
    }

    // Delete a member
    public function delete_member($id) {
        return $this->db->delete('mp_vidhan_sabha_member', array('id' => $id));
    }

}
?>
