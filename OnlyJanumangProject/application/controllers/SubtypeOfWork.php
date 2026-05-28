<?php
require APPPATH . '/libraries/BaseController.php';

class SubtypeOfWork extends BaseController {

    public function __construct() {
        parent::__construct();
        $this->load->model('SubtypeOfWork_model');
        $this->load->model('worktype_model');
        $this->load->helper('url');
        $this->load->model('user_model');
        $this->load->model('Comman_model');
        $this->isLoggedIn();
        $this->load->library('form_validation');  
        $this->load->model('Log_model');
        $this->module = 'SubtypeOfWork';
    }

    // Display all subtype of work
    public function index() {
        if (!$this->hasListAccess()) {
            $this->loadThis(); // Redirect to the unauthorized access page
        } else {
            $data['subtype_of_works'] = $this->SubtypeOfWork_model->get_all_subtype_of_work();
            $this->global['pageTitle'] = 'Datacollector : Subtype Of Work';
            $this->loadViews("subtypeofwork/index", $this->global, $data, NULL);
        }
    }

    // Show a form to create a new subtype of work
    public function create() {
        if (!$this->hasCreateAccess()) {
            $this->loadThis(); // Redirect to the unauthorized access page
        } else {
            $data['worktypes'] = $this->worktype_model->get_worktypes();
            $this->global['pageTitle'] = 'Datacollector : Create Subtype Of Work';
            $this->loadViews("subtypeofwork/create", $this->global, $data, NULL);
        }
    }

    // Insert a new subtype of work
    public function store() {
        if (!$this->hasCreateAccess()) {
            $this->loadThis(); // Redirect to the unauthorized access page
        } else {
            $data = array(
                'work_type_id' => $this->input->post('work_type_id'),
                'name' => $this->input->post('name'),
                'created_by' => $this->vendorId,
            );

            $id = $this->SubtypeOfWork_model->create_subtype_of_work($data);
            if ($id) {
                // Log activity (single entry)
                $this->logActivity('add', 'subtype_of_work', $id, $data, null, 'Subtype Of Work created with ID: ' . $id . ' (Name: ' . $data['name'] . ')');
            }
            redirect('subtypeofwork');
        }
    }

    // Show a form to edit a subtype of work
    public function edit($id) {
        if (!$this->hasUpdateAccess()) {
            $this->loadThis(); // Redirect to the unauthorized access page
        } else {
            $data['subtype_of_work'] = $this->SubtypeOfWork_model->get_subtype_of_work($id);
            $data['worktypes'] = $this->worktype_model->get_worktypes();
            $this->global['pageTitle'] = 'Datacollector : Edit Subtype Of Work';
            $this->loadViews("subtypeofwork/edit", $this->global, $data, NULL);
        }
    }

    // Update a subtype of work
    public function update($id) {
        if (!$this->hasUpdateAccess()) {
            $this->loadThis(); // Redirect to the unauthorized access page
        } else {
            $data = array(
                'work_type_id' => $this->input->post('work_type_id'),
                'name' => $this->input->post('name'),
                'updated_by' => $this->vendorId,
            );

            // Get old data before update for logging
            $oldData = $this->SubtypeOfWork_model->get_subtype_of_work($id);
            
            $this->SubtypeOfWork_model->update_subtype_of_work($id, $data);
            
            // Log activity with old and new data (single entry)
            $this->logActivity('edit', 'subtype_of_work', $id, $data, $oldData, 'Subtype Of Work updated with ID: ' . $id . ' (Name: ' . $data['name'] . ')');
            
            redirect('subtypeofwork');
        }
    }

    // Delete a subtype of work
    public function delete($id) {
        if (!$this->hasDeleteAccess()) {
            $this->loadThis(); // Redirect to the unauthorized access page
        } else {
            // Get data before delete for logging
            $subtypeData = $this->SubtypeOfWork_model->get_subtype_of_work($id);
            
            $this->SubtypeOfWork_model->delete_subtype_of_work($id);
            
            // Log activity (single entry)
            $this->logActivity('delete', 'subtype_of_work', $id, $subtypeData, null, 'Subtype Of Work deleted with ID: ' . $id . ' (Name: ' . (!empty($subtypeData['name']) ? $subtypeData['name'] : 'N/A') . ')');
            
            redirect('subtypeofwork');
        }
    }

}

