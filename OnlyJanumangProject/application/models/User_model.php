<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class User_model extends CI_Model {
    // In your model
    public function getWorkStatusByBlockData() {
        $this->db->select('block.name as block_name, jansunwai.work_status, COUNT(jansunwai.id) as total');
        $this->db->join('block', 'block.id = jansunwai.block');
        $this->db->group_by('block.name, jansunwai.work_status');
        $query = $this->db->get('jansunwai');
        return $query->result();
    }
    public function getStatusCountByBlock() {
        $this->db->select('block.name as block_name, jansunwai.work_status, COUNT(jansunwai.id) as total');
        $this->db->join('block', 'block.id = jansunwai.block');
        // Apply date filters if provided
        $start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');
        if (!empty($start_date)) {
            $this->db->where('jansunwai.createdAt >=', $start_date);
        }
        if (!empty($end_date)) {
            $this->db->where('jansunwai.createdAt <=', $end_date);
        }
        $this->db->group_by('block.name, jansunwai.work_status');
        $query = $this->db->get('jansunwai');
        return $query->result();
    }
    public function getAllBlocks() {
        $this->db->select('*');
        $this->db->where('id !=', 6);
        $this->db->from('block');
        $query = $this->db->get();
        return $query->result(); // This will return an array of objects containing all the blocks
        
    }
    public function getStatusCount() {
        $this->db->select('work_status, COUNT(id) as total');
        $this->db->group_by('work_status');
        // Apply date filters if provided
        $start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');
        if (!empty($start_date)) {
            $this->db->where('jansunwai.createdAt >=', $start_date);
        }
        if (!empty($end_date)) {
            $this->db->where('jansunwai.createdAt <=', $end_date);
        }
        $query = $this->db->get('jansunwai');
        return $query->result(); // This should return an array of objects
        
    }
    public function getJansunwaiStatusCountByBlock($block) {
        // Define the possible statuses
        $statuses = ['Incomplete', 'In progress', 'Complete', 'Reject'];
        // Initialize the result array with all statuses set to 0 and block_name as an empty string
        $result = ['block_name' => '', 'Incomplete' => 0, 'In progress' => 0, 'Complete' => 0, 'Reject' => 0, 'count' => 0];
        // Query to get the count of records grouped by work_status for the given block
        $this->db->select('work_status, block.name as block_name, COUNT(*) as count');
        $this->db->from('jansunwai');
        $this->db->join('block', 'block.id = jansunwai.block');
        $this->db->where('jansunwai.block', $block);
        $this->db->group_by('work_status');
        $query = $this->db->get();
        // Fetch the result
        $db_result = $query->result_array();
        // Loop through the database result and update the count in the result array
        foreach ($db_result as $row) {
            $result['block_name'] = $row['block_name']; // Set the block name
            $result['count'] = $row['count']; // Set the block name
            $result[$row['work_status']] = $row['count'];
        }
        return $result;
    }
    function userListingCount($searchText) {
        $this->db->select('BaseTbl.userId, BaseTbl.email, BaseTbl.name, BaseTbl.mobile, BaseTbl.isAdmin, BaseTbl.createdDtm, Role.role');
        $this->db->from('tbl_users as BaseTbl');
        $this->db->join('tbl_roles as Role', 'Role.roleId = BaseTbl.roleId', 'left');
        if (!empty($searchText)) {
            $likeCriteria = "(BaseTbl.email  LIKE '%" . $searchText . "%'
                            OR  BaseTbl.name  LIKE '%" . $searchText . "%'
                            OR  BaseTbl.mobile  LIKE '%" . $searchText . "%')";
            $this->db->where($likeCriteria);
        }
        $this->db->where('BaseTbl.isDeleted', 0);
        $query = $this->db->get();
        return $query->num_rows();
    }
    function userListing($searchText, $page, $segment) {
        $this->db->select('BaseTbl.userId, BaseTbl.email, BaseTbl.name, BaseTbl.mobile, BaseTbl.isAdmin, BaseTbl.createdDtm,BaseTbl.servaystatus, 
        Role.role, Role.status as roleStatus');
        $this->db->from('tbl_users as BaseTbl');
        $this->db->join('tbl_roles as Role', 'Role.roleId = BaseTbl.roleId', 'left');
        if (!empty($searchText)) {
            $likeCriteria = "(BaseTbl.email  LIKE '%" . $searchText . "%'
                            OR  BaseTbl.name  LIKE '%" . $searchText . "%'
                            OR  BaseTbl.mobile  LIKE '%" . $searchText . "%')";
            $this->db->where($likeCriteria);
        }
        $this->db->where('BaseTbl.isDeleted', 0);
        $this->db->order_by('BaseTbl.userId', 'DESC');
        $this->db->limit($page, $segment);
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }
    function usercountListing() {
        $this->db->select('BaseTbl.userId, BaseTbl.email, BaseTbl.name, BaseTbl.mobile, BaseTbl.isAdmin, BaseTbl.createdDtm,BaseTbl.servaystatus, 
        Role.role, Role.status as roleStatus');
        $this->db->from('tbl_users as BaseTbl');
        $this->db->join('tbl_roles as Role', 'Role.roleId = BaseTbl.roleId', 'left');
        $this->db->where('BaseTbl.isDeleted', 0);
        $this->db->where('BaseTbl.roleId ', 3);
        $this->db->order_by('BaseTbl.userId', 'DESC');
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }
    
    function getUserCountByDate($userId, $date) {
        $this->db->select('count(*) as usercoun');
        $this->db->from('servayapp');
        $this->db->where('user_id', $userId);
        $this->db->like('create_date', $date);
        $query = $this->db->get();
        $result = $query->row();
        return $result ? $result->usercoun : 0;
    }
    
    function partylist() {
        $this->db->select('party.*');
        $this->db->from('party');
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }
    function departmentlist() {
        $this->db->select('department.*');
        $this->db->from('department');
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }
    function jansunwailist24() {
        // Build the query
        $this->db->select('jansunwai.*, tbl_users.userId, block.name as block_name, booth.name as booth_name, village.name as village_name, panchayat.name as panchayat_name, subtype_of_work.name as sub_work_type_name');
        $this->db->from('jansunwai');
        // Add the condition to check work status is not 'Complete'
        // $this->db->where('jansunwai.work_status !=', 'Complete');
         $this->db->where('jansunwai.current_stage', '2');
        // Join related tables
        $this->db->join('tbl_users', 'tbl_users.userId = jansunwai.createdBy');
        $this->db->join('block', 'block.id = jansunwai.block');
        $this->db->join('booth', 'booth.id = jansunwai.booth_name');
        $this->db->join('village', 'village.id = jansunwai.village');
        $this->db->join('panchayat', 'panchayat.id = jansunwai.panchayat_name');
        $this->db->join('subtype_of_work', 'subtype_of_work.id = jansunwai.sub_work_type_id', 'left');
        $this->db->where('jansunwai.createdAt <', 'DATE_SUB(NOW(), INTERVAL 72 HOUR)', false);
        $this->db->where('jansunwai.createdAt >', 'DATE_SUB(NOW(), INTERVAL 96 HOUR)', false);
        // Apply filters if provided
        $block = $this->input->post('block');
        if ($block != '') {
            $this->db->where('jansunwai.block', $block);
        }
        $work_status = $this->input->post('work_status');
        if ($work_status != '') {
            $this->db->where('jansunwai.work_status', $work_status);
        }
        $year = $this->input->post('year');
        if ($year != '') {
            $this->db->where('jansunwai.year', $year);
        }
        $month = $this->input->post('month');
        if ($month != '') {
            $this->db->where('jansunwai.month', $month);
        }
        
         $department = $this->input->post('department');
        if ($department != '') {
           
            $this->db->where('jansunwai.department', $department);
        }
        
        // Execute the query
            $this->db->order_by('jansunwai.id', 'desc');

        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }
    function jansunwailist48() {
        $this->db->select('jansunwai.*, tbl_users.userId, block.name as block_name, booth.name as booth_name, village.name as village_name, panchayat.name as panchayat_name, subtype_of_work.name as sub_work_type_name');
        $this->db->from('jansunwai');
        //$this->db->where('jansunwai.work_status !=', 'Complete');
        $this->db->where('jansunwai.current_stage', '3');
        
        $this->db->join('tbl_users', 'tbl_users.userId = jansunwai.createdBy');
        $this->db->join('block', 'block.id = jansunwai.block');
        $this->db->join('booth', 'booth.id = jansunwai.booth_name');
        $this->db->join('village', 'village.id = jansunwai.village');
        $this->db->join('panchayat', 'panchayat.id = jansunwai.panchayat_name');
        $this->db->join('subtype_of_work', 'subtype_of_work.id = jansunwai.sub_work_type_id', 'left');
        $this->db->where('jansunwai.createdAt <=', 'DATE_SUB(NOW(), INTERVAL 96 HOUR)', false);
        $block = $this->input->post('block');
        if ($block != '') {
            $this->db->where('jansunwai.block', $block);
        }
        $work_status = $this->input->post('work_status');
        if ($work_status != '') {
            $this->db->where('jansunwai.work_status', $work_status);
        }
        $year = $this->input->post('year');
        if ($year != '') {
            $this->db->where('jansunwai.year', $year);
        }
        $month = $this->input->post('month');
        if ($month != '') {
            $this->db->where('jansunwai.month', $month);
        }
          $department = $this->input->post('department');
        if ($department != '') {
           
            $this->db->where('jansunwai.department', $department);
        }
        // Execute the query
            $this->db->order_by('jansunwai.id', 'desc');

        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }
    
    function jansunwailist48_approved() {
        $this->db->select('jansunwai.*, tbl_users.userId, block.name as block_name, booth.name as booth_name, village.name as village_name, panchayat.name as panchayat_name, subtype_of_work.name as sub_work_type_name');
        $this->db->from('jansunwai');
        $this->db->where('jansunwai.current_stage', '3');
        $this->db->where('jansunwai.work_status', 'Complete'); // Only Complete status
        
        $this->db->join('tbl_users', 'tbl_users.userId = jansunwai.createdBy');
        $this->db->join('block', 'block.id = jansunwai.block');
        $this->db->join('booth', 'booth.id = jansunwai.booth_name');
        $this->db->join('village', 'village.id = jansunwai.village');
        $this->db->join('panchayat', 'panchayat.id = jansunwai.panchayat_name');
        $this->db->join('subtype_of_work', 'subtype_of_work.id = jansunwai.sub_work_type_id', 'left');
        $this->db->where('jansunwai.createdAt <=', 'DATE_SUB(NOW(), INTERVAL 96 HOUR)', false);
        
        // Execute the query
        $this->db->order_by('jansunwai.id', 'desc');
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }
    
   public function jansunwailist($block, $year, $month, $department, $approved_fund = null) {
    // Select the desired fields from the jansunwai table and related tables
    $this->db->select('jansunwai.*, tbl_users.userId, tbl_users.name as added_by_name, block.name as block_name, booth.name as booth_name, booth.bnumber as booth_number, village.name as village_name, panchayat.name as panchayat_name, department.name as department_name, subtype_of_work.name as sub_work_type_name');
    $this->db->from('jansunwai');

    // Get blockId from session
    $blockid = $this->session->userdata('blockId');

    // Apply filters based on session and input parameters
    if ($blockid != 0) {
      //   $this->db->where_in('jansunwai.block', (array)$blockid);
    }
    
    $blockid = $this->session->userdata('blockId');
if ($blockid != 0) {
    // Convert the comma-separated string into an array
    $blockid_array = explode(',', $blockid);
    
    // Use where_in with the array
    $this->db->where_in('jansunwai.block', $blockid_array);
}

    if (!empty($block)) {
        $this->db->where('jansunwai.block', $block);
    }
    
     if (!empty($department)) {
        $this->db->where('jansunwai.department', $department);
    }
    
    if (!empty($approved_fund)) {
        $this->db->where('jansunwai.approved_fund', $approved_fund);
    }
    
    $work_status = $this->input->post('work_status');
    if (!empty($work_status)) {
        $this->db->where('jansunwai.work_status', $work_status);
    }
    
    if (!empty($year)) {
        $this->db->where('jansunwai.year', $year);
    }
    
    if (!empty($month)) {
        $this->db->where('jansunwai.month', $month);
    }

    // Join with related tables
    $this->db->join('tbl_users', 'tbl_users.userId = jansunwai.createdBy', 'left');
    $this->db->join('block', 'block.id = jansunwai.block', 'left');
    $this->db->join('booth', 'booth.id = jansunwai.booth_name', 'left');
    $this->db->join('village', 'village.id = jansunwai.village', 'left');
    $this->db->join('panchayat', 'panchayat.id = jansunwai.panchayat_name', 'left');
    $this->db->join('department', 'department.id = jansunwai.department', 'left');
    $this->db->join('subtype_of_work', 'subtype_of_work.id = jansunwai.sub_work_type_id', 'left');
    $this->db->order_by('jansunwai.id', 'desc');
    // Execute the query and return results
    $query = $this->db->get();
   
    return $query->result();
}

    
    
    public function filterjansunwailist($block, $stage, $status, $today,$department) {
        $this->db->select('jansunwai.*, tbl_users.userId, block.name as block_name, booth.name as booth_name, village.name as village_name, panchayat.name as panchayat_name, subtype_of_work.name as sub_work_type_name');
        $this->db->from('jansunwai');
        if ($block != '') {
            $this->db->where('jansunwai.block', $block);
        }
        if ($today != '') {
            $this->db->where('jansunwai.createdAt', $today);
        }
        if ($department != '') {
            $this->db->where('jansunwai.department', $department);
        }
        
         if ($status != '') {
            $this->db->where('jansunwai.work_status', $status);
        }
        
        
        if ($stage != '') {
            $this->db->where('jansunwai.current_stage', $stage);
        }
        $this->db->join('tbl_users', 'tbl_users.userId = jansunwai.createdBy', 'left');
        $this->db->join('block', 'block.id = jansunwai.block', 'left');
        $this->db->join('booth', 'booth.id = jansunwai.booth_name', 'left');
        $this->db->join('village', 'village.id = jansunwai.village', 'left');
        $this->db->join('panchayat', 'panchayat.id = jansunwai.panchayat_name', 'left');
        $this->db->join('subtype_of_work', 'subtype_of_work.id = jansunwai.sub_work_type_id', 'left');
            $this->db->order_by('jansunwai.id', 'desc');

        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }
    function jansunwaicommentlist($id) {
        $this->db->select('jansunwaicomment.*,tbl_users.name as userName');
         $this->db->where("jansunwaicomment.jid", $id);
        $this->db->from('jansunwaicomment');
        $this->db->join('jansunwai', 'jansunwai.id = jansunwaicomment.jid');
        $this->db->join('tbl_users', 'tbl_users.userId = jansunwaicomment.createdBy', 'left');

        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }
    function getUserRoles() {
        $this->db->select('roleId, role, status as roleStatus');
        $this->db->from('tbl_roles');
        $query = $this->db->get();
        return $query->result();
    }
    function checkEmailExists($email, $userId = 0) {
        $this->db->select("email");
        $this->db->from("tbl_users");
        $this->db->where("email", $email);
        $this->db->where("isDeleted", 0);
        if ($userId != 0) {
            $this->db->where("userId !=", $userId);
        }
        $query = $this->db->get();
        return $query->result();
    }
    function addNewUser($userInfo) {
        $this->db->trans_start();
        $this->db->insert('tbl_users', $userInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }
     function getUserInfo($userId) {
        $this->db->select('*');
        $this->db->from('tbl_users');
        $this->db->where('isDeleted', 0);
        $this->db->where('userId', $userId);
        $query = $this->db->get();
        return $query->row();
    }
    function editUser($userInfo, $userId) {
        $this->db->where('userId', $userId);
        $this->db->update('tbl_users', $userInfo);
        return TRUE;
    }
    function deleteUser($userId, $userInfo) {
        $this->db->where('userId', $userId);
        $this->db->update('tbl_users', $userInfo);
        return $this->db->affected_rows();
    }
    function matchOldPassword($userId, $oldPassword) {
        $this->db->select('userId, password');
        $this->db->where('userId', $userId);
        $this->db->where('isDeleted', 0);
        $query = $this->db->get('tbl_users');
        $user = $query->result();
        if (!empty($user)) {
            if (verifyHashedPassword($oldPassword, $user[0]->password)) {
                return $user;
            } else {
                return array();
            }
        } else {
            return array();
        }
    }
    function changePassword($userId, $userInfo) {
        $this->db->where('userId', $userId);
        $this->db->where('isDeleted', 0);
        $this->db->update('tbl_users', $userInfo);
        return $this->db->affected_rows();
    }
    function loginHistoryCount($userId, $searchText, $fromDate, $toDate) {
        $this->db->select('logs.user_id, logs.data, logs.timestamp');
        if (!empty($searchText)) {
            $likeCriteria = "(logs.data LIKE '%" . $searchText . "%')";
            $this->db->where($likeCriteria);
        }
        if (!empty($fromDate)) {
            $this->db->where("DATE_FORMAT(logs.timestamp, '%Y-%m-%d') >= '" . date('Y-m-d', strtotime($fromDate)) . "'");
        }
        if (!empty($toDate)) {
            $this->db->where("DATE_FORMAT(logs.timestamp, '%Y-%m-%d') <= '" . date('Y-m-d', strtotime($toDate)) . "'");
        }
        if ($userId >= 1) {
            $this->db->where('logs.user_id', $userId);
        }
        $this->db->from('logs');
        $query = $this->db->get();
        return $query->num_rows();
    }
    function loginHistory($userId, $searchText, $fromDate, $toDate, $page, $segment) {
        $this->db->select('logs.user_id, logs.data, logs.timestamp, logs.action, logs.table_name, logs.row_id');
        $this->db->from('logs');
        if (!empty($searchText)) {
            $this->db->where("(logs.data LIKE '%" . $searchText . "%')");
        }
        if (!empty($fromDate)) {
            $this->db->where("DATE_FORMAT(logs.timestamp, '%Y-%m-%d') >= '" . date('Y-m-d', strtotime($fromDate)) . "'");
        }
        if (!empty($toDate)) {
            $this->db->where("DATE_FORMAT(logs.timestamp, '%Y-%m-%d') <= '" . date('Y-m-d', strtotime($toDate)) . "'");
        }
        if ($userId >= 1) {
            $this->db->where('logs.user_id', $userId);
        }
        $this->db->order_by('logs.id', 'DESC');
        $this->db->limit($page, $segment);
        $query = $this->db->get();
        return $query->result();
    }
    function getUserInfoById($userId) {
        $this->db->select('userId, name, email, mobile, roleId');
        $this->db->from('tbl_users');
        $this->db->where('isDeleted', 0);
        $this->db->where('userId', $userId);
        $query = $this->db->get();
        return $query->row();
    }
    /**
     * This function used to get user information by id with role
     * @param number $userId : This is user id
     * @return aray $result : This is user information
     */
    function getUserInfoWithRole($userId) {
        $this->db->select('BaseTbl.userId, BaseTbl.email, BaseTbl.name, BaseTbl.mobile, BaseTbl.isAdmin, BaseTbl.roleId, Roles.role');
        $this->db->from('tbl_users as BaseTbl');
        $this->db->join('tbl_roles as Roles', 'Roles.roleId = BaseTbl.roleId');
        $this->db->where('BaseTbl.userId', $userId);
        $this->db->where('BaseTbl.isDeleted', 0);
        $query = $this->db->get();
        return $query->row();
    }
    function servayListing() {
        $this->db->select('*');
        $this->db->from('servayapp');
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get();
        return $query->result();
    }
    function getservayInfoById($userId) {
        $this->db->select('*');
        $this->db->from('servayapp');
        $this->db->where('id', $userId);
        $query = $this->db->get();
        return $query->row();
    }
    function getservayInfouserById($userId) {
        $this->db->select('*');
        $this->db->from('servayapp');
        $this->db->where('user_id', $userId);
        $this->db->where('servayid', 'own');
        $query = $this->db->get();
        return $query->row();
    }
}
