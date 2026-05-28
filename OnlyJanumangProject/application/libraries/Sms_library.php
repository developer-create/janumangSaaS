<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * SMS Library for sending Unicode SMS messages
 * Supports Hindi text in Unicode format
 */
class Sms_library {
    
    private $CI;
    private $apiUrl;
    private $apiKey;
    private $senderId;
    private $route;
    
    public function __construct() {
        $this->CI =& get_instance();
        
        // SMS API Configuration
        $this->apiUrl = 'http://216.48.180.220/vb/apikey.php';
        $this->apiKey = 'hdNhqlbtPSqBWt9G';
        $this->senderId = 'UMANGS';
        $this->route = '1'; // Route 4 for Unicode/Hindi messages
        
    }
    
    /**
     * Send SMS to a mobile number
     * 
     * @param string $mobile Mobile number (10 digits)
     * @param string $message Message text (supports Hindi/Unicode)
     * @param string $templateId Template ID for DLT
     * @return array Response with status and message
     */
    public function sendSms($mobile, $message, $templateId = '') {
        try {
            // Validate mobile number
            if (empty($mobile) || strlen($mobile) < 10) {
                return [
                    'status' => false,
                    'message' => 'Invalid mobile number'
                ];
            }
            
            // Clean mobile number (remove spaces, dashes, etc.)
            $mobile = preg_replace('/[^0-9]/', '', $mobile);
            
            // Take last 10 digits if longer
            if (strlen($mobile) > 10) {
                $mobile = substr($mobile, -10);
            }
            
            // Prepare API parameters
            $params = [
                'apikey' => $this->apiKey,
                'senderid' => $this->senderId,
                'route' => $this->route,
                'number' => $mobile,
                'message' => $message
            ];
            
            // Add template ID if provided
            if (!empty($templateId)) {
                $params['templateid'] = $templateId;
            }
          log_message('info', 'The $params variable contains: ' . print_r($params, TRUE));
            // Build query string
            $queryString = http_build_query($params);
            $url = $this->apiUrl . '?' . $queryString;

        log_message('info', 'The $url variable contains: ' .  $url);
            
            // Send SMS using cURL
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $curlError = curl_error($ch);
            curl_close($ch);
            
            // Check for cURL errors
            if ($curlError) {
                log_message('error', 'SMS cURL Error: ' . $curlError);
                return [
                    'status' => false,
                    'message' => 'Failed to send SMS: ' . $curlError
                ];
            }
            
            // Check HTTP response code
            if ($httpCode != 200) {
                log_message('error', 'SMS API HTTP Error: ' . $httpCode . ' - Response: ' . $response);
                return [
                    'status' => false,
                    'message' => 'SMS API returned error code: ' . $httpCode
                ];
            }
            
            // Log success
            log_message('info', 'SMS sent successfully to ' . $mobile . ' - Response: ' . $response);
            
            return [
                'status' => true,
                'message' => 'SMS sent successfully',
                'response' => $response
            ];
            
        } catch (Exception $e) {
            log_message('error', 'SMS Exception: ' . $e->getMessage());
            return [
                'status' => false,
                'message' => 'Exception occurred: ' . $e->getMessage()
            ];
        }
    }
    
    /**
     * Send welcome SMS to new survey member
     * 
     * @param string $mobile Mobile number
     * @param string $name Member name (optional, for personalization)
     * @return array Response with status and message
     */
    public function sendWelcomeSms($mobile, $name = '') {
        // Template ID for welcome message
        $templateId = '1707176484272940190';
        
        // Hindi welcome message (Unicode)
        $message = 'आप को संगठन के सक्रिय सदस्य बनने पर मेरी तरफ से से शुभकामनाएं - उमंग सिंघार';
        
        return $this->sendSms($mobile, $message, $templateId);
    }
}
