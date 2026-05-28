<?php
require APPPATH . '/libraries/BaseController.php';

class ActivityLog extends BaseController {

    public function __construct() {
        parent::__construct();
        $this->load->model('Log_model');
        $this->load->model('user_model');
        $this->isLoggedIn();
        $this->module = 'ActivityLog';
    }

    /**
     * Display activity logs list
     */
    public function index() {
        if (!$this->hasListAccess()) {
            $this->loadThis();
        } else {
            // Get filter parameters (support both GET and POST)
            $searchText = $this->input->post('searchText') ? $this->input->post('searchText') : $this->input->get('searchText');
            $filterUser = $this->input->post('filterUser') ? $this->input->post('filterUser') : $this->input->get('filterUser');
            $filterModule = $this->input->post('filterModule') ? $this->input->post('filterModule') : $this->input->get('filterModule');
            $filterAction = $this->input->post('filterAction') ? $this->input->post('filterAction') : $this->input->get('filterAction');
            $dateFrom = $this->input->post('dateFrom') ? $this->input->post('dateFrom') : $this->input->get('dateFrom');
            $dateTo = $this->input->post('dateTo') ? $this->input->post('dateTo') : $this->input->get('dateTo');
            
            // Prepare filters
            $filters = array();
            if (!empty($searchText)) {
                $filters['search'] = $searchText;
            }
            if (!empty($filterUser)) {
                $filters['user_id'] = $filterUser;
            }
            if (!empty($filterModule)) {
                $filters['module'] = $filterModule;
            }
            if (!empty($filterAction)) {
                $filters['action'] = $filterAction;
            }
            if (!empty($dateFrom)) {
                $filters['date_from'] = $dateFrom;
            }
            if (!empty($dateTo)) {
                $filters['date_to'] = $dateTo;
            }
            
            // Pagination
            $page = $this->input->get('page') ? $this->input->get('page') : 1;
            // Allow UI to control page length; defaults to 20
            $perPageParam = $this->input->get('perPage');
            if ($perPageParam === null) {
                $perPageParam = $this->input->post('perPage');
            }
            // Default to 20 records per page for better performance
            $perPage = is_numeric($perPageParam) ? (int)$perPageParam : 20;
            if ($perPage <= 0) { $perPage = 20; }
            
            // Build two datasets: main (exclude login/logout) and auth (only login/logout)
            $mainFilters = $filters;
            $mainFilters['exclude_actions'] = array('login', 'logout');
            $authFilters = $filters;
            $authFilters['only_actions'] = array('login', 'logout');

            // Get activity logs
            $result = $this->Log_model->get_activity_logs($mainFilters, $page, $perPage);
            $authResult = $this->Log_model->get_activity_logs($authFilters, 1, 100000);
            // If requesting all records (perPage = -1), fetch all
            if ($perPageParam === '-1') {
                $perPage = (int)$result['total'];
                $page = 1;
                $result = $this->Log_model->get_activity_logs($mainFilters, $page, $perPage);
            }
            
            // Get all users for filter dropdown
            $this->db->select('userId, name, email');
            $this->db->from('tbl_users');
            $this->db->where('isDeleted', 0);
            $this->db->order_by('name', 'ASC');
            $query = $this->db->get();
            $data['users'] = $query->result();
            
            // Get all modules for filter dropdown
            $this->load->config('modules');
            $data['modules'] = $this->config->item('moduleList');
            
            // Actions list
            $data['actions'] = array(
                'add' => 'Add',
                'edit' => 'Edit',
                'delete' => 'Delete',
                'download' => 'Download',
                'view' => 'View'
            );
            
            $data['logs'] = $result['logs'];
            $data['total'] = $result['total'];
            $data['auth_logs'] = $authResult['logs'];
            $data['auth_total'] = $authResult['total'];
            $data['filters'] = $filters;
            $data['page'] = $page;
            $data['perPage'] = $perPage;
            
            $this->global['pageTitle'] = 'Jan Umang : User Activity Logs';
            $this->loadViews("activitylog/index", $this->global, $data, NULL);
        }
    }

