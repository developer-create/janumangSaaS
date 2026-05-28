<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . "/libraries/BaseController.php";

#[AllowDynamicProperties]
class ServayController extends BaseController {

    public function __construct() {
        parent::__construct();
        $this->load->model('ServayModel');
        $this->load->model('Comman_model');
        $this->load->model('Sms_model');
        $this->load->model('Vidhan_sabha_model');
        $this->load->library('form_validation');
        $this->load->helper(array('form', 'url'));
        $this->isLoggedIn();
        date_default_timezone_set('Asia/Kolkata');
    }

    // Create a new survey entry

        /**
         * Callback validator to ensure at least one 'code' checkbox is selected
         */
        public function validate_code() {
            $codes = $this->input->post('code');
            if (empty($codes)) {
                $this->form_validation->set_message('validate_code', 'Please select at least one Code option.');
                return FALSE;
            }
            return TRUE;
        }

        public function validate_vehicle() {
            $vehicles = $this->input->post('vehicle');
            if (empty($vehicles)) {
                $this->form_validation->set_message('validate_vehicle', 'The {field} field is required.');
                return FALSE;
            }
            return TRUE;
        }
        public function createServay() {
            $this->module = "MemberList";

            // Check if the user has access to create surveys
            if (!$this->hasCreateAccess()) {
                $this->loadThis();
                return;
            }

        // Define form validation rules (All fields set to optional as per user request)
       $this->form_validation->set_rules('block_name_number', 'Block Name/Number', 'numeric');
        $this->form_validation->set_rules('grampanchayat', 'Gram Panchayat', 'numeric');
      $this->form_validation->set_rules('village', 'Village', 'numeric');
        $this->form_validation->set_rules('name', 'Name', 'trim');
        $this->form_validation->set_rules('fathername', 'Father Name', 'trim');
        $this->form_validation->set_rules('jaati', 'Caste', 'trim');
        $this->form_validation->set_rules('age', 'Age', 'numeric');
        $this->form_validation->set_rules('education', 'Education', 'trim');
        $this->form_validation->set_rules('mobile', 'Mobile', 'trim');
        $this->form_validation->set_rules('votarcode', 'Voter Code', 'trim');
        $this->form_validation->set_rules('address', 'Address', 'trim');
        $this->form_validation->set_rules('gender', 'Gender', 'trim');
        $this->form_validation->set_rules('vehicle[]', 'Vehicle', 'trim');
        $this->form_validation->set_rules('government_employee', 'Government Employee', 'trim');
        $this->form_validation->set_rules('parti', 'Party', 'numeric');
        // Validate checkbox array: optional
        $this->form_validation->set_rules('code[]', 'Code', 'trim');
        // $this->form_validation->set_rules('image', 'Image', 'required'); // Removed required for image
        $this->form_validation->set_rules('respect_for_women', 'Respect for Women', 'trim');
        $this->form_validation->set_rules('farmer_loan_waiver', 'Farmer Loan Waiver', 'trim');
        $this->form_validation->set_rules('samithi', 'Samithi', 'numeric');
        // $this->form_validation->set_rules('dob', 'Date of Birth', 'required'); // Removed required for date of birth
        // $this->form_validation->set_rules('dom', 'Date of Marriage', 'required'); // Removed required for date of marriage
        // $this->form_validation->set_rules('facebook', 'Facebook', 'required');
        // $this->form_validation->set_rules('instagram', 'Instagram', 'required');
        // $this->form_validation->set_rules('twitter', 'Twitter', 'required');

        // If the form is not valid, reload the form with validation errors
        if ($this->form_validation->run() == FALSE) {
            $data['blocks'] = $this->Comman_model->getAllData('block', [], '');
            $data['departments'] = $this->Comman_model->getAllData('department', [], '');
            $data['committees'] = $this->Comman_model->getAllData('samiti', [], '');
            $data['parties'] = $this->Comman_model->getAllData('party', [], '');
            $data['districts'] = $this->Comman_model->getAllData('district', [], '');
            $this->global['pageTitle'] = 'Datacollector :add';
            $data['upload_error'] = isset($this->upload_error) ? $this->upload_error : '';

            $this->loadViews("member/add", $this->global, $data, NULL);
        } else {
            
             // Handle file upload (optional)
        $imagePath = ''; // Initialize empty image path
        if (!empty($_FILES['image']['name'])) {
            $config['upload_path'] = './uploads/userservey/'; // Path to store uploaded files
            $config['allowed_types'] = 'gif|jpg|jpeg|png|pdf|doc|docx';      // Allowed file types
            $config['max_size'] = 5120;                    // Maximum size in KB (5MB)
            $config['encrypt_name'] = TRUE;                // Encrypt file name to avoid conflicts

            // Create directory if it doesn't exist
            if (!is_dir($config['upload_path'])) {
                mkdir($config['upload_path'], 0755, true);
            }

            $this->load->library('upload', $config);

            // Check if the image is uploaded
            if (!$this->upload->do_upload('image')) {
                // If file upload fails, return an error
                $this->session->set_flashdata('error', $this->upload->display_errors());
                redirect('ServayListing');
                return;
            } else {
                // Retrieve the uploaded file data
                $fileData = $this->upload->data();
                $imagePath = $fileData['file_name']; // This will store the file name (encrypted)
            }
        }

        // Collect form data
            $surveyData = array(
                
                'block_name_number' => $this->input->post('block_name_number') ?: 'NA',
                'janpad_panchayat' => $this->input->post('janpad_panchayat') ?: 'NA',
                'mandalam' => $this->input->post('mandalam') ?: 'NA',
                'boothname' => $this->input->post('boothname') ?: 'NA',
                'boothnumber' => $this->input->post('boothnumber') ?: 'NA',
                'grampanchayat' => $this->input->post('grampanchayat') ?: 'NA',
                'village' => $this->input->post('village') ?: 'NA',
                'name' => $this->input->post('name') ?: 'NA',
                'fathername' => $this->input->post('fathername') ?: 'NA',
                'jaati' => $this->input->post('jaati') ?: 'NA',
                'age' => $this->input->post('age') ?: 'NA',
                'education' => $this->input->post('education') ?: 'NA',
                'mobile' => $this->input->post('mobile') ?: 'NA',
                'votarcode' => $this->input->post('votarcode') ?: 'NA',
                'address' => $this->input->post('address') ?: 'NA',
                'gender' => $this->input->post('gender') ?: 'NA',
                'vehicle' => $this->input->post('vehicle') ?: 'NA',
                'government_employee' => $this->input->post('government_employee') ?: 'NA',
                'parti' => $this->input->post('parti') ?: 'NA',
                'code' => !empty($this->input->post('code')) ? implode(',', $this->input->post('code')) : 'NA',
                'respect_for_women' => $this->input->post('respect_for_women') ?: 'NA',
                'farmer_loan_waiver' => $this->input->post('farmer_loan_waiver') ?: 'NA',
                'lat' => 0,
                'long' => 0,
                'date' => '0000-00-00',
                'samithi' => $this->input->post('samithi') ?: 'NA',
                'facebook' => $this->input->post('facebook') ?: 'NA',
                'instagram' => $this->input->post('instagram') ?: 'NA',
                'twitter' => $this->input->post('twitter') ?: 'NA',
                'end_lat' => 0,
                'end_long' => 0,
                'group' => $this->input->post('group') ?: 'NA',
                'toll' => $this->input->post('toll') ?: 'NA',
                'padvarsh' => $this->input->post('padvarsh') ?: 'NA',
                'remark' => $this->input->post('remark') ?: 'NA',
                'reference' => $this->input->post('reference') ?: 'NA',
                'district' => $this->input->post('district') ?: 'NA',
                'vidhan_sabha_id' => $this->input->post('vidhan_sabha_id') ? $this->input->post('vidhan_sabha_id') : null,
                'user_id' => $this->session->userdata('userId'),
                'create_date' => date('Y-m-d H:i:s'),
                'startdate' => date('D M d Y H:i:s \G\M\T+0530 (T)'), // Set current date time as start date		
            	'enddate' => date('D M d Y H:i:s \G\M\T+0530 (T)'), // Set current date time as end date
                'user_id'=> $this->session->userdata("userId")
            );
            
            // Add image path to data if uploaded
            if (!empty($imagePath)) {
                $surveyData['image'] = $imagePath;
            }
            
            // Add dob and dom (handle empty strings as NULL or default date)
            $surveyData['dob'] = $this->input->post('dob') ?: '0000-00-00';
            $surveyData['dom'] = $this->input->post('dom') ?: '0000-00-00';

            // Insert survey data into the database
            $insertId = $this->ServayModel->insertServay($surveyData);

            // Check if data was successfully inserted
            if ($insertId) {
                // Log activity
                $this->logActivity('add', 'servayapp', $insertId, $surveyData, null, 'Member record created with ID: ' . $insertId . ' (Name: ' . $surveyData['name'] . ')');
                // Send welcome SMS to new member asynchronously (non-blocking)
                // Queue SMS for background processing instead of sending synchronously
                $this->queueSms($insertId, $surveyData['mobile'], $surveyData['name']);
                
                $this->session->set_flashdata('success', 'Survey created successfully');
            } else {
                $this->session->set_flashdata('error', 'Failed to create survey. Please try again.');
            }
        
            // Redirect to the survey list page or any other page
            redirect('ServayListing');
        }
    }
    
    
    // Load Edit Survey Form
    public function editServay($id) {
        // Get the existing survey details based on the id
        $data['survey'] = $this->ServayModel->getServayById($id);
        
        if(empty($data['survey'])) {
            // If no survey found, redirect or show error
            redirect('ServayListing');
        }

        $data['blocks'] = $this->Comman_model->getAllData('block', [], '');
            $data['departments'] = $this->Comman_model->getAllData('department', [], '');
            $data['committees'] = $this->Comman_model->getAllData('samiti', [], '');
            $data['parties'] = $this->Comman_model->getAllData('party', [], '');
            $data['districts'] = $this->Comman_model->getAllData('district', [], '');
            $data['vidhan_sabhas'] = array();
            if (!empty($data['survey']->district)) {
                $data['vidhan_sabhas'] = $this->Vidhan_sabha_model->get_vidhan_sabhas_by_district($data['survey']->district);
            }
            $this->global['pageTitle'] = 'Datacollector :add';
            $data['upload_error'] = isset($this->upload_error) ? $this->upload_error : '';

            $this->loadViews("member/edit", $this->global, $data, NULL);
    }

