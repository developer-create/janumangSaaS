<?php
require APPPATH . '/libraries/BaseController.php';

class Database_setup extends BaseController {

    public function __construct() {
        parent::__construct();
        $this->isLoggedIn();
        
        // Only allow admin users to access this
        if ($this->role != ROLE_ADMIN) {
            $this->loadThis();
            return;
        }
    }

    /**
     * Setup activity logging tables
     */
    public function activity_tables() {
        echo "<h1>Activity Logging Database Setup</h1>";
        
        // Check if tables exist
        $user_activity_exists = $this->db->table_exists('user_activity_logs');
        $user_sessions_exists = $this->db->table_exists('user_sessions');
        
        echo "<h3>Current Status:</h3>";
        echo "<ul>";
        echo "<li>user_activity_logs table: " . ($user_activity_exists ? "<span style='color:green'>EXISTS</span>" : "<span style='color:red'>NOT FOUND</span>") . "</li>";
        echo "<li>user_sessions table: " . ($user_sessions_exists ? "<span style='color:green'>EXISTS</span>" : "<span style='color:red'>NOT FOUND</span>") . "</li>";
        echo "</ul>";
        
        if (!$user_activity_exists || !$user_sessions_exists) {
            echo "<h3>Setup Instructions:</h3>";
            echo "<p>Please run the following SQL files in your database:</p>";
            echo "<ol>";
            if (!$user_activity_exists) {
                echo "<li><code>database/user_activity_logs.sql</code> - Creates the main activity logging table</li>";
            }
            if (!$user_sessions_exists) {
                echo "<li><code>database/user_sessions.sql</code> - Creates the session tracking table for accurate time calculation</li>";
            }
            echo "</ol>";
            
            echo "<h3>Quick Setup (Auto-create tables):</h3>";
            echo "<p><a href='" . site_url('database_setup/create_tables') . "' class='btn btn-primary' onclick='return confirm(\"This will create the required database tables. Continue?\")'>Auto-Create Tables</a></p>";
        } else {
            echo "<h3>✅ All Required Tables Exist</h3>";
            echo "<p>Activity logging is properly configured. You can now use the activity reports.</p>";
            
            // Show table counts
            $activity_count = $this->db->count_all('user_activity_logs');
            $session_count = $this->db->count_all('user_sessions');
            
            echo "<h4>Current Data:</h4>";
            echo "<ul>";
            echo "<li>Activity Records: " . $activity_count . "</li>";
            echo "<li>Session Records: " . $session_count . "</li>";
            echo "</ul>";
        }
        
        echo "<br><p><a href='" . site_url('activitylog/report') . "'>Go to Activity Report</a></p>";
    }
    