    /**
     * AJAX handler for DataTables server-side pagination
     */
    public function getActivityLogsAjax() {
        if (!$this->hasListAccess()) {
            echo json_encode(['error' => 'Access denied']);
            return;
        }

        try {
            // Get DataTables parameters
            $draw = intval($this->input->post('draw'));
            $start = intval($this->input->post('start'));
            $length = intval($this->input->post('length'));
            
            $search = $this->input->post('search');
            $searchValue = is_array($search) ? $search['value'] : '';

            // Get filter parameters
            $filters = array();
            
            $filterUser = $this->input->post('filterUser');
            $filterModule = $this->input->post('filterModule');
            $filterAction = $this->input->post('filterAction');
            $dateFrom = $this->input->post('dateFrom');
            $dateTo = $this->input->post('dateTo');

            if (!empty($filterUser)) {
                $filters['user_id'] = $filterUser;
            }
            if (!empty($filterModule)) {
                $filters['module'] = $filterModule;
            }
            if (!empty($filterAction)) {
                $filters['action'] = $filterAction;
            }
            if (!empty($dateFrom)) {
                $filters['date_from'] = $dateFrom;
            }
            if (!empty($dateTo)) {
                $filters['date_to'] = $dateTo;
            }
            if (!empty($searchValue)) {
                $filters['search'] = $searchValue;
            }

            $filters['exclude_actions'] = array('login', 'logout');

            // Calculate page
            $perPage = $length > 0 ? $length : 20;
            $page = ($start / $perPage) + 1;
            
            // Get data
            $result = $this->Log_model->get_activity_logs($filters, $page, $perPage);

            $data = array();
            $sno = $start + 1;
            
            if (!empty($result['logs'])) {
                foreach ($result['logs'] as $log) {
                    $actionClass = 'label-success';
                    if ($log['action'] == 'edit') $actionClass = 'label-warning';
                    elseif ($log['action'] == 'delete') $actionClass = 'label-danger';
                    elseif ($log['action'] == 'download') $actionClass = 'label-info';

                    $details = !empty($log['details']) ? htmlspecialchars(substr($log['details'], 0, 50)) : '-';
                    if (!empty($log['details']) && strlen($log['details']) > 50) {
                        $details .= '...';
                    }

                    $data[] = array(
                        $sno++,
                        date('d/m/Y H:i:s', strtotime($log['created_at'])),
                        htmlspecialchars($log['user_name']),
                        '<span class="label ' . $actionClass . '">' . strtoupper($log['action']) . '</span>',
                        htmlspecialchars($log['module']),
                        $log['record_id'] ? $log['record_id'] : '-',
                        $log['table_name'] ? htmlspecialchars($log['table_name']) : '-',
                        $details,
                        htmlspecialchars($log['ip_address']),
                        '<a href="' . base_url('activitylog/view/' . $log['id']) . '" class="btn btn-info btn-sm"><i class="fa fa-eye"></i></a>'
                    );
                }
            }

            $response = array(
                'draw' => $draw,
                'recordsTotal' => $result['total'],
                'recordsFiltered' => $result['total'],
                'data' => $data
            );

            header('Content-Type: application/json');
            echo json_encode($response);
        } catch (Exception $e) {
            header('Content-Type: application/json');
            echo json_encode([
                'error' => $e->getMessage(),
                'draw' => isset($draw) ? $draw : 0,
                'recordsTotal' => 0,
                'recordsFiltered' => 0,
                'data' => []
            ]);
        }
    }
    
    /**
     * View detailed activity log
     */
    public function view($id) {
        if (!$this->hasListAccess()) {
            $this->loadThis();
        } else {
            $this->db->select('ual.*');
            $this->db->from('user_activity_logs as ual');
            $this->db->where('ual.id', $id);
            $query = $this->db->get();
            $data['log'] = $query->row_array();
            
            if (empty($data['log'])) {
                $this->session->set_flashdata('error', 'Activity log not found');
                redirect('activitylog');
                return;
            }
            
            // Decode JSON data if present
            if (!empty($data['log']['record_data'])) {
                $data['log']['record_data_decoded'] = json_decode($data['log']['record_data'], true);
            }
            if (!empty($data['log']['old_data'])) {
                $data['log']['old_data_decoded'] = json_decode($data['log']['old_data'], true);
            }
            
            $this->global['pageTitle'] = 'Jan Umang : Activity Log Details';
            $this->loadViews("activitylog/view", $this->global, $data, NULL);
        }
    }
    
