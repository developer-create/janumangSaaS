<?php
// Google Calendar Debug Tool

$conn = new mysqli('localhost', 'root', '', 'janumang');
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

echo "=== GOOGLE CALENDAR SYNC DEBUG ===\n\n";

// Check 1: Users with Google Calendar
echo "1. USERS WITH GOOGLE CALENDAR:\n";
echo str_repeat("-", 80) . "\n";
$result = $conn->query('SELECT userId, roleId, name, email, google_calendar_enabled, LENGTH(google_refresh_token) as token_length FROM tbl_users WHERE isDeleted=0');
$found_enabled = false;
while ($row = $result->fetch_assoc()) {
    $role = $row['roleId'] == 1 ? 'ADMIN' : 'USER';
    $enabled = $row['google_calendar_enabled'] ? 'YES' : 'NO';
    $token = $row['token_length'] > 0 ? 'SET (' . $row['token_length'] . ' chars)' : 'MISSING';
    printf("ID: %d | Role: %s | Name: %-20s | Enabled: %s | Token: %s\n", 
        $row['userId'], $role, substr($row['name'], 0, 20), $enabled, $token);
    
    if ($row['google_calendar_enabled'] && $row['token_length'] > 0) {
        $found_enabled = true;
    }
}

echo "\n2. ISSUE CHECK:\n";
echo str_repeat("-", 80) . "\n";
if (!$found_enabled) {
    echo "❌ ISSUE FOUND: No user has calendar enabled WITH a valid token!\n";
    echo "   ACTION REQUIRED: Admin must connect to Google Calendar first.\n";
} else {
    echo "✓ At least one user has Google Calendar properly configured.\n";
}

// Check 2: Configuration
echo "\n3. GOOGLE API CONFIGURATION:\n";
echo str_repeat("-", 80) . "\n";
$config_file = 'application/config/google_calendar.php';
if (file_exists($config_file)) {
    $content = file_get_contents($config_file);
    
    // Check for credentials
    if (preg_match("/google_client_id\s*=\s*['\"](.+?)['\"]/", $content, $m)) {
        $client_id = strlen($m[1]) > 30 ? substr($m[1], 0, 30) . '...' : $m[1];
        echo "Client ID: $client_id\n";
        if (strlen($m[1]) == 0 || $m[1] == 'YOUR_CLIENT_ID') {
            echo "  ❌ CLIENT ID NOT SET!\n";
        } else {
            echo "  ✓ Set\n";
        }
    }
    
    if (preg_match("/google_client_secret\s*=\s*['\"](.+?)['\"]/", $content, $m)) {
        $secret = strlen($m[1]) > 30 ? substr($m[1], 0, 30) . '...' : $m[1];
        echo "Client Secret: $secret\n";
        if (strlen($m[1]) == 0 || $m[1] == 'YOUR_CLIENT_SECRET') {
            echo "  ❌ CLIENT SECRET NOT SET!\n";
        } else {
            echo "  ✓ Set\n";
        }
    }
    
    if (preg_match("/google_calendar_email\s*=\s*['\"](.+?)['\"]/", $content, $m)) {
        echo "Calendar Email: " . (!empty($m[1]) ? $m[1] : "(empty - using primary)") . "\n";
        if (!empty($m[1]) && Filter::validate_email($m[1])) {
            echo "  ✓ Valid email\n";
        }
    }
} else {
    echo "❌ Config file not found!\n";
}

// Check 3: Google API Library
echo "\n4. GOOGLE API LIBRARY:\n";
echo str_repeat("-", 80) . "\n";
$autoload = 'application/third_party/google-api-php-client/vendor/autoload.php';
$vendor_google = 'vendor/google/apiclient/src/Google/Client.php';
$vendor_autoload = 'vendor/autoload.php';

