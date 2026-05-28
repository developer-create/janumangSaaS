<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class KabbadiSamiti_model extends CI_Model
{
    /**
     * Get all samiti types (for Khel Samiti - Kabbadi, Volleyball, etc.)
     */
    function get_samiti_types()
    {
        $this->db->order_by('name', 'ASC');
        $query = $this->db->get('khel_samiti_types');
        return $query->result_array();
    }

    function create_samiti_type($name)
    {
        $this->db->insert('khel_samiti_types', array('name' => $name, 'created_at' => date('Y-m-d H:i:s')));
        return $this->db->insert_id();
    }

    /**
     * This function is used to get all kabbadi samiti groups (locations)
     * @param string $search optional search text
     * @param array $filters optional ['year' => ?, 'month' => ?, 'date' => ?, 'samiti_type_id' => ?, 'block' => ?]
     */
    function get_groups($search = null, $filters = array())
    {
        $this->db->select('BaseTbl.*, block.name as block_name, booth.name as booth_display_name, booth.bnumber as booth_no_val, st.name as samiti_type_name, (SELECT COUNT(*) FROM kabbadi_samiti WHERE group_id = BaseTbl.id) as member_count');
        $this->db->from('kabbadi_samiti_groups as BaseTbl');
        $this->db->join('block', 'block.id = BaseTbl.block', 'left');
        $this->db->join('booth', 'booth.id = BaseTbl.booth_name', 'left');
        $this->db->join('khel_samiti_types as st', 'st.id = BaseTbl.samiti_type_id', 'left');
        
        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('BaseTbl.unique_id', $search);
            $this->db->or_like('booth.name', $search);
            $this->db->or_like('BaseTbl.gram_panchayat', $search);
            $this->db->or_like('BaseTbl.village', $search);
            $this->db->group_end();
        }
        
        if (!empty($filters['year'])) {
            $this->db->where('YEAR(BaseTbl.created_at)', $filters['year']);
        }
        if (!empty($filters['month'])) {
            // Filter by month from either created_at or updated_at
            $this->db->group_start();
            $this->db->where('MONTH(BaseTbl.created_at)', (int)$filters['month']);
            $this->db->or_where('MONTH(BaseTbl.updated_at)', (int)$filters['month']);
            $this->db->group_end();
        }
        if (!empty($filters['date'])) {
            // Filter by date from either created_at or updated_at
            $this->db->group_start();
            $this->db->where('DATE(BaseTbl.created_at)', $filters['date']);
            $this->db->or_where('DATE(BaseTbl.updated_at)', $filters['date']);
            $this->db->group_end();
        }
        if (isset($filters['samiti_type_id']) && $filters['samiti_type_id'] !== '' && $filters['samiti_type_id'] !== null) {
            $this->db->where('BaseTbl.samiti_type_id', (int)$filters['samiti_type_id']);
        }
        if (!empty($filters['block'])) {
            $this->db->where('BaseTbl.block', (int)$filters['block']);
        }
        
        $this->db->order_by('BaseTbl.id', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }

    /**
     * This function is used to get a single group by ID (with block/booth names for members page)
     */
    function get_group_by_id($id)
    {
        $this->db->select('BaseTbl.*, BaseTbl.booth_name as booth_id, block.name as block_name, booth.name as booth_name, booth.bnumber as booth_no');
        $this->db->from('kabbadi_samiti_groups as BaseTbl');
        $this->db->join('block', 'block.id = BaseTbl.block', 'left');
        $this->db->join('booth', 'booth.id = BaseTbl.booth_name', 'left');
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
        $this->db->where('group_id', $id);
        $this->db->delete('kabbadi_samiti');
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

    public function get_total_members_count($filters = array()) {
        $this->db->select('SUM((SELECT COUNT(*) FROM kabbadi_samiti WHERE kabbadi_samiti.group_id = kabbadi_samiti_groups.id)) as total_members');
        $this->db->from('kabbadi_samiti_groups');
        $this->db->join('block', 'block.id = kabbadi_samiti_groups.block', 'left');
        
        if (!empty($filters['year'])) {
            $this->db->where('YEAR(kabbadi_samiti_groups.created_at)', $filters['year']);
        }
        if (!empty($filters['month'])) {
            // Filter by month from either created_at or updated_at
            $this->db->group_start();
            $this->db->where('MONTH(kabbadi_samiti_groups.created_at)', (int)$filters['month']);
            $this->db->or_where('MONTH(kabbadi_samiti_groups.updated_at)', (int)$filters['month']);
            $this->db->group_end();
        }
        if (!empty($filters['date'])) {
            // Filter by date from either created_at or updated_at
            $this->db->group_start();
            $this->db->where('DATE(kabbadi_samiti_groups.created_at)', $filters['date']);
            $this->db->or_where('DATE(kabbadi_samiti_groups.updated_at)', $filters['date']);
            $this->db->group_end();
        }
        if (!empty($filters['block'])) {
            $this->db->where('kabbadi_samiti_groups.block', (int)$filters['block']);
        }
        if (isset($filters['samiti_type_id']) && $filters['samiti_type_id'] !== '' && $filters['samiti_type_id'] !== null) {
            $this->db->where('kabbadi_samiti_groups.samiti_type_id', (int)$filters['samiti_type_id']);
        }
        
        $query = $this->db->get();
        $result = $query->row_array();
        return $result['total_members'] ?? 0;
    }

    /**
     * Get distinct years from kabbadi_samiti_groups
     */
    public function get_years() {
        $this->db->select('DISTINCT(YEAR(created_at)) as year');
        $this->db->from('kabbadi_samiti_groups');
        $this->db->where('created_at IS NOT NULL');
        $this->db->order_by('YEAR(created_at)', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }

    /**
     * Get distinct months from kabbadi_samiti_groups
     */
    public function get_months() {
        $this->db->select('DISTINCT(MONTH(created_at)) as month');
        $this->db->from('kabbadi_samiti_groups');
        $this->db->where('created_at IS NOT NULL');
        $this->db->order_by('MONTH(created_at)', 'ASC');
        $query = $this->db->get();
        return $query->result_array();
    }
}
