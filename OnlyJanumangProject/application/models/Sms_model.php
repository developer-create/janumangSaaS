<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sms_model extends CI_Model {

    private $api_key = "XXXXXXXXXXXXXXXXXXXX";
    private $sender_id = "XXXXXX";
    private $route = 1;
    private $template_id = "XXXXXX";
    private $api_url = "http://216.48.180.220/vb/apikey.php";

    public function __construct() {
        parent::__construct();
    }

    /**
     * Format welcome message for new member
     *
     * @param string $memberName Name of the member
     * @return string Formatted welcome message
     */
    public function format_welcome_message($memberName) {
        return "Welcome " . $memberName . " to our system. Thank you for joining us.";
    }

    /**
     * Get welcome template ID
     *
     * @return string Template ID for welcome message
     */
    public function get_welcome_template_id() {
        return $this->template_id;
    }

    /**
     * Send SMS using the API
     *
     * @param string $mobile_numbers Comma-separated mobile numbers
     * @param string $message Content of the SMS
     * @param string $templateId Optional template ID to override default
     * @return array Response array with status and response/error keys
     */
    public function send_sms($mobile_numbers, $message, $templateId = null) {
        // URL encode the message content
        $message_content = urlencode($message);
        
        // Use provided template ID or default
        $template = $templateId ? $templateId : $this->template_id;

        // Construct the URL with parameters
        $url = $this->api_url . "?apikey=" . $this->api_key .
               "&senderid=" . $this->sender_id .
               "&templateid=" . $template .
               "&route=" . $this->route .
               "&number=" . $mobile_numbers .
               "&message=" . $message_content;

        // Fetch the API response
        $response = file_get_contents($url);
        
        // Parse response - assuming API returns success/failure indicator
        // Adjust parsing based on your actual API response format
        $isSuccess = !empty($response) && strpos($response, 'error') === false;
        
        return array(
            'status' => $isSuccess,
            'response' => $response,
            'error' => $isSuccess ? null : $response
        );
    }
}
