<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class DispatchRegister_model extends CI_Model
{
    /**
     * Get all dispatch register entries (non-deleted)
     */
    public function get_dispatch_registers()
    {
        $this->db->select('dr.*, d.name as department_name, b.name as block_name, dist.name as district_name, vs.vidhan_sabha_name, u.name as created_by_name');
        $this->db->from('dispatch_register as dr');
        $this->db->join('department as d', 'd.id = dr.department_id', 'left');
        $this->db->join('block as b', 'b.id = dr.block_id', 'left');
        $this->db->join('district as dist', 'dist.id = dr.district_id', 'left');
        $this->db->join('vidhan_sabha as vs', 'vs.id = dr.vidhan_sabha_id', 'left');
        $this->db->join('tbl_users as u', 'u.userId = dr.created_by', 'left');
        $this->db->where('dr.isDeleted', 0);
        
        // Apply block-level permission filter
        $blockId = $this->session->userdata('blockId');
        if ($blockId != 0 && !empty($blockId)) {
            // User has block restriction - show only their blocks
            $blockid_array = explode(',', $blockId);
            $this->db->where_in('dr.block_id', $blockid_array);
        }
        
        $this->db->order_by('dr.id', 'DESC');
        $query = $this->db->get();
        $results = $query->result_array();
        
        // Get panchayat and village names for each record
        foreach ($results as &$result) {
            // Get panchayat names
            if (!empty($result['panchayat_id'])) {
                $panchayat_ids = explode(',', $result['panchayat_id']);
                if (!empty($panchayat_ids)) {
                    $this->db->select('name');
                    $this->db->from('panchayat');
                    $this->db->where_in('id', $panchayat_ids);
                    $panchayats_query = $this->db->get();
                    $panchayat_names = array_column($panchayats_query->result_array(), 'name');
                    $result['panchayat_name'] = implode(', ', $panchayat_names);
                } else {
                    $result['panchayat_name'] = '';
                }
            } else {
                $result['panchayat_name'] = '';
            }
            
            // Get village names
            if (!empty($result['village_id'])) {
                $village_ids = explode(',', $result['village_id']);
                if (!empty($village_ids)) {
                    $this->db->select('name');
                    $this->db->from('village');
                    $this->db->where_in('id', $village_ids);
                    $villages_query = $this->db->get();
                    $village_names = array_column($villages_query->result_array(), 'name');
                    $result['village_name'] = implode(', ', $village_names);
                } else {
                    $result['village_name'] = '';
                }
            } else {
                $result['village_name'] = '';
            }
        }
        
        return $results;
    }

    /**
     * Get single dispatch register entry by ID
     */
    public function get_dispatch_register($id)
    {
        $this->db->select('dr.*, d.name as department_name, b.name as block_name, dist.name as district_name, vs.vidhan_sabha_name');
        $this->db->from('dispatch_register as dr');
        $this->db->join('department as d', 'd.id = dr.department_id', 'left');
        $this->db->join('block as b', 'b.id = dr.block_id', 'left');
        $this->db->join('district as dist', 'dist.id = dr.district_id', 'left');
        $this->db->join('vidhan_sabha as vs', 'vs.id = dr.vidhan_sabha_id', 'left');
        $this->db->where('dr.id', $id);
        $this->db->where('dr.isDeleted', 0);
        $query = $this->db->get();
        $result = $query->row();
        
        // Get panchayat names if multiple panchayats are stored
        if ($result && !empty($result->panchayat_id)) {
            $panchayat_ids = explode(',', $result->panchayat_id);
            if (!empty($panchayat_ids)) {
                $this->db->select('name');
                $this->db->from('panchayat');
                $this->db->where_in('id', $panchayat_ids);
                $panchayats_query = $this->db->get();
                $panchayat_names = array_column($panchayats_query->result_array(), 'name');
                $result->panchayat_name = implode(', ', $panchayat_names);
            }
        }
        
        // Get village names if multiple villages are stored
        if ($result && !empty($result->village_id)) {
            $village_ids = explode(',', $result->village_id);
            if (!empty($village_ids)) {
                $this->db->select('name');
                $this->db->from('village');
                $this->db->where_in('id', $village_ids);
                $villages_query = $this->db->get();
                $village_names = array_column($villages_query->result_array(), 'name');
                $result->village_name = implode(', ', $village_names);
            }
        }
        
        return $result;
    }

    /**
     * Create new dispatch register entry
     */
    public function create_dispatch_register($data)
    {
        $this->db->insert('dispatch_register', $data);
        return $this->db->insert_id();
    }

    /**
     * Update dispatch register entry
     */
    public function update_dispatch_register($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->where('isDeleted', 0);
        return $this->db->update('dispatch_register', $data);
    }

    /**
     * Soft delete dispatch register entry
     */
    public function delete_dispatch_register($id)
    {
        $data = array(
            'isDeleted' => 1,
            'updated_at' => date('Y-m-d H:i:s')
        );
        $this->db->where('id', $id);
        return $this->db->update('dispatch_register', $data);
    }

    /**
     * Get all departments
     */
    public function get_departments()
    {
        $this->db->select('*');
        $this->db->from('department');
        $this->db->order_by('name', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }

    /**
     * Get all districts
     */
    public function get_districts()
    {
        $this->db->select('*');
        $this->db->from('district');
        $this->db->order_by('name', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }

    /**
     * Get all blocks
     */
    public function get_blocks()
    {
        $this->db->select('*');
        $this->db->from('block');
        
        // Apply block-level permission filter
        $blockId = $this->session->userdata('blockId');
        if ($blockId != 0 && !empty($blockId)) {
            // User has block restriction - show only their blocks
            $blockid_array = explode(',', $blockId);
            $this->db->where_in('id', $blockid_array);
        }
        
        $this->db->order_by('name', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }

    /**
     * Get panchayats by block ID
     */
    public function get_panchayats_by_block($block_id)
    {
        $this->db->select('*');
        $this->db->from('panchayat');
        $this->db->where('blockid', $block_id);
        $this->db->order_by('name', 'ASC');
        $query = $this->db->get();
        return $query->result_array();
    }

    /**
     * Get villages by panchayat ID
     */
    public function get_villages_by_panchayat($panchayat_id)
    {
        $this->db->select('*');
        $this->db->from('village');
        $this->db->where('panchayatid', $panchayat_id);
        $this->db->order_by('name', 'ASC');
        $query = $this->db->get();
        return $query->result_array();
    }

    /**
     * Get villages by block ID (NEW - fetch all villages under a block)
     */
    public function get_villages_by_block($block_id)
    {
        $this->db->select('v.*');
        $this->db->from('village as v');
        $this->db->join('panchayat as p', 'p.id = v.panchayatid', 'inner');
        $this->db->where('p.blockid', $block_id);
        $this->db->order_by('v.name', 'ASC');
        $query = $this->db->get();
        return $query->result_array();
    }
}
