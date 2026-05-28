<?php

class Log_model extends CI_Model {
    public function log_action($action, $table_name, $row_id, $data) {
        // Convert the array data to JSON
        $json_data = json_encode($data);

        // Set the timezone to India Standard Time (IST)
        $datetime = new DateTime("now", new DateTimeZone('Asia/Kolkata'));
        $timestamp = $datetime->format('Y-m-d H:i:s'); // Format the timestamp
        
        $log_data = array(
            'action' => $action,
            'table_name' => $table_name,
            'data' => $json_data,  // Store the data as JSON
            'row_id' => $row_id,
            'user_id' => $this->session->userdata('userId'),  // Assuming you store user_id in session
            'timestamp' => $timestamp  // Add the timestamp with India timezone
        );
        
        $this->db->insert('logs', $log_data);
    }
    
    /**
     * Log user activity with comprehensive details
     * @param string $action - Action type: 'add', 'edit', 'delete', 'download', 'view'
     * @param string $module - Module name (e.g., 'Voter', 'Events', 'MemberList')
     * @param string $table_name - Database table name
     * @param int $record_id - ID of the affected record
     * @param array $record_data - Current record data (for add/edit)
     * @param array $old_data - Old record data (for edit, to show what changed)
     * @param string $details - Additional details about the action
     * @param int $user_id - User ID (optional, will use session if not provided)
     * @param string $user_name - User name (optional, will fetch if not provided)
     */
    public function log_activity($action, $module, $table_name = null, $record_id = null, $record_data = null, $old_data = null, $details = null, $user_id = null, $user_name = null) {
        // Get user ID from session if not provided
        if ($user_id === null) {
            $user_id = $this->session->userdata('userId');
        }
        
        // Get user name if not provided
        if ($user_name === null && $user_id) {
            $this->db->select('name');
            $this->db->from('tbl_users');
            $this->db->where('userId', $user_id);
            $query = $this->db->get();
            if ($query->num_rows() > 0) {
                $user_name = $query->row()->name;
            }
        }
        
        // Get IP address using improved detection method
        $ip_address = $this->get_real_ip_address();
        
        // Get user agent
        $user_agent = $this->input->user_agent();
        
        // Convert data to JSON if it's an array
        $record_data_json = null;
        if ($record_data !== null) {
            $record_data_json = is_array($record_data) ? json_encode($record_data) : $record_data;
        }
        
        $old_data_json = null;
        if ($old_data !== null) {
            $old_data_json = is_array($old_data) ? json_encode($old_data) : $old_data;
        }
        
        // Prepare log data with IST timezone for created_at
        $dtIst = new DateTime('now', new DateTimeZone('Asia/Kolkata'));
        $createdAtIst = $dtIst->format('Y-m-d H:i:s');
        
        // Prepare log data
        $log_data = array(
            'user_id' => $user_id,
            'user_name' => $user_name,
            'action' => $action,
            'module' => $module,
            'table_name' => $table_name,
            'record_id' => $record_id,
            'record_data' => $record_data_json,
            'old_data' => $old_data_json,
            'details' => $details,
            'ip_address' => $ip_address,
            'user_agent' => $user_agent,
            'created_at' => $createdAtIst
        );
        
        // Insert into user_activity_logs table
        $this->db->insert('user_activity_logs', $log_data);
        
        // Also maintain backward compatibility with old logs table
        if ($record_data_json) {
            $old_log_data = array(
                'action' => $action,
                'table_name' => $table_name,
                'data' => $record_data_json,
                'row_id' => $record_id,
                'user_id' => $user_id,
                'timestamp' => date('Y-m-d H:i:s')
            );
            $this->db->insert('logs', $old_log_data);
        }
    }
    