    /**
     * AJAX: Get Vidhan Sabha list by district (for Member add/edit dropdown)
     */
    public function getVidhanSabhaByDistrict() {
        $district_id = $this->input->get_post('district_id');
        $list = $this->Vidhan_sabha_model->get_vidhan_sabhas_by_district($district_id);
        header('Content-Type: application/json');
        echo json_encode($list);
    }

    // Update survey details
   public function updateServay($id) {
    // Validation rules (All fields set to optional as per user request)
    $this->form_validation->set_rules('block_name_number', 'Block Name/Number', 'numeric');
    $this->form_validation->set_rules('grampanchayat', 'Gram Panchayat', 'numeric');
    $this->form_validation->set_rules('village', 'Village', 'numeric');
    $this->form_validation->set_rules('name', 'Name', 'trim');
    $this->form_validation->set_rules('fathername', 'Father Name', 'trim');
    $this->form_validation->set_rules('jaati', 'Caste', 'trim');
    $this->form_validation->set_rules('age', 'Age', 'numeric');
    $this->form_validation->set_rules('education', 'Education', 'trim');
    $this->form_validation->set_rules('mobile', 'Mobile', 'trim');
    $this->form_validation->set_rules('votarcode', 'Voter Code', 'trim');
    $this->form_validation->set_rules('address', 'Address', 'trim');
    $this->form_validation->set_rules('gender', 'Gender', 'trim');
    $this->form_validation->set_rules('vehicle[]', 'Vehicle', 'trim');
    $this->form_validation->set_rules('government_employee', 'Government Employee', 'trim');
    $this->form_validation->set_rules('parti', 'Party', 'numeric');
    // Validate checkbox array: optional
    $this->form_validation->set_rules('code[]', 'Code', 'trim');
    // $this->form_validation->set_rules('image', 'Image', 'required'); // Removed required for image
        $this->form_validation->set_rules('respect_for_women', 'Respect for Women', 'trim');
        $this->form_validation->set_rules('farmer_loan_waiver', 'Farmer Loan Waiver', 'trim');
        $this->form_validation->set_rules('samithi', 'Samithi', 'numeric');
        // $this->form_validation->set_rules('dob', 'Date of Birth', 'required'); // Removed required for date of birth
        // $this->form_validation->set_rules('dom', 'Date of Marriage', 'required'); // Removed required for date of marriage
    
    if ($this->form_validation->run() == FALSE) {
        // If validation fails, reload the form with validation errors
        $this->editServay($id);
    } else {
        // Handle file upload (optional)
        $imagePath = ''; // Initialize empty image path
        if (!empty($_FILES['image']['name'])) {
            $config['upload_path'] = './uploads/userservey/'; // Path to store uploaded files
            $config['allowed_types'] = 'gif|jpg|jpeg|png|pdf|doc|docx'; // Allowed file types
            $config['max_size'] = 5120; // Maximum size in KB (5MB)
            $config['encrypt_name'] = TRUE; // Encrypt file name to avoid conflicts

            // Create directory if it doesn't exist
            if (!is_dir($config['upload_path'])) {
                mkdir($config['upload_path'], 0755, true);
            }

            $this->load->library('upload', $config);

            // Check if the image is uploaded
            if (!$this->upload->do_upload('image')) {
                // If file upload fails, set flashdata error
                $this->session->set_flashdata('error', $this->upload->display_errors());
                redirect('ServayListing');
                return;
            } else {
                // Retrieve the uploaded file data
                $fileData = $this->upload->data();
                $imagePath = $fileData['file_name']; // This will store the file name (encrypted)
            }
        }

        // Collect form data
        $data = array(
            'block_name_number' => $this->input->post('block_name_number'),
            'janpad_panchayat' => $this->input->post('janpad_panchayat'),
            'mandalam' => $this->input->post('mandalam'),
            'boothname' => $this->input->post('boothname'),
            'boothnumber' => $this->input->post('boothnumber'),
            'grampanchayat' => $this->input->post('grampanchayat'),
            'village' => $this->input->post('village'),
            'name' => $this->input->post('name'),
            'fathername' => $this->input->post('fathername'),
            'jaati' => $this->input->post('jaati'),
            'age' => $this->input->post('age'),
            'education' => $this->input->post('education'),
            'mobile' => $this->input->post('mobile'),
            'votarcode' => $this->input->post('votarcode'),
            'address' => $this->input->post('address'),
            'gender' => $this->input->post('gender'),
            'vehicle' => !empty($this->input->post('vehicle')) ? implode(',', $this->input->post('vehicle')) : '',
            'government_employee' => $this->input->post('government_employee'),
            'parti' => $this->input->post('parti'),
            'code' => !empty($this->input->post('code')) ? implode(',', $this->input->post('code')) : '',
            'respect_for_women' => $this->input->post('respect_for_women'),
            'farmer_loan_waiver' => $this->input->post('farmer_loan_waiver'),
            'samithi' => $this->input->post('samithi'),
            'facebook' => $this->input->post('facebook'),
            'instagram' => $this->input->post('instagram'),
            'twitter' => $this->input->post('twitter'),
            'group' => $this->input->post('group'),
            'toll' => $this->input->post('toll'),
            'padvarsh' => $this->input->post('padvarsh'),
            'remark' => $this->input->post('remark'),
            'reference' => $this->input->post('reference'),
            'district' => $this->input->post('district'),
            'vidhan_sabha_id' => $this->input->post('vidhan_sabha_id') ? $this->input->post('vidhan_sabha_id') : null,
            'update_date' => date('Y-m-d H:i:s'),
            'enddate' => date('D M d Y H:i:s \G\M\T+0530 (T)') // Update enddate when editing
        );

        // Add image path to data if uploaded
        if (!empty($imagePath)) {
            $data['image'] = $imagePath;
        }
        
        // Add dob and dom
        $data['dob'] = $this->input->post('dob') ?: NULL;
        $data['dom'] = $this->input->post('dom') ?: NULL;

        // Get old data before update for logging
        $oldData = $this->ServayModel->getServayById($id);
        
        // Update survey details in the database
        $result = $this->ServayModel->updateServay($id, $data);

        if ($result) {
            // Convert old data object to array for logging if it's an object
            $oldDataArray = is_object($oldData) ? (array)$oldData : $oldData;
            
            // Log activity with old and new data
            $this->logActivity('edit', 'servayapp', $id, $data, $oldDataArray, 'Member record updated with ID: ' . $id . ' (Name: ' . $data['name'] . ')');
            // Redirect or display success message
            $this->session->set_flashdata('success', 'Survey details updated successfully!');
            redirect('ServayListing');
        } else {
            // Redirect or display error message
            $this->session->set_flashdata('error', 'Failed to update survey details. Try again.');
            redirect('ServayController/editServay/'.$id);
        }
    }
}

