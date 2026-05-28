<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class : DpSamiti_model (DpSamiti Model)
 * DpSamiti model class to manage database operations for DP Samiti groups and members
 * @author : Your Name
 * @version : 1.0
 * @since : November 2025
 */
class DpSamiti_model extends CI_Model
{
    /**
     * This function is used to get the groups listing
     */
    function getGroups()
    {
        $this->db->select('g.*, 
            bl.name as block_name, 
            b.name as booth_name,
            COUNT(m.id) as total_members');
        $this->db->from('dp_samiti_groups as g');
        $this->db->join('block as bl', 'bl.id = g.block', 'left');
        $this->db->join('booth as b', 'b.id = g.booth_name', 'left');
        $this->db->join('dp_samiti as m', 'm.group_id = g.id', 'left');
        $this->db->group_by('g.id');
        $this->db->order_by('g.id', 'DESC');
        $query = $this->db->get();
        
        return $query->result_array();
    }
    
    /**
     * Get groups with filters (Block, Year, Month, Day)
     */
    public function get_groups($search = null, $filters = array()) {
        $this->db->select('g.*, 
            bl.name as block_name, 
            b.name as booth_name,
            COUNT(m.id) as total_members');
        $this->db->from('dp_samiti_groups as g');
        $this->db->join('block as bl', 'bl.id = g.block', 'left');
        $this->db->join('booth as b', 'b.id = g.booth_name', 'left');
        $this->db->join('dp_samiti as m', 'm.group_id = g.id', 'left');
        
        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('g.unique_id', $search);
            $this->db->or_like('b.name', $search);
            $this->db->or_like('g.gram_panchayat', $search);
            $this->db->or_like('g.village', $search);
            $this->db->group_end();
        }
        
        if (!empty($filters['block'])) {
            $this->db->where('g.block', (int)$filters['block']);
        }
        if (!empty($filters['year'])) {
            $this->db->where('g.year', $filters['year']);
        }
        if (!empty($filters['month'])) {
            // Filter by month from either created_at or updated_at
            $this->db->group_start();
            $this->db->where('MONTH(g.created_at)', (int)$filters['month']);
            $this->db->or_where('MONTH(g.updated_at)', (int)$filters['month']);
            $this->db->group_end();
        }
        if (!empty($filters['date'])) {
            // Filter by date from either created_at or updated_at
            $this->db->group_start();
            $this->db->where('DATE(g.created_at)', $filters['date']);
            $this->db->or_where('DATE(g.updated_at)', $filters['date']);
            $this->db->group_end();
        }
        
        $this->db->group_by('g.id');
        $this->db->order_by('g.id', 'DESC');
        $query = $this->db->get();
        
        return $query->result_array();
    }
    
    /**
     * Get all groups with member count (alternative method for consistency)
     */
    public function get_all_groups() {
        return $this->getGroups();
    }
    
    /**
     * This function is used to get group information by id
     */
    function getGroupInfo($groupId)
    {
        $this->db->select('g.*, 
            bl.name as block_name, 
            b.name as booth_name_text');
        $this->db->from('dp_samiti_groups as g');
        $this->db->join('block as bl', 'bl.id = g.block', 'left');
        $this->db->join('booth as b', 'b.id = g.booth_name', 'left');
        $this->db->where('g.id', $groupId);
        $query = $this->db->get();
        
        return $query->row();
    }
    
    /**
     * Get single group by ID (alternative method for consistency)
     */
    public function get_group_by_id($id) {
        $this->db->select('dp_samiti_groups.*, block.name as block_name');
        $this->db->from('dp_samiti_groups');
        $this->db->join('block', 'block.id = dp_samiti_groups.block', 'left');
        $this->db->where('dp_samiti_groups.id', $id);
        $query = $this->db->get();
        return $query->row_array();
    }
    
    /**
     * This function is used to add new group
     */
    function addGroup($groupInfo)
    {
        $this->db->trans_start();
        $this->db->insert('dp_samiti_groups', $groupInfo);
        
        $insert_id = $this->db->insert_id();
        
        $this->db->trans_complete();
        
        return $insert_id;
    }
    
    /**
     * This function is used to update group information
     */
    function editGroup($groupInfo, $groupId)
    {
        $this->db->where('id', $groupId);
        $this->db->update('dp_samiti_groups', $groupInfo);
        
        return TRUE;
    }
    
    /**
     * This function is used to delete group
     */
    function deleteGroup($groupId)
    {
        $this->db->where('id', $groupId);
        $this->db->delete('dp_samiti_groups');
        
        return $this->db->affected_rows();
    }
    
    /**
     * This function is used to get members for a group
     */
    function getMembers($groupId)
    {
        $this->db->select('*');
        $this->db->from('dp_samiti');
        $this->db->where('group_id', $groupId);
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get();
        
        return $query->result();
    }
    
    /**
     * This function is used to get member information by id
     */
    function getMemberInfo($memberId)
    {
        $this->db->select('*');
        $this->db->from('dp_samiti');
        $this->db->where('id', $memberId);
        $query = $this->db->get();
        
        return $query->row();
    }
    
    /**
     * This function is used to add new member
     */
    function addMember($memberInfo)
    {
        $this->db->trans_start();
        $this->db->insert('dp_samiti', $memberInfo);
        
        $insert_id = $this->db->insert_id();
        
        $this->db->trans_complete();
        
        return $insert_id;
    }
    
    /**
     * This function is used to update member information
     */
    function editMember($memberInfo, $memberId)
    {
        $this->db->where('id', $memberId);
        $this->db->update('dp_samiti', $memberInfo);
        
        return TRUE;
    }
    
    /**
     * This function is used to delete member
     */
    function deleteMember($memberId)
    {
        $this->db->where('id', $memberId);
        $this->db->delete('dp_samiti');
        
        return $this->db->affected_rows();
    }
    
    /**
     * This function is used to get all blocks
     */
    function getBlocks()
    {
        $this->db->select('id, name');
        $this->db->from('block');
        $this->db->order_by('name', 'ASC');
        $query = $this->db->get();
        
        return $query->result();
    }

    // Get distinct years from dp_samiti_groups
    public function get_years() {
        $this->db->select('DISTINCT(year) as year');
        $this->db->from('dp_samiti_groups');
        $this->db->where('year IS NOT NULL');
        $this->db->where('year !=', '');
        $this->db->order_by('year', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }

    // Get distinct months from dp_samiti_groups
    public function get_months() {
        $this->db->select('DISTINCT(MONTH(created_at)) as month');
        $this->db->from('dp_samiti_groups');
        $this->db->where('created_at IS NOT NULL');
        $this->db->order_by('MONTH(created_at)', 'ASC');
        $query = $this->db->get();
        return $query->result_array();
    }

    // Get distinct days from dp_samiti_groups
    public function get_days() {
        $this->db->select('DISTINCT(DAY(created_at)) as day');
        $this->db->from('dp_samiti_groups');
        $this->db->where('created_at IS NOT NULL');
        $this->db->order_by('DAY(created_at)', 'ASC');
        $query = $this->db->get();
        return $query->result_array();
    }

    // Get blocks that have data in dp_samiti_groups
    public function get_blocks_with_data() {
        $this->db->select('DISTINCT(bl.id), bl.name');
        $this->db->from('dp_samiti_groups as g');
        $this->db->join('block as bl', 'bl.id = g.block', 'inner');
        $this->db->order_by('bl.name', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }
    
    /**
     * This function is used to get booths by block
     */
    function getBoothsByBlock($blockId)
    {
        $this->db->select('id, name, bnumber');
        $this->db->from('booth');
        $this->db->where('blockid', $blockId);
        $this->db->order_by('name', 'ASC');
        $query = $this->db->get();
        
        return $query->result_array();
    }
    
    /**
     * This function is used to get booth details
     */
    function getBoothDetails($boothId)
    {
        $query = $this->db->get_where('booth', array('id' => $boothId));
        return $query->row();
    }
    
    /**
     * This function is used to get panchayat by booth
     */
    function getPanchayatByBooth($boothId)
    {
        $this->db->select('*');
        $this->db->from('panchayat');
        $this->db->where('boothid', $boothId);
        $query = $this->db->get();
        return $query->row();
    }
    
    /**
     * This function is used to get villages by panchayat
     */
    function getVillagesByPanchayat($panchayatId)
    {
        $this->db->select('*');
        $this->db->from('village');
        $this->db->where('panchayatid', $panchayatId);
        $this->db->order_by('name', 'ASC');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_total_members_count($filters = array()) {
        $this->db->select('SUM((SELECT COUNT(*) FROM dp_samiti WHERE dp_samiti.group_id = dp_samiti_groups.id)) as total_members');
        $this->db->from('dp_samiti_groups');
        $this->db->join('block', 'block.id = dp_samiti_groups.block', 'left');
        
        if (!empty($filters['block'])) {
            $this->db->where('dp_samiti_groups.block', (int)$filters['block']);
        }
        if (!empty($filters['year'])) {
            $this->db->where('dp_samiti_groups.year', $filters['year']);
        }
        if (!empty($filters['month'])) {
            // Filter by month from either created_at or updated_at
            $this->db->group_start();
            $this->db->where('MONTH(dp_samiti_groups.created_at)', (int)$filters['month']);
            $this->db->or_where('MONTH(dp_samiti_groups.updated_at)', (int)$filters['month']);
            $this->db->group_end();
        }
        if (!empty($filters['day'])) {
            // Filter by day from either created_at or updated_at
            $this->db->group_start();
            $this->db->where('DAY(dp_samiti_groups.created_at)', (int)$filters['day']);
            $this->db->or_where('DAY(dp_samiti_groups.updated_at)', (int)$filters['day']);
            $this->db->group_end();
        }
        
        $query = $this->db->get();
        $result = $query->row_array();
        return $result['total_members'] ?? 0;
    }
    
}

?>