    /**
     * Get real IP address of the user
     * Handles proxy headers and localhost scenarios
     * @return string IP address
     */
    private function get_real_ip_address() {
        $ip_keys = array(
            'HTTP_CF_CONNECTING_IP', // Cloudflare
            'HTTP_X_REAL_IP',         // Nginx proxy
            'HTTP_X_FORWARDED_FOR',   // Proxy/Load balancer
            'HTTP_X_FORWARDED',       // Proxy
            'HTTP_X_CLUSTER_CLIENT_IP', // Cluster
            'HTTP_FORWARDED_FOR',     // Proxy
            'HTTP_FORWARDED',         // Proxy
            'REMOTE_ADDR'             // Standard
        );
        
        foreach ($ip_keys as $key) {
            if (array_key_exists($key, $_SERVER) === true) {
                $ip = $_SERVER[$key];
                
                // Handle comma-separated IPs (from X-Forwarded-For)
                if (strpos($ip, ',') !== false) {
                    $ips = explode(',', $ip);
                    $ip = trim($ips[0]);
                }
                
                // Validate IP address (including private ranges for localhost)
                if (filter_var($ip, FILTER_VALIDATE_IP) !== false) {
                    // Convert IPv6 localhost to IPv4 for better readability
                    if ($ip === '::1' || $ip === '::') {
                        return '127.0.0.1';
                    }
                    return $ip;
                }
            }
        }
        
        // Fallback to CodeIgniter's method
        $ip = $this->input->ip_address();
        
        // Convert IPv6 localhost to IPv4 for better readability
        if ($ip === '::1' || $ip === '::') {
            return '127.0.0.1';
        }
        
        // Validate the IP (including private ranges)
        if (filter_var($ip, FILTER_VALIDATE_IP) !== false) {
            return $ip;
        }
        
        // Final fallback to REMOTE_ADDR
        if (isset($_SERVER['REMOTE_ADDR'])) {
            $final_ip = $_SERVER['REMOTE_ADDR'];
            // Convert IPv6 localhost
            if ($final_ip === '::1' || $final_ip === '::') {
                return '127.0.0.1';
            }
            return $final_ip;
        }
        
        return 'Unknown';
    }
    
    /**
     * Get activity logs with filters
     * @param array $filters - Array of filters (user_id, module, action, date_from, date_to, search)
     * @param int $page - Page number for pagination
     * @param int $per_page - Records per page
     * @return array
     */
    public function get_activity_logs($filters = array(), $page = 1, $per_page = 20) {
        // Build count query first
        $this->db->select('COUNT(*) as total');
        $this->db->from('user_activity_logs as ual');
        
        // Apply filters for count
        if (!empty($filters['user_id'])) {
            $this->db->where('ual.user_id', $filters['user_id']);
        }
        
        if (!empty($filters['module'])) {
            $this->db->where('ual.module', $filters['module']);
        }
        
        if (!empty($filters['action'])) {
            $this->db->where('ual.action', $filters['action']);
        }
        
        if (!empty($filters['date_from'])) {
            $this->db->where("DATE(ual.created_at) >= ", date('Y-m-d', strtotime($filters['date_from'])));
        }
        
        if (!empty($filters['date_to'])) {
            $this->db->where("DATE(ual.created_at) <= ", date('Y-m-d', strtotime($filters['date_to'])));
        }
        
        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $this->db->group_start();
            $this->db->like('ual.user_name', $search);
            $this->db->or_like('ual.module', $search);
            $this->db->or_like('ual.action', $search);
            $this->db->or_like('ual.details', $search);
            $this->db->group_end();
        }
        // Exclude/include by actions for count
        if (!empty($filters['exclude_actions']) && is_array($filters['exclude_actions'])) {
            $this->db->where_not_in('ual.action', $filters['exclude_actions']);
        }
        if (!empty($filters['only_actions']) && is_array($filters['only_actions'])) {
            $this->db->where_in('ual.action', $filters['only_actions']);
        }
        
        $count_query = $this->db->get();
        $count_result = $count_query->row();
        $total_records = $count_result ? $count_result->total : 0;
        
        // Now build the actual data query
        $this->db->select('ual.*');
        $this->db->from('user_activity_logs as ual');
        
        // Apply same filters
        if (!empty($filters['user_id'])) {
            $this->db->where('ual.user_id', $filters['user_id']);
        }
        
        if (!empty($filters['module'])) {
            $this->db->where('ual.module', $filters['module']);
        }
        
        if (!empty($filters['action'])) {
            $this->db->where('ual.action', $filters['action']);
        }
        
