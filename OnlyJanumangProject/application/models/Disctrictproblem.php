<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
#[AllowDynamicProperties]
class Disctrictproblem extends CI_Model { 
    
    
    public function districtpublicproblemlist($block = null, $year = null, $month = null, $department = null, $status = null, $approved_fund = null) {
        // Select the desired fields from the districtpublicproblem table and related tables
        $this->db->select('districtpublicproblem.*, tbl_users.userId, tbl_users.name as added_by_name, block.name as block_name, 
                          booth.name as joined_booth_name, booth.bnumber as booth_number, village.name as joined_village_name, 
                          panchayat.name as joined_panchayat_name, department.name as department_name');
        $this->db->from('districtpublicproblem');
        $this->db->join('department', 'department.id = districtpublicproblem.department', 'left');

        // Get blockId from session for access control
        $blockId = $this->session->userdata('blockId');
        $isAdmin = $this->session->userdata('isAdmin');
        $roleId = $this->session->userdata('role');
        
        // Debug logging - remove this after testing
        error_log("DEBUG - blockId: " . $blockId . ", isAdmin: " . $isAdmin . ", roleId: " . $roleId . ", block param: " . $block);
        
        // Apply block filter only for regular users (roleId > 3)
        // Admin, subadmin, and manager can see all entries
        if ($block && !($isAdmin == 1 || $roleId <= 3)) {
            $this->db->where('districtpublicproblem.block', $block);
        }
        
        // Apply session-based block restriction only for regular users
        if ($blockId != 0 && $isAdmin != 1 && $roleId > 3) {
            $blockid_array = explode(',', $blockId);
            $this->db->where_in('districtpublicproblem.block', $blockid_array);
        }
        
        // Apply other filters
        if ($department) {
            $this->db->where('districtpublicproblem.department', $department);
        }
        if ($status) {
            $this->db->where('districtpublicproblem.work_status', $status);
        }
        if ($approved_fund) {
            $this->db->where('districtpublicproblem.approved_fund', $approved_fund);
        }
        if (!empty($year)) {
            $this->db->where('districtpublicproblem.year', $year);
        }
        if (!empty($month)) {
            $this->db->where('districtpublicproblem.month', $month);
        }
        
        // Join with related tables
        $this->db->join('tbl_users', 'tbl_users.userId = districtpublicproblem.createdBy', 'left');
        $this->db->join('block', 'block.id = districtpublicproblem.block', 'left');
        $this->db->join('booth', 'booth.id = districtpublicproblem.booth_name', 'left');
        $this->db->join('village', 'village.id = districtpublicproblem.village', 'left');
        $this->db->join('panchayat', 'panchayat.id = districtpublicproblem.panchayat_name', 'left');
        $this->db->order_by('districtpublicproblem.id', 'desc');
        
        // Execute the query and return results
        $query = $this->db->get();
        return $query->result();
}




    public function getWorkStatusByBlockData() {
        $this->db->select('block.name as block_name, districtpublicproblem.work_status, COUNT(districtpublicproblem.id) as total');
        $this->db->join('block', 'block.id = districtpublicproblem.block');
        $this->db->group_by('block.name, districtpublicproblem.work_status');
        $query = $this->db->get('districtpublicproblem');
        return $query->result();
    }
    public function getStatusCountByBlock() {
        $this->db->select('block.name as block_name, districtpublicproblem.work_status, COUNT(districtpublicproblem.id) as total');
        $this->db->join('block', 'block.id = districtpublicproblem.block');
        // Apply date filters if provided
        $start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');
        if (!empty($start_date)) {
            $this->db->where('districtpublicproblem.createdAt >=', $start_date);
        }
        if (!empty($end_date)) {
            $this->db->where('districtpublicproblem.createdAt <=', $end_date);
        }
        $this->db->group_by('block.name, districtpublicproblem.work_status');
        $query = $this->db->get('districtpublicproblem');
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
            $this->db->where('districtpublicproblem.createdAt >=', $start_date);
        }
        if (!empty($end_date)) {
            $this->db->where('districtpublicproblem.createdAt <=', $end_date);
        }
        $query = $this->db->get('districtpublicproblem');
        return $query->result(); // This should return an array of objects
    } // Added missing closing brace
    public function getdistrictpublicproblemStatusCountByBlock($block) {
        // Define the possible statuses
        $statuses = ['Incomplete', 'In progress', 'Complete', 'Reject'];
        // Initialize the result array with all statuses set to 0 and block_name as an empty string
        $result = ['block_name' => '', 'Incomplete' => 0, 'In progress' => 0, 'Complete' => 0, 'Reject' => 0, 'count' => 0];
        // Query to get the count of records grouped by work_status for the given block
        $this->db->select('work_status, block.name as block_name, COUNT(*) as count');
        $this->db->from('districtpublicproblem');
        $this->db->join('block', 'block.id = districtpublicproblem.block');
        $this->db->where('districtpublicproblem.block', $block);
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

    public function get_districtpublicproblem_by_id($id) {
        $this->db->select('districtpublicproblem.*, tbl_users.name as added_by_name, block.name as block_name, 
                          booth.name as booth_name_joined, village.name as village_name_joined, 
                          panchayat.name as panchayat_name_joined, department.name as department_name');
        $this->db->from('districtpublicproblem');
        $this->db->join('department', 'department.id = districtpublicproblem.department', 'left');
        $this->db->join('block', 'block.id = districtpublicproblem.block', 'left');
        $this->db->join('booth', 'booth.id = districtpublicproblem.booth_name', 'left');
        $this->db->join('village', 'village.id = districtpublicproblem.village', 'left');
        $this->db->join('panchayat', 'panchayat.id = districtpublicproblem.panchayat_name', 'left');
        $this->db->join('tbl_users', 'tbl_users.userId = districtpublicproblem.createdBy', 'left');
        $this->db->where('districtpublicproblem.id', $id);
        $query = $this->db->get();
        return $query->row();
    }
    function districtpublicproblemlist24() {
        // Build the query
        $this->db->select('districtpublicproblem.*, tbl_users.userId, block.name as block_name, booth.name as booth_name, village.name as village_name, panchayat.name as panchayat_name');
        $this->db->from('districtpublicproblem');
        // Add the condition to check work status is not 'Complete'
        // $this->db->where('districtpublicproblem.work_status !=', 'Complete');
         $this->db->where('districtpublicproblem.current_stage', '2');
        // Join related tables
        $this->db->join('tbl_users', 'tbl_users.userId = districtpublicproblem.createdBy');
        $this->db->join('block', 'block.id = districtpublicproblem.block');
        $this->db->join('booth', 'booth.id = districtpublicproblem.booth_name');
        $this->db->join('village', 'village.id = districtpublicproblem.village');
        $this->db->join('panchayat', 'panchayat.id = districtpublicproblem.panchayat_name');
        $this->db->where('districtpublicproblem.createdAt <', 'DATE_SUB(NOW(), INTERVAL 72 HOUR)', false);
        $this->db->where('districtpublicproblem.createdAt >', 'DATE_SUB(NOW(), INTERVAL 96 HOUR)', false);
        // Apply filters if provided
        $block = $this->input->post('block');
        
        // Check if user is admin/subadmin/manager - if so, ignore block filter
        $isAdmin = $this->session->userdata('isAdmin');
        $roleId = $this->session->userdata('role');
        
        // Only apply block filter for regular users (roleId > 3)
        if ($block != '' && !($isAdmin == 1 || $roleId <= 3)) {
            $this->db->where('districtpublicproblem.block', $block);
        }
        $work_status = $this->input->post('work_status');
        if ($work_status != '') {
            $this->db->where('districtpublicproblem.work_status', $work_status);
        }
        $year = $this->input->post('year');
        if ($year != '') {
            $this->db->where('districtpublicproblem.year', $year);
        }
        $month = $this->input->post('month');
        if ($month != '') {
            $this->db->where('districtpublicproblem.month', $month);
        }
        // Execute the query
            $this->db->order_by('districtpublicproblem.id', 'desc');

        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }
    function districtpublicproblemlist48() {
        $this->db->select('districtpublicproblem.*, tbl_users.userId, block.name as block_name, booth.name as booth_name, village.name as village_name, panchayat.name as panchayat_name');
        $this->db->from('districtpublicproblem');
        //$this->db->where('districtpublicproblem.work_status !=', 'Complete');
        $this->db->where('districtpublicproblem.current_stage', '3');
        
        $this->db->join('tbl_users', 'tbl_users.userId = districtpublicproblem.createdBy');
        $this->db->join('block', 'block.id = districtpublicproblem.block');
        $this->db->join('booth', 'booth.id = districtpublicproblem.booth_name');
        $this->db->join('village', 'village.id = districtpublicproblem.village');
        $this->db->join('panchayat', 'panchayat.id = districtpublicproblem.panchayat_name');
        $this->db->where('districtpublicproblem.createdAt <=', 'DATE_SUB(NOW(), INTERVAL 96 HOUR)', false);
        $block = $this->input->post('block');
        
        // Check if user is admin/subadmin/manager - if so, ignore block filter
        $isAdmin = $this->session->userdata('isAdmin');
        $roleId = $this->session->userdata('role');
        
        // Only apply block filter for regular users (roleId > 3)
        if ($block != '' && !($isAdmin == 1 || $roleId <= 3)) {
            $this->db->where('districtpublicproblem.block', $block);
        }
        $work_status = $this->input->post('work_status');
        if ($work_status != '') {
            $this->db->where('districtpublicproblem.work_status', $work_status);
        }
        $year = $this->input->post('year');
        if ($year != '') {
            $this->db->where('districtpublicproblem.year', $year);
        }
        $month = $this->input->post('month');
        if ($month != '') {
            $this->db->where('districtpublicproblem.month', $month);
        }
        // Execute the query
            $this->db->order_by('districtpublicproblem.id', 'desc');

        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }
  
    // Get Public Problems Department Summary Report
    public function getPublicProblemsDepartmentSummary() {
        $this->db->select('d.id as department_id, 
            d.name as department_name, 
            COUNT(dp.id) as total_problems,
            SUM(CASE WHEN dp.work_status = "Complete" THEN 1 ELSE 0 END) as completed,
            SUM(CASE WHEN dp.work_status = "In progress" THEN 1 ELSE 0 END) as in_progress,
            SUM(CASE WHEN dp.work_status = "Incomplete" THEN 1 ELSE 0 END) as incomplete');
        $this->db->from('department d');
        $this->db->join('districtpublicproblem dp', 'dp.department = d.id', 'left');
        $this->db->group_by('d.id, d.name');
        $this->db->order_by('total_problems', 'DESC');
        $query = $this->db->get();
        return $query->result();
    }

    // Get Public Problems Summary Report by Date
    public function getPublicProblemsSummaryByDate() {
        $this->db->select('
            COUNT(id) as total_records,
            SUM(CASE WHEN DATE(createdAt) = CURDATE() THEN 1 ELSE 0 END) as today_records,
            SUM(CASE WHEN work_status = "Incomplete" THEN 1 ELSE 0 END) as total_incomplete,
            SUM(CASE WHEN work_status = "Complete" THEN 1 ELSE 0 END) as total_complete,
            SUM(CASE WHEN work_status = "In progress" THEN 1 ELSE 0 END) as in_progress
        ');
        $this->db->from('districtpublicproblem');
        $query = $this->db->get();
        return $query->result();
    }
    public function filterdistrictpublicproblemlist($block, $stage, $status, $today,$department) {
        $this->db->select('districtpublicproblem.*, tbl_users.userId, block.name as block_name, booth.name as booth_name, village.name as village_name, panchayat.name as panchayat_name');
        $this->db->from('districtpublicproblem');
        
        // Check if user is admin/subadmin/manager - if so, ignore block filter
        $isAdmin = $this->session->userdata('isAdmin');
        $roleId = $this->session->userdata('role');
        
        // Only apply block filter for regular users (roleId > 3)
        if ($block != '' && !($isAdmin == 1 || $roleId <= 3)) {
            $this->db->where('districtpublicproblem.block', $block);
        }
        if ($today != '') {
            $this->db->where('districtpublicproblem.createdAt', $today);
        }
        if ($department != '') {
            $this->db->where('districtpublicproblem.department', $department);
        }
        
         if ($status != '') {
            $this->db->where('districtpublicproblem.work_status', $status);
        }
        
        
        if ($stage != '') {
            $this->db->where('districtpublicproblem.current_stage', $stage);
        }
        $this->db->join('tbl_users', 'tbl_users.userId = districtpublicproblem.createdBy', 'left');
        $this->db->join('block', 'block.id = districtpublicproblem.block', 'left');
        $this->db->join('booth', 'booth.id = districtpublicproblem.booth_name', 'left');
        $this->db->join('village', 'village.id = districtpublicproblem.village', 'left');
        $this->db->join('panchayat', 'panchayat.id = districtpublicproblem.panchayat_name', 'left');
            $this->db->order_by('districtpublicproblem.id', 'desc');

        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }
    function districtpublicproblemcommentlist($id) {
        $this->db->select('districtpublicproblemcomment.*,tbl_users.name as userName');
         $this->db->where("districtpublicproblemcomment.jid", $id);
        $this->db->from('districtpublicproblemcomment');
        $this->db->join('districtpublicproblem', 'districtpublicproblem.id = districtpublicproblemcomment.jid');
        $this->db->join('tbl_users', 'tbl_users.userId = districtpublicproblemcomment.createdBy', 'left');

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
        $this->db->select('userId, name, email, mobile, isAdmin, roleId');
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