    /**
     * User Activity Report - Date wise activity and time spent
     */
    public function report() {
        if (!$this->hasListAccess()) {
            $this->loadThis();
        } else {
            // Get filter parameters
            $selectedUser = $this->input->post('selectedUser') ? $this->input->post('selectedUser') : $this->input->get('selectedUser');
            $dateFrom = $this->input->post('dateFrom') ? $this->input->post('dateFrom') : $this->input->get('dateFrom');
            $dateTo = $this->input->post('dateTo') ? $this->input->post('dateTo') : $this->input->get('dateTo');
            $reportType = $this->input->post('reportType') ? $this->input->post('reportType') : $this->input->get('reportType');
            
            // Default date range (last 30 days if not specified)
            if (empty($dateFrom)) {
                $dateFrom = date('Y-m-d', strtotime('-30 days'));
            }
            if (empty($dateTo)) {
                $dateTo = date('Y-m-d');
            }
            if (empty($reportType)) {
                $reportType = 'summary';
            }
            
            // Get all users for filter dropdown
            $this->db->select('userId, name, email');
            $this->db->from('tbl_users');
            $this->db->where('isDeleted', 0);
            $this->db->order_by('name', 'ASC');
            $query = $this->db->get();
            $data['users'] = $query->result();
            
            // Initialize reportData
            $data['reportData'] = array();
            $data['sessionData'] = array();
            $data['treeData'] = array();
            
            // Check if user_activity_logs table exists
            if ($this->db->table_exists('user_activity_logs')) {
                // Get report data based on type
                if ($reportType === 'detailed') {
                    $data['reportData'] = $this->Log_model->get_detailed_activity_report($selectedUser, $dateFrom, $dateTo);
                    log_message('debug', 'Detailed Report - Count: ' . count($data['reportData']));
                } elseif ($reportType === 'timeline') {
                    // Get timeline view data (only for specific user selection)
                    if ($selectedUser) {
                        $treeData = $this->Log_model->get_tree_view_report($selectedUser, $dateFrom, $dateTo);
                        $data['treeData'] = $treeData;
                        
                        // Debug logging
                        log_message('debug', 'Timeline View - User ID: ' . $selectedUser . ', Date From: ' . $dateFrom . ', Date To: ' . $dateTo);
                        log_message('debug', 'Timeline View Data Count: ' . count($treeData));
                        
                        // Add flash message for debugging
                        if (empty($treeData)) {
                            $this->session->set_flashdata('info', 'No activities found for selected user and date range in Timeline view.');
                            log_message('debug', 'Timeline View - No data found for the selected criteria');
                        } else {
                            $this->session->set_flashdata('success', 'Timeline data loaded: ' . count($treeData) . ' days with activities.');
                        }
                    } else {
                        $this->session->set_flashdata('error', 'Please select a specific user for Timeline View report.');
                        log_message('debug', 'Timeline View - No user selected');
                    }
                } else {
                    // Summary report
                    // Try enhanced report first (if user_sessions table exists)
                    if ($this->db->table_exists('user_sessions')) {
                        try {
                            $data['reportData'] = $this->Log_model->get_enhanced_summary_report($selectedUser, $dateFrom, $dateTo);
                        } catch (Exception $e) {
                            // Fallback to basic report
                            $data['reportData'] = $this->Log_model->get_summary_activity_report($selectedUser, $dateFrom, $dateTo);
                        }
                    } else {
                        $data['reportData'] = $this->Log_model->get_summary_activity_report($selectedUser, $dateFrom, $dateTo);
                    }
                }
                
                // Get login/logout data for time calculation (fallback)
                $data['sessionData'] = $this->Log_model->get_session_time_report($selectedUser, $dateFrom, $dateTo);
            } else {
                // Tables don't exist, show message to create them
                $this->session->set_flashdata('error', 'Activity logging tables not found. Please run the database setup scripts first.');
            }
            
            $data['filters'] = array(
                'selectedUser' => $selectedUser,
                'dateFrom' => $dateFrom,
                'dateTo' => $dateTo,
                'reportType' => $reportType
            );
            
            $this->global['pageTitle'] = 'Jan Umang : User Activity Report';
            $this->loadViews("activitylog/report", $this->global, $data, NULL);
        }
    }
    
