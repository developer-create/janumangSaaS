<?php
class BlockSamiti_model extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    // ===== GROUP/LOCATION METHODS =====
    
    // Get all groups with member count
    public function get_all_groups() {
        // Join with booth to return booth name and booth number instead of raw id
        $this->db->select('block_samiti_groups.*, block.name as block_name, booth.name as booth_name, booth.bnumber as booth_no,
                          (SELECT COUNT(*) FROM block_samiti WHERE block_samiti.group_id = block_samiti_groups.id) as total_members');
        $this->db->from('block_samiti_groups');
        $this->db->join('block', 'block.id = block_samiti_groups.block', 'left');
        $this->db->join('booth', 'booth.id = block_samiti_groups.booth_name', 'left');
        $this->db->order_by('block_samiti_groups.id', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }

    // Get groups with filters (Block, Year, Month, Day)
    public function get_groups($search = null, $filters = array()) {
        // Join with booth to return booth name and booth number instead of raw id
        $this->db->select('block_samiti_groups.*, block.name as block_name, booth.name as booth_name, booth.bnumber as booth_no,
                          (SELECT COUNT(*) FROM block_samiti WHERE block_samiti.group_id = block_samiti_groups.id) as total_members');
        $this->db->from('block_samiti_groups');
        $this->db->join('block', 'block.id = block_samiti_groups.block', 'left');
        $this->db->join('booth', 'booth.id = block_samiti_groups.booth_name', 'left');
        
        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('block_samiti_groups.unique_id', $search);
            $this->db->or_like('booth.name', $search);
            $this->db->or_like('block_samiti_groups.gram_panchayat', $search);
            $this->db->or_like('block_samiti_groups.village', $search);
            $this->db->group_end();
        }
        
        if (!empty($filters['block'])) {
            $this->db->where('block_samiti_groups.block', (int)$filters['block']);
        }
        if (!empty($filters['year'])) {
            $this->db->where('block_samiti_groups.year', $filters['year']);
        }
        if (!empty($filters['month'])) {
            // Filter by month from either created_at or updated_at
            $this->db->group_start();
            $this->db->where('MONTH(block_samiti_groups.created_at)', (int)$filters['month']);
            $this->db->or_where('MONTH(block_samiti_groups.updated_at)', (int)$filters['month']);
            $this->db->group_end();
        }
        if (!empty($filters['date'])) {
            // Filter by date from either created_at or updated_at
            $this->db->group_start();
            $this->db->where('DATE(block_samiti_groups.created_at)', $filters['date']);
            $this->db->or_where('DATE(block_samiti_groups.updated_at)', $filters['date']);
            $this->db->group_end();
        }
        
        $this->db->order_by('block_samiti_groups.id', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }

    // Get single group by ID
    public function get_group_by_id($id) {
        // Include booth details (name and number) when fetching a single group
        // Keep original booth_name as booth_id for form selection
        $this->db->select('block_samiti_groups.*, block.name as block_name, 
                          block_samiti_groups.booth_name as booth_id,
                          booth.name as booth_display_name, booth.bnumber as booth_no');
        $this->db->from('block_samiti_groups');
        $this->db->join('block', 'block.id = block_samiti_groups.block', 'left');
        $this->db->join('booth', 'booth.id = block_samiti_groups.booth_name', 'left');
        $this->db->where('block_samiti_groups.id', $id);
        $query = $this->db->get();
        return $query->row_array();
    }

    // Create new group
    public function create_group($data) {
        $data['created_at'] = date('Y-m-d H:i:s');
        $this->db->insert('block_samiti_groups', $data);
        return $this->db->insert_id();
    }

    // Update group
    public function update_group($id, $data) {
        $data['updated_at'] = date('Y-m-d H:i:s');
        $this->db->where('id', $id);
        return $this->db->update('block_samiti_groups', $data);
    }

    // Delete group
    public function delete_group($id) {
        // Delete all members first
        $this->db->where('group_id', $id);
        $this->db->delete('block_samiti');
        
        // Delete group
        $this->db->where('id', $id);
        return $this->db->delete('block_samiti_groups');
    }

    // ===== MEMBER METHODS =====
    
    // Get all members for a specific group
    public function get_members_by_group($group_id) {
        $this->db->select('*');
        $this->db->from('block_samiti');
        $this->db->where('group_id', $group_id);
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }

    // Get single member by ID
    public function get_member_by_id($id) {
        $query = $this->db->get_where('block_samiti', array('id' => $id));
        return $query->row_array();
    }

    // Create new member
    public function create_member($data) {
        $data['created_at'] = date('Y-m-d H:i:s');
        $this->db->insert('block_samiti', $data);
        return $this->db->insert_id();
    }

    // Update member
    public function update_member($id, $data) {
        $data['updated_at'] = date('Y-m-d H:i:s');
        $this->db->where('id', $id);
        return $this->db->update('block_samiti', $data);
    }

    // Delete member
    public function delete_member($id) {
        $this->db->where('id', $id);
        return $this->db->delete('block_samiti');
    }

    // ===== HELPER METHODS =====
    
    // Get all blocks
    public function get_blocks() {
        $this->db->select('*');
        $this->db->from('block');
        $this->db->order_by('name', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }

    // Get distinct years from block_samiti_groups
    public function get_years() {
        $this->db->select('DISTINCT(year) as year');
        $this->db->from('block_samiti_groups');
        $this->db->where('year IS NOT NULL');
        $this->db->where('year !=', '');
        $this->db->order_by('year', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }

    // Get distinct months from block_samiti_groups
    public function get_months() {
        $this->db->select('DISTINCT(MONTH(created_at)) as month');
        $this->db->from('block_samiti_groups');
        $this->db->where('created_at IS NOT NULL');
        $this->db->order_by('MONTH(created_at)', 'ASC');
        $query = $this->db->get();
        return $query->result_array();
    }

    // Get distinct days from block_samiti_groups
    public function get_days() {
        $this->db->select('DISTINCT(DAY(created_at)) as day');
        $this->db->from('block_samiti_groups');
        $this->db->where('created_at IS NOT NULL');
        $this->db->order_by('DAY(created_at)', 'ASC');
        $query = $this->db->get();
        return $query->result_array();
    }

    // Get blocks that have data in block_samiti_groups
    public function get_blocks_with_data() {
        $this->db->select('DISTINCT(b.id), b.name');
        $this->db->from('block_samiti_groups as g');
        $this->db->join('block as b', 'b.id = g.block', 'inner');
        $this->db->order_by('b.name', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }

    // Get booths by block ID
    public function get_booths_by_block($block_id) {
        $this->db->select('id, name, bnumber');
        $this->db->from('booth');
        $this->db->where('blockid', $block_id);
        $this->db->order_by('name', 'ASC');
        $query = $this->db->get();
        return $query->result_array();
    }

    // Get booth details by booth ID
    public function get_booth_details($booth_id) {
        $query = $this->db->get_where('booth', array('id' => $booth_id));
        return $query->row();
    }

    // Get panchayat by booth ID
    public function get_panchayat_by_booth($booth_id) {
        $this->db->select('*');
        $this->db->from('panchayat');
        $this->db->where('boothid', $booth_id);
        $query = $this->db->get();
        return $query->row();
    }

    // Get villages by panchayat ID
    public function get_villages_by_panchayat($panchayat_id) {
        $this->db->select('*');
        $this->db->from('village');
        $this->db->where('panchayatid', $panchayat_id);
        $this->db->order_by('name', 'ASC');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_total_members_count($filters = array()) {
        $this->db->select('SUM((SELECT COUNT(*) FROM block_samiti WHERE block_samiti.group_id = block_samiti_groups.id)) as total_members');
        $this->db->from('block_samiti_groups');
        $this->db->join('block', 'block.id = block_samiti_groups.block', 'left');
        
        if (!empty($filters['block'])) {
            $this->db->where('block_samiti_groups.block', (int)$filters['block']);
        }
        if (!empty($filters['year'])) {
            $this->db->where('block_samiti_groups.year', $filters['year']);
        }
        if (!empty($filters['month'])) {
            // Filter by month from either created_at or updated_at
            $this->db->group_start();
            $this->db->where('MONTH(block_samiti_groups.created_at)', (int)$filters['month']);
            $this->db->or_where('MONTH(block_samiti_groups.updated_at)', (int)$filters['month']);
            $this->db->group_end();
        }
        if (!empty($filters['date'])) {
            // Filter by date from either created_at or updated_at
            $this->db->group_start();
            $this->db->where('DATE(block_samiti_groups.created_at)', $filters['date']);
            $this->db->or_where('DATE(block_samiti_groups.updated_at)', $filters['date']);
            $this->db->group_end();
        }
        
        $query = $this->db->get();
        $result = $query->row_array();
        return $result['total_members'] ?? 0;
    }
}
?>
