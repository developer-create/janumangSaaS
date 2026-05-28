<?php
require APPPATH . '/libraries/BaseController.php';

class District extends BaseController {

    public function __construct() {
        parent::__construct();
        $this->load->model('district_model');
        $this->load->helper('url');
        $this->load->model('user_model');
        $this->load->model('Comman_model');
        $this->isLoggedIn();
        $this->load->model('Log_model');
        $this->load->library('form_validation');
        $this->module = 'District';
    }

    // Display all districts
    public function index() {
        if(!$this->hasListAccess()) {
            $this->loadThis();
        } else {
            $data['districts'] = $this->district_model->get_districts();
            $this->global['pageTitle'] = 'Datacollector :district';
            $this->loadViews("district/index", $this->global, $data, NULL);
        }
    }

    // Show a form to create a new district
    public function create() {
        if(!$this->hasCreateAccess()) {
            $this->loadThis();
        } else {
            $this->global['pageTitle'] = 'Datacollector :district';
            $this->loadViews("district/create", $this->global, [], NULL);
        }
    }

    // Insert a new district
    public function store() {
        if(!$this->hasCreateAccess()) {
            $this->loadThis();
        } else {
            $name = $this->input->post('name');
            $data = array('name' => $name);

            $insert_id = $this->district_model->create_district($data);
            if ($insert_id) {
                $this->logActivity('add', 'district', $insert_id, $data, null, 'District created with ID: ' . $insert_id . ' (Name: ' . $name . ')');
            }

            redirect('district');
        }
    }

    // Show a form to edit a district
    public function edit($id) {
        if(!$this->hasUpdateAccess()) {
            $this->loadThis();
        } else {
            $data['district'] = $this->district_model->get_district($id);
            $this->global['pageTitle'] = 'Datacollector :district';
            $this->loadViews("district/edit", $this->global, $data, NULL);
        }
    }

    // Update a district
    public function update($id) {
        if(!$this->hasUpdateAccess()) {
            $this->loadThis();
        } else {
            $name = $this->input->post('name');
            $data = array('name' => $name);

            // Get old data before update for logging
            $oldData = $this->district_model->get_district($id);
            
            $this->district_model->update_district($id, $data);
            
            // Log activity with old and new data
            $this->logActivity('edit', 'district', $id, $data, $oldData, 'District updated with ID: ' . $id . ' (Name: ' . $name . ')');

            redirect('district');
        }
    }

    // Delete a district
    public function delete($id) {
        if(!$this->hasDeleteAccess()) {
            $this->loadThis();
        } else {
            // Get data before delete for logging
            $districtData = $this->district_model->get_district($id);
            
            $this->district_model->delete_district($id);
            
            // Log activity
            $this->logActivity('delete', 'district', $id, $districtData, null, 'District deleted with ID: ' . $id . ' (Name: ' . (!empty($districtData['name']) ? $districtData['name'] : 'N/A') . ')');

            redirect('district');
        }
    }
}
?>