 /**
     * Send welcome SMS to new member
     */
    public function sendWelcomeSms($memberId, $mobile, $memberName) {
        // Validate mobile number - should be 10 digits
        if (empty($mobile) || !preg_match('/^[6-9][0-9]{9}$/', $mobile)) {
            log_message('error', 'Invalid mobile number: ' . $mobile);
            $this->logSms($memberId, $mobile, null, '', 'Mobile number invalid or empty', 'failed');
            return false;
        }
        
        $templateId = null;
        $message = '';
        
        try {
            // Format welcome message using OTP template format
            $message = $this->Sms_model->format_welcome_message($memberName);
            log_message('info', 'Formatted welcome message: ' . $message);
            
            // Get welcome template ID
            $templateId = $this->Sms_model->get_welcome_template_id();
            log_message('info', 'Using template ID: ' . $templateId);
            
            // Send SMS using SMS_model with template ID
            $response = $this->Sms_model->send_sms($mobile, $message, $templateId);
            log_message('info', 'SMS Response: ' . json_encode($response));
            
            if ($response['status']) {
                // SMS sent successfully
                $responseText = isset($response['response']) ? $response['response'] : 'SMS sent successfully';
                $this->logSms($memberId, $mobile, $templateId, $message, $responseText, 'sent');
                log_message('info', 'Welcome SMS sent successfully to: ' . $mobile);
                return true;
            } else {
                // SMS failed
                $errorText = isset($response['error']) ? $response['error'] : 'Unknown error';
                $this->logSms($memberId, $mobile, $templateId, $message, $errorText, 'failed');
                log_message('error', 'Welcome SMS failed: ' . $errorText);
                return false;
            }
        } catch (Exception $e) {
            // Handle any exceptions
            log_message('error', 'Welcome SMS exception: ' . $e->getMessage());
            $this->logSms($memberId, $mobile, $templateId, $message, $e->getMessage(), 'failed');
            return false;
        }
    }

