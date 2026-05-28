<?php
/**
 * Quick SMS Test - Direct API Call (Standalone - No CodeIgniter)
 * Access: http://localhost/janumang/sms_quick_test.php?mobile=YOUR_NUMBER
 */

// Get mobile number from URL parameter
$mobile = isset($_GET['mobile']) ? $_GET['mobile'] : '9876543210';

// Prevent CodeIgniter from loading
if (!defined('BASEPATH')) {
    define('BASEPATH', TRUE);
}

echo "<h2>Quick SMS Test</h2>";
echo "<p>Testing SMS to: <strong>" . htmlspecialchars($mobile) . "</strong></p>";
echo "<p>Change number: <a href='?mobile=YOUR_NUMBER'>?mobile=YOUR_NUMBER</a></p>";
echo "<hr>";

// SMS Configuration
$apiUrl = 'http://216.48.180.220/vb/apikey.php';
$apiKey = 'hdNhqlbtPSqBWt9G';
$senderId = 'UMANGS';
$templateId = '1707176484272940190';
$route = '4';
$message = 'आप को संगठन के सक्रिय सदस्य बनने पर मेरी तरफ से से शुभकामनाएं - उमंग सिंघार';

// Clean mobile number
$mobile = preg_replace('/[^0-9]/', '', $mobile);
if (strlen($mobile) > 10) {
    $mobile = substr($mobile, -10);
}

echo "<h3>Configuration:</h3>";
echo "<ul>";
echo "<li><strong>API URL:</strong> " . $apiUrl . "</li>";
echo "<li><strong>API Key:</strong> " . $apiKey . "</li>";
echo "<li><strong>Sender ID:</strong> " . $senderId . "</li>";
echo "<li><strong>Template ID:</strong> " . $templateId . "</li>";
echo "<li><strong>Route:</strong> " . $route . "</li>";
echo "<li><strong>Mobile:</strong> " . $mobile . "</li>";
echo "</ul>";

// Build API URL
$params = [
    'apikey' => $apiKey,
    'senderid' => $senderId,
    'route' => $route,
    'number' => $mobile,
    'message' => $message,
    'templateid' => $templateId
];

$fullUrl = $apiUrl . '?' . http_build_query($params);

echo "<h3>Full API URL:</h3>";
echo "<textarea style='width: 100%; height: 100px; font-size: 11px;'>" . $fullUrl . "</textarea>";

// Check cURL
echo "<h3>System Check:</h3>";
if (!function_exists('curl_init')) {
    echo "<p style='color: red;'><strong>ERROR:</strong> cURL is NOT enabled in PHP!</p>";
    echo "<p>Enable cURL in php.ini file: <code>extension=curl</code></p>";
    exit;
} else {
    echo "<p style='color: green;'>✓ cURL is enabled</p>";
    $version = curl_version();
    echo "<p>cURL Version: " . $version['version'] . "</p>";
}

// Send SMS
echo "<h3>Sending SMS...</h3>";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $fullUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 30);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

$startTime = microtime(true);
$response = curl_exec($ch);
$endTime = microtime(true);

$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$curlError = curl_error($ch);
$curlInfo = curl_getinfo($ch);
curl_close($ch);

$timeTaken = round(($endTime - $startTime) * 1000, 2);

echo "<h3>Response:</h3>";
echo "<ul>";
echo "<li><strong>HTTP Code:</strong> " . $httpCode . "</li>";
echo "<li><strong>Time Taken:</strong> " . $timeTaken . " ms</li>";

if ($curlError) {
    echo "<li style='color: red;'><strong>cURL Error:</strong> " . htmlspecialchars($curlError) . "</li>";
}

echo "</ul>";

echo "<h4>API Response:</h4>";
echo "<div style='background: #f5f5f5; padding: 10px; border: 1px solid #ddd;'>";
echo "<pre>" . htmlspecialchars($response) . "</pre>";
echo "</div>";

// Interpret response
echo "<h3>Result:</h3>";
if ($httpCode == 200 && !$curlError) {
    echo "<p style='color: green; font-size: 18px;'><strong>✓ SMS API call successful!</strong></p>";
    echo "<p>Check your mobile for the SMS. If not received, check:</p>";
    echo "<ul>";
    echo "<li>Mobile number is correct</li>";
    echo "<li>API credits are available</li>";
    echo "<li>Template ID is approved</li>";
    echo "<li>Sender ID is active</li>";
    echo "</ul>";
} else {
    echo "<p style='color: red; font-size: 18px;'><strong>✗ SMS API call failed!</strong></p>";
    echo "<p>Possible issues:</p>";
    echo "<ul>";
    echo "<li>API server is down or unreachable</li>";
    echo "<li>Network/firewall blocking the request</li>";
    echo "<li>Invalid API credentials</li>";
    echo "</ul>";
}

echo "<hr>";
echo "<h3>Debug Info:</h3>";
echo "<pre>";
print_r($curlInfo);
echo "</pre>";
?>
