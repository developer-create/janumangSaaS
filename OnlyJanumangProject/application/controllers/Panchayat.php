<?php
require APPPATH . '/libraries/BaseController.php';

class Panchayat extends BaseController {

    public function __construct() {
        parent::__construct();
        $this->load->model('panchayat_model');
        $this->load->model('booth_model');
        $this->load->model('Block_model');
        $this->load->model('user_model');
        $this->load->model('Comman_model');
        $this->load->model('Log_model');
        $this->load->helper('url');
        $this->load->library('form_validation');
        
        $this->isLoggedIn(); // Ensures user is logged in
        $this->module = 'Panchayat'; // Module name for access control
    }

    // Get booths by block ID (AJAX)
    public function getBoothsByBlock() {
        $blockId = $this->input->post('blockid');
        $year = $this->input->post('year');
        $booths = $this->booth_model->getBoothsByBlock($blockId, $year);
        
        // Set proper JSON header
        header('Content-Type: application/json');
        echo json_encode($booths);
    }

    // Get panchayat by booth ID (AJAX)
    public function getpanchayatidByBooth() {
        $boothId = $this->input->post('boothid');
        $panchayat = $this->booth_model->getpanchayatidByBooth($boothId);
        
        // Set proper JSON header
        header('Content-Type: application/json');
        echo json_encode($panchayat);
    }

    // Get village by panchayat ID (AJAX)
    public function getvillageBypanchayat() {
        $panchayatId = $this->input->post('panchayatid');
        $villages = $this->booth_model->getvillageBypanchayat($panchayatId);
        
        // Set proper JSON header
        header('Content-Type: application/json');
        echo json_encode($villages);
    }

    // Display all panchayats
    public function index() {
        if(!$this->hasListAccess()) {
            $this->loadThis(); // Load the restricted page
        } else {
            // Get filter values from GET request
            $block_id = $this->input->get('block_id');
            $year = $this->input->get('year');
            
            // Get filtered panchayats
            $data['panchayats'] = $this->panchayat_model->get_panchayats_filtered($block_id, $year);
            
            // Get blocks for filter dropdown
            $data['blocks'] = $this->Block_model->get_blocks();
            
            // Get years for filter dropdown
            $data['years'] = $this->panchayat_model->get_years();
            
            // Store current filter values for view
            $data['selected_block'] = $block_id;
            $data['selected_year'] = $year;
            
            $this->global['pageTitle'] = 'Datacollector : Panchayat';
            $this->loadViews("panchayat/index", $this->global, $data, NULL);
        }
    }

    // Show form to create a new panchayat
    public function create() {
        if(!$this->hasCreateAccess()) {
            $this->loadThis(); // Restrict access if not authorized
        } else {
            $this->global['pageTitle'] = 'Datacollector : Create Panchayat';
            $data['blocks'] = $this->Block_model->get_blocks();
            $this->loadViews("panchayat/create", $this->global, $data, NULL);
        }
    }

    // Insert a new panchayat
    public function store() {
        if(!$this->hasCreateAccess()) {
            $this->loadThis(); // Restrict access if not authorized
        } else {
            $name = $this->input->post('name');
            $blockid = $this->input->post('blockid');
            $boothid = $this->input->post('boothid');
            $data = array(
                'name' => $name,
                'boothid' => $boothid,
                'blockid' => $blockid
            );
            $id = $this->panchayat_model->create_panchayat($data);
            if ($id) {
                $this->logActivity('add', 'panchayat', $id, $data, null, 'Panchayat created with ID: ' . $id . ' (Name: ' . $name . ')');
            }

            redirect('panchayat');
        }
    }

    // Show form to edit a panchayat
    public function edit($id) {
        if(!$this->hasUpdateAccess()) {
            $this->loadThis(); // Restrict access if not authorized
        } else {
            $data['panchayat'] = $this->panchayat_model->get_panchayat($id);
            $data['blocks'] = $this->Block_model->get_blocks();
            $this->global['pageTitle'] = 'Datacollector : Edit Panchayat';
            $this->loadViews("panchayat/edit", $this->global, $data, NULL);
        }
    }

    // Update a panchayat
    public function update($id) {
        if(!$this->hasUpdateAccess()) {
            $this->loadThis(); // Restrict access if not authorized
        } else {
            $name = $this->input->post('name');
            $blockid = $this->input->post('blockid');
            $boothid = $this->input->post('boothid');
            $data = array(
                'name' => $name,
                'boothid' => $boothid,
                'blockid' => $blockid
            );
            // Get old data before update for logging
            $oldData = $this->panchayat_model->get_panchayat($id);
            
            $this->panchayat_model->update_panchayat($id, $data);
            
            // Log activity with old and new data
            $this->logActivity('edit', 'panchayat', $id, $data, $oldData, 'Panchayat updated with ID: ' . $id . ' (Name: ' . $name . ')');

            redirect('panchayat');
        }
    }

    // Delete a panchayat
    public function delete($id) {
        if(!$this->hasDeleteAccess()) {
            $this->loadThis(); // Restrict access if not authorized
        } else {
            // Get data before delete for logging
            $panchayatData = $this->panchayat_model->get_panchayat($id);
            
            $this->panchayat_model->delete_panchayat($id);
            
            // Log activity
            $this->logActivity('delete', 'panchayat', $id, $panchayatData, null, 'Panchayat deleted with ID: ' . $id . ' (Name: ' . (!empty($panchayatData['name']) ? $panchayatData['name'] : 'N/A') . ')');

            redirect('panchayat');
        }
    }
}
?>