if (file_exists($autoload)) {
    echo "✓ Found at: application/third_party/...\n";
} elseif (file_exists($vendor_autoload)) {
    echo "✓ Found at: vendor/autoload.php (in project root)\n";
    echo "  Status: INSTALLED VIA COMPOSER\n";
} elseif (file_exists($vendor_google)) {
    echo "⚠ Partial installation detected at: vendor/google/apiclient/\n";
    echo "  Status: Composer install may have interrupted\n";
} else {
    echo "❌ NOT FOUND - Library not installed!\n";
    echo "   Expected paths (check one of these):\n";
    echo "   1. " . $autoload . "\n";
    echo "   2. " . $vendor_autoload . "\n";
    echo "\n   FIX OPTIONS:\n";
    echo "   Option A: Run composer install\n";
    echo "   Option B: Download from GitHub and extract manually\n";
    echo "   Option C: Copy vendor folder from another installation\n";
}

// Check 4: Events and sync status
echo "\n5. EVENTS SYNC STATUS:\n";
echo str_repeat("-", 80) . "\n";
$result = $conn->query('SELECT COUNT(*) as total FROM events');
$total = $result->fetch_assoc()['total'];

$result = $conn->query('SELECT COUNT(*) as synced FROM events WHERE google_event_id IS NOT NULL AND google_event_id != ""');
$synced = $result->fetch_assoc()['synced'];

$pct = $total > 0 ? round(($synced / $total) * 100, 1) : 0;
echo "Total Events: $total\n";
echo "Synced Events: $synced\n";
echo "Sync Rate: $pct%\n";

if ($synced == 0 && $total > 0) {
    echo "❌ ISSUE: Events exist but NONE are synced!\n";
    echo "   This means sync is NOT working.\n";
} elseif ($synced == 0 && $total == 0) {
    echo "⚠ No events created yet.\n";
}

// Check 5: Recent events detail
echo "\n6. RECENT EVENTS:\n";
echo str_repeat("-", 80) . "\n";
$result = $conn->query('SELECT id, name, date, created_by, google_event_id FROM events ORDER BY id DESC LIMIT 5');
if ($result->num_rows == 0) {
    echo "No events found.\n";
} else {
    while ($row = $result->fetch_assoc()) {
        $status = !empty($row['google_event_id']) ? 'SYNCED' : 'NOT SYNCED';
        $icon = !empty($row['google_event_id']) ? '✓' : '❌';
        echo "$icon ID: {$row['id']} | Name: " . substr($row['name'], 0, 30) . " | Status: $status\n";
    }
}

// Check 6: Sync issues summary
echo "\n7. DIAGNOSIS:\n";
echo str_repeat("-", 80) . "\n";

$admin_result = $conn->query('SELECT google_calendar_enabled, LENGTH(google_refresh_token) as token_len FROM tbl_users WHERE roleId=1 LIMIT 1');
$admin = $admin_result->fetch_assoc();

$issues = [];

if (!$admin || !$admin['google_calendar_enabled']) {
    $issues[] = "CRITICAL: Admin does not have Google Calendar enabled";
}

if (!$admin || $admin['token_len'] == 0) {
    $issues[] = "CRITICAL: Admin does not have a valid refresh token";
}

// Check if function exists
if (!function_exists('filter_var')) {
    $issues[] = "WARNING: PHP filter functions not available";
}

if (empty($issues)) {
    if ($synced == 0 && $total > 0) {
        echo "⚠ POSSIBLE ISSUES:\n";
        echo "  1. Google API credentials might be wrong\n";
        echo "  2. Google Calendar API might not be enabled\n";
        echo "  3. Authorization might have expired\n\n";
        echo "NEXT STEPS:\n";
        echo "  1. Check Google Cloud Console for API errors\n";
        echo "  2. Try disconnecting and reconnecting Google Calendar\n";
        echo "  3. Check application logs for error details\n";
    } else {
        echo "✓ No obvious issues found.\n";
        echo "  Google Calendar setup appears correct.\n";
    }
} else {
    echo count($issues) . " ISSUE(S) FOUND:\n\n";
    foreach ($issues as $i => $issue) {
        echo ($i+1) . ". $issue\n";
    }
    
    echo "\n❌ SYNC WILL NOT WORK until these issues are fixed!\n\n";
    
    echo "SETUP STEPS:\n";
    echo "1. Log in as Admin user\n";
    echo "2. Go to Events module\n";
    echo "3. Click 'Connect Google Calendar' button\n";
    echo "4. Complete the Google authorization\n\n";
}

$conn->close();
echo "\nDebug completed at: " . date('Y-m-d H:i:s') . "\n";
?>
