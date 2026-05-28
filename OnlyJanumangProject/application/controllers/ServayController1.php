<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . "/libraries/BaseController.php";

#[AllowDynamicProperties]
class ServayController extends BaseController {

    public function __construct() {
        parent::__construct();
        $this->load->model('ServayModel');
        $this->load->model('Comman_model');
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

        // Define form validation rules
       $this->form_validation->set_rules('block_name_number', 'Block Name/Number', 'required|numeric');
        $this->form_validation->set_rules('grampanchayat', 'Gram Panchayat', 'required|numeric');
      $this->form_validation->set_rules('village', 'Village', 'required|numeric');
        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('fathername', 'Father Name', 'required');
        $this->form_validation->set_rules('jaati', 'Caste', 'required');
        $this->form_validation->set_rules('age', 'Age', 'required|numeric');
        $this->form_validation->set_rules('education', 'Education', 'required');
        $this->form_validation->set_rules('mobile', 'Mobile', 'required');
        $this->form_validation->set_rules('votarcode', 'Voter Code', 'required');
        $this->form_validation->set_rules('address', 'Address', 'required');
        $this->form_validation->set_rules('gender', 'Gender', 'required');
        $this->form_validation->set_rules('vehicle[]', 'Vehicle', 'callback_validate_vehicle');
        $this->form_validation->set_rules('government_employee', 'Government Employee', 'required');
        $this->form_validation->set_rules('parti', 'Party', 'required|numeric');
        // Validate checkbox array: require at least one code option via callback
        $this->form_validation->set_rules('code[]', 'Code', 'callback_validate_code');
        // $this->form_validation->set_rules('image', 'Image', 'required'); // Removed required for image
        $this->form_validation->set_rules('respect_for_women', 'Respect for Women', 'required');
        $this->form_validation->set_rules('farmer_loan_waiver', 'Farmer Loan Waiver', 'required');
        $this->form_validation->set_rules('samithi', 'Samithi', 'required|numeric');
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
                'lat' => 0,
                'long' => 0,
                'date' => '0000-00-00',
                'samithi' => $this->input->post('samithi'),
                'facebook' => $this->input->post('facebook'),
                'instagram' => $this->input->post('instagram'),
                'twitter' => $this->input->post('twitter'),
                'end_lat' => 0,
                'end_long' => 0,
                'group' => $this->input->post('group'),
                'toll' => $this->input->post('toll'),
                'padvarsh' => $this->input->post('padvarsh'),
                'remark' => $this->input->post('remark'),
                'reference' => $this->input->post('reference'),
                'district' => $this->input->post('district'),
                'create_date' => date('Y-m-d H:i:s'),
                'startdate' => date('D M d Y H:i:s \G\M\T+0530 (T)'),  // Set current date time as start date
                'enddate' => date('D M d Y H:i:s \G\M\T+0530 (T)'),    // Set current date time as end date
                'user_id'=> $this->session->userdata("userId")
            );            // Add image path to data if uploaded
            if (!empty($imagePath)) {
                $surveyData['image'] = $imagePath;
            }
            
            // Add dob and dom (handle empty strings as NULL)
            $surveyData['dob'] = $this->input->post('dob') ?: NULL;
            $surveyData['dom'] = $this->input->post('dom') ?: NULL;

            // Insert survey data into the database
            $insertId = $this->ServayModel->insertServay($surveyData);

            // Check if data was successfully inserted
            if ($insertId) {
                // Log activity
                $this->logActivity('add', 'servayapp', $insertId, $surveyData, null, 'Member record created with ID: ' . $insertId . ' (Name: ' . $surveyData['name'] . ')');
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
            $this->global['pageTitle'] = 'Datacollector :add';
            $data['upload_error'] = isset($this->upload_error) ? $this->upload_error : '';

            $this->loadViews("member/edit", $this->global, $data, NULL);
    }

    // Update survey details
   public function updateServay($id) {
    // Validation rules
    $this->form_validation->set_rules('block_name_number', 'Block Name/Number', 'required|numeric');
    $this->form_validation->set_rules('grampanchayat', 'Gram Panchayat', 'required|numeric');
    $this->form_validation->set_rules('village', 'Village', 'required|numeric');
    $this->form_validation->set_rules('name', 'Name', 'required');
    $this->form_validation->set_rules('fathername', 'Father Name', 'required');
    $this->form_validation->set_rules('jaati', 'Caste', 'required');
    $this->form_validation->set_rules('age', 'Age', 'required|numeric');
    $this->form_validation->set_rules('education', 'Education', 'required');
    $this->form_validation->set_rules('mobile', 'Mobile', 'required');
    $this->form_validation->set_rules('votarcode', 'Voter Code', 'required');
    $this->form_validation->set_rules('address', 'Address', 'required');
    $this->form_validation->set_rules('gender', 'Gender', 'required');
    $this->form_validation->set_rules('vehicle[]', 'Vehicle', 'callback_validate_vehicle');
    $this->form_validation->set_rules('government_employee', 'Government Employee', 'required');
    $this->form_validation->set_rules('parti', 'Party', 'required|numeric');
    // Validate checkbox array: require at least one code option via callback
    $this->form_validation->set_rules('code[]', 'Code', 'callback_validate_code');
    // $this->form_validation->set_rules('image', 'Image', 'required'); // Removed required for image
        $this->form_validation->set_rules('respect_for_women', 'Respect for Women', 'required');
        $this->form_validation->set_rules('farmer_loan_waiver', 'Farmer Loan Waiver', 'required');
        $this->form_validation->set_rules('samithi', 'Samithi', 'required|numeric');
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
            'update_date' => date('Y-m-d H:i:s'),
            'enddate' => date('D M d Y H:i:s \G\M\T+0530 (T)')  // Update enddate when editing
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

}
