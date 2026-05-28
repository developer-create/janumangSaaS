<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class PhoneDirectory_model extends CI_Model
{
    
    /**
     * This function is used to get the phone directory listing count
     * @param string $searchText : This is optional search text
     * @return number $count : This is row count
     */
    function phoneDirectoryListingCount($searchText = '')
    {
        $this->db->select('pd.*, d.name as department_name, dt.name as district_name, b.name as block_name, p.name as party_name');
        $this->db->from('phone_directory pd');
        $this->db->join('department d', 'd.id = pd.department_id', 'left');
        $this->db->join('district dt', 'dt.id = pd.district_id', 'left');
        $this->db->join('block b', 'b.id = pd.vs_block_id', 'left');
        $this->db->join('party p', 'p.id = pd.party_id', 'left');
        
        if(!empty($searchText)) {
            $likeCriteria = "(pd.name LIKE '%".$searchText."%'
                            OR pd.post LIKE '%".$searchText."%'
                            OR pd.number LIKE '%".$searchText."%'
                            OR pd.email LIKE '%".$searchText."%'
                            OR d.name LIKE '%".$searchText."%'
                            OR dt.name LIKE '%".$searchText."%'
                            OR b.name LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
        
        $query = $this->db->get();
        
        return $query->num_rows();
    }
    
    /**
     * This function is used to get the phone directory listing
     * @param number $page : This is pagination offset
     * @param number $segment : This is pagination limit
     * @param string $searchText : This is optional search text
     * @return array $result : This is result
     */
    function phoneDirectoryListing($page, $segment, $searchText = '')
    {
        $this->db->select('pd.*, d.name as department_name, dt.name as district_name, b.name as block_name, p.name as party_name');
        $this->db->from('phone_directory pd');
        $this->db->join('department d', 'd.id = pd.department_id', 'left');
        $this->db->join('district dt', 'dt.id = pd.district_id', 'left');
        $this->db->join('block b', 'b.id = pd.vs_block_id', 'left');
        $this->db->join('party p', 'p.id = pd.party_id', 'left');
        
        if(!empty($searchText)) {
            $likeCriteria = "(pd.name LIKE '%".$searchText."%'
                            OR pd.post LIKE '%".$searchText."%'
                            OR pd.number LIKE '%".$searchText."%'
                            OR pd.email LIKE '%".$searchText."%'
                            OR d.name LIKE '%".$searchText."%'
                            OR dt.name LIKE '%".$searchText."%'
                            OR b.name LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
        
        $this->db->order_by('pd.id', 'DESC');
        $this->db->limit($page, $segment);
        $query = $this->db->get();
        
        $result = $query->result();        
        return $result;
    }

    function phoneDirectoryListingAll($searchText = '')
    {
        $this->db->select('pd.*, d.name as department_name, dt.name as district_name, b.name as block_name, p.name as party_name');
        $this->db->from('phone_directory pd');
        $this->db->join('department d', 'd.id = pd.department_id', 'left');
        $this->db->join('district dt', 'dt.id = pd.district_id', 'left');
        $this->db->join('block b', 'b.id = pd.vs_block_id', 'left');
        $this->db->join('party p', 'p.id = pd.party_id', 'left');
        if(!empty($searchText)) {
            $likeCriteria = "(pd.name LIKE '%".$searchText."%'
                            OR pd.post LIKE '%".$searchText."%'
                            OR pd.number LIKE '%".$searchText."%'
                            OR pd.email LIKE '%".$searchText."%'
                            OR d.name LIKE '%".$searchText."%'
                            OR dt.name LIKE '%".$searchText."%'
                            OR b.name LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
        $this->db->order_by('pd.id', 'DESC');
        $query = $this->db->get();
        return $query->result();
    }
    
    /**
     * This function is used to get phone directory information by ID
     * @param number $phoneDirectoryId : This is phone directory id
     * @return array $result : This is phone directory information
     */
    function getPhoneDirectoryInfo($phoneDirectoryId)
    {
        $this->db->select('pd.*, d.name as department_name, dt.name as district_name, b.name as block_name, p.name as party_name');
        $this->db->from('phone_directory pd');
        $this->db->join('department d', 'd.id = pd.department_id', 'left');
        $this->db->join('district dt', 'dt.id = pd.district_id', 'left');
        $this->db->join('block b', 'b.id = pd.vs_block_id', 'left');
        $this->db->join('party p', 'p.id = pd.party_id', 'left');
        $this->db->where('pd.id', $phoneDirectoryId);
        $query = $this->db->get();
        
        return $query->row();
    }
    
    /**
     * This function is used to add new phone directory entry
     * @param array $phoneDirectoryInfo : This is phone directory information
     * @return number $insert_id : This is last inserted id
     */
    function addNewPhoneDirectory($phoneDirectoryInfo)
    {
        $this->db->trans_start();
        $this->db->insert('phone_directory', $phoneDirectoryInfo);
        
        $insert_id = $this->db->insert_id();
        
        $this->db->trans_complete();
        
        return $insert_id;
    }
    
    /**
     * This function is used to update the phone directory information
     * @param array $phoneDirectoryInfo : This is phone directory updated information
     * @param number $phoneDirectoryId : This is phone directory id
     * @return boolean $result : TRUE / FALSE
     */
    function editPhoneDirectory($phoneDirectoryInfo, $phoneDirectoryId)
    {
        $this->db->where('id', $phoneDirectoryId);
        $this->db->update('phone_directory', $phoneDirectoryInfo);
        
        return TRUE;
    }
    
    /**
     * This function is used to delete the phone directory information
     * @param number $phoneDirectoryId : This is phone directory id
     * @return boolean $result : TRUE / FALSE
     */
    function deletePhoneDirectory($phoneDirectoryId)
    {
        $this->db->where('id', $phoneDirectoryId);
        $this->db->delete('phone_directory');
        
        return $this->db->affected_rows();
    }

    /**
     * This function is used to get all departments
     * @return array $result : This is result
     */
    function getDepartments()
    {
        $this->db->select('id, name');
        $this->db->from('department');
        $this->db->order_by('name', 'ASC');
        $query = $this->db->get();
        
        return $query->result();
    }

    /**
     * This function is used to get all districts
     * @return array $result : This is result
     */
    function getDistricts()
    {
        $this->db->select('id, name');
        $this->db->from('district');
        $this->db->order_by('name', 'ASC');
        $query = $this->db->get();
        
        return $query->result();
    }

    /**
     * This function is used to get all blocks
     * @return array $result : This is result
     */
    function getBlocks()
    {
        $this->db->select('id, name');
        $this->db->from('block');
        $this->db->where('id !=', 6); // Excluding block with id 6 as per your existing pattern
        $this->db->order_by('name', 'ASC');
        $query = $this->db->get();
        
        return $query->result();
    }

    /**
     * This function is used to get all parties
     * @return array $result : This is result
     */
    function getParties()
    {
        $this->db->select('id, name');
        $this->db->from('party');
        $this->db->order_by('name', 'ASC');
        $query = $this->db->get();
        
        return $query->result();
    }
}

?>