    /**
     * Export User Activity Report to Excel
     */
    public function export() {
        if (!$this->hasListAccess()) {
            $this->loadThis();
        } else {
            // Get filter parameters
            $selectedUser = $this->input->get('selectedUser');
            $dateFrom = $this->input->get('dateFrom');
            $dateTo = $this->input->get('dateTo');
            $reportType = $this->input->get('reportType') ? $this->input->get('reportType') : 'summary';
            
            // Default date range if not specified
            if (empty($dateFrom)) {
                $dateFrom = date('Y-m-d', strtotime('-30 days'));
            }
            if (empty($dateTo)) {
                $dateTo = date('Y-m-d');
            }
            
            // Get report data
            if ($reportType === 'detailed') {
                $reportData = $this->Log_model->get_detailed_activity_report($selectedUser, $dateFrom, $dateTo);
                $this->export_detailed_report($reportData, $dateFrom, $dateTo, $selectedUser);
            } elseif ($reportType === 'timeline') {
                $treeData = $this->Log_model->get_tree_view_report($selectedUser, $dateFrom, $dateTo);
                $this->export_timeline_report($treeData, $dateFrom, $dateTo, $selectedUser);
            } else {
                $reportData = $this->Log_model->get_summary_activity_report($selectedUser, $dateFrom, $dateTo);
                $this->export_summary_report($reportData, $dateFrom, $dateTo, $selectedUser);
            }
        }
    }
    
    /**
     * Export summary report to CSV
     */
    private function export_summary_report($reportData, $dateFrom, $dateTo, $selectedUser = null) {
        // Set headers for CSV download
        $filename = 'user_activity_summary_' . $dateFrom . '_to_' . $dateTo . '.csv';
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        
        // Open output stream
        $output = fopen('php://output', 'w');
        
        // CSV headers
        fputcsv($output, array(
            'Date',
            'User Name',
            'Login Time',
            'Logout Time', 
            'Session Duration (Hours)',
            'Total Activities',
            'Add Actions',
            'Edit Actions',
            'Delete Actions',
            'View Actions',
            'Download Actions'
        ));
        
        // Write data rows
        foreach ($reportData as $row) {
            fputcsv($output, array(
                $row['activity_date'],
                $row['user_name'],
                $row['login_time'] ? $row['login_time'] : 'N/A',
                $row['logout_time'] ? $row['logout_time'] : 'N/A',
                $row['session_hours'] ? number_format($row['session_hours'], 2) : '0.00',
                $row['total_activities'],
                $row['add_count'],
                $row['edit_count'],
                $row['delete_count'],
                $row['view_count'],
                $row['download_count']
            ));
        }
        
        fclose($output);
    }
    
    /**
     * Export detailed report to CSV
     */
    private function export_detailed_report($reportData, $dateFrom, $dateTo, $selectedUser = null) {
        // Set headers for CSV download
        $filename = 'user_activity_detailed_' . $dateFrom . '_to_' . $dateTo . '.csv';
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        
        // Open output stream
        $output = fopen('php://output', 'w');
        
        // CSV headers
        fputcsv($output, array(
            'Date Time',
            'User Name',
            'Action',
            'Module',
            'Table Name',
            'Record ID',
            'Details',
            'IP Address'
        ));
        
        // Write data rows
        foreach ($reportData as $row) {
            fputcsv($output, array(
                $row['created_at'],
                $row['user_name'],
                $row['action'],
                $row['module'],
                $row['table_name'] ? $row['table_name'] : 'N/A',
                $row['record_id'] ? $row['record_id'] : 'N/A',
                $row['details'] ? $row['details'] : 'N/A',
                $row['ip_address']
            ));
        }
        
        fclose($output);
    }
    
