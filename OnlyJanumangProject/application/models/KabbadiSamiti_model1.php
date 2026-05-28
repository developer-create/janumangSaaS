<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class KabbadiSamiti_model extends CI_Model
{
    /**
     * This function is used to get all kabbadi samiti groups (locations)
     */
    function get_groups($search = null)
    {
        $this->db->select('BaseTbl.*, block.name as block_name, booth.name as booth_display_name, booth.bnumber as booth_no_val, (SELECT COUNT(*) FROM kabbadi_samiti WHERE group_id = BaseTbl.id) as member_count');
        $this->db->from('kabbadi_samiti_groups as BaseTbl');
        $this->db->join('block', 'block.id = BaseTbl.block', 'left');
        $this->db->join('booth', 'booth.id = BaseTbl.booth_name', 'left');
        
        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('BaseTbl.unique_id', $search);
            $this->db->or_like('booth.name', $search);
            $this->db->or_like('BaseTbl.gram_panchayat', $search);
            $this->db->or_like('BaseTbl.village', $search);
            $this->db->group_end();
        }
        
        $this->db->order_by('BaseTbl.id', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }

    /**
     * This function is used to get a single group by ID
     */
    function get_group_by_id($id)
    {
        $this->db->select('BaseTbl.*, BaseTbl.booth_name as booth_id');
        $this->db->from('kabbadi_samiti_groups as BaseTbl');
        $this->db->where('BaseTbl.id', $id);
        $query = $this->db->get();
        return $query->row_array();
    }

    /**
     * This function is used to create a new group
     */
    function create_group($data)
    {
        $this->db->insert('kabbadi_samiti_groups', $data);
        return $this->db->insert_id();
    }

    /**
     * This function is used to update a group
     */
    function update_group($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('kabbadi_samiti_groups', $data);
        return TRUE;
    }

    /**
     * This function is used to delete a group and its members
     */
    function delete_group($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('kabbadi_samiti_groups');
        return TRUE;
    }

    /**
     * This function is used to get all members for a group
     */
    function get_members_by_group($group_id)
    {
        $this->db->select('*');
        $this->db->from('kabbadi_samiti');
        $this->db->where('group_id', $group_id);
        $this->db->order_by('id', 'ASC');
        $query = $this->db->get();
        return $query->result_array();
    }

    /**
     * This function is used to get a single member by ID
     */
    function get_member_by_id($id)
    {
        $this->db->select('*');
        $this->db->from('kabbadi_samiti');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->row_array();
    }

    /**
     * This function is used to create a new member
     */
    function create_member($data)
    {
        $this->db->insert('kabbadi_samiti', $data);
        return $this->db->insert_id();
    }

    /**
     * This function is used to update a member
     */
    function update_member($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('kabbadi_samiti', $data);
        return TRUE;
    }

    /**
     * This function is used to delete a member
     */
    function delete_member($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('kabbadi_samiti');
        return TRUE;
    }

    /**
     * This function is used to check if a unique ID already exists
     */
    function check_unique_id_exists($unique_id, $id = 0)
    {
        $this->db->select('unique_id');
        $this->db->from('kabbadi_samiti_groups');
        $this->db->where('unique_id', $unique_id);
        if($id != 0) {
            $this->db->where('id !=', $id);
        }
        $query = $this->db->get();
        return $query->num_rows();
    }

    /**
     * This function is used to get last unique id number
     */
    function get_last_unique_id()
    {
        $this->db->select('unique_id');
        $this->db->from('kabbadi_samiti_groups');
        $this->db->like('unique_id', 'KS/', 'after');
        $this->db->order_by('id', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get();
        return $query->row_array();
    }

    /**
     * Helper functions for dropdowns (Mirroring Ganesh Samiti)
     */
    function get_blocks() {
        return $this->db->get('block')->result();
    }

    function get_booths_by_block($block_id) {
        $this->db->where('blockid', $block_id);
        return $this->db->get('booth')->result();
    }

    function get_booth_details($booth_id) {
        $this->db->where('id', $booth_id);
        return $this->db->get('booth')->row();
    }

    function get_panchayat_by_booth($booth_id) {
        $this->db->where('boothid', $booth_id);
        return $this->db->get('panchayat')->row();
    }

    function get_villages_by_panchayat($panchayat_id) {
        $this->db->where('panchayatid', $panchayat_id);
        return $this->db->get('village')->result();
    }
}
