<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * SMS Debug Controller - Check SMS delivery status
 * Access: http://localhost/janumang/SmsDebug
 */
class SmsDebug extends CI_Controller {

    public function index() {
        echo '<!DOCTYPE html>
        <html>
        <head>
            <title>SMS Debug Info</title>
            <style>
                body { font-family: Arial, sans-serif; margin: 20px; }
                .box { background: #f5f5f5; padding: 15px; margin: 10px 0; border: 1px solid #ddd; }
                .success { background: #d4edda; border-color: #c3e6cb; }
                .warning { background: #fff3cd; border-color: #ffeaa7; }
                .error { background: #f8d7da; border-color: #f5c6cb; }
                pre { background: white; padding: 10px; overflow-x: auto; }
            </style>
        </head>
        <body>';
        
        echo '<h2>SMS Debugging Information</h2>';
        
        // Check recent logs
        $logFile = APPPATH . 'logs/log-' . date('Y-m-d') . '.php';
        
        if (file_exists($logFile)) {
            $logContent = file_get_contents($logFile);
            
            // Find SMS related logs
            preg_match_all('/INFO.*SMS.*/', $logContent, $smsLogs);
            
            echo '<div class="box success">';
            echo '<h3>Recent SMS Activity (Today):</h3>';
            if (!empty($smsLogs[0])) {
                echo '<pre>';
                foreach (array_slice($smsLogs[0], -10) as $log) {
                    echo htmlspecialchars($log) . "\n";
                }
                echo '</pre>';
            } else {
                echo '<p>No SMS logs found today.</p>';
            }
            echo '</div>';
            
            // Find API responses
            preg_match_all('/Response:.*\{.*\}/', $logContent, $responses);
            
            if (!empty($responses[0])) {
                echo '<div class="box">';
                echo '<h3>Latest API Responses:</h3>';
                echo '<pre>';
                foreach (array_slice($responses[0], -5) as $response) {
                    echo htmlspecialchars($response) . "\n\n";
                }
                echo '</pre>';
                echo '</div>';
            }
        } else {
            echo '<div class="box error">';
            echo '<p>Log file not found for today.</p>';
            echo '</div>';
        }
        
        // Configuration check
        echo '<div class="box warning">';
        echo '<h3>⚠️ Important Checks:</h3>';
        echo '<ol>';
        echo '<li><strong>Template ID Approval:</strong> Contact your SMS provider to verify template ID <code>1707176484272940190</code> is approved</li>';
        echo '<li><strong>Sender ID Status:</strong> Verify <code>UMANGS</code> sender ID is active</li>';
        echo '<li><strong>DLT Registration:</strong> Ensure template is registered with DLT (Distributed Ledger Technology)</li>';
        echo '<li><strong>Credits:</strong> Check if you have sufficient SMS credits</li>';
        echo '<li><strong>DND Numbers:</strong> If testing on DND numbers, transactional route may be needed</li>';
        echo '<li><strong>Network Delay:</strong> SMS can take 2-10 minutes to deliver</li>';
        echo '</ol>';
        echo '</div>';
        
        // Provider contact info
        echo '<div class="box">';
        echo '<h3>📞 Contact Your SMS Provider:</h3>';
        echo '<p>API URL: <code>http://216.48.180.220/vb/apikey.php</code></p>';
        echo '<p>They can check:</p>';
        echo '<ul>';
        echo '<li>Message delivery status using Message ID from logs</li>';
        echo '<li>Why messages are not being delivered</li>';
        echo '<li>Template approval status</li>';
        echo '<li>Account credits and status</li>';
        echo '</ul>';
        echo '</div>';
        
        // Test different message
        echo '<div class="box">';
        echo '<h3>🧪 Alternative Test:</h3>';
        echo '<p>Try sending a simple test message without template:</p>';
        echo '<form method="GET" action="' . base_url('SmsDebug/testSimple') . '">';
        echo '<input type="text" name="mobile" placeholder="10-digit mobile number" required style="padding: 8px; width: 200px;">';
        echo '<button type="submit" style="padding: 8px 15px; margin-left: 10px;">Send Test SMS</button>';
        echo '</form>';
        echo '</div>';
        
        echo '</body></html>';
    }
    
    public function testSimple() {
        $mobile = $this->input->get('mobile');
        
        if (empty($mobile)) {
            echo 'Please provide mobile number';
            return;
        }
        
        // Clean mobile
        $mobile = preg_replace('/[^0-9]/', '', $mobile);
        if (strlen($mobile) > 10) {
            $mobile = substr($mobile, -10);
        }
        
        echo '<!DOCTYPE html>
        <html>
        <head>
            <title>Simple SMS Test</title>
            <style>
                body { font-family: Arial, sans-serif; margin: 20px; }
                pre { background: #f5f5f5; padding: 10px; border: 1px solid #ddd; }
            </style>
        </head>
        <body>';
        
        echo '<h2>Sending Simple Test SMS</h2>';
        echo '<p>Mobile: ' . htmlspecialchars($mobile) . '</p>';
        
        // Try with simpler message (English only, no template)
        $apiUrl = 'http://216.48.180.220/vb/apikey.php';
        $params = [
            'apikey' => 'hdNhqlbtPSqBWt9G',
            'senderid' => 'UMANGS',
            'route' => '1', // Try route 1 (promotional) instead of 4
            'number' => $mobile,
            'message' => 'Test message from Janumang system'
        ];
        
        $url = $apiUrl . '?' . http_build_query($params);
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);
        curl_close($ch);
        
        echo '<h3>Result:</h3>';
        echo '<p><strong>HTTP Code:</strong> ' . $httpCode . '</p>';
        if ($curlError) {
            echo '<p style="color: red;"><strong>Error:</strong> ' . htmlspecialchars($curlError) . '</p>';
        }
        echo '<p><strong>Response:</strong></p>';
        echo '<pre>' . htmlspecialchars($response) . '</pre>';
        
        echo '<p><a href="' . base_url('SmsDebug') . '">← Back</a></p>';
        
        echo '</body></html>';
    }
}