        if (!empty($filters['date_from'])) {
            $this->db->where("DATE(ual.created_at) >= ", date('Y-m-d', strtotime($filters['date_from'])));
        }
        
        if (!empty($filters['date_to'])) {
            $this->db->where("DATE(ual.created_at) <= ", date('Y-m-d', strtotime($filters['date_to'])));
        }
        
        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $this->db->group_start();
            $this->db->like('ual.user_name', $search);
            $this->db->or_like('ual.module', $search);
            $this->db->or_like('ual.action', $search);
            $this->db->or_like('ual.details', $search);
            $this->db->group_end();
        }
        // Exclude/include by actions for data
        if (!empty($filters['exclude_actions']) && is_array($filters['exclude_actions'])) {
            $this->db->where_not_in('ual.action', $filters['exclude_actions']);
        }
        if (!empty($filters['only_actions']) && is_array($filters['only_actions'])) {
            $this->db->where_in('ual.action', $filters['only_actions']);
        }
        
        // Apply pagination
        $offset = ($page - 1) * $per_page;
        $this->db->limit($per_page, $offset);
        
        // Order by latest first
        $this->db->order_by('ual.created_at', 'DESC');
        
        $query = $this->db->get();
        $results = $query->result_array();
        
        return array(
            'logs' => $results,
            'total' => $total_records
        );
    }
    
    /**
     * Get activity log count
     */
    public function get_activity_logs_count($filters = array()) {
        $this->db->select('COUNT(*) as total');
        $this->db->from('user_activity_logs as ual');
        
        // Apply same filters as get_activity_logs
        if (!empty($filters['user_id'])) {
            $this->db->where('ual.user_id', $filters['user_id']);
        }
        
        if (!empty($filters['module'])) {
            $this->db->where('ual.module', $filters['module']);
        }
        
        if (!empty($filters['action'])) {
            $this->db->where('ual.action', $filters['action']);
        }
        
        if (!empty($filters['date_from'])) {
            $this->db->where("DATE(ual.created_at) >= ", date('Y-m-d', strtotime($filters['date_from'])));
        }
        
        if (!empty($filters['date_to'])) {
            $this->db->where("DATE(ual.created_at) <= ", date('Y-m-d', strtotime($filters['date_to'])));
        }
        
        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $this->db->group_start();
            $this->db->like('ual.user_name', $search);
            $this->db->or_like('ual.module', $search);
            $this->db->or_like('ual.action', $search);
            $this->db->or_like('ual.details', $search);
            $this->db->group_end();
        }
        
        $query = $this->db->get();
        $result = $query->row();
        return $result ? $result->total : 0;
    }
    
    /**
     * Get summary activity report - date wise user activity with time spent
     * @param int $user_id - Filter by specific user (optional)
     * @param string $date_from - Start date (Y-m-d format)
     * @param string $date_to - End date (Y-m-d format)
     * @return array
     */
    public function get_summary_activity_report($user_id = null, $date_from = null, $date_to = null) {
        // First try to use user_sessions table for accurate login/logout times
        if ($this->db->table_exists('user_sessions')) {
            return $this->get_enhanced_summary_report($user_id, $date_from, $date_to);
        }
        
        // Fallback: Build the query to get daily summary per user from activity logs
        $sql = "
        SELECT 
            DATE(CONVERT_TZ(ual.created_at, '+00:00', '+05:30')) as activity_date,
            ual.user_id,
            ual.user_name,
            COUNT(CASE WHEN ual.action NOT IN ('login', 'logout') THEN 1 END) as total_activities,
            SUM(CASE WHEN ual.action = 'add' THEN 1 ELSE 0 END) as add_count,
            SUM(CASE WHEN ual.action = 'edit' THEN 1 ELSE 0 END) as edit_count,
            SUM(CASE WHEN ual.action = 'delete' THEN 1 ELSE 0 END) as delete_count,
            SUM(CASE WHEN ual.action = 'view' THEN 1 ELSE 0 END) as view_count,
            SUM(CASE WHEN ual.action = 'download' THEN 1 ELSE 0 END) as download_count,
            MIN(CASE WHEN ual.action = 'login' THEN TIME(CONVERT_TZ(ual.created_at, '+00:00', '+05:30')) END) as login_time,
            MAX(CASE WHEN ual.action = 'logout' THEN TIME(CONVERT_TZ(ual.created_at, '+00:00', '+05:30')) END) as logout_time
        FROM user_activity_logs ual
        WHERE 1=1
        ";
        
        $params = array();
        
        if ($user_id) {
            $sql .= " AND ual.user_id = ?";
            $params[] = $user_id;
        }
        
        if ($date_from) {
            $sql .= " AND DATE(CONVERT_TZ(ual.created_at, '+00:00', '+05:30')) >= ?";
            $params[] = $date_from;
        }
        
        if ($date_to) {
            $sql .= " AND DATE(CONVERT_TZ(ual.created_at, '+00:00', '+05:30')) <= ?";
            $params[] = $date_to;
        }
        
        $sql .= " GROUP BY DATE(CONVERT_TZ(ual.created_at, '+00:00', '+05:30')), ual.user_id, ual.user_name
                 ORDER BY activity_date DESC, ual.user_name ASC";
        
        $query = $this->db->query($sql, $params);
        $results = $query->result_array();
        
        // Calculate session duration for each row
        foreach ($results as &$row) {
            if ($row['login_time'] && $row['logout_time']) {
                $login = new DateTime($row['activity_date'] . ' ' . $row['login_time']);
                $logout = new DateTime($row['activity_date'] . ' ' . $row['logout_time']);
                $diff = $logout->diff($login);
                $row['session_hours'] = $diff->h + ($diff->i / 60) + ($diff->s / 3600);
            } else {
                $row['session_hours'] = 0;
            }
        }
        
        return $results;
    }
    
    /**
     * Get detailed activity report - all activities with user details
     * @param int $user_id - Filter by specific user (optional)
     * @param string $date_from - Start date (Y-m-d format)
     * @param string $date_to - End date (Y-m-d format)
     * @return array
     */
    public function get_detailed_activity_report($user_id = null, $date_from = null, $date_to = null) {
        $this->db->select('
            ual.id,
            ual.user_id,
            ual.user_name,
            ual.action,
            ual.module,
            ual.table_name,
            ual.record_id,
            ual.details,
            ual.ip_address,
            ual.created_at,
            DATE(ual.created_at) as activity_date,
            TIME(ual.created_at) as activity_time
        ');
        $this->db->from('user_activity_logs as ual');
        
        if ($user_id) {
            $this->db->where('ual.user_id', $user_id);
        }
        
        if ($date_from) {
            $this->db->where("DATE(ual.created_at) >= ", $date_from);
        }
        
        if ($date_to) {
            $this->db->where("DATE(ual.created_at) <= ", $date_to);
        }
        
        // Exclude login/logout from detailed view as they're handled separately
        $this->db->where_not_in('ual.action', array('login', 'logout'));
        
        $this->db->order_by('ual.created_at', 'DESC');
        
        $query = $this->db->get();
        return $query->result_array();
    }
    
    /**
     * Get session time report - login/logout data for time calculation
     * @param int $user_id - Filter by specific user (optional)
     * @param string $date_from - Start date (Y-m-d format)
     * @param string $date_to - End date (Y-m-d format)
     * @return array
     */
    public function get_session_time_report($user_id = null, $date_from = null, $date_to = null) {
        $this->db->select('
            ual.user_id,
            ual.user_name,
            ual.action,
            ual.created_at,
            DATE(ual.created_at) as activity_date,
            TIME(ual.created_at) as activity_time
        ');
        $this->db->from('user_activity_logs as ual');
        
        if ($user_id) {
            $this->db->where('ual.user_id', $user_id);
        }
        
        if ($date_from) {
            $this->db->where("DATE(ual.created_at) >= ", $date_from);
        }
        
        if ($date_to) {
            $this->db->where("DATE(ual.created_at) <= ", $date_to);
        }
        
        // Only login/logout actions
        $this->db->where_in('ual.action', array('login', 'logout'));
        
        $this->db->order_by('ual.user_id', 'ASC');
        $this->db->order_by('ual.created_at', 'ASC');
        
        $query = $this->db->get();
        return $query->result_array();
    }
    
    /**
     * Log user login activity
     */
    public function log_user_login($user_id, $user_name = null) {
        $this->log_activity('login', 'Authentication', null, null, null, null, 'User logged in', $user_id, $user_name);
    }
    
    /**
     * Log user logout activity
     */
    public function log_user_logout($user_id, $user_name = null) {
        $this->log_activity('logout', 'Authentication', null, null, null, null, 'User logged out', $user_id, $user_name);
    }
    
    /**
     * Start user session tracking
     */
    public function start_user_session($user_id, $user_name = null, $session_id = null) {
        // Get user info
        if (!$user_name && $user_id) {
            $this->db->select('name');
            $this->db->from('tbl_users');
            $this->db->where('userId', $user_id);
            $query = $this->db->get();
            if ($query->num_rows() > 0) {
                $user_name = $query->row()->name;
            }
        }
        
        // Close any existing active sessions for this user with IST timezone
        $dtIst = new DateTime('now', new DateTimeZone('Asia/Kolkata'));
        $istDateTime = $dtIst->format('Y-m-d H:i:s');
        
        $this->db->where('user_id', $user_id);
        $this->db->where('is_active', 1);
        $this->db->update('user_sessions', [
            'is_active' => 0,
            'logout_time' => $istDateTime,
            'updated_at' => $istDateTime
        ]);
        
        // Calculate session duration for closed sessions
        $this->db->where('user_id', $user_id);
        $this->db->where('is_active', 0);
        $this->db->where('session_duration_minutes IS NULL');
        $this->db->where('logout_time IS NOT NULL');
        $query = $this->db->get('user_sessions');
        foreach ($query->result() as $session) {
            $login = new DateTime($session->login_time);
            $logout = new DateTime($session->logout_time);
            $diff = $logout->diff($login);
            $minutes = ($diff->h * 60) + $diff->i;
            
            $this->db->where('id', $session->id);
            $this->db->update('user_sessions', ['session_duration_minutes' => $minutes]);
        }
        
        // Get IP and user agent
        $ip_address = $this->get_real_ip_address();
        $user_agent = $this->input->user_agent();
        
        // Create new session record with IST timezone
        $dtIst = new DateTime('now', new DateTimeZone('Asia/Kolkata'));
        $istDateTime = $dtIst->format('Y-m-d H:i:s');
        
        $session_data = [
            'user_id' => $user_id,
            'user_name' => $user_name,
            'session_id' => $session_id ? $session_id : session_id(),
            'login_time' => $istDateTime,
            'ip_address' => $ip_address,
            'user_agent' => $user_agent,
            'is_active' => 1,
            'last_activity' => $istDateTime,
            'created_at' => $istDateTime
        ];
        
        $this->db->insert('user_sessions', $session_data);
        return $this->db->insert_id();
    }
    
    /**
     * End user session tracking
     */
    public function end_user_session($user_id) {
        // Get active session
        $this->db->select('*');
        $this->db->from('user_sessions');
        $this->db->where('user_id', $user_id);
        $this->db->where('is_active', 1);
        $this->db->order_by('id', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get();
        
        if ($query->num_rows() > 0) {
            $session = $query->row();
            
            // Calculate session duration
            $login = new DateTime($session->login_time);
            $logout = new DateTime();
            $diff = $logout->diff($login);
            $minutes = ($diff->h * 60) + $diff->i;
            
            // Update session with IST timezone
            $dtIst = new DateTime('now', new DateTimeZone('Asia/Kolkata'));
            $istDateTime = $dtIst->format('Y-m-d H:i:s');
            
            $this->db->where('id', $session->id);
            $this->db->update('user_sessions', [
                'logout_time' => $istDateTime,
                'session_duration_minutes' => $minutes,
                'is_active' => 0,
                'updated_at' => $istDateTime
            ]);
            
            return $minutes;
        }
        
        return 0;
    }
    
    /**
     * Update user session activity
     */
    public function update_session_activity($user_id) {
        $dtIst = new DateTime('now', new DateTimeZone('Asia/Kolkata'));
        $istDateTime = $dtIst->format('Y-m-d H:i:s');
        
        $this->db->where('user_id', $user_id);
        $this->db->where('is_active', 1);
        $this->db->update('user_sessions', [
            'last_activity' => $istDateTime
        ]);
    }
    
    /**
     * Get enhanced summary activity report with accurate session data
     */
    public function get_enhanced_summary_report($user_id = null, $date_from = null, $date_to = null) {
        $sql = "
        SELECT 
            DATE(us.login_time) as activity_date,
            us.user_id,
            us.user_name,
            MIN(TIME(us.login_time)) as first_login_time,
            MAX(CASE WHEN us.logout_time IS NOT NULL THEN TIME(us.logout_time) END) as last_logout_time,
            SUM(COALESCE(us.session_duration_minutes, 
                CASE WHEN us.logout_time IS NOT NULL 
                THEN TIMESTAMPDIFF(MINUTE, us.login_time, us.logout_time) 
                ELSE 0 END)) as total_session_minutes,
            COUNT(us.id) as session_count,
            COUNT(CASE WHEN us.is_active = 1 THEN 1 END) as active_sessions,
            -- Activity counts from activity logs
            COALESCE(al.total_activities, 0) as total_activities,
            COALESCE(al.add_count, 0) as add_count,
            COALESCE(al.edit_count, 0) as edit_count,
            COALESCE(al.delete_count, 0) as delete_count,
            COALESCE(al.view_count, 0) as view_count,
            COALESCE(al.download_count, 0) as download_count
        FROM user_sessions us
        LEFT JOIN (
            SELECT 
                DATE(created_at) as activity_date,
                user_id,
                COUNT(*) as total_activities,
                SUM(CASE WHEN action = 'add' THEN 1 ELSE 0 END) as add_count,
                SUM(CASE WHEN action = 'edit' THEN 1 ELSE 0 END) as edit_count,
                SUM(CASE WHEN action = 'delete' THEN 1 ELSE 0 END) as delete_count,
                SUM(CASE WHEN action = 'view' THEN 1 ELSE 0 END) as view_count,
                SUM(CASE WHEN action = 'download' THEN 1 ELSE 0 END) as download_count
            FROM user_activity_logs 
            WHERE action NOT IN ('login', 'logout')
        ";
        
        $params = array();
        
        if ($user_id) {
            $sql .= " AND user_id = ?";
            $params[] = $user_id;
        }
        
        if ($date_from) {
            $sql .= " AND DATE(created_at) >= ?";
            $params[] = $date_from;
        }
        
        if ($date_to) {
            $sql .= " AND DATE(created_at) <= ?";
            $params[] = $date_to;
        }
        
        $sql .= "
            GROUP BY DATE(created_at), user_id
        ) al ON DATE(us.login_time) = al.activity_date AND us.user_id = al.user_id
        WHERE 1=1
        ";
        
        if ($user_id) {
            $sql .= " AND us.user_id = ?";
            $params[] = $user_id;
        }
        
        if ($date_from) {
            $sql .= " AND DATE(us.login_time) >= ?";
            $params[] = $date_from;
        }
        
        if ($date_to) {
            $sql .= " AND DATE(us.login_time) <= ?";
            $params[] = $date_to;
        }
        
        $sql .= " GROUP BY DATE(us.login_time), us.user_id, us.user_name
                 ORDER BY activity_date DESC, us.user_name ASC";
        
        $query = $this->db->query($sql, $params);
        $results = $query->result_array();
        
        // Convert minutes to hours and format data
        foreach ($results as &$row) {
            $row['session_hours'] = $row['total_session_minutes'] / 60;
            $row['login_time'] = $row['first_login_time'];
            $row['logout_time'] = $row['last_logout_time'];
        }
        
        return $results;
    }
    
    /**
     * Fix timezone issues in existing data
     */
    public function fix_timezone_issues() {
        // Update session durations that might be calculated incorrectly
        $sql = "UPDATE user_sessions 
                SET session_duration_minutes = TIMESTAMPDIFF(MINUTE, login_time, logout_time)
                WHERE logout_time IS NOT NULL 
                AND (session_duration_minutes IS NULL OR session_duration_minutes = 0)";
        
        $this->db->query($sql);
        
        return $this->db->affected_rows();
    }
    
    /**
     * Get current server timezone info for debugging
     */
    public function get_timezone_info() {
        $info = array();
        
        // Current PHP timezone
        $info['php_timezone'] = date_default_timezone_get();
        $info['php_datetime'] = date('Y-m-d H:i:s');
        
        // MySQL timezone
        $query = $this->db->query("SELECT @@session.time_zone as mysql_timezone, NOW() as mysql_datetime");
        $result = $query->row_array();
        $info['mysql_timezone'] = $result['mysql_timezone'];
        $info['mysql_datetime'] = $result['mysql_datetime'];
        
        // IST timezone
        $dtIst = new DateTime('now', new DateTimeZone('Asia/Kolkata'));
        $info['ist_datetime'] = $dtIst->format('Y-m-d H:i:s');
        
        return $info;
    }
    
    /**
     * Get tree view report - organized by date with timeline activities
     * @param int $user_id - Specific user ID (required for tree view)
     * @param string $date_from - Start date (Y-m-d format)
     * @param string $date_to - End date (Y-m-d format)
     * @return array
     */
    public function get_tree_view_report($user_id, $date_from = null, $date_to = null) {
        if (!$user_id) {
            log_message('debug', 'Tree View Model - No user ID provided');
            return array();
        }
        
        log_message('debug', 'Tree View Model - Starting query for User ID: ' . $user_id . ', Date From: ' . $date_from . ', Date To: ' . $date_to);
        
        // Get all activities for the user in date range
        $this->db->select('
            ual.id,
            ual.user_id,
            ual.user_name,
            ual.action,
            ual.module,
            ual.table_name,
            ual.record_id,
            ual.details,
            ual.ip_address,
            ual.created_at,
            DATE(ual.created_at) as activity_date,
            TIME(ual.created_at) as activity_time
        ');
        $this->db->from('user_activity_logs as ual');
        $this->db->where('ual.user_id', $user_id);
        
        if ($date_from) {
            $this->db->where("DATE(ual.created_at) >= ", $date_from);
        }
        
        if ($date_to) {
            $this->db->where("DATE(ual.created_at) <= ", $date_to);
        }
        
        $this->db->order_by('ual.created_at', 'ASC');
        
        $query = $this->db->get();
        $activities = $query->result_array();
        
        log_message('debug', 'Tree View Model - Activities query: ' . $this->db->last_query());
        log_message('debug', 'Tree View Model - Found ' . count($activities) . ' activities');
        
        // Get session data for the same period
        $sessionData = array();
        if ($this->db->table_exists('user_sessions')) {
            $this->db->select('
                DATE(login_time) as session_date,
                MIN(TIME(login_time)) as login_time,
                MAX(TIME(logout_time)) as logout_time,
                SUM(COALESCE(session_duration_minutes, 0)) / 60 as session_hours
            ');
            $this->db->from('user_sessions');
            $this->db->where('user_id', $user_id);
            
            if ($date_from) {
                $this->db->where("DATE(login_time) >= ", $date_from);
            }
            
            if ($date_to) {
                $this->db->where("DATE(login_time) <= ", $date_to);
            }
            
            $this->db->group_by('DATE(login_time)');
            $this->db->order_by('DATE(login_time)', 'ASC');
            
            $sessionQuery = $this->db->get();
            $sessions = $sessionQuery->result_array();
            
            // Index session data by date
            foreach ($sessions as $session) {
                $sessionData[$session['session_date']] = $session;
            }
        }
        
        // Organize activities by date
        $treeData = array();
        foreach ($activities as $activity) {
            $date = $activity['activity_date'];
            
            if (!isset($treeData[$date])) {
                $treeData[$date] = array(
                    'activities' => array(),
                    'session_info' => isset($sessionData[$date]) ? $sessionData[$date] : null
                );
            }
            
            $treeData[$date]['activities'][] = $activity;
        }
        
        // Sort dates in descending order (most recent first)
        krsort($treeData);
        
        log_message('debug', 'Tree View Model - Final tree data has ' . count($treeData) . ' dates');
        
        return $treeData;
    }
}
