<?php
// Google Calendar Verification Tool
// Database connection
$conn = new mysqli('localhost', 'root', '', 'janumang');
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

$mode = isset($_GET['mode']) ? $_GET['mode'] : 'users';
$eventId = isset($_GET['eventId']) ? (int)$_GET['eventId'] : null;

?>
<!DOCTYPE html>
<html>
<head>
    <title>Google Calendar Status Verification</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background: #f5f5f5; }
        .container { max-width: 1200px; margin: 0 auto; background: white; padding: 20px; border-radius: 5px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        h1 { color: #333; border-bottom: 3px solid #4CAF50; padding-bottom: 10px; }
        h2 { color: #555; margin-top: 30px; }
        .nav-tabs { display: flex; gap: 10px; margin-bottom: 20px; }
        .nav-tabs a { padding: 10px 20px; background: #e0e0e0; text-decoration: none; color: #333; border-radius: 5px 5px 0 0; }
        .nav-tabs a.active { background: #4CAF50; color: white; }
        table { width: 100%; border-collapse: collapse; margin: 15px 0; }
        th { background: #4CAF50; color: white; padding: 12px; text-align: left; }
        td { padding: 10px; border-bottom: 1px solid #ddd; }
        tr:hover { background: #f9f9f9; }
        .status-ok { color: #4CAF50; font-weight: bold; }
        .status-warning { color: #ff9800; font-weight: bold; }
        .status-error { color: #f44336; font-weight: bold; }
        .badge { display: inline-block; padding: 5px 10px; border-radius: 20px; font-size: 12px; margin: 2px; }
        .badge-success { background: #4CAF50; color: white; }
        .badge-warning { background: #ff9800; color: white; }
        .badge-error { background: #f44336; color: white; }
        .badge-info { background: #2196F3; color: white; }
        .info-box { background: #f0f7ff; border-left: 4px solid #2196F3; padding: 15px; margin: 15px 0; }
        .warning-box { background: #fff3e0; border-left: 4px solid #ff9800; padding: 15px; margin: 15px 0; }
        .error-box { background: #ffebee; border-left: 4px solid #f44336; padding: 15px; margin: 15px 0; }
        .success-box { background: #e8f5e9; border-left: 4px solid #4CAF50; padding: 15px; margin: 15px 0; }
        input, select { padding: 8px; margin: 5px; border: 1px solid #ddd; border-radius: 4px; }
        button { padding: 10px 20px; background: #4CAF50; color: white; border: none; border-radius: 4px; cursor: pointer; }
        button:hover { background: #45a049; }
        .grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔍 Google Calendar Status Verification Tool</h1>
        
        <div class="nav-tabs">
            <a href="?mode=users" class="<?php echo ($mode == 'users' ? 'active' : ''); ?>">📋 Users Status</a>
            <a href="?mode=events" class="<?php echo ($mode == 'events' ? 'active' : ''); ?>">📅 Events Sync Check</a>
            <a href="?mode=verify" class="<?php echo ($mode == 'verify' ? 'active' : ''); ?>">✓ Verify Event</a>
        </div>
        
        <?php if ($mode == 'users'): ?>
            <h2>Users Google Calendar Configuration</h2>
            
            <?php
            $result = $conn->query('SELECT userId, roleId, name, email, google_calendar_enabled, google_refresh_token FROM tbl_users WHERE isDeleted=0 ORDER BY roleId, name');
            
            $admins_with_gcal = 0;
            $users_with_gcal = 0;
            $total_users = 0;
            
            while($row = $result->fetch_assoc()) {
                $total_users++;
                if ($row['google_calendar_enabled'] && !empty($row['google_refresh_token'])) {
                    $users_with_gcal++;
                    if ($row['roleId'] == 1) $admins_with_gcal++;
                }
            }
            $result->data_seek(0);
            
            echo '<div class="grid">';
            echo '<div class="info-box"><strong>Total Users:</strong> ' . $total_users . '</div>';
            echo '<div class="' . ($users_with_gcal > 0 ? 'success-box' : 'warning-box') . '">';
            echo '<strong>Google Calendar Enabled:</strong> ' . $users_with_gcal . ' / ' . $total_users;
            if ($admins_with_gcal > 0) {
                echo '<br><span class="badge badge-success">Admin: ' . $admins_with_gcal . '</span>';
            } else {
                echo '<br><span class="badge badge-error">No Admin Connection</span>';
            }
            echo '</div>';
            echo '</div>';
            
            echo "<table>";
            echo "<thead><tr style='background: #4CAF50; color: white;'>";
            echo "<th>User ID</th><th>Name</th><th>Email</th><th>Role</th><th>GCal Enabled</th><th>Token Status</th>";
            echo "</tr></thead><tbody>";
            
            while($row = $result->fetch_assoc()) {
                $role = $row['roleId'] == 1 ? 'Admin' : 'User';
                $enabled = $row['google_calendar_enabled'] ? '<span class="badge badge-success">✓ YES</span>' : '<span class="badge badge-error">✗ NO</span>';
                $token = !empty($row['google_refresh_token']) ? '<span class="badge badge-success">SET</span>' : '<span class="badge badge-warning">NOT SET</span>';
                
                echo "<tr>";
                echo "<td>" . $row['userId'] . "</td>";
                echo "<td><strong>" . $row['name'] . "</strong></td>";
                echo "<td>" . $row['email'] . "</td>";
                echo "<td>" . $role . "</td>";
                echo "<td>" . $enabled . "</td>";
                echo "<td>" . $token . "</td>";
                echo "</tr>";
            }
            
            echo "</tbody></table>";
            
            if ($users_with_gcal == 0) {
                echo '<div class="error-box"><strong>⚠️ Issue:</strong> No calendar connections configured. Please connect at least one user (Admin recommended) to Google Calendar before events can be synced.</div>';
            }
            ?>
            
        <?php elseif ($mode == 'events'): ?>
            <h2>Events Google Calendar Sync Status</h2>
            
            <?php
            $result = $conn->query('SELECT id, unique_id, name, created_by, google_event_id, date FROM events ORDER BY id DESC LIMIT 20');
            
            $total_events = $conn->query('SELECT COUNT(*) as count FROM events')->fetch_assoc()['count'];
            $synced_count = $conn->query('SELECT COUNT(*) as count FROM events WHERE google_event_id IS NOT NULL AND google_event_id != ""')->fetch_assoc()['count'];
            
            echo '<div class="grid">';
            echo '<div class="info-box"><strong>Total Events:</strong> ' . $total_events . '</div>';
            echo '<div class="' . ($synced_count > 0 ? 'success-box' : 'warning-box') . '">';
            echo '<strong>Synced to Google Calendar:</strong> ' . $synced_count . ' / ' . $total_events . ' (' . round(($synced_count/$total_events)*100, 1) . '%)';
            echo '</div>';
            echo '</div>';
            
            echo "<table>";
            echo "<thead><tr style='background: #4CAF50; color: white;'>";
            echo "<th>Event ID</th><th>Event Name</th><th>Date</th><th>Google Event ID</th><th>Sync Status</th><th>Action</th>";
            echo "</tr></thead><tbody>";
            
            while($row = $result->fetch_assoc()) {
                $sync_status = !empty($row['google_event_id']) 
                    ? '<span class="badge badge-success">✓ SYNCED</span>' 
                    : '<span class="badge badge-warning">⏳ PENDING</span>';
                
                echo "<tr>";
                echo "<td>" . $row['id'] . "</td>";
                echo "<td><strong>" . substr($row['name'], 0, 30) . "</strong></td>";
                echo "<td>" . $row['date'] . "</td>";
                echo "<td><code style='background: #f0f0f0; padding: 2px 5px;'>" . (substr($row['google_event_id'], 0, 20) . (strlen($row['google_event_id']) > 20 ? '...' : '')) . "</code></td>";
                echo "<td>" . $sync_status . "</td>";
                echo "<td><a href='?mode=verify&eventId=" . $row['id'] . "' class='btn' style='background: #2196F3;'>Details</a></td>";
                echo "</tr>";
            }
            
            echo "</tbody></table>";
            ?>
            
        <?php elseif ($mode == 'verify' && $eventId): ?>
            <h2>Event Verification Details</h2>
            
            <?php
            $event = $conn->query("SELECT * FROM events WHERE id = $eventId")->fetch_assoc();
            
            if (!$event) {
                echo '<div class="error-box">Event not found!</div>';
            } else {
                // Get event owner
                $owner = $conn->query("SELECT userId, name, email, google_calendar_enabled, google_refresh_token FROM tbl_users WHERE userId = " . $event['created_by'])->fetch_assoc();
                
                // Get fallback admin if owner has no calendar
                if (!$owner || !$owner['google_calendar_enabled'] || empty($owner['google_refresh_token'])) {
                    $owner = $conn->query("SELECT userId, name, email, google_calendar_enabled, google_refresh_token FROM tbl_users WHERE roleId = 1 LIMIT 1")->fetch_assoc();
                }
                
                echo '<div class="info-box">';
                echo '<strong>Event:</strong> ' . $event['name'] . '<br>';
                echo '<strong>Event ID:</strong> ' . $event['id'] . '<br>';
                echo '<strong>Event Date:</strong> ' . $event['date'] . '<br>';
                echo '<strong>Created By:</strong> ' . $event['created_by'] . '<br>';
                echo '</div>';
                
                echo '<h3>Sync Configuration</h3>';
                echo '<div class="grid">';
                
                // Google Event ID Status
                echo '<div>';
                echo '<strong>Google Event ID:</strong><br>';
                if (!empty($event['google_event_id'])) {
                    echo '<span class="badge badge-success">✓ SYNCED</span><br>';
                    echo '<code style="background: #f0f0f0; padding: 5px; display: block; word-break: break-all; margin-top: 5px;">' . $event['google_event_id'] . '</code>';
                } else {
                    echo '<span class="badge badge-warning">✗ NOT SYNCED</span>';
                }
                echo '</div>';
                
                // Calendar User Status
                echo '<div>';
                if ($owner) {
                    echo '<strong>Calendar User:</strong> ' . $owner['name'] . '<br>';
                    echo '<strong>Email:</strong> ' . $owner['email'] . '<br>';
                    
                    if ($owner['google_calendar_enabled'] && !empty($owner['google_refresh_token'])) {
                        echo '<span class="badge badge-success">✓ ENABLED</span><br>';
                        echo '<span class="badge badge-success">✓ TOKEN SET</span>';
                    } else {
                        echo '<span class="badge badge-warning">';
                        if (!$owner['google_calendar_enabled']) echo '✗ DISABLED ';
                        if (empty($owner['google_refresh_token'])) echo '✗ NO TOKEN ';
                        echo '</span>';
                    }
                } else {
                    echo '<span class="badge badge-error">✗ NO CALENDAR USER</span>';
                }
                echo '</div>';
                echo '</div>';
                
                // Recommendations
                echo '<h3>Recommendations</h3>';
                if (empty($event['google_event_id'])) {
                    echo '<div class="warning-box">';
                    echo '<strong>Event Not Synced Yet</strong><br>';
                    echo 'Possible reasons:<br>';
                    if (!$owner) {
                        echo '• No admin user has Google Calendar enabled<br>';
                        echo '<strong>Fix:</strong> Have an admin user connect to Google Calendar<br>';
                    } elseif (!$owner['google_calendar_enabled']) {
                        echo '• Calendar user has not enabled Google Calendar<br>';
                        echo '<strong>Fix:</strong> User must connect to Google Calendar in Events module<br>';
                    } elseif (empty($owner['google_refresh_token'])) {
                        echo '• Calendar user has not completed authorization<br>';
                        echo '<strong>Fix:</strong> Click "Connect Google Calendar" button<br>';
                    }
                    echo '</div>';
                } else {
                    echo '<div class="success-box"><strong>✓ Event Successfully Synced</strong><br>Google Event ID is set and event should appear in Google Calendar</div>';
                }
            }
            ?>
            
        <?php else: ?>
            <h2>Quick Start</h2>
            <div class="info-box">
                Use the navigation tabs above to:
                <ul>
                    <li><strong>Users Status</strong> - Check which users have Google Calendar connected</li>
                    <li><strong>Events Sync Check</strong> - View sync status of recent events</li>
                    <li><strong>Verify Event</strong> - Check detailed sync status of a specific event</li>
                </ul>
            </div>
            
            <h2>Requirements for Events to Sync</h2>
            <ol>
                <li>At least one Admin user must connect to Google Calendar</li>
                <li>Google Calendar must be enabled for that user</li>
                <li>User must have valid Google refresh token</li>
                <li>Google API credentials must be configured</li>
            </ol>
        <?php endif; ?>
        
        <hr style="margin-top: 40px;">
        <small style="color: #999;">Last updated: <?php echo date('Y-m-d H:i:s'); ?></small>
    </div>
</body>
</html>

<?php
$conn->close();
?>