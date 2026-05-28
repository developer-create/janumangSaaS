<?php
require APPPATH . '/libraries/BaseController.php';

class Worktype extends BaseController {

    public function __construct() {
        parent::__construct();
        $this->load->model('worktype_model');
        $this->load->helper('url');
        $this->load->model('user_model');
        $this->load->model('Comman_model');
        $this->isLoggedIn();
        $this->load->library('form_validation');  
        $this->load->model('Log_model');
        $this->module = 'Worktype'; // Fixed: Changed from lowercase to match config
    }

    // Display all worktypes
    public function index() {
        if (!$this->hasListAccess()) {
            $this->loadThis(); // Redirect to the unauthorized access page
        } else {
            $data['worktypes'] = $this->worktype_model->get_worktypes();
            $this->global['pageTitle'] = 'Datacollector : worktype';
            $this->loadViews("worktype/index", $this->global, $data, NULL);
        }
    }

    // Show a form to create a new worktype
    public function create() {
        if (!$this->hasCreateAccess()) {
            $this->loadThis(); // Redirect to the unauthorized access page
        } else {
            $this->global['pageTitle'] = 'Datacollector : Create worktype';
            $this->loadViews("worktype/create", $this->global, [], NULL);
        }
    }

    // Insert a new worktype
    public function store() {
        if (!$this->hasCreateAccess()) {
            $this->loadThis(); // Redirect to the unauthorized access page
        } else {
            $name = $this->input->post('name');
            $data = array('name' => $name);
            $id = $this->worktype_model->create_worktype($data);
            if ($id) {
                $this->logActivity('add', 'worktype', $id, $data, null, 'Worktype created with ID: ' . $id . ' (Name: ' . $name . ')');
            }
            redirect('worktype');
        }
    }

    // Show a form to edit a worktype
    public function edit($id) {
        if (!$this->hasUpdateAccess()) {
            $this->loadThis(); // Redirect to the unauthorized access page
        } else {
            $data['worktype'] = $this->worktype_model->get_worktype($id);
            $this->global['pageTitle'] = 'Datacollector : Edit worktype';
            $this->loadViews("worktype/edit", $this->global, $data, NULL);
        }
    }

    // Update a worktype
    public function update($id) {
        if (!$this->hasUpdateAccess()) {
            $this->loadThis(); // Redirect to the unauthorized access page
        } else {
            $name = $this->input->post('name');
            $data = array('name' => $name);
            // Get old data before update for logging
            $oldData = $this->worktype_model->get_worktype($id);
            
            $this->worktype_model->update_worktype($id, $data);
            
            // Log activity with old and new data
            $this->logActivity('edit', 'worktype', $id, $data, $oldData, 'Worktype updated with ID: ' . $id . ' (Name: ' . $name . ')');
            
            redirect('worktype');
        }
    }

    // Delete a worktype
    public function delete($id) {
        if (!$this->hasDeleteAccess()) {
            $this->loadThis(); // Redirect to the unauthorized access page
        } else {
            // Get data before delete for logging
            $worktypeData = $this->worktype_model->get_worktype($id);
            
            $this->worktype_model->delete_worktype($id);
            
            // Log activity
            $this->logActivity('delete', 'worktype', $id, $worktypeData, null, 'Worktype deleted with ID: ' . $id . ' (Name: ' . (!empty($worktypeData['name']) ? $worktypeData['name'] : 'N/A') . ')');
            
            redirect('worktype');
        }
    }


}
?>
