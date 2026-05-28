<?php
require APPPATH . '/libraries/BaseController.php';

class Samiti extends BaseController {

    public function __construct() {
        parent::__construct();
        $this->load->model('Samiti_model');
        $this->load->helper('url');
        $this->load->model('user_model');
        $this->load->model('Comman_model');
        $this->isLoggedIn();
        $this->load->library('form_validation');  
        $this->load->model('Log_model');
        $this->module = 'Samiti';
    }

    // Display all samitis
    public function index() {
        if (!$this->hasListAccess()) {
            $this->loadThis(); // Redirect to the unauthorized access page
        } else {
            // Get filter values from POST
            $block_id = $this->input->post('block_id');
            $year = $this->input->post('year');
            $month = $this->input->post('month');
            
            // Get filtered samitis
            $data['samitis'] = $this->Samiti_model->get_samitis($block_id, $year, $month);
            
            // Get blocks for filter dropdown
            $data['blocks'] = $this->Samiti_model->get_blocks();
            
            // Pass filter values to view
            $data['filter_block_id'] = $block_id;
            $data['filter_year'] = $year;
            $data['filter_month'] = $month;
            
            $this->global['pageTitle'] = 'Datacollector : Samiti';
            $this->loadViews("samiti/index", $this->global, $data, NULL);
        }
    }

    // Show a form to create a new samiti
    public function create() {
        if (!$this->hasCreateAccess()) {
            $this->loadThis(); // Redirect to the unauthorized access page
        } else {
            $data['blocks'] = $this->Samiti_model->get_blocks();
            $this->global['pageTitle'] = 'Datacollector : Create Samiti';
            $this->loadViews("samiti/create", $this->global, $data, NULL);
        }
    }

    // Insert a new samiti
    public function store() {
        if (!$this->hasCreateAccess()) {
            $this->loadThis(); // Redirect to the unauthorized access page
        } else {
            $name = $this->input->post('name');
            $block_id = $this->input->post('block_id');
            $year = $this->input->post('year');
            $month = $this->input->post('month');
            
            $data = array(
                'name' => $name,
                'block_id' => !empty($block_id) ? $block_id : null,
                'year' => !empty($year) ? $year : null,
                'month' => !empty($month) ? $month : null
            );
            
            $id = $this->Samiti_model->create_samiti($data);
            if ($id) {
                $this->logActivity('add', 'samiti', $id, $data, null, 'Samiti created with ID: ' . $id . ' (Name: ' . $name . ')');
            }
            redirect('samiti');
        }
    }

    // Show a form to edit a samiti
    public function edit($id) {
        if (!$this->hasUpdateAccess()) {
            $this->loadThis(); // Redirect to the unauthorized access page
        } else {
            $data['samiti'] = $this->Samiti_model->get_samiti($id);
            $data['blocks'] = $this->Samiti_model->get_blocks();
            $this->global['pageTitle'] = 'Datacollector : Edit Samiti';
            $this->loadViews("samiti/edit", $this->global, $data, NULL);
        }
    }

    // Update a samiti
    public function update($id) {
        if (!$this->hasUpdateAccess()) {
            $this->loadThis(); // Redirect to the unauthorized access page
        } else {
            $name = $this->input->post('name');
            $block_id = $this->input->post('block_id');
            $year = $this->input->post('year');
            $month = $this->input->post('month');
            
            $data = array(
                'name' => $name,
                'block_id' => !empty($block_id) ? $block_id : null,
                'year' => !empty($year) ? $year : null,
                'month' => !empty($month) ? $month : null
            );
            
            // Get old data before update for logging
            $oldData = $this->Samiti_model->get_samiti($id);
            
            $this->Samiti_model->update_samiti($id, $data);
            
            // Log activity with old and new data
            $this->logActivity('edit', 'samiti', $id, $data, $oldData, 'Samiti updated with ID: ' . $id . ' (Name: ' . $name . ')');
            
            redirect('samiti');
        }
    }

    // Delete a samiti
    public function delete($id) {
        if (!$this->hasDeleteAccess()) {
            $this->loadThis(); // Redirect to the unauthorized access page
        } else {
            // Get data before delete for logging
            $samitiData = $this->Samiti_model->get_samiti($id);
            
            $this->Samiti_model->delete_samiti($id);
            
            // Log activity
            $this->logActivity('delete', 'samiti', $id, $samitiData, null, 'Samiti deleted with ID: ' . $id . ' (Name: ' . (!empty($samitiData['name']) ? $samitiData['name'] : 'N/A') . ')');
            
            redirect('samiti');
        }
    }


}
?>
