<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class : ProjectSummary_model (Project Summary Model)
 * Project Summary model class to handle project summary related data 
 * @author : Admin
 * @version : 1.0
 * @since : 10 Aug 2025
 */
class ProjectSummary_model extends CI_Model
{
    /**
     * This function is used to get the project listing count
     * @param string $searchText : This is optional search text
     * @return number $count : This is row count
     */
    function projectListingCount($searchText)
    {
        $this->db->select('BaseTbl.id, BaseTbl.work_name, BaseTbl.status, BaseTbl.officer_name, BaseTbl.remark');
        $this->db->from('project_details as BaseTbl');
        $this->db->join('district as District', 'District.id = BaseTbl.district_id', 'left');
        $this->db->join('block as Block', 'Block.id = BaseTbl.block_id', 'left');
        $this->db->join('department as Dept', 'Dept.id = BaseTbl.department_id', 'left');
        
        if(!empty($searchText)) {
            $likeCriteria = "(BaseTbl.work_name LIKE '%".$searchText."%' OR BaseTbl.officer_name LIKE '%".$searchText."%' OR BaseTbl.status LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
        $this->db->where('BaseTbl.is_deleted', 0);
        $query = $this->db->get();
        
        return $query->num_rows();
    }
    
    /**
     * This function is used to get the project listing
     * @param string $searchText : This is optional search text
     * @param number $page : This is pagination offset
     * @param number $segment : This is pagination limit
     * @return array $result : This is result
     */
    function projectListing($searchText, $page, $segment)
    {
        $this->db->select('BaseTbl.id, BaseTbl.unique_id, BaseTbl.work_name, BaseTbl.amount_project_cost, BaseTbl.proposal_estimate, 
                          BaseTbl.status, BaseTbl.officer_name, BaseTbl.contact_no, BaseTbl.technical_session, BaseTbl.administrative_session,
                          BaseTbl.tender_status, BaseTbl.company_name, BaseTbl.contractor_name, BaseTbl.phone_no, BaseTbl.usd_remark,
                          BaseTbl.remark, BaseTbl.created_at,
                          District.name as district_name, Block.name as block_name, Dept.name as department_name');
        $this->db->from('project_details as BaseTbl');
        $this->db->join('district as District', 'District.id = BaseTbl.district_id', 'left');
        $this->db->join('block as Block', 'Block.id = BaseTbl.block_id', 'left');
        $this->db->join('department as Dept', 'Dept.id = BaseTbl.department_id', 'left');
        
        if(!empty($searchText)) {
            $likeCriteria = "(BaseTbl.work_name LIKE '%".$searchText."%' OR BaseTbl.officer_name LIKE '%".$searchText."%' OR BaseTbl.status LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
        $this->db->where('BaseTbl.is_deleted', 0);
        $this->db->order_by('BaseTbl.id', 'DESC');
        $this->db->limit($page, $segment);
        $query = $this->db->get();
        
        $result = $query->result();
        
        // Add latest comment with date/time for each project
        foreach($result as $row) {
            $this->db->select('comment, created_at');
            $this->db->from('project_comments');
            $this->db->where('project_id', $row->id);
            $this->db->where('is_deleted', 0);
            $this->db->order_by('created_at', 'DESC');
            $this->db->limit(1);
            $comment_query = $this->db->get();
            
            if($comment_query->num_rows() > 0) {
                $comment_row = $comment_query->row();
                $formatted_date = date('d-m-Y H:i', strtotime($comment_row->created_at));
                $row->last_comment = $comment_row->comment . ' (' . $formatted_date . ')';
            } else {
                $row->last_comment = 'No comments';
            }
        }
        
        return $result;
    }
    
    /**
     * This function is used to add new project to system
     * @return number $insert_id : This is last inserted id
     */
    function addNewProject($projectInfo)
    {
        $this->db->trans_start();
        $this->db->insert('project_details', $projectInfo);
        
        $insert_id = $this->db->insert_id();
        
        $this->db->trans_complete();
        
        return $insert_id;
    }
    
    /**
     * This function used to get project information by id
     * @param number $projectId : This is project id
     * @return array $result : This is project information
     */
    function getProjectInfo($projectId)
    {
        $this->db->select('BaseTbl.*, District.name as district_name, Block.name as block_name, Dept.name as department_name');
        $this->db->from('project_details as BaseTbl');
        $this->db->join('district as District', 'District.id = BaseTbl.district_id', 'left');
        $this->db->join('block as Block', 'Block.id = BaseTbl.block_id', 'left');
        $this->db->join('department as Dept', 'Dept.id = BaseTbl.department_id', 'left');
        $this->db->where('BaseTbl.id', $projectId);
        $this->db->where('BaseTbl.is_deleted', 0);
        $query = $this->db->get();
        
        return $query->row();
    }
    
    /**
     * This function is used to update the project information
     * @param array $projectInfo : This is project updated information
     * @param number $projectId : This is project id
     */
    function editProject($projectInfo, $projectId)
    {
        $this->db->where('id', $projectId);
        $this->db->update('project_details', $projectInfo);
        
        return TRUE;
    }
    
    /**
     * This function is used to delete the project (soft delete)
     * @param number $projectId : This is project id
     */
    function deleteProject($projectId)
    {
        $projectInfo = array('is_deleted' => 1, 'updated_at' => date('Y-m-d H:i:s'));
        
        $this->db->where('id', $projectId);
        $this->db->update('project_details', $projectInfo);
        
        return $this->db->affected_rows();
    }
    
    /**
     * This function is used to get all projects (for DataTables pagination)
     * @return array $result : This is result
     */
    function getAllProjects($filters = array())
    {
        $this->db->select('BaseTbl.id, BaseTbl.unique_id, BaseTbl.work_name, BaseTbl.amount_project_cost, BaseTbl.proposal_estimate, 
                          BaseTbl.status, BaseTbl.officer_name, BaseTbl.contact_no, BaseTbl.technical_session, BaseTbl.administrative_session,
                          BaseTbl.tender_status, BaseTbl.company_name, BaseTbl.contractor_name, BaseTbl.phone_no, BaseTbl.usd_remark,
                          BaseTbl.remark, BaseTbl.created_at,
                          District.name as district_name, Block.name as block_name, Dept.name as department_name,
                          CONCAT(LastComment.comment, " (", DATE_FORMAT(LastComment.created_at, "%d-%m-%Y %H:%i"), ")") as last_comment');
        $this->db->from('project_details as BaseTbl');
        $this->db->join('district as District', 'District.id = BaseTbl.district_id', 'left');
        $this->db->join('block as Block', 'Block.id = BaseTbl.block_id', 'left');
        $this->db->join('department as Dept', 'Dept.id = BaseTbl.department_id', 'left');
        
        // Subquery to get the latest comment for each project
        $this->db->join('(SELECT pc1.project_id, pc1.comment, pc1.created_at
                         FROM project_comments pc1
                         INNER JOIN (
                             SELECT project_id, MAX(id) as max_id
                             FROM project_comments
                             WHERE is_deleted = 0
                             GROUP BY project_id
                         ) pc2 ON pc1.project_id = pc2.project_id AND pc1.id = pc2.max_id
                         WHERE pc1.is_deleted = 0) as LastComment', 
                        'LastComment.project_id = BaseTbl.id', 'left');
        
        $this->db->where('BaseTbl.is_deleted', 0);
        
        // Apply filters
        if(!empty($filters['department'])) {
            $this->db->where('Dept.name', $filters['department']);
        }
        if(!empty($filters['tender_status'])) {
            $this->db->where('BaseTbl.tender_status', $filters['tender_status']);
        }
        if(!empty($filters['work_status'])) {
            $this->db->where('BaseTbl.status', $filters['work_status']);
        }
        
        // Proposal Estimate Range Filter (in Crores: 1 Crore = 10,000,000 rupees)
        if(!empty($filters['estimate_range'])) {
            switch($filters['estimate_range']) {
                case '0-1':
                    $this->db->where('BaseTbl.proposal_estimate >=', 0);
                    $this->db->where('BaseTbl.proposal_estimate <', 10000000);
                    break;
                case '1-5':
                    $this->db->where('BaseTbl.proposal_estimate >=', 10000000);
                    $this->db->where('BaseTbl.proposal_estimate <', 50000000);
                    break;
                case '5-10':
                    $this->db->where('BaseTbl.proposal_estimate >=', 50000000);
                    $this->db->where('BaseTbl.proposal_estimate <', 100000000);
                    break;
                case '10 Above':
                    $this->db->where('BaseTbl.proposal_estimate >=', 100000000);
                    break;
            }
        }
        
        $this->db->order_by('BaseTbl.id', 'DESC');
        $query = $this->db->get();
        
        $result = $query->result();        
        return $result;
    }

    /**
     * This function is used to get all comments for a project
     * @param number $projectId : Project ID
     * @return array $result : Comments with user details
     */
    function getProjectComments($projectId)
    {
        $this->db->select('pc.id, pc.comment, pc.created_at, u.name as created_by_name');
        $this->db->from('project_comments as pc');
        $this->db->join('tbl_users as u', 'u.userId = pc.created_by', 'left');
        $this->db->where('pc.project_id', $projectId);
        $this->db->where('pc.is_deleted', 0);
        $this->db->order_by('pc.created_at', 'DESC');
        $query = $this->db->get();
        
        return $query->result();
    }

    /**
     * This function is used to add a new comment
     * @param array $commentData : Comment information
     * @return number $insert_id : Inserted comment ID
     */
    function addComment($commentData)
    {
        $this->db->trans_start();
        $this->db->insert('project_comments', $commentData);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        
        return $insert_id;
    }

    /**
     * This function is used to count comments for a project
     * @param number $projectId : Project ID
     * @return number $count : Comment count
     */
    function getCommentCount($projectId)
    {
        $this->db->where('project_id', $projectId);
        $this->db->where('is_deleted', 0);
        return $this->db->count_all_results('project_comments');
    }

    /**
     * This function is used to generate unique project ID (PS/001, PS/002, etc)
     * @return string $unique_id : Generated unique ID
     */
    function generateUniqueID()
    {
        // Get the count of non-deleted projects with unique_id
        $this->db->select('MAX(CAST(SUBSTRING(unique_id, 4) AS UNSIGNED)) as max_num');
        $this->db->where('unique_id IS NOT NULL');
        $this->db->where('is_deleted', 0);  // Only count non-deleted records
        $query = $this->db->get('project_details');
        $result = $query->row_array();
        
        // If no existing IDs, start from 1
        $next_num = (!empty($result['max_num'])) ? $result['max_num'] + 1 : 1;
        
        // Format as PS/001, PS/002, etc
        $unique_id = 'PS/' . str_pad($next_num, 3, '0', STR_PAD_LEFT);
        
        return $unique_id;
    }

    /**
     * This function is used to get all unique departments from projects
     * @return array $result : List of departments
     */
    function getUniqueDepartments()
    {
        $this->db->select('Dept.id, Dept.name as department_name', FALSE);
        $this->db->from('project_details as BaseTbl');
        $this->db->join('department as Dept', 'Dept.id = BaseTbl.department_id', 'left');
        $this->db->where('BaseTbl.is_deleted', 0);
        $this->db->group_by('Dept.id, Dept.name');
        $this->db->order_by('Dept.name', 'ASC');
        $query = $this->db->get();
        
        return $query->result();
    }

    /**
     * This function is used to get all unique tender statuses from projects
     * @return array $result : List of tender statuses
     */
    function getUniqueTenderStatuses()
    {
        $this->db->select('BaseTbl.tender_status', FALSE);
        $this->db->from('project_details as BaseTbl');
        $this->db->where('BaseTbl.is_deleted', 0);
        $this->db->where('BaseTbl.tender_status IS NOT NULL');
        $this->db->where('BaseTbl.tender_status !=', '');
        $this->db->group_by('BaseTbl.tender_status');
        $this->db->order_by('BaseTbl.tender_status', 'ASC');
        $query = $this->db->get();
        
        return $query->result();
    }

    /**
     * This function is used to get all unique work statuses from projects
     * @return array $result : List of work statuses
     */
    function getUniqueWorkStatuses()
    {
        $this->db->select('BaseTbl.status', FALSE);
        $this->db->from('project_details as BaseTbl');
        $this->db->where('BaseTbl.is_deleted', 0);
        $this->db->where('BaseTbl.status IS NOT NULL');
        $this->db->where('BaseTbl.status !=', '');
        $this->db->group_by('BaseTbl.status');
        $this->db->order_by('BaseTbl.status', 'ASC');
        $query = $this->db->get();
        
        return $query->result();
    }
}
?>
