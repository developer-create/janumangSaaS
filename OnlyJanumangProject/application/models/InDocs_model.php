<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class : InDocs_model (In Docs / Incoming Documents Model)
 * Model class to handle in docs related data
 * @author : Admin
 * @version : 1.0
 */
class InDocs_model extends CI_Model
{
    /**
     * Get all in docs records
     */
    function get_all_docs()
    {
        $this->db->select('*');
        $this->db->from('in_docs');
        $this->db->where('is_deleted', 0);
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get();
        
        $result = $query->result_array();
        return $result;
    }

    /**
     * Get in docs record by ID
     */
    function get_doc_by_id($docId)
    {
        $this->db->select('*');
        $this->db->from('in_docs');
        $this->db->where('id', $docId);
        $this->db->where('is_deleted', 0);
        $query = $this->db->get();
        
        return $query->row();
    }

    /**
     * Add new in docs record
     */
    function add_doc($docInfo)
    {
        $this->db->trans_start();
        $this->db->insert('in_docs', $docInfo);
        
        $insert_id = $this->db->insert_id();
        
        $this->db->trans_complete();
        
        return $insert_id;
    }

    /**
     * Update in docs record
     */
    function update_doc($docId, $docInfo)
    {
        $this->db->where('id', $docId);
        $this->db->update('in_docs', $docInfo);
        
        return TRUE;
    }

    /**
     * Delete in docs record (soft delete)
     */
    function delete_doc($docId)
    {
        $docInfo = array('is_deleted' => 1, 'updated_at' => date('Y-m-d H:i:s'));
        
        $this->db->where('id', $docId);
        $this->db->update('in_docs', $docInfo);
        
        return $this->db->affected_rows();
    }
}
?>
