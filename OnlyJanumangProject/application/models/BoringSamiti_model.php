<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class BoringSamiti_model extends CI_Model
{
    public function __construct() {
        $this->load->database();
    }

    // ===== GROUP/LOCATION METHODS =====
    
    // Get all groups with member count
    public function get_all_groups() {
        $this->db->select('boring_samiti_groups.*, block.name as block_name, booth.name as booth_name, booth.bnumber as booth_no,
                          (SELECT COUNT(*) FROM boring_samiti WHERE boring_samiti.group_id = boring_samiti_groups.id) as total_members');
        $this->db->from('boring_samiti_groups');
        $this->db->join('block', 'block.id = boring_samiti_groups.block', 'left');
        $this->db->join('booth', 'booth.id = boring_samiti_groups.booth_name', 'left');
        $this->db->order_by('boring_samiti_groups.id', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }

    // Get single group by ID
    public function get_group_by_id($id) {
        $this->db->select('boring_samiti_groups.*, block.name as block_name, 
                          boring_samiti_groups.booth_name as booth_id,
                          booth.name as booth_display_name, booth.bnumber as booth_no');
        $this->db->from('boring_samiti_groups');
        $this->db->join('block', 'block.id = boring_samiti_groups.block', 'left');
        $this->db->join('booth', 'booth.id = boring_samiti_groups.booth_name', 'left');
        $this->db->where('boring_samiti_groups.id', $id);
        $query = $this->db->get();
        return $query->row_array();
    }

    // Create new group
    public function create_group($data) {
        $data['created_at'] = date('Y-m-d H:i:s');
        $this->db->insert('boring_samiti_groups', $data);
        return $this->db->insert_id();
    }

    // Update group
    public function update_group($id, $data) {
        $data['updated_at'] = date('Y-m-d H:i:s');
        $this->db->where('id', $id);
        return $this->db->update('boring_samiti_groups', $data);
    }

    // Delete group
    public function delete_group($id) {
        // Delete all members first
        $this->db->where('group_id', $id);
        $this->db->delete('boring_samiti');
        
        // Delete group
        $this->db->where('id', $id);
        return $this->db->delete('boring_samiti_groups');
    }

    // ===== MEMBER METHODS =====
    
    // Get all members for a specific group
    public function get_members_by_group($group_id) {
        $this->db->select('*');
        $this->db->from('boring_samiti');
        $this->db->where('group_id', $group_id);
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }

    // Get single member by ID
    public function get_member_by_id($id) {
        $query = $this->db->get_where('boring_samiti', array('id' => $id));
        return $query->row_array();
    }

    // Create new member
    public function create_member($data) {
        $data['created_at'] = date('Y-m-d H:i:s');
        $this->db->insert('boring_samiti', $data);
        return $this->db->insert_id();
    }

    // Update member
    public function update_member($id, $data) {
        $data['updated_at'] = date('Y-m-d H:i:s');
        $this->db->where('id', $id);
        return $this->db->update('boring_samiti', $data);
    }

    // Delete member
    public function delete_member($id) {
        $this->db->where('id', $id);
        return $this->db->delete('boring_samiti');
    }

    // ===== HELPER METHODS =====
    
    public function get_blocks() {
        $this->db->select('*');
        $this->db->from('block');
        $this->db->order_by('name', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }

    public function get_booths_by_block($block_id) {
        $this->db->select('id, name, bnumber');
        $this->db->from('booth');
        $this->db->where('blockid', $block_id);
        $this->db->order_by('name', 'ASC');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_booth_details($booth_id) {
        $query = $this->db->get_where('booth', array('id' => $booth_id));
        return $query->row();
    }

    public function get_panchayat_by_booth($booth_id) {
        $this->db->select('*');
        $this->db->from('panchayat');
        $this->db->where('boothid', $booth_id);
        $query = $this->db->get();
        return $query->row();
    }

    public function get_villages_by_panchayat($panchayat_id) {
        $this->db->select('*');
        $this->db->from('village');
        $this->db->where('panchayatid', $panchayat_id);
        $this->db->order_by('name', 'ASC');
        $query = $this->db->get();
        return $query->result_array();
    }

    function getUniqueYears() {
        $this->db->select('DISTINCT(year) as year');
        $this->db->from('boring_samiti_groups');
        $this->db->where('year IS NOT NULL');
        $this->db->where('year !=', '');
        $this->db->order_by('year', 'DESC');
        return $this->db->get()->result();
    }

    function getUniqueNames() {
        $this->db->select('DISTINCT(boring_samiti_name) as name');
        $this->db->from('boring_samiti_groups');
        $this->db->where('boring_samiti_name IS NOT NULL');
        $this->db->where('boring_samiti_name !=', '');
        $this->db->order_by('boring_samiti_name', 'ASC');
        return $this->db->get()->result();
    }
}