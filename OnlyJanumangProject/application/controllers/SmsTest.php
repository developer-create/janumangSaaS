<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * SMS Test Controller
 * Access: http://localhost/janumang/SmsTest
 * Or with mobile: http://localhost/janumang/SmsTest/index/9876543210
 */
class SmsTest extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('Sms_library');
    }

    public function index($mobile = '9876543210') {
        // HTML Header
        echo '<!DOCTYPE html>
        <html>
        <head>
            <title>SMS Test</title>
            <style>
                body { font-family: Arial, sans-serif; margin: 20px; }
                h2 { color: #333; }
                .success { color: green; background: #d4edda; padding: 10px; border: 1px solid #c3e6cb; }
                .error { color: red; background: #f8d7da; padding: 10px; border: 1px solid #f5c6cb; }
                .info { background: #d1ecf1; padding: 10px; border: 1px solid #bee5eb; }
                pre { background: #f5f5f5; padding: 10px; border: 1px solid #ddd; overflow-x: auto; }
                ul { line-height: 1.8; }
            </style>
        </head>
        <body>';
        
        echo '<h2>SMS Test Controller</h2>';
        echo '<p>Testing SMS to: <strong>' . htmlspecialchars($mobile) . '</strong></p>';
        echo '<p>Change number: <a href="' . base_url('SmsTest/index/YOUR_NUMBER') . '">Click here</a></p>';
        echo '<hr>';

        // System Check
        echo '<h3>System Check:</h3>';
        echo '<ul>';
        
        // Check cURL
        if (function_exists('curl_init')) {
            echo '<li style="color: green;">✓ cURL is enabled</li>';
            $version = curl_version();
            echo '<li>cURL Version: ' . $version['version'] . '</li>';
        } else {
            echo '<li style="color: red;">✗ cURL is NOT enabled - Enable it in php.ini</li>';
        }
        
        // Check SMS Library
        if (isset($this->sms_library)) {
            echo '<li style="color: green;">✓ SMS Library loaded successfully</li>';
        } else {
            echo '<li style="color: red;">✗ SMS Library NOT loaded</li>';
        }
        
        echo '<li>PHP Version: ' . phpversion() . '</li>';
        echo '</ul>';
        echo '<hr>';

        // Configuration
        echo '<h3>SMS Configuration:</h3>';
        echo '<ul>';
        echo '<li><strong>API URL:</strong> http://216.48.180.220/vb/apikey.php</li>';
        echo '<li><strong>API Key:</strong> hdNhqlbtPSqBWt9G</li>';
        echo '<li><strong>Sender ID:</strong> UMANGS</li>';
        echo '<li><strong>Template ID:</strong> 1707176484272940190</li>';
        echo '<li><strong>Route:</strong> 4 (Unicode/Hindi)</li>';
        echo '<li><strong>Message:</strong> आप को संगठन के सक्रिय सदस्य बनने पर मेरी तरफ से से शुभकामनाएं - उमंग सिंघार</li>';
        echo '</ul>';
        echo '<hr>';

        // Send SMS
        echo '<h3>Sending SMS...</h3>';
        
        if (!isset($this->sms_library)) {
            echo '<div class="error">SMS Library not loaded! Cannot send SMS.</div>';
        } else {
            $result = $this->sms_library->sendWelcomeSms($mobile, 'Test User');
            
            echo '<h4>Result:</h4>';
            echo '<pre>';
            print_r($result);
            echo '</pre>';
            
            if ($result['status']) {
                echo '<div class="success">';
                echo '<h3>✓ SUCCESS!</h3>';
                echo '<p>SMS sent successfully to ' . htmlspecialchars($mobile) . '</p>';
                echo '<p>Check your mobile phone for the message.</p>';
                echo '</div>';
            } else {
                echo '<div class="error">';
                echo '<h3>✗ FAILED!</h3>';
                echo '<p><strong>Error:</strong> ' . htmlspecialchars($result['message']) . '</p>';
                echo '<h4>Possible Issues:</h4>';
                echo '<ul>';
                echo '<li>API server is down or unreachable</li>';
                echo '<li>Invalid API credentials</li>';
                echo '<li>Network/firewall blocking the request</li>';
                echo '<li>Insufficient API credits</li>';
                echo '<li>Template ID not approved</li>';
                echo '</ul>';
                echo '</div>';
            }
        }
        
        echo '<hr>';
        echo '<h3>Next Steps:</h3>';
        echo '<ol>';
        echo '<li>If SMS sent successfully, test by adding a member at: <a href="' . base_url('ServayListing') . '">Survey Listing</a></li>';
        echo '<li>Check logs at: application/logs/log-' . date('Y-m-d') . '.php</li>';
        echo '<li>If failed, check the error message above and fix the issue</li>';
        echo '</ol>';
        
        echo '</body></html>';
    }
    
    public function direct($mobile = '9876543210') {
        // Direct API test without library
        echo '<!DOCTYPE html>
        <html>
        <head>
            <title>Direct SMS API Test</title>
            <style>
                body { font-family: Arial, sans-serif; margin: 20px; }
                pre { background: #f5f5f5; padding: 10px; border: 1px solid #ddd; overflow-x: auto; }
                .success { color: green; }
                .error { color: red; }
            </style>
        </head>
        <body>';
        
        echo '<h2>Direct SMS API Test</h2>';
        echo '<p>Testing direct API call to: <strong>' . htmlspecialchars($mobile) . '</strong></p>';
        echo '<hr>';
        
        // Clean mobile
        $mobile = preg_replace('/[^0-9]/', '', $mobile);
        if (strlen($mobile) > 10) {
            $mobile = substr($mobile, -10);
        }
        
        // API Configuration
        $apiUrl = 'http://216.48.180.220/vb/apikey.php';
        $params = [
            'apikey' => 'hdNhqlbtPSqBWt9G',
            'senderid' => 'UMANGS',
            'route' => '4',
            'number' => $mobile,
            'message' => 'आप को संगठन के सक्रिय सदस्य बनने पर मेरी तरफ से से शुभकामनाएं - उमंग सिंघार',
            'templateid' => '1707176484272940190'
        ];
        
        $fullUrl = $apiUrl . '?' . http_build_query($params);
        
        echo '<h3>API URL:</h3>';
        echo '<textarea style="width: 100%; height: 80px; font-size: 11px;">' . $fullUrl . '</textarea>';
        
        // Send request
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $fullUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        
        $startTime = microtime(true);
        $response = curl_exec($ch);
        $endTime = microtime(true);
        
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);
        curl_close($ch);
        
        $timeTaken = round(($endTime - $startTime) * 1000, 2);
        
        echo '<h3>Response:</h3>';
        echo '<ul>';
        echo '<li><strong>HTTP Code:</strong> ' . $httpCode . '</li>';
        echo '<li><strong>Time Taken:</strong> ' . $timeTaken . ' ms</li>';
        if ($curlError) {
            echo '<li class="error"><strong>cURL Error:</strong> ' . htmlspecialchars($curlError) . '</li>';
        }
        echo '</ul>';
        
        echo '<h3>API Response:</h3>';
        echo '<pre>' . htmlspecialchars($response) . '</pre>';
        
        if ($httpCode == 200 && !$curlError) {
            echo '<p class="success" style="font-size: 18px;"><strong>✓ API call successful!</strong></p>';
        } else {
            echo '<p class="error" style="font-size: 18px;"><strong>✗ API call failed!</strong></p>';
        }
        
        echo '</body></html>';
    }
}
