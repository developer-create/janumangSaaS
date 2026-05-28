<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class GaneshSamiti_model extends CI_Model
{
    /**
     * This function is used to get the ganesh samiti listing count
     * @param string $searchText : This is optional search text
     * @return number $count : This is row count
     */
    function ganeshSamitiListingCount($searchText = '')
    {
        $this->db->select('BaseTbl.id, BaseTbl.serial_number, BaseTbl.year, BaseTbl.ganesh_samiti_name, BaseTbl.establishment, BaseTbl.medium_circle_writer, BaseTbl.medium_circle_name, BaseTbl.group_number, BaseTbl.group_name, BaseTbl.coordinator, BaseTbl.quantity, BaseTbl.phone, BaseTbl.helper_name, BaseTbl.rep_name, BaseTbl.up_sub, BaseTbl.pat, BaseTbl.mobile_number, BaseTbl.remark, BaseTbl.status, BaseTbl.created_on');
        $this->db->from('ganesh_samiti as BaseTbl');
        if(!empty($searchText)) {
            $likeCriteria = "(BaseTbl.serial_number LIKE '%".$searchText."%'
                            OR BaseTbl.year LIKE '%".$searchText."%'
                            OR BaseTbl.ganesh_samiti_name LIKE '%".$searchText."%'
                            OR BaseTbl.establishment LIKE '%".$searchText."%'
                            OR BaseTbl.medium_circle_writer LIKE '%".$searchText."%'
                            OR BaseTbl.medium_circle_name LIKE '%".$searchText."%'
                            OR BaseTbl.group_name LIKE '%".$searchText."%'
                            OR BaseTbl.coordinator LIKE '%".$searchText."%'
                            OR BaseTbl.phone LIKE '%".$searchText."%'
                            OR BaseTbl.mobile_number LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
        $this->db->where('BaseTbl.status !=', 'Deleted');
        $query = $this->db->get();
        
        return $query->num_rows();
    }
    
    /**
     * This function is used to get the ganesh samiti listing
     * @param number $page : This is pagination offset
     * @param number $segment : This is pagination limit
     * @param string $searchText : This is optional search text
     * @return array $result : This is result
     */
    function ganeshSamitiListing($page, $segment, $searchText = '')
    {
        $this->db->select('BaseTbl.id, BaseTbl.serial_number, BaseTbl.year, BaseTbl.ganesh_samiti_name, BaseTbl.establishment, BaseTbl.medium_circle_writer, BaseTbl.medium_circle_name, BaseTbl.group_number, BaseTbl.group_name, BaseTbl.coordinator, BaseTbl.quantity, BaseTbl.phone, BaseTbl.helper_name, BaseTbl.rep_name, BaseTbl.up_sub, BaseTbl.pat, BaseTbl.mobile_number, BaseTbl.remark, BaseTbl.status, BaseTbl.created_on');
        $this->db->from('ganesh_samiti as BaseTbl');
        if(!empty($searchText)) {
            $likeCriteria = "(BaseTbl.serial_number LIKE '%".$searchText."%'
                            OR BaseTbl.year LIKE '%".$searchText."%'
                            OR BaseTbl.ganesh_samiti_name LIKE '%".$searchText."%'
                            OR BaseTbl.establishment LIKE '%".$searchText."%'
                            OR BaseTbl.medium_circle_writer LIKE '%".$searchText."%'
                            OR BaseTbl.medium_circle_name LIKE '%".$searchText."%'
                            OR BaseTbl.group_name LIKE '%".$searchText."%'
                            OR BaseTbl.coordinator LIKE '%".$searchText."%'
                            OR BaseTbl.phone LIKE '%".$searchText."%'
                            OR BaseTbl.mobile_number LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
        $this->db->where('BaseTbl.status !=', 'Deleted');
        $this->db->order_by('BaseTbl.id', 'DESC');
        $this->db->limit($page, $segment);
        $query = $this->db->get();
        
        $result = $query->result_array();        
        return $result;
    }
    
    /**
     * This function is used to get ganesh samiti information by ID
     * @param number $ganeshSamitiId : This is ganesh samiti id
     * @return array $result : This is ganesh samiti information
     */
    function getGaneshSamitiInfo($ganeshSamitiId)
    {
        $this->db->select('id, serial_number, year, ganesh_samiti_name, establishment, medium_circle_writer, medium_circle_name, group_number, group_name, coordinator, quantity, phone, helper_name, rep_name, up_sub, pat, mobile_number, remark, status, created_on, updated_on');
        $this->db->from('ganesh_samiti');
        $this->db->where('id', $ganeshSamitiId);
        $this->db->where('status !=', 'Deleted');
        $query = $this->db->get();
        
        return $query->result();
    }
    
    /**
     * This function is used to add new ganesh samiti to the system
     * @return number $insert_id : This is last inserted id
     */
    function addNewGaneshSamiti($ganeshSamitiInfo)
    {
        $this->db->trans_start();
        $this->db->insert('ganesh_samiti', $ganeshSamitiInfo);
        
        $insert_id = $this->db->insert_id();
        
        $this->db->trans_complete();
        
        return $insert_id;
    }
    
    /**
     * This function used to get ganesh samiti information by id
     * @param number $ganeshSamitiId : This is ganesh samiti id
     * @return array $result : This is ganesh samiti information
     */
    function getGaneshSamitiInfoById($ganeshSamitiId)
    {
        $this->db->select('id, serial_number, year, ganesh_samiti_name, establishment, medium_circle_writer, medium_circle_name, group_number, group_name, coordinator, quantity, phone, helper_name, rep_name, up_sub, pat, mobile_number, remark, status');
        $this->db->from('ganesh_samiti');
        $this->db->where('id', $ganeshSamitiId);
        $this->db->where('status !=', 'Deleted');
        $query = $this->db->get();
        
        return $query->row_array();
    }
    
    /**
     * This function is used to update the ganesh samiti information
     * @param array $ganeshSamitiInfo : This is ganesh samiti updated information
     * @param number $ganeshSamitiId : This is ganesh samiti id
     */
    function editGaneshSamiti($ganeshSamitiInfo, $ganeshSamitiId)
    {
        $this->db->where('id', $ganeshSamitiId);
        $this->db->update('ganesh_samiti', $ganeshSamitiInfo);
        
        return TRUE;
    }
    
    /**
     * This function is used to delete the ganesh samiti information
     * @param number $ganeshSamitiId : This is ganesh samiti id
     * @return boolean $result : TRUE / FALSE
     */
    function deleteGaneshSamiti($ganeshSamitiId, $ganeshSamitiInfo)
    {
        $this->db->where('id', $ganeshSamitiId);
        $this->db->update('ganesh_samiti', $ganeshSamitiInfo);

        return $this->db->affected_rows();
    }

    /**
     * This function is used to check whether serial number already exist or not
     * @param string $serialNumber : This is serial number
     * @param number $ganeshSamitiId : This is ganesh samiti id
     * @return boolean true or false
     */
    function checkSerialNumberExists($serialNumber, $ganeshSamitiId = 0)
    {
        $this->db->select('id');
        $this->db->where('serial_number', $serialNumber);   
        $this->db->where('status !=', 'Deleted');
        if($ganeshSamitiId != 0){
            $this->db->where('id !=', $ganeshSamitiId);
        }
        $query = $this->db->get('ganesh_samiti');
        
        if($query->num_rows() > 0){
            return true;
        } else {
            return false;
        }
    }
}

?>