    /**
     * Auto-create required tables
     */
    public function create_tables() {
        $created = array();
        $errors = array();
        
        // Create user_activity_logs table
        if (!$this->db->table_exists('user_activity_logs')) {
            $sql = "CREATE TABLE IF NOT EXISTS `user_activity_logs` (
              `id` bigint(20) NOT NULL AUTO_INCREMENT,
              `user_id` int(11) NOT NULL COMMENT 'User who performed the action',
              `user_name` varchar(255) DEFAULT NULL COMMENT 'User name for quick reference',
              `action` varchar(50) NOT NULL COMMENT 'Action type: add, edit, delete, download, view',
              `module` varchar(100) NOT NULL COMMENT 'Module name where action was performed',
              `table_name` varchar(100) DEFAULT NULL COMMENT 'Database table name',
              `record_id` int(11) DEFAULT NULL COMMENT 'ID of the record that was affected',
              `record_data` text DEFAULT NULL COMMENT 'JSON data of the record (for add/edit)',
              `old_data` text DEFAULT NULL COMMENT 'JSON data of old record (for edit)',
              `details` text DEFAULT NULL COMMENT 'Additional details about the action',
              `ip_address` varchar(45) DEFAULT NULL COMMENT 'IP address of the user',
              `user_agent` text DEFAULT NULL COMMENT 'User agent string',
              `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Timestamp when action was performed',
              PRIMARY KEY (`id`),
              KEY `idx_user_id` (`user_id`),
              KEY `idx_module` (`module`),
              KEY `idx_action` (`action`),
              KEY `idx_created_at` (`created_at`),
              KEY `idx_record_id` (`record_id`, `table_name`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='User activity logs for tracking all CRUD operations'";
            
            if ($this->db->query($sql)) {
                $created[] = 'user_activity_logs';
            } else {
                $errors[] = 'Failed to create user_activity_logs table';
            }
        }
        
        // Create user_sessions table
        if (!$this->db->table_exists('user_sessions')) {
            $sql = "CREATE TABLE IF NOT EXISTS `user_sessions` (
              `id` bigint(20) NOT NULL AUTO_INCREMENT,
              `user_id` int(11) NOT NULL COMMENT 'User ID from tbl_users',
              `user_name` varchar(255) DEFAULT NULL COMMENT 'User name for quick reference',
              `session_id` varchar(128) DEFAULT NULL COMMENT 'PHP session ID',
              `login_time` datetime NOT NULL COMMENT 'When user logged in',
              `logout_time` datetime DEFAULT NULL COMMENT 'When user logged out (null if still active)',
              `session_duration_minutes` int(11) DEFAULT NULL COMMENT 'Session duration in minutes (calculated on logout)',
              `ip_address` varchar(45) DEFAULT NULL COMMENT 'IP address of the user',
              `user_agent` text DEFAULT NULL COMMENT 'User agent string',
              `is_active` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1 = active session, 0 = ended session',
              `last_activity` datetime DEFAULT NULL COMMENT 'Last activity timestamp',
              `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
              `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
              PRIMARY KEY (`id`),
              KEY `idx_user_id` (`user_id`),
              KEY `idx_login_time` (`login_time`),
              KEY `idx_is_active` (`is_active`),
              KEY `idx_session_id` (`session_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='User session tracking for accurate time calculation'";
            
            if ($this->db->query($sql)) {
                $created[] = 'user_sessions';
                
                // Create additional indexes
                $this->db->query("CREATE INDEX idx_user_session_date ON user_sessions (user_id, DATE(login_time))");
                $this->db->query("CREATE INDEX idx_active_sessions ON user_sessions (is_active, user_id)");
            } else {
                $errors[] = 'Failed to create user_sessions table';
            }
        }
        
        // Show results
        echo "<h1>Database Setup Results</h1>";
        
        if (!empty($created)) {
            echo "<div style='color:green; padding:10px; background:#f0fff0; border:1px solid #4CAF50; margin:10px 0;'>";
            echo "<h3>✅ Successfully Created:</h3>";
            echo "<ul>";
            foreach ($created as $table) {
                echo "<li>" . $table . "</li>";
            }
            echo "</ul>";
            echo "</div>";
        }
        
        if (!empty($errors)) {
            echo "<div style='color:red; padding:10px; background:#fff0f0; border:1px solid #f44336; margin:10px 0;'>";
            echo "<h3>❌ Errors:</h3>";
            echo "<ul>";
            foreach ($errors as $error) {
                echo "<li>" . $error . "</li>";
            }
            echo "</ul>";
            echo "</div>";
        }
        
        if (empty($created) && empty($errors)) {
            echo "<p>All tables already exist. No action needed.</p>";
        }
        
        echo "<br><p><a href='" . site_url('activitylog/report') . "' class='btn btn-primary'>Go to Activity Report</a></p>";
        echo "<p><a href='" . site_url('database_setup/activity_tables') . "'>Check Setup Status</a></p>";
    }
    
