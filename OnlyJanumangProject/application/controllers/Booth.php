<?php
require APPPATH . '/libraries/BaseController.php';
class Booth extends BaseController {

    public function __construct() {
        parent::__construct();
        $this->load->model('booth_model');
        $this->load->helper('url');
        $this->load->model('user_model');
        $this->load->model('Comman_model');
        $this->load->model('Block_model');
        $this->load->model('Log_model');
        $this->isLoggedIn();
        $this->load->library('form_validation');
        $this->module = 'Booth';
    }

    // Display all booths
    public function index() {
        if(!$this->hasListAccess()) {
            $this->loadThis();
        } else {
            $filter_block = $this->input->get('filter_block');
            $filter_year = $this->input->get('filter_year');
            
            // Get all blocks for filter dropdown
            $data['blocks'] = $this->Block_model->get_blocks();
            
            // Get filtered booths
            if ($filter_block || $filter_year) {
                $data['booths'] = $this->booth_model->getBoothsByBlock($filter_block, $filter_year);
            } else {
                $data['booths'] = $this->booth_model->get_booths();
            }
            
            // Get unique years from booth table
            $data['years'] = $this->booth_model->get_unique_years();
            
            // Pass filter values to view
            $data['filter_block'] = $filter_block;
            $data['filter_year'] = $filter_year;
            
            $this->global['pageTitle'] = 'Datacollector :booth';
            $this->loadViews("booth/index", $this->global, $data, NULL);
        }
    }

    // Show a form to create a new booth
    public function create() {
        if(!$this->hasCreateAccess()) {
            $this->loadThis();
        } else {
            $this->global['pageTitle'] = 'Datacollector :booth';
            $data['blocks'] = $this->Block_model->get_blocks();
            $this->loadViews("booth/create", $this->global, $data, NULL);
        }
    }

    // Insert a new booth
    public function store() {
        if(!$this->hasCreateAccess()) {
            $this->loadThis();
        } else {
            $name = $this->input->post('name');
            $blockid = $this->input->post('blockid');
            $bnumber = $this->input->post('bnumber');
            $year = $this->input->post('year');
            $data = array(
                'name' => $name,
                'bnumber' => $bnumber,
                'blockid' => $blockid,
                'year' => $year
            );
            $id = $this->booth_model->create_booth($data);
            if ($id) {
                $this->logActivity('add', 'booth', $id, $data, null, 'Booth created with ID: ' . $id . ' (Name: ' . $name . ')');
            }

            redirect('booth');
        }
    }

    // Show a form to edit a booth
    public function edit($id) {
        if(!$this->hasUpdateAccess()) {
            $this->loadThis();
        } else {
            $data['booth'] = $this->booth_model->get_booth($id);
            $data['blocks'] = $this->Block_model->get_blocks();
            $this->global['pageTitle'] = 'Datacollector :booth';
            $this->loadViews("booth/edit", $this->global, $data, NULL);
        }
    }

    // Update a booth
    public function update($id) {
        if(!$this->hasUpdateAccess()) {
            $this->loadThis();
        } else {
            $name = $this->input->post('name');
            $blockid = $this->input->post('blockid');
            $bnumber = $this->input->post('bnumber');
            $year = $this->input->post('year');
            $data = array(
                'name' => $name,
                'bnumber' => $bnumber,
                'blockid' => $blockid,
                'year' => $year
            );
            // Get old data before update for logging
            $oldData = $this->booth_model->get_booth($id);
            
            $this->booth_model->update_booth($id, $data);
            
            // Log activity with old and new data
            $this->logActivity('edit', 'booth', $id, $data, $oldData, 'Booth updated with ID: ' . $id . ' (Name: ' . $name . ')');

            redirect('booth');
        }
    }

    // Delete a booth
    public function delete($id) {
        if(!$this->hasDeleteAccess()) {
            $this->loadThis();
        } else {
            // Get data before delete for logging
            $boothData = $this->booth_model->get_booth($id);
            
            $this->booth_model->delete_booth($id);
            
            // Log activity
            $this->logActivity('delete', 'booth', $id, $boothData, null, 'Booth deleted with ID: ' . $id . ' (Name: ' . (!empty($boothData['name']) ? $boothData['name'] : 'N/A') . ')');

            redirect('booth');
        }
    }
}
?>
