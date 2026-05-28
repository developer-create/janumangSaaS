<?php
require APPPATH . '/libraries/BaseController.php';

class CallManagement extends BaseController {

    public function __construct() {
        parent::__construct();
        $this->load->model('CallManagement_model');
        $this->load->helper('url');
        $this->load->model('user_model');
        $this->load->model('Comman_model');
        $this->isLoggedIn();
        $this->load->library('form_validation');
        $this->load->model('Log_model');
        $this->module = 'Call-Management';
    }

    // Display all call management records
    public function index() {
        if (!$this->hasListAccess()) {
            $this->loadThis(); // Redirect to the unauthorized access page
        } else {
            $data['calls'] = $this->CallManagement_model->get_all_calls();
            $this->global['pageTitle'] = 'Datacollector : Call Management';
            $this->loadViews("call_management/list", $this->global, $data, NULL);
        }
    }

    // Show a form to create a new call
    public function create() {
        if (!$this->hasCreateAccess()) {
            $this->loadThis(); // Redirect to the unauthorized access page
        } else {
            $data['categories'] = $this->get_categories();
            $this->global['pageTitle'] = 'Datacollector : Create Call Management';
            $this->loadViews("call_management/add", $this->global, $data, NULL);
        }
    }

    // Store a new call (renamed from add to store like Events)
    public function store() {
        if (!$this->hasCreateAccess()) {
            $this->loadThis(); // Redirect to the unauthorized access page
        } else {
            $assign_datetime = $this->input->post('assign_datetime');
            $assign_datetime = !empty($assign_datetime) ? date('Y-m-d H:i:s', strtotime($assign_datetime)) : null;
            
            $data = array(
                'date_time' => date('Y-m-d H:i:s', strtotime($this->input->post('date_time'))),
                'category' => $this->input->post('category'),
                'name' => $this->input->post('name'),
                'mobile_no' => $this->input->post('mobile_no'),
                'address' => $this->input->post('address'),
                'subject' => $this->input->post('subject'),
                'description' => $this->input->post('description'),
                'remark' => $this->input->post('remark'),
                'assign_datetime' => $assign_datetime,
                'created_by' => $this->vendorId,
            );
            
            $id = $this->CallManagement_model->insert_call($data);
            if ($id) {
                // Log activity
                $this->logActivity('add', 'call_management', $id, $data, null, 'Call created with ID: ' . $id . ' (Name: ' . $data['name'] . ')');
            }
            redirect('callmanagement');
        }
    }

    // Legacy add method for backward compatibility
    public function add() {
        redirect('callmanagement/create');
    }

    // Show a form to edit a call
    public function edit($id) {
        if (!$this->hasUpdateAccess()) {
            $this->loadThis(); // Redirect to the unauthorized access page
        } else {
            $data['call'] = $this->CallManagement_model->get_call_by_id($id);
            $data['categories'] = $this->get_categories();
            $this->global['pageTitle'] = 'Datacollector : Edit Call Management';
            $this->loadViews("call_management/edit", $this->global, $data, NULL);
        }
    }

    // Update a call
    public function update($id) {
        if (!$this->hasUpdateAccess()) {
            $this->loadThis(); // Redirect to the unauthorized access page
        } else {
            $assign_datetime = $this->input->post('assign_datetime');
            $assign_datetime = !empty($assign_datetime) ? date('Y-m-d H:i:s', strtotime($assign_datetime)) : null;
            
            $data = array(
                'date_time' => date('Y-m-d H:i:s', strtotime($this->input->post('date_time'))),
                'category' => $this->input->post('category'),
                'name' => $this->input->post('name'),
                'mobile_no' => $this->input->post('mobile_no'),
                'address' => $this->input->post('address'),
                'subject' => $this->input->post('subject'),
                'description' => $this->input->post('description'),
                'remark' => $this->input->post('remark'),
                'assign_datetime' => $assign_datetime,
                'updated_by' => $this->vendorId,
            );
            
            // Get old data before update for logging
            $oldData = $this->CallManagement_model->get_call_by_id($id);
            
            $this->CallManagement_model->update_call($id, $data);
            
            // Log activity with old and new data
            $this->logActivity('edit', 'call_management', $id, $data, $oldData, 'Call updated with ID: ' . $id . ' (Name: ' . $data['name'] . ')');
            
            redirect('callmanagement');
        }
    }

    // View call details
    public function view($id) {
        if (!$this->hasListAccess()) {
            $this->loadThis(); // Redirect to the unauthorized access page
        } else {
            $data['call'] = $this->CallManagement_model->get_call_by_id($id);
            $this->global['pageTitle'] = 'Datacollector : View Call Management';
            $this->loadViews("call_management/view", $this->global, $data, NULL);
        }
    }

    // Delete a call management record
    public function delete($id) {
        if (!$this->hasDeleteAccess()) {
            $this->loadThis(); // Redirect to the unauthorized access page
        } else {
            // Get data before delete for logging
            $callData = $this->CallManagement_model->get_call_by_id($id);
            
            if ($callData) {
                // Convert object to string for logging
                $oldData = json_encode($callData);
                
                $this->CallManagement_model->delete_call($id);
                
                // Log activity
                $this->logActivity('delete', 'call_management', $id, $oldData, null, 'Call deleted with ID: ' . $id . ' (Name: ' . (!empty($callData->name) ? $callData->name : 'N/A') . ')');
            } else {
                $this->CallManagement_model->delete_call($id);
                $this->logActivity('delete', 'call_management', $id, '', null, 'Call deleted with ID: ' . $id);
            }
            
            redirect('callmanagement');
        }
    }

    private function get_categories() {
        return array(
            'Appointment' => 'Appointment',
            'Samsya' => 'Samsya',
            'General' => 'General'
        );
    }
}