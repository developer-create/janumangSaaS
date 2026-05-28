<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . '/libraries/BaseController.php';
class PhoneDirectory extends BaseController
{
    // Declare properties that may be dynamically assigned
    public $session;
    public $PhoneDirectory_model;
    public $form_validation;

    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('PhoneDirectory_model');
        $this->isLoggedIn();
        $this->module = 'Phone-Directory'; // Fixed: Changed to match config (with hyphen)
        $this->load->library('form_validation');
    }

    /**
     * This function used to load the first screen of the phone directory
     */
    public function index()
    {
        $this->global['pageTitle'] = 'Jan Umang : Phone Directory';
        
        if(!$this->hasListAccess())
        {
            $this->loadThis();
        }
        else
        {        
            $searchText = $this->input->post('searchText');
            $searchText = $searchText ? $this->security->xss_clean($searchText) : '';
            $data['searchText'] = $searchText;
            
            $data['phoneDirectoryRecords'] = $this->PhoneDirectory_model->phoneDirectoryListingAll($searchText);
            
            $this->loadViews("phonedirectory/index", $this->global, $data, NULL);
        }
    }

    /**
     * This function is used to load the add new form
     */
    function add()
    {
        if(!$this->hasCreateAccess())
        {
            $this->loadThis();
        }
        else
        {
            $this->global['pageTitle'] = 'Jan Umang : Add New Phone Directory Entry';

            $this->form_validation->set_rules('name','Name','trim|required|max_length[255]');
            $this->form_validation->set_rules('number','Number','trim|required|max_length[20]');
            $this->form_validation->set_rules('alternate_number','Alternate Number','trim|max_length[20]');
            $this->form_validation->set_rules('email','Email','trim|valid_email|max_length[255]');
            $this->form_validation->set_rules('post','Post','trim|max_length[255]');
            $this->form_validation->set_rules('department_id','Department','trim|numeric');
            $this->form_validation->set_rules('district_id','District','trim|numeric');
            $this->form_validation->set_rules('vs_block_id','VS Block','trim|numeric');
            $this->form_validation->set_rules('party_id','Party','trim|numeric');
            $this->form_validation->set_rules('remark','Remark','trim');
            
            if($this->form_validation->run() == FALSE)
            {
                $data['departments'] = $this->PhoneDirectory_model->getDepartments();
                $data['districts'] = $this->PhoneDirectory_model->getDistricts();
                $data['blocks'] = $this->PhoneDirectory_model->getBlocks();
                $data['parties'] = $this->PhoneDirectory_model->getParties();
                
                $this->loadViews("phonedirectory/add", $this->global, $data, NULL);
            }
            else
            {
                $name_input = $this->input->post('name');
                $name = $name_input ? ucwords(strtolower($this->security->xss_clean($name_input))) : '';
                
                $post_input = $this->input->post('post');
                $post = $post_input ? $this->security->xss_clean($post_input) : '';
                
                $department_id = $this->input->post('department_id') ? $this->input->post('department_id') : NULL;
                $district_id = $this->input->post('district_id') ? $this->input->post('district_id') : NULL;
                $vs_block_id = $this->input->post('vs_block_id') ? $this->input->post('vs_block_id') : NULL;
                
                $number_input = $this->input->post('number');
                $number = $number_input ? $this->security->xss_clean($number_input) : '';
                
                $alternate_number_input = $this->input->post('alternate_number');
                $alternate_number = $alternate_number_input ? $this->security->xss_clean($alternate_number_input) : '';
                
                $email_input = $this->input->post('email');
                $email = $email_input ? strtolower($this->security->xss_clean($email_input)) : '';
                
                $party_id = $this->input->post('party_id') ? $this->input->post('party_id') : NULL;
                
                $remark_input = $this->input->post('remark');
                $remark = $remark_input ? $this->security->xss_clean($remark_input) : '';
                
                $phoneDirectoryInfo = array(
                    'name' => $name,
                    'post' => $post,
                    'department_id' => $department_id,
                    'district_id' => $district_id,
                    'vs_block_id' => $vs_block_id,
                    'number' => $number,
                    'alternate_number' => $alternate_number,
                    'email' => $email,
                    'party_id' => $party_id,
                    'remark' => $remark,
                    'status' => 'Active',
                    'created_by' => $this->vendorId,
                    'created_at' => date('Y-m-d H:i:s')
                );
                
                $result = $this->PhoneDirectory_model->addNewPhoneDirectory($phoneDirectoryInfo);
                
                if($result > 0)
                {
                    // Log activity
                    $this->logActivity('add', 'phone_directory', $result, $phoneDirectoryInfo, null, 'Phone Directory entry created with ID: ' . $result . ' (Name: ' . $phoneDirectoryInfo['name'] . ')');
                    $this->session->set_flashdata('success', 'New Phone Directory entry created successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', 'Phone Directory entry creation failed');
                }
                
                redirect('phonedirectory');
            }
        }
    }

    /**
     * This function is used load phone directory edit information
     * @param number $phoneDirectoryId : Optional parameter of the phone directory
     */
    function edit($phoneDirectoryId = NULL)
    {
        if(!$this->hasUpdateAccess())
        {
            $this->loadThis();
        }
        else
        {
            if($phoneDirectoryId == null)
            {
                redirect('phonedirectory');
            }
            
            $data['phoneDirectoryInfo'] = $this->PhoneDirectory_model->getPhoneDirectoryInfo($phoneDirectoryId);
            
            if(empty($data['phoneDirectoryInfo']))
            {
                $this->session->set_flashdata('error', 'Phone Directory entry not found');
                redirect('phonedirectory');
            }
            
            $this->global['pageTitle'] = 'Jan Umang : Edit Phone Directory Entry';
            
            $this->form_validation->set_rules('name','Name','trim|required|max_length[255]');
            $this->form_validation->set_rules('number','Number','trim|required|max_length[20]');
            $this->form_validation->set_rules('alternate_number','Alternate Number','trim|max_length[20]');
            $this->form_validation->set_rules('email','Email','trim|valid_email|max_length[255]');
            $this->form_validation->set_rules('post','Post','trim|max_length[255]');
            $this->form_validation->set_rules('department_id','Department','trim|numeric');
            $this->form_validation->set_rules('district_id','District','trim|numeric');
            $this->form_validation->set_rules('vs_block_id','VS Block','trim|numeric');
            $this->form_validation->set_rules('party_id','Party','trim|numeric');
            $this->form_validation->set_rules('remark','Remark','trim');
            
            if($this->form_validation->run() == FALSE)
            {
                $data['departments'] = $this->PhoneDirectory_model->getDepartments();
                $data['districts'] = $this->PhoneDirectory_model->getDistricts();
                $data['blocks'] = $this->PhoneDirectory_model->getBlocks();
                $data['parties'] = $this->PhoneDirectory_model->getParties();
                
                $this->loadViews("phonedirectory/edit", $this->global, $data, NULL);
            }
            else
            {
                $name_input = $this->input->post('name');
                $name = $name_input ? ucwords(strtolower($this->security->xss_clean($name_input))) : '';
                
                $post_input = $this->input->post('post');
                $post = $post_input ? $this->security->xss_clean($post_input) : '';
                
                $department_id = $this->input->post('department_id') ? $this->input->post('department_id') : NULL;
                $district_id = $this->input->post('district_id') ? $this->input->post('district_id') : NULL;
                $vs_block_id = $this->input->post('vs_block_id') ? $this->input->post('vs_block_id') : NULL;
                
                $number_input = $this->input->post('number');
                $number = $number_input ? $this->security->xss_clean($number_input) : '';
                
                $alternate_number_input = $this->input->post('alternate_number');
                $alternate_number = $alternate_number_input ? $this->security->xss_clean($alternate_number_input) : '';
                
                $email_input = $this->input->post('email');
                $email = $email_input ? strtolower($this->security->xss_clean($email_input)) : '';
                
                $party_id = $this->input->post('party_id') ? $this->input->post('party_id') : NULL;
                
                $remark_input = $this->input->post('remark');
                $remark = $remark_input ? $this->security->xss_clean($remark_input) : '';
                
                $phoneDirectoryInfo = array(
                    'name' => $name,
                    'post' => $post,
                    'department_id' => $department_id,
                    'district_id' => $district_id,
                    'vs_block_id' => $vs_block_id,
                    'number' => $number,
                    'alternate_number' => $alternate_number,
                    'email' => $email,
                    'party_id' => $party_id,
                    'remark' => $remark,
                    'updated_by' => $this->vendorId,
                    'updated_at' => date('Y-m-d H:i:s')
                );
                
                // Get old data before update for logging
                $oldData = $this->PhoneDirectory_model->getPhoneDirectoryInfo($phoneDirectoryId);
                
                $result = $this->PhoneDirectory_model->editPhoneDirectory($phoneDirectoryInfo, $phoneDirectoryId);
                
                if($result == true)
                {
                    // Log activity with old and new data
                    $this->logActivity('edit', 'phone_directory', $phoneDirectoryId, $phoneDirectoryInfo, (array)$oldData, 'Phone Directory entry updated with ID: ' . $phoneDirectoryId . ' (Name: ' . $phoneDirectoryInfo['name'] . ')');
                    $this->session->set_flashdata('success', 'Phone Directory entry updated successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', 'Phone Directory entry updation failed');
                }
                
                redirect('phonedirectory');
            }
        }
    }

    /**
     * This function is used to view phone directory information
     * @param number $phoneDirectoryId : Optional parameter of the phone directory
     */
    function view($phoneDirectoryId = NULL)
    {
        if(!$this->hasListAccess())
        {
            $this->loadThis();
        }
        else
        {
            if($phoneDirectoryId == null)
            {
                redirect('phonedirectory');
            }
            
            $data['phoneDirectoryInfo'] = $this->PhoneDirectory_model->getPhoneDirectoryInfo($phoneDirectoryId);
            
            if(empty($data['phoneDirectoryInfo']))
            {
                $this->session->set_flashdata('error', 'Phone Directory entry not found');
                redirect('phonedirectory');
            }
            
            $this->global['pageTitle'] = 'Jan Umang : Phone Directory Details';
            
            $this->loadViews("phonedirectory/view", $this->global, $data, NULL);
        }
    }

    /**
     * This function is used to delete phone directory entry
     * @param number $phoneDirectoryId : This is phone directory id
     */
    function delete($phoneDirectoryId = NULL)
    {
        if(!$this->hasDeleteAccess())
        {
            $this->loadThis();
        }
        else
        {
            if($phoneDirectoryId == null)
            {
                $this->session->set_flashdata('error', 'Invalid phone directory entry');
                redirect('phonedirectory');
            }
            else
            {
                $phoneDirectoryInfo = $this->PhoneDirectory_model->getPhoneDirectoryInfo($phoneDirectoryId);
                
                if(empty($phoneDirectoryInfo))
                {
                    $this->session->set_flashdata('error', 'Phone Directory entry not found');
                    redirect('phonedirectory');
                }
                else
                {
                    $result = $this->PhoneDirectory_model->deletePhoneDirectory($phoneDirectoryId);
                    
                    if ($result > 0) {
                        // Log activity
                        $this->logActivity('delete', 'phone_directory', $phoneDirectoryId, (array)$phoneDirectoryInfo, null, 'Phone Directory entry deleted with ID: ' . $phoneDirectoryId . ' (Name: ' . (!empty($phoneDirectoryInfo->name) ? $phoneDirectoryInfo->name : 'N/A') . ')');
                        $this->session->set_flashdata('success', 'Phone Directory entry deleted successfully');
                    }
                    else
                    {
                        $this->session->set_flashdata('error', 'Phone Directory entry deletion failed');
                    }
                    
                    redirect('phonedirectory');
                }
            }
        }
    }

    /**
     * Show bulk upload form for Phone Directory
     */
    public function bulk_upload() {
        if (!$this->hasCreateAccess()) {
            $this->loadThis();
        } else {
            $data["departments"] = $this->PhoneDirectory_model->getDepartments();
            $data["districts"] = $this->PhoneDirectory_model->getDistricts();
            $data["blocks"] = $this->PhoneDirectory_model->getBlocks();
            $data["parties"] = $this->PhoneDirectory_model->getParties();
            
            $this->global["pageTitle"] = "Jan Umang : Bulk Upload Phone Directory";
            $this->loadViews("phonedirectory/bulk_upload", $this->global, $data, null);
        }
    }

    /**
     * Process bulk upload for Phone Directory
     */
    public function process_bulk_upload() {
        if (!$this->hasCreateAccess()) {
            $this->loadThis();
        } else {
            $config['upload_path'] = './uploads/bulk_phonedirectory/';
            $config['allowed_types'] = 'csv';
            $config['max_size'] = 10240; // 10MB
            
            if (!is_dir($config['upload_path'])) {
                mkdir($config['upload_path'], 0755, true);
            }
            
            $this->load->library('upload', $config);
            $this->load->helper('bulk_upload');
            
            if (!$this->upload->do_upload('bulk_file')) {
                $this->session->set_flashdata('error', $this->upload->display_errors());
                redirect('phonedirectory/bulk_upload');
            } else {
                $upload_data = $this->upload->data();
                $file_path = $upload_data['full_path'];
                
                try {
                    $rows = parse_bulk_upload_file($file_path);
                    
                    if (empty($rows)) {
                        throw new Exception('Unable to parse file. Please ensure it is a valid CSV file.');
                    }
                    
                    $headers = array_map('trim', $rows[0]);
                    $column_map = array();
                    foreach ($headers as $index => $header) {
                        $column_map[strtolower(str_replace([' ', '*'], ['_', ''], $header))] = $index;
                    }
                    
                    $success_count = 0;
                    $error_count = 0;
                    $errors = array();
                    
                    for ($i = 1; $i < count($rows); $i++) {
                        $row = $rows[$i];
                        if (empty(array_filter($row))) continue;
                        
                        $get_col = function($col_name) use ($row, $column_map) {
                            $key = strtolower(str_replace([' ', '*'], ['_', ''], $col_name));
                            return isset($column_map[$key]) && isset($row[$column_map[$key]]) ? trim($row[$column_map[$key]]) : '';
                        };
                        
                        $name = $get_col('Name');
                        $number = $get_col('Number');
                        
                        if (empty($name) || empty($number)) {
                            $errors[] = "Row " . ($i + 1) . ": Name and Number are required";
                            $error_count++;
                            continue;
                        }
                        
                        $dept_name = $get_col('Department Name');
                        $dist_name = $get_col('District Name');
                        $block_name = $get_col('VS Block Name');
                        $party_name = $get_col('Party Name');
                        
                        $dept_id = !empty($dept_name) ? get_id_by_name($this, 'department', 'name', $dept_name) : null;
                        $dist_id = !empty($dist_name) ? get_id_by_name($this, 'district', 'name', $dist_name) : null;
                        $block_id = !empty($block_name) ? get_id_by_name($this, 'block', 'name', $block_name) : null;
                        $party_id = !empty($party_name) ? get_id_by_name($this, 'party', 'name', $party_name) : null;
                        
                        // Auto-create if not exists (optional, following jansunwai pattern)
                        if (empty($dept_id) && !empty($dept_name)) {
                            $this->db->insert('department', ['name' => $dept_name]);
                            $dept_id = $this->db->insert_id();
                        }
                        if (empty($dist_id) && !empty($dist_name)) {
                            $this->db->insert('district', ['name' => $dist_name]);
                            $dist_id = $this->db->insert_id();
                        }
                        if (empty($block_id) && !empty($block_name)) {
                            $this->db->insert('block', ['name' => $block_name]);
                            $block_id = $this->db->insert_id();
                        }
                        if (empty($party_id) && !empty($party_name)) {
                            $this->db->insert('party', ['name' => $party_name]);
                            $party_id = $this->db->insert_id();
                        }
                        
                        $data = array(
                            'name' => ucwords(strtolower($name)),
                            'number' => $number,
                            'alternate_number' => $get_col('Alternate Number'),
                            'email' => strtolower($get_col('Email')),
                            'post' => $get_col('Post'),
                            'department_id' => $dept_id,
                            'district_id' => $dist_id,
                            'vs_block_id' => $block_id,
                            'party_id' => $party_id,
                            'remark' => $get_col('Remark'),
                            'status' => 'Active',
                            'created_by' => $this->vendorId,
                            'created_at' => date('Y-m-d H:i:s')
                        );
                        
                        $result = $this->PhoneDirectory_model->addNewPhoneDirectory($data);
                        if ($result) {
                            $this->logActivity('add', 'phone_directory', $result, $data, null, 'Phone Directory entry created via bulk upload with ID: ' . $result . ' (Name: ' . $data['name'] . ')');
                            $success_count++;
                        } else {
                            $errors[] = "Row " . ($i + 1) . ": Failed to insert record";
                            $error_count++;
                        }
                    }
                    
                    unlink($file_path);
                    
                    $message = "Bulk upload completed. Success: $success_count, Errors: $error_count";
                    if (!empty($errors)) {
                        $message .= "\nErrors: " . implode(", ", array_slice($errors, 0, 5));
                    }
                    
                    if ($success_count > 0) {
                        $this->session->set_flashdata('success', $message);
                    } else {
                        $this->session->set_flashdata('error', $message);
                    }
                    
                } catch (Exception $e) {
                    $this->session->set_flashdata('error', 'Error processing file: ' . $e->getMessage());
                }
                
                redirect('phonedirectory');
            }
        }
    }

    /**
     * Download sample CSV template for Phone Directory
     */
    public function download_template() {
        $filename = 'phonedirectory_template.csv';
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        
        $output = fopen('php://output', 'w');
        $headers = array('Name*', 'Number*', 'Email', 'Post', 'Department Name', 'District Name', 'VS Block Name', 'Party Name');
        fputcsv($output, $headers);
        
        $sample = array('John Doe', '9876543210', 'john@example.com', 'Manager', 'PWD', 'Dhar', 'Gandhwani', 'BJP');
        fputcsv($output, $sample);
        fclose($output);
    }

    /**
     * Page not found : error 404
     */
    function pageNotFound()
    {
        $this->global['pageTitle'] = 'Jan Umang : 404 - Page Not Found';
        
        $this->loadViews("404", $this->global, NULL, NULL);
    }
}

?>