    /**
     * Check tree view data for debugging
     */
    public function check_tree_data() {
        echo "<h1>Tree View Data Debug</h1>";
        
        // Check if tables exist
        $activity_exists = $this->db->table_exists('user_activity_logs');
        $session_exists = $this->db->table_exists('user_sessions');
        
        echo "<h3>Table Status:</h3>";
        echo "<ul>";
        echo "<li>user_activity_logs: " . ($activity_exists ? "✅ EXISTS" : "❌ NOT FOUND") . "</li>";
        echo "<li>user_sessions: " . ($session_exists ? "✅ EXISTS" : "❌ NOT FOUND") . "</li>";
        echo "</ul>";
        
        if ($activity_exists) {
            // Get all users
            $this->db->select('userId, name');
            $this->db->from('tbl_users');
            $this->db->where('roleId !=', ROLE_ADMIN);
            $users = $this->db->get()->result_array();
            
            echo "<h3>Available Users for Testing:</h3>";
            echo "<ul>";
            foreach ($users as $user) {
                echo "<li>ID: " . $user['userId'] . " - Name: " . $user['name'] . "</li>";
            }
            echo "</ul>";
            
            // Check activity data count
            $activity_count = $this->db->count_all('user_activity_logs');
            echo "<h3>Activity Data:</h3>";
            echo "<p>Total activity records: " . $activity_count . "</p>";
            
            if ($activity_count > 0) {
                // Show sample activities
                $this->db->select('user_id, user_name, action, module, created_at');
                $this->db->from('user_activity_logs');
                $this->db->order_by('created_at', 'DESC');
                $this->db->limit(5);
                $sample_activities = $this->db->get()->result_array();
                
                echo "<h4>Recent Activities (Last 5):</h4>";
                echo "<table border='1' style='border-collapse: collapse;'>";
                echo "<tr><th>User ID</th><th>User Name</th><th>Action</th><th>Module</th><th>Date/Time</th></tr>";
                foreach ($sample_activities as $activity) {
                    echo "<tr>";
                    echo "<td>" . $activity['user_id'] . "</td>";
                    echo "<td>" . $activity['user_name'] . "</td>";
                    echo "<td>" . $activity['action'] . "</td>";
                    echo "<td>" . $activity['module'] . "</td>";
                    echo "<td>" . $activity['created_at'] . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "<p style='color:orange;'>⚠️ No activity data found. You need to perform some actions to generate activity logs.</p>";
                echo "<p>Try:</p>";
                echo "<ul>";
                echo "<li>Login/logout to generate session data</li>";
                echo "<li>Add/edit/delete records to generate activity logs</li>";
                echo "<li>Navigate to different modules</li>";
                echo "</ul>";
            }
        }
        
        echo "<br><p><a href='" . site_url('activitylog/report') . "' class='btn btn-primary'>Go to Activity Report</a></p>";
        echo "<p><a href='" . site_url('database_setup/generate_sample_data') . "' class='btn btn-warning'>Generate Sample Activity Data</a></p>";
    }
    
    /**
     * Generate sample data for testing tree view
     */
    public function generate_sample_data() {
        if (!$this->db->table_exists('user_activity_logs') || !$this->db->table_exists('user_sessions')) {
            echo "<p style='color:red;'>❌ Required tables don't exist. Please create tables first.</p>";
            echo "<p><a href='" . site_url('database_setup/create_tables') . "'>Create Tables</a></p>";
            return;
        }
        
        // Get first non-admin user
        $this->db->select('userId, name');
        $this->db->from('tbl_users');
        $this->db->where('roleId !=', ROLE_ADMIN);
        $this->db->limit(1);
        $user = $this->db->get()->row();
        
        if (!$user) {
            echo "<p style='color:red;'>❌ No users found. Please ensure you have users in the system.</p>";
            return;
        }
        
        $user_id = $user->userId;
        $user_name = $user->name;
        
        echo "<h1>Generating Sample Data</h1>";
        echo "<p>Creating sample data for User: " . $user_name . " (ID: " . $user_id . ")</p>";
        
        $generated = 0;
        
        // Generate activities for last 7 days
        for ($i = 6; $i >= 0; $i--) {
            $date = date('Y-m-d', strtotime("-{$i} days"));
            
            // Generate 3-8 activities per day
            $activities_count = rand(3, 8);
            
            for ($j = 0; $j < $activities_count; $j++) {
                $hour = rand(9, 17); // Working hours
                $minute = rand(0, 59);
                $second = rand(0, 59);
                
                $timestamp = $date . ' ' . sprintf('%02d:%02d:%02d', $hour, $minute, $second);
                
                $actions = ['add', 'edit', 'view', 'delete', 'download'];
                $modules = ['Voter', 'Booth', 'Village', 'Panchayat', 'User', 'District'];
                $tables = ['tbl_voter', 'tbl_booth', 'tbl_village', 'tbl_panchayat', 'tbl_users', 'tbl_district'];
                
                $action = $actions[array_rand($actions)];
                $module = $modules[array_rand($modules)];
                $table = $tables[array_rand($tables)];
                
                $activity_data = array(
                    'user_id' => $user_id,
                    'user_name' => $user_name,
                    'action' => $action,
                    'module' => $module,
                    'table_name' => $table,
                    'record_id' => rand(1, 100),
                    'details' => ucfirst($action) . ' operation on ' . $module . ' module',
                    'ip_address' => '127.0.0.1',
                    'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Sample Data',
                    'created_at' => $timestamp
                );
                
                $this->db->insert('user_activity_logs', $activity_data);
                $generated++;
            }
            
            // Generate session data
            $login_time = $date . ' 09:00:00';
            $logout_time = $date . ' 17:30:00';
            $session_duration = 8.5 * 60; // 8.5 hours in minutes
            
            $session_data = array(
                'user_id' => $user_id,
                'user_name' => $user_name,
                'session_id' => 'sample_session_' . $date . '_' . $user_id,
                'login_time' => $login_time,
                'logout_time' => $logout_time,
                'session_duration_minutes' => $session_duration,
                'ip_address' => '127.0.0.1',
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Sample Data',
                'is_active' => 0,
                'last_activity' => $logout_time
            );
            
            $this->db->insert('user_sessions', $session_data);
        }
        
        echo "<div style='color:green; padding:10px; background:#f0fff0; border:1px solid #4CAF50;'>";
        echo "<h3>✅ Sample Data Generated Successfully!</h3>";
        echo "<ul>";
        echo "<li>Generated " . $generated . " activity records</li>";
        echo "<li>Generated 7 days of session data</li>";
        echo "<li>Data created for user: " . $user_name . " (ID: " . $user_id . ")</li>";
        echo "</ul>";
        echo "</div>";
        
        echo "<br><p><a href='" . site_url('activitylog/report') . "' class='btn btn-primary'>Test Timeline View Now</a></p>";
        echo "<p><a href='" . site_url('database_setup/check_tree_data') . "'>Check Data Status</a></p>";
    }
    
    /**
     * Generate comprehensive timeline data for better visualization
     */
    public function generate_timeline_data() {
        if (!$this->db->table_exists('user_activity_logs') || !$this->db->table_exists('user_sessions')) {
            echo "<p style='color:red;'>❌ Required tables don't exist. Please create tables first.</p>";
            echo "<p><a href='" . site_url('database_setup/create_tables') . "'>Create Tables</a></p>";
            return;
        }
        
        // Get all non-admin users
        $this->db->select('userId, name');
        $this->db->from('tbl_users');
        $this->db->where('roleId !=', ROLE_ADMIN);
        $users = $this->db->get()->result_array();
        
        if (empty($users)) {
            echo "<p style='color:red;'>❌ No users found. Please ensure you have users in the system.</p>";
            return;
        }
        
        echo "<h1>Generating Comprehensive Timeline Data</h1>";
        $total_generated = 0;
        
        // Generate data for each user
        foreach ($users as $user) {
            $user_id = $user['userId'];
            $user_name = $user['name'];
            
            echo "<p>Creating timeline data for User: " . $user_name . " (ID: " . $user_id . ")</p>";
            
            // Generate activities for last 14 days
            for ($i = 13; $i >= 0; $i--) {
                $date = date('Y-m-d', strtotime("-{$i} days"));
                
                // Skip weekends for more realistic data
                $dayOfWeek = date('w', strtotime($date));
                if ($dayOfWeek == 0 || $dayOfWeek == 6) {
                    continue; // Skip Sunday (0) and Saturday (6)
                }
                
                // Generate 5-15 activities per working day
                $activities_count = rand(5, 15);
                
                // Generate session data first
                $login_hour = rand(8, 10); // Login between 8-10 AM
                $logout_hour = rand(17, 19); // Logout between 5-7 PM
                $session_duration = ($logout_hour - $login_hour) * 60; // in minutes
                
                $login_time = $date . ' ' . sprintf('%02d:%02d:00', $login_hour, rand(0, 59));
                $logout_time = $date . ' ' . sprintf('%02d:%02d:00', $logout_hour, rand(0, 59));
                
                $session_data = array(
                    'user_id' => $user_id,
                    'user_name' => $user_name,
                    'session_id' => 'timeline_session_' . $date . '_' . $user_id,
                    'login_time' => $login_time,
                    'logout_time' => $logout_time,
                    'session_duration_minutes' => $session_duration,
                    'ip_address' => '192.168.1.' . rand(100, 200),
                    'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Timeline Data',
                    'is_active' => 0,
                    'last_activity' => $logout_time
                );
                
                $this->db->insert('user_sessions', $session_data);
                
                // Generate activities throughout the day
                for ($j = 0; $j < $activities_count; $j++) {
                    $hour = rand($login_hour, $logout_hour - 1); // Activities within work hours
                    $minute = rand(0, 59);
                    $second = rand(0, 59);
                    
                    $timestamp = $date . ' ' . sprintf('%02d:%02d:%02d', $hour, $minute, $second);
                    
                    // More realistic activity patterns
                    $activities = [
                        ['action' => 'login', 'module' => 'Authentication', 'table' => 'tbl_users', 'details' => 'User logged into the system'],
                        ['action' => 'view', 'module' => 'Dashboard', 'table' => 'tbl_dashboard', 'details' => 'Viewed dashboard statistics'],
                        ['action' => 'view', 'module' => 'Voter', 'table' => 'tbl_voter', 'details' => 'Browsed voter records'],
                        ['action' => 'add', 'module' => 'Voter', 'table' => 'tbl_voter', 'details' => 'Added new voter registration'],
                        ['action' => 'edit', 'module' => 'Voter', 'table' => 'tbl_voter', 'details' => 'Updated voter information'],
                        ['action' => 'view', 'module' => 'Booth', 'table' => 'tbl_booth', 'details' => 'Reviewed booth assignments'],
                        ['action' => 'add', 'module' => 'Booth', 'table' => 'tbl_booth', 'details' => 'Created new polling booth record'],
                        ['action' => 'edit', 'module' => 'Village', 'table' => 'tbl_village', 'details' => 'Modified village boundary data'],
                        ['action' => 'view', 'module' => 'Panchayat', 'table' => 'tbl_panchayat', 'details' => 'Accessed panchayat information'],
                        ['action' => 'download', 'module' => 'Reports', 'table' => 'tbl_reports', 'details' => 'Downloaded voter list report'],
                        ['action' => 'view', 'module' => 'District', 'table' => 'tbl_district', 'details' => 'Reviewed district statistics'],
                        ['action' => 'delete', 'module' => 'Voter', 'table' => 'tbl_voter', 'details' => 'Removed duplicate voter entry'],
                        ['action' => 'logout', 'module' => 'Authentication', 'table' => 'tbl_users', 'details' => 'User logged out of the system']
                    ];
                    
                    $activity = $activities[array_rand($activities)];
                    
                    $activity_data = array(
                        'user_id' => $user_id,
                        'user_name' => $user_name,
                        'action' => $activity['action'],
                        'module' => $activity['module'],
                        'table_name' => $activity['table'],
                        'record_id' => rand(1, 500),
                        'details' => $activity['details'],
                        'ip_address' => '192.168.1.' . rand(100, 200),
                        'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Timeline Data Generator',
                        'created_at' => $timestamp
                    );
                    
                    $this->db->insert('user_activity_logs', $activity_data);
                    $total_generated++;
                }
            }
        }
        
        echo "<div style='color:green; padding:15px; background:#f0fff0; border:2px solid #4CAF50; border-radius:8px; margin:20px 0;'>";
        echo "<h3>✅ Comprehensive Timeline Data Generated Successfully!</h3>";
        echo "<ul style='margin:10px 0;'>";
        echo "<li><strong>Total Activity Records:</strong> " . $total_generated . "</li>";
        echo "<li><strong>Users Covered:</strong> " . count($users) . "</li>";
        echo "<li><strong>Date Range:</strong> Last 14 days (weekdays only)</li>";
        echo "<li><strong>Realistic Patterns:</strong> Work hours, login/logout, various activities</li>";
        echo "</ul>";
        echo "</div>";
        
        echo "<div style='background:#e3f2fd; padding:15px; border-left:4px solid #2196F3; margin:20px 0;'>";
        echo "<h4>🎯 Timeline Features to Test:</h4>";
        echo "<ul>";
        echo "<li>📅 <strong>Date Grouping:</strong> Activities organized by date with session info</li>";
        echo "<li>🎨 <strong>Color Coding:</strong> Different colors for Add, Edit, Delete, View actions</li>";
        echo "<li>⏰ <strong>Time Tracking:</strong> Precise timestamps for each activity</li>";
        echo "<li>👤 <strong>User Context:</strong> IP addresses and user information</li>";
        echo "<li>📊 <strong>Session Data:</strong> Login/logout times and work duration</li>";
        echo "<li>🔄 <strong>Compact Toggle:</strong> Switch between normal and compact views</li>";
        echo "</ul>";
        echo "</div>";
        
        echo "<div style='text-align:center; margin:30px 0;'>";
        echo "<a href='" . site_url('activitylog/report') . "' class='btn btn-success btn-lg' style='margin:10px; padding:15px 30px; font-size:16px;'>";
        echo "<i class='fa fa-clock-o'></i> View Timeline Now";
        echo "</a>";
        echo "<a href='" . site_url('database_setup/check_tree_data') . "' class='btn btn-info btn-lg' style='margin:10px; padding:15px 30px; font-size:16px;'>";
        echo "<i class='fa fa-database'></i> Check Data Status";
        echo "</a>";
        echo "</div>";
    }
    
    /**
     * Debug timezone issues
     */
    public function debug_timezone() {
        $this->load->model('Log_model');
        
        echo "<h1>Timezone Debug Information</h1>";
        
        // Get timezone info
        $timezoneInfo = $this->Log_model->get_timezone_info();
        
        echo "<h3>Current Time Information:</h3>";
        echo "<table border='1' cellpadding='10'>";
        echo "<tr><th>Source</th><th>Timezone</th><th>Current Time</th></tr>";
        echo "<tr><td>PHP Server</td><td>" . $timezoneInfo['php_timezone'] . "</td><td>" . $timezoneInfo['php_datetime'] . "</td></tr>";
        echo "<tr><td>MySQL Server</td><td>" . $timezoneInfo['mysql_timezone'] . "</td><td>" . $timezoneInfo['mysql_datetime'] . "</td></tr>";
        echo "<tr><td>IST (Asia/Kolkata)</td><td>+05:30</td><td>" . $timezoneInfo['ist_datetime'] . "</td></tr>";
        echo "</table>";
        
        // Check recent sessions
        if ($this->db->table_exists('user_sessions')) {
            echo "<h3>Recent Session Data (Last 5):</h3>";
            $this->db->select('user_name, login_time, logout_time, session_duration_minutes');
            $this->db->from('user_sessions');
            $this->db->order_by('id', 'DESC');
            $this->db->limit(5);
            $query = $this->db->get();
            
            if ($query->num_rows() > 0) {
                echo "<table border='1' cellpadding='5'>";
                echo "<tr><th>User</th><th>Login Time</th><th>Logout Time</th><th>Duration (min)</th><th>Calculated Duration</th></tr>";
                
                foreach ($query->result_array() as $session) {
                    $calculatedDuration = 'N/A';
                    if ($session['login_time'] && $session['logout_time']) {
                        $login = new DateTime($session['login_time']);
                        $logout = new DateTime($session['logout_time']);
                        $diff = $logout->diff($login);
                        $calculatedDuration = ($diff->h * 60) + $diff->i . ' min';
                    }
                    
                    echo "<tr>";
                    echo "<td>" . $session['user_name'] . "</td>";
                    echo "<td>" . $session['login_time'] . "</td>";
                    echo "<td>" . ($session['logout_time'] ? $session['logout_time'] : 'Still Active') . "</td>";
                    echo "<td>" . ($session['session_duration_minutes'] ? $session['session_duration_minutes'] : 'N/A') . "</td>";
                    echo "<td>" . $calculatedDuration . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "<p>No session data found.</p>";
            }
        }
        
        // Fix timezone issues button
        echo "<h3>Actions:</h3>";
        echo "<p><a href='" . site_url('database_setup/fix_sessions') . "' class='btn btn-warning' onclick='return confirm(\"This will recalculate session durations. Continue?\")'>Fix Session Durations</a></p>";
        echo "<p><a href='" . site_url('activitylog/report') . "'>Go to Activity Report</a></p>";
    }
    
    /**
     * Fix session duration calculations
     */
    public function fix_sessions() {
        $this->load->model('Log_model');
        
        $fixed = $this->Log_model->fix_timezone_issues();
        
        echo "<h1>Session Fix Results</h1>";
        echo "<p><strong>" . $fixed . "</strong> session records were updated with correct duration calculations.</p>";
        echo "<p><a href='" . site_url('database_setup/debug_timezone') . "'>View Debug Info</a></p>";
        echo "<p><a href='" . site_url('activitylog/report') . "'>Go to Activity Report</a></p>";
    }
    
    /**
     * Quick status check for timeline functionality
     */
    public function timeline_status() {
        echo "<h1>🕒 Timeline View Status Check</h1>";
        
        // Check tables
        $activity_exists = $this->db->table_exists('user_activity_logs');
        $session_exists = $this->db->table_exists('user_sessions');
        
        echo "<div style='background:#f8f9fa; padding:20px; border-radius:8px; margin:20px 0;'>";
        echo "<h3>📊 Database Status</h3>";
        echo "<ul style='font-size:16px; line-height:1.8;'>";
        echo "<li>user_activity_logs: " . ($activity_exists ? "✅ <span style='color:green;'>EXISTS</span>" : "❌ <span style='color:red;'>NOT FOUND</span>") . "</li>";
        echo "<li>user_sessions: " . ($session_exists ? "✅ <span style='color:green;'>EXISTS</span>" : "❌ <span style='color:red;'>NOT FOUND</span>") . "</li>";
        echo "</ul>";
        echo "</div>";
        
        if ($activity_exists && $session_exists) {
            // Get data counts
            $activity_count = $this->db->count_all('user_activity_logs');
            $session_count = $this->db->count_all('user_sessions');
            
            // Get users with activity data
            $this->db->select('DISTINCT user_name, COUNT(*) as activity_count');
            $this->db->from('user_activity_logs');
            $this->db->group_by('user_id');
            $user_activities = $this->db->get()->result_array();
            
            echo "<div style='background:#e8f5e8; padding:20px; border-radius:8px; border-left:5px solid #4CAF50;'>";
            echo "<h3>📈 Data Summary</h3>";
            echo "<ul style='font-size:16px; line-height:1.8;'>";
            echo "<li><strong>Total Activities:</strong> " . $activity_count . " records</li>";
            echo "<li><strong>Total Sessions:</strong> " . $session_count . " records</li>";
            echo "<li><strong>Users with Data:</strong> " . count($user_activities) . " users</li>";
            echo "</ul>";
            
            if (!empty($user_activities)) {
                echo "<h4>👥 Users Available for Timeline:</h4>";
                echo "<ul style='columns:2; font-size:14px;'>";
                foreach ($user_activities as $user) {
                    echo "<li>" . $user['user_name'] . " (" . $user['activity_count'] . " activities)</li>";
                }
                echo "</ul>";
            }
            echo "</div>";
            
            if ($activity_count > 0) {
                echo "<div style='background:#e3f2fd; padding:20px; border-radius:8px; border-left:5px solid #2196F3; text-align:center;'>";
                echo "<h3>🚀 Ready to Use Timeline View!</h3>";
                echo "<p style='font-size:16px; margin:15px 0;'>Your timeline data is ready. Follow these steps:</p>";
                echo "<ol style='text-align:left; font-size:15px; max-width:600px; margin:0 auto;'>";
                echo "<li>Go to <strong>Activity Report</strong> page</li>";
                echo "<li>Select <strong>Timeline View</strong> tab</li>";
                echo "<li>Choose any user from the dropdown</li>";
                echo "<li>Set date range (last 14 days recommended)</li>";
                echo "<li>Click <strong>Generate Report</strong></li>";
                echo "</ol>";
                
                echo "<div style='margin:25px 0;'>";
                echo "<a href='" . site_url('activitylog/report') . "' class='btn btn-primary btn-lg' style='margin:10px; padding:15px 30px; font-size:18px; text-decoration:none; background:#007bff; color:white; border-radius:5px; display:inline-block;'>";
                echo "🕒 Open Timeline View";
                echo "</a>";
                echo "</div>";
                echo "</div>";
            }
        } else {
            echo "<div style='background:#fff3cd; padding:20px; border-radius:8px; border-left:5px solid #ffc107;'>";
            echo "<h3>⚠️ Setup Required</h3>";
            echo "<p>Database tables need to be created first.</p>";
            echo "<a href='" . site_url('database_setup/create_tables') . "' class='btn btn-warning'>Create Tables</a>";
            echo "</div>";
        }
    }
    
    /**
     * Add year field to Vidhan Sabha, Block, and Booth tables
     */
    public function add_year_fields() {
        echo "<h1>Adding Year Fields to Tables</h1>";
        
        $tables_to_update = [
            'tbl_vidhan_sabha' => 'districtId',
            'tbl_block' => 'districtId',
            'tbl_booth' => 'villageId'
        ];
        
        $success_count = 0;
        $already_exists_count = 0;
        $errors = [];
        
        foreach ($tables_to_update as $table => $after_column) {
            // Check if table exists
            if (!$this->db->table_exists($table)) {
                $errors[] = "Table {$table} does not exist";
                continue;
            }
            
            // Check if year column already exists
            $fields = $this->db->field_data($table);
            $year_exists = false;
            foreach ($fields as $field) {
                if ($field->name == 'year') {
                    $year_exists = true;
                    break;
                }
            }
            
            if ($year_exists) {
                $already_exists_count++;
                echo "<p style='color:orange;'>⚠️ Year field already exists in {$table}</p>";
                continue;
            }
            
            // Add year column
            $sql = "ALTER TABLE `{$table}` 
                    ADD COLUMN `year` INT(4) NOT NULL DEFAULT 2024 COMMENT 'Year (2013-2028)' 
                    AFTER `{$after_column}`";
            
            if ($this->db->query($sql)) {
                // Add index
                $index_sql = "ALTER TABLE `{$table}` ADD INDEX `idx_year` (`year`)";
                $this->db->query($index_sql);
                
                $success_count++;
                echo "<p style='color:green;'>✅ Successfully added year field to {$table}</p>";
            } else {
                $errors[] = "Failed to add year field to {$table}: " . $this->db->error()['message'];
            }
        }
        
        echo "<div style='margin-top:20px; padding:15px; border-radius:8px; background:#f8f9fa;'>";
        echo "<h3>Summary:</h3>";
        echo "<ul style='font-size:16px;'>";
        echo "<li><strong>Successfully Added:</strong> {$success_count} tables</li>";
        echo "<li><strong>Already Exists:</strong> {$already_exists_count} tables</li>";
        echo "<li><strong>Errors:</strong> " . count($errors) . "</li>";
        echo "</ul>";
        
        if (!empty($errors)) {
            echo "<h4 style='color:red;'>Errors:</h4>";
            echo "<ul style='color:red;'>";
            foreach ($errors as $error) {
                echo "<li>{$error}</li>";
            }
            echo "</ul>";
        }
        echo "</div>";
        
        if ($success_count > 0 || $already_exists_count > 0) {
            echo "<div style='margin-top:20px; padding:15px; border-radius:8px; background:#e8f5e8; border-left:4px solid #4CAF50;'>";
            echo "<h3>✅ Year Field Configuration Complete!</h3>";
            echo "<p>Year dropdown (2013-2028) has been added to:</p>";
            echo "<ul>";
            echo "<li>✅ Vidhan Sabha</li>";
            echo "<li>✅ Block</li>";
            echo "<li>✅ Booth</li>";
            echo "</ul>";
            echo "<p><strong>Note:</strong> Forms have been updated to include year selection dropdown.</p>";
            echo "</div>";
        }
        
        echo "<div style='margin-top:20px;'>";
        echo "<a href='" . site_url('vidhan_sabha') . "' class='btn btn-primary'>Go to Vidhan Sabha</a> ";
        echo "<a href='" . site_url('block') . "' class='btn btn-primary'>Go to Block</a> ";
        echo "<a href='" . site_url('booth') . "' class='btn btn-primary'>Go to Booth</a>";
        echo "</div>";
    }
}
?>