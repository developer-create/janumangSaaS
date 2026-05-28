<?php
/**
 * Activity Logs Database Diagnostic Script
 * This script checks the database setup and data for activity logging
 */

// Database configuration
$host = 'localhost';
$dbname = 'janumang'; // Update this to your database name
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "<h1>Activity Logs Database Diagnostic</h1>";
    echo "<style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        h1 { color: #333; }
        h2 { color: #3c8dbc; margin-top: 30px; }
        table { border-collapse: collapse; width: 100%; margin: 20px 0; }
        th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
        th { background-color: #3c8dbc; color: white; }
        tr:nth-child(even) { background-color: #f2f2f2; }
        .success { color: green; font-weight: bold; }
        .error { color: red; font-weight: bold; }
        .warning { color: orange; font-weight: bold; }
        .info { background: #e3f2fd; padding: 15px; border-left: 4px solid #2196F3; margin: 20px 0; }
        code { background: #f4f4f4; padding: 2px 6px; border-radius: 3px; }
    </style>";
    
    // 1. Check if user_activity_logs table exists
    echo "<h2>1. Checking Tables</h2>";
    
    $stmt = $pdo->query("SHOW TABLES LIKE 'user_activity_logs'");
    $activityTableExists = $stmt->rowCount() > 0;
    
    $stmt = $pdo->query("SHOW TABLES LIKE 'user_sessions'");
    $sessionTableExists = $stmt->rowCount() > 0;
    
    echo "<table>";
    echo "<tr><th>Table Name</th><th>Status</th></tr>";
    echo "<tr><td>user_activity_logs</td><td class='" . ($activityTableExists ? 'success' : 'error') . "'>" . ($activityTableExists ? '✓ EXISTS' : '✗ NOT FOUND') . "</td></tr>";
    echo "<tr><td>user_sessions</td><td class='" . ($sessionTableExists ? 'success' : 'error') . "'>" . ($sessionTableExists ? '✓ EXISTS' : '✗ NOT FOUND') . "</td></tr>";
    echo "</table>";
    
    if (!$activityTableExists) {
        echo "<div class='info'><strong>Action Required:</strong> The user_activity_logs table does not exist. Please import <code>database/user_activity_logs.sql</code></div>";
        exit;
    }
    
    // 2. Check table structure
    echo "<h2>2. Table Structure</h2>";
    
    $stmt = $pdo->query("DESCRIBE user_activity_logs");
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "<h3>user_activity_logs columns:</h3>";
    echo "<table>";
    echo "<tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th></tr>";
    foreach ($columns as $col) {
        echo "<tr>";
        echo "<td>{$col['Field']}</td>";
        echo "<td>{$col['Type']}</td>";
        echo "<td>{$col['Null']}</td>";
        echo "<td>{$col['Key']}</td>";
        echo "</tr>";
    }
    echo "</table>";
    
    // 3. Check data counts
    echo "<h2>3. Data Analysis</h2>";
    
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM user_activity_logs");
    $totalActivities = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    
    echo "<table>";
    echo "<tr><th>Metric</th><th>Count</th></tr>";
    echo "<tr><td>Total Activity Records</td><td class='" . ($totalActivities > 0 ? 'success' : 'warning') . "'>{$totalActivities}</td></tr>";
    
    if ($totalActivities > 0) {
        // Activities by action type
        $stmt = $pdo->query("SELECT action, COUNT(*) as count FROM user_activity_logs GROUP BY action ORDER BY count DESC");
        $actions = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        echo "<tr><td colspan='2'><strong>Activities by Action Type:</strong></td></tr>";
        foreach ($actions as $action) {
            echo "<tr><td>&nbsp;&nbsp;{$action['action']}</td><td>{$action['count']}</td></tr>";
        }
        
        // Activities by user
        $stmt = $pdo->query("SELECT user_id, user_name, COUNT(*) as count FROM user_activity_logs GROUP BY user_id, user_name ORDER BY count DESC LIMIT 10");
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        echo "<tr><td colspan='2'><strong>Top 10 Users by Activity:</strong></td></tr>";
        foreach ($users as $user) {
            echo "<tr><td>&nbsp;&nbsp;{$user['user_name']} (ID: {$user['user_id']})</td><td>{$user['count']}</td></tr>";
        }
        
        // Date range
        $stmt = $pdo->query("SELECT MIN(DATE(created_at)) as earliest, MAX(DATE(created_at)) as latest FROM user_activity_logs");
        $dateRange = $stmt->fetch(PDO::FETCH_ASSOC);
        
        echo "<tr><td>Earliest Activity Date</td><td>{$dateRange['earliest']}</td></tr>";
        echo "<tr><td>Latest Activity Date</td><td>{$dateRange['latest']}</td></tr>";
        
        // Recent activities (last 30 days)
        $stmt = $pdo->query("SELECT COUNT(*) as count FROM user_activity_logs WHERE DATE(created_at) >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)");
        $recentCount = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
        
        echo "<tr><td>Activities (Last 30 Days)</td><td class='" . ($recentCount > 0 ? 'success' : 'warning') . "'>{$recentCount}</td></tr>";
    }
    echo "</table>";
    
    // 4. Check for specific user activity (for detailed/timeline reports)
    if ($totalActivities > 0) {
        echo "<h2>4. Sample Data for Testing</h2>";
        
        // Get a user with activities excluding login/logout
        $stmt = $pdo->query("
            SELECT user_id, user_name, COUNT(*) as activity_count,
                   MIN(DATE(created_at)) as first_date,
                   MAX(DATE(created_at)) as last_date
            FROM user_activity_logs
            WHERE action NOT IN ('login', 'logout')
            GROUP BY user_id, user_name
            HAVING activity_count > 0
            ORDER BY activity_count DESC
            LIMIT 1
        ");
        $testUser = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($testUser) {
            echo "<div class='info'>";
            echo "<strong>Test User for Reports:</strong><br>";
            echo "User ID: <code>{$testUser['user_id']}</code><br>";
            echo "User Name: <code>{$testUser['user_name']}</code><br>";
            echo "Activity Count: <code>{$testUser['activity_count']}</code><br>";
            echo "Date Range: <code>{$testUser['first_date']}</code> to <code>{$testUser['last_date']}</code><br><br>";
            echo "<strong>Use these values to test:</strong><br>";
            echo "1. Select user: <code>{$testUser['user_name']}</code><br>";
            echo "2. Date From: <code>{$testUser['first_date']}</code><br>";
            echo "3. Date To: <code>{$testUser['last_date']}</code><br>";
            echo "4. Report Type: Detailed Report or Timeline View<br>";
            echo "</div>";
            
            // Show sample activities
            echo "<h3>Sample Activities for this user:</h3>";
            $stmt = $pdo->prepare("
                SELECT DATE(created_at) as date, action, module, COUNT(*) as count
                FROM user_activity_logs
                WHERE user_id = :user_id AND action NOT IN ('login', 'logout')
                GROUP BY DATE(created_at), action, module
                ORDER BY date DESC, count DESC
                LIMIT 20
            ");
            $stmt->execute(['user_id' => $testUser['user_id']]);
            $samples = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            echo "<table>";
            echo "<tr><th>Date</th><th>Action</th><th>Module</th><th>Count</th></tr>";
            foreach ($samples as $sample) {
                echo "<tr>";
                echo "<td>{$sample['date']}</td>";
                echo "<td>{$sample['action']}</td>";
                echo "<td>{$sample['module']}</td>";
                echo "<td>{$sample['count']}</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<div class='warning'>";
            echo "<strong>Warning:</strong> No activities found (excluding login/logout). ";
            echo "Detailed and Timeline reports require actual user activities like add, edit, delete, view, etc.";
            echo "</div>";
        }
    } else {
        echo "<div class='info'>";
        echo "<strong>No Activity Data Found</strong><br><br>";
        echo "The tables exist but contain no data. Activity logging will start automatically as you use the system.<br><br>";
        echo "<strong>To generate activity data:</strong><br>";
        echo "1. Log in to the system<br>";
        echo "2. Create, edit, or delete records in any module (Dispatch Register, Block Samiti, etc.)<br>";
        echo "3. View records<br>";
        echo "4. Return to this diagnostic page to verify data is being logged<br>";
        echo "</div>";
    }
    
    // 5. Check user_sessions table if exists
    if ($sessionTableExists) {
        echo "<h2>5. Session Data</h2>";
        
        $stmt = $pdo->query("SELECT COUNT(*) as total FROM user_sessions");
        $totalSessions = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        
        echo "<p>Total Sessions: <strong>{$totalSessions}</strong></p>";
        
        if ($totalSessions > 0) {
            $stmt = $pdo->query("
                SELECT DATE(login_time) as date, COUNT(*) as sessions, 
                       SUM(session_duration_minutes)/60 as total_hours
                FROM user_sessions
                GROUP BY DATE(login_time)
                ORDER BY date DESC
                LIMIT 10
            ");
            $sessionStats = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            echo "<h3>Recent Session Summary:</h3>";
            echo "<table>";
            echo "<tr><th>Date</th><th>Sessions</th><th>Total Hours</th></tr>";
            foreach ($sessionStats as $stat) {
                echo "<tr>";
                echo "<td>{$stat['date']}</td>";
                echo "<td>{$stat['sessions']}</td>";
                echo "<td>" . number_format($stat['total_hours'], 2) . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        }
    }
    
    // 6. Recommendations
    echo "<h2>6. Recommendations</h2>";
    echo "<ul>";
    
    if ($totalActivities == 0) {
        echo "<li class='warning'>No activity data found. Start using the system to generate activity logs.</li>";
    } else {
        echo "<li class='success'>Activity logging is working correctly with {$totalActivities} records.</li>";
    }
    
    if (!$sessionTableExists) {
        echo "<li class='warning'>user_sessions table not found. Session time tracking will be limited. Import database/user_sessions.sql for enhanced tracking.</li>";
    }
    
    if ($totalActivities > 0) {
        $stmt = $pdo->query("
            SELECT COUNT(DISTINCT user_id) as user_count
            FROM user_activity_logs
            WHERE action NOT IN ('login', 'logout')
        ");
        $activeUsers = $stmt->fetch(PDO::FETCH_ASSOC)['user_count'];
        
        if ($activeUsers == 0) {
            echo "<li class='warning'>Only login/logout activities found. No actual work activities recorded yet.</li>";
        } else {
            echo "<li class='success'>{$activeUsers} users have recorded activities. Reports should work correctly.</li>";
        }
    }
    
    echo "</ul>";
    
    echo "<div class='info'>";
    echo "<strong>Next Steps:</strong><br>";
    echo "1. Go to <a href='" . str_replace('/check_activity_logs.php', '/activitylog/report', $_SERVER['PHP_SELF']) . "'>Activity Report</a><br>";
    echo "2. Select a user from the test data above<br>";
    echo "3. Select the date range shown above<br>";
    echo "4. Choose 'Detailed Report' or 'Timeline View'<br>";
    echo "5. Click 'Generate Report'<br>";
    echo "</div>";
    
} catch(PDOException $e) {
    echo "<h1 style='color: red;'>Database Connection Error</h1>";
    echo "<p><strong>Error:</strong> " . $e->getMessage() . "</p>";
    echo "<p>Please check your database configuration in this file.</p>";
}
?>
