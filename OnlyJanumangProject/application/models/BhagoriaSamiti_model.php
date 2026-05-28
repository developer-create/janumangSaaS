<?php
class BhagoriaSamiti_model extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    // Get all records (with total members count)
    public function get_all() {
        $blockid = $this->session->userdata('blockId');

        $this->db->select('bhagoria_samiti.*, (SELECT COUNT(*) FROM bhagoria_samiti_members WHERE bhagoria_samiti_members.samiti_id = bhagoria_samiti.id) as total_members');

        if ($blockid != 0) {
            $blockid_array = explode(',', $blockid);
            $this->db->where_in('block', $blockid_array);
        }

        $query = $this->db->get('bhagoria_samiti');
        return $query->result_array();
    }

    // Get records with filters (Block, Year, Month, Day)
    public function get_records($search = null, $filters = array()) {
        $blockid = $this->session->userdata('blockId');

        $this->db->select('bhagoria_samiti.*, (SELECT COUNT(*) FROM bhagoria_samiti_members WHERE bhagoria_samiti_members.samiti_id = bhagoria_samiti.id) as total_members');

        if ($blockid != 0) {
            $blockid_array = explode(',', $blockid);
            $this->db->where_in('bhagoria_samiti.block', $blockid_array);
        }

        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('bhagoria_samiti.unique_id', $search);
            $this->db->or_like('bhagoria_samiti.name', $search);
            $this->db->group_end();
        }

        if (!empty($filters['block'])) {
            $this->db->where('bhagoria_samiti.block', (int)$filters['block']);
        }
        if (!empty($filters['year'])) {
            $this->db->where('YEAR(bhagoria_samiti.created_at)', $filters['year']);
        }
        if (!empty($filters['month'])) {
            // Filter by month from either created_at or updated_at
            $this->db->group_start();
            $this->db->where('MONTH(bhagoria_samiti.created_at)', (int)$filters['month']);
            $this->db->or_where('MONTH(bhagoria_samiti.updated_at)', (int)$filters['month']);
            $this->db->group_end();
        }
        if (!empty($filters['date'])) {
            // Filter by date from either created_at or updated_at
            $this->db->group_start();
            $this->db->where('DATE(bhagoria_samiti.created_at)', $filters['date']);
            $this->db->or_where('DATE(bhagoria_samiti.updated_at)', $filters['date']);
            $this->db->group_end();
        }

        $this->db->order_by('bhagoria_samiti.id', 'DESC');
        $query = $this->db->get('bhagoria_samiti');
        return $query->result_array();
    }

    // Get all blocks
    public function get_blocks() {
        $this->db->select('*');
        $this->db->from('block');
        $this->db->order_by('name', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }

    // Get distinct years from bhagoria_samiti
    public function get_years() {
        $this->db->select('DISTINCT(YEAR(created_at)) as year');
        $this->db->from('bhagoria_samiti');
        $this->db->where('created_at IS NOT NULL');
        $this->db->order_by('YEAR(created_at)', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }

    // Get distinct months from bhagoria_samiti
    public function get_months() {
        $this->db->select('DISTINCT(MONTH(created_at)) as month');
        $this->db->from('bhagoria_samiti');
        $this->db->where('created_at IS NOT NULL');
        $this->db->order_by('MONTH(created_at)', 'ASC');
        $query = $this->db->get();
        return $query->result_array();
    }

    // Get distinct days from bhagoria_samiti
    public function get_days() {
        $this->db->select('DISTINCT(DAY(created_at)) as day');
        $this->db->from('bhagoria_samiti');
        $this->db->where('created_at IS NOT NULL');
        $this->db->order_by('DAY(created_at)', 'ASC');
        $query = $this->db->get();
        return $query->result_array();
    }

    // Get blocks that have data in bhagoria_samiti
    public function get_blocks_with_data() {
        $this->db->select('DISTINCT(b.id), b.name');
        $this->db->from('bhagoria_samiti as g');
        $this->db->join('block as b', 'b.id = g.block', 'inner');
        $this->db->order_by('b.name', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }

    // Get single record by ID
    public function get_by_id($id) {
        $query = $this->db->get_where('bhagoria_samiti', array('id' => $id));
        return $query->row_array();
    }

    // Insert new record
    public function create($data) {
        $this->db->insert('bhagoria_samiti', $data);
        return $this->db->insert_id();
    }

    // Update record
    public function update($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('bhagoria_samiti', $data);
    }

    // Delete record (and its members)
    public function delete($id) {
        $this->db->where('samiti_id', $id);
        $this->db->delete('bhagoria_samiti_members');
        return $this->db->delete('bhagoria_samiti', array('id' => $id));
    }

    // ===== MEMBER METHODS =====

    public function get_members_by_samiti($samiti_id) {
        $this->db->select('*');
        $this->db->from('bhagoria_samiti_members');
        $this->db->where('samiti_id', $samiti_id);
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_member_by_id($id) {
        $query = $this->db->get_where('bhagoria_samiti_members', array('id' => $id));
        return $query->row_array();
    }

    public function create_member($data) {
        $data['created_at'] = date('Y-m-d H:i:s');
        $this->db->insert('bhagoria_samiti_members', $data);
        return $this->db->insert_id();
    }

    public function update_member($id, $data) {
        $data['updated_at'] = date('Y-m-d H:i:s');
        $this->db->where('id', $id);
        return $this->db->update('bhagoria_samiti_members', $data);
    }

    public function delete_member($id) {
        return $this->db->delete('bhagoria_samiti_members', array('id' => $id));
    }

    public function get_total_members_count($filters = array()) {
        $this->db->select('SUM((SELECT COUNT(*) FROM bhagoria_samiti_members WHERE bhagoria_samiti_members.samiti_id = bhagoria_samiti.id)) as total_members');
        $this->db->from('bhagoria_samiti');
        $this->db->join('block', 'block.id = bhagoria_samiti.block', 'left');
        
        if (!empty($filters['block'])) {
            $this->db->where('bhagoria_samiti.block', (int)$filters['block']);
        }
        if (!empty($filters['year'])) {
            $this->db->where('YEAR(bhagoria_samiti.created_at)', $filters['year']);
        }
        if (!empty($filters['month'])) {
            // Filter by month from either created_at or updated_at
            $this->db->group_start();
            $this->db->where('MONTH(bhagoria_samiti.created_at)', (int)$filters['month']);
            $this->db->or_where('MONTH(bhagoria_samiti.updated_at)', (int)$filters['month']);
            $this->db->group_end();
        }
        if (!empty($filters['date'])) {
            // Filter by date from either created_at or updated_at
            $this->db->group_start();
            $this->db->where('DATE(bhagoria_samiti.created_at)', $filters['date']);
            $this->db->or_where('DATE(bhagoria_samiti.updated_at)', $filters['date']);
            $this->db->group_end();
        }
        
        $query = $this->db->get();
        $result = $query->row_array();
        return $result['total_members'] ?? 0;
    }
}
?>