    /**
     * Queue SMS for background processing (non-blocking)
     * This prevents page slowdown by queuing SMS instead of sending immediately
     */
    public function queueSms($memberId, $mobile, $memberName) {
        try {
            // Store SMS in queue table for background processing
            $smsQueue = array(
                'member_id' => $memberId,
                'mobile' => $mobile,
                'member_name' => $memberName,
                'status' => 'pending',
                'created_at' => date('Y-m-d H:i:s'),
                'attempts' => 0
            );
            
            // Insert into sms_queue table (you'll need to create this table)
            $this->db->insert('sms_queue', $smsQueue);
            log_message('info', 'SMS queued for member: ' . $memberId);
            return true;
        } catch (Exception $e) {
            log_message('error', 'Failed to queue SMS: ' . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Log SMS activity to database
     */
    public function logSms($memberId, $mobile, $templateId, $message, $response, $status) {
        $smsLogData = array(
            'member_id' => $memberId,
            'mobile' => $mobile,
            'template_id' => !empty($templateId) ? $templateId : '1707176484272940190',
            'message' => $message,
            'response' => $response,
            'status' => $status,
            'sent_at' => date('Y-m-d H:i:s'),
            'created_by' => $this->session->userdata('userId')
        );
        
        // Check if sms_logs table exists before inserting
        try {
            $this->Comman_model->insertData('sms_logs', $smsLogData);
        } catch (Exception $e) {
            // Log to file if table doesn't exist
            log_message('info', 'SMS Log: ' . json_encode($smsLogData));
        }
    }
}