    /**
     * Export timeline report to CSV
     */
    private function export_timeline_report($treeData, $dateFrom, $dateTo, $selectedUser = null) {
        // Set headers for CSV download
        $filename = 'user_activity_timeline_' . $dateFrom . '_to_' . $dateTo . '.csv';
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        
        // Open output stream
        $output = fopen('php://output', 'w');
        
        // CSV headers
        fputcsv($output, array(
            'Date',
            'Time',
            'User Name',
            'Action',
            'Module',
            'Table Name',
            'Record ID',
            'Details',
            'IP Address'
        ));
        
        // Write data rows
        foreach ($treeData as $date => $dateData) {
            foreach ($dateData['activities'] as $activity) {
                fputcsv($output, array(
                    $date,
                    $activity['activity_time'],
                    $activity['user_name'],
                    ucfirst($activity['action']),
                    $activity['module'],
                    $activity['table_name'] ? $activity['table_name'] : 'N/A',
                    $activity['record_id'] ? $activity['record_id'] : 'N/A',
                    $activity['details'] ? $activity['details'] : 'N/A',
                    $activity['ip_address']
                ));
            }
        }
        
        fclose($output);
    }
    
    /**
     * Debug timeline view data (for testing)
     */
    public function debug_timeline() {
        $this->load->model('Log_model');
        
        echo "<h1>Timeline View Debug</h1>";
        
        // Get all users
        $this->db->select('userId, name');
        $this->db->from('tbl_users');
        $this->db->where('roleId !=', ROLE_ADMIN);
        $users = $this->db->get()->result_array();
        
        if (empty($users)) {
            echo "<p>No users found</p>";
            return;
        }
        
        $user_id = $users[0]['userId'];
        $user_name = $users[0]['name'];
        $date_from = date('Y-m-d', strtotime('-7 days'));
        $date_to = date('Y-m-d');
        
        echo "<h3>Testing with:</h3>";
        echo "<ul>";
        echo "<li>User: " . $user_name . " (ID: " . $user_id . ")</li>";
        echo "<li>Date Range: " . $date_from . " to " . $date_to . "</li>";
        echo "</ul>";
        
        // Get timeline data
        $treeData = $this->Log_model->get_tree_view_report($user_id, $date_from, $date_to);
        
        echo "<h3>Results:</h3>";
        echo "<p>Timeline data contains " . count($treeData) . " days of data</p>";
        
        if (!empty($treeData)) {
            echo "<h4>Sample Data Structure:</h4>";
            echo "<pre>";
            $sample = array_slice($treeData, 0, 2, true); // First 2 days
            foreach ($sample as $date => $data) {
                echo "Date: " . $date . "\n";
                echo "  Activities: " . count($data['activities']) . "\n";
                echo "  Session Info: " . ($data['session_info'] ? 'Yes' : 'No') . "\n";
                if (!empty($data['activities'])) {
                    echo "  Sample Activity: " . $data['activities'][0]['action'] . " on " . $data['activities'][0]['module'] . "\n";
                }
                echo "\n";
            }
            echo "</pre>";
        } else {
            echo "<p style='color:red;'>No data found!</p>";
            
            // Check if tables exist and have data
            $activity_exists = $this->db->table_exists('user_activity_logs');
            $session_exists = $this->db->table_exists('user_sessions');
            
            echo "<h4>Diagnostics:</h4>";
            echo "<ul>";
            echo "<li>user_activity_logs table exists: " . ($activity_exists ? 'Yes' : 'No') . "</li>";
            echo "<li>user_sessions table exists: " . ($session_exists ? 'Yes' : 'No') . "</li>";
            
            if ($activity_exists) {
                $count = $this->db->count_all('user_activity_logs');
                echo "<li>Total activity records: " . $count . "</li>";
                
                if ($count > 0) {
                    $this->db->select('COUNT(*) as user_count');
                    $this->db->from('user_activity_logs');
                    $this->db->where('user_id', $user_id);
                    $user_activities = $this->db->get()->row();
                    echo "<li>Activities for user " . $user_id . ": " . $user_activities->user_count . "</li>";
                }
            }
            echo "</ul>";
        }
        
        echo "<br><p><a href='" . site_url('activitylog/report') . "'>Back to Activity Report</a></p>";
        echo "<p><a href='" . site_url('database_setup/generate_sample_data') . "'>Generate Sample Data</a></p>";
    }
}

