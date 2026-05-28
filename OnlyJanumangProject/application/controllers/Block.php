<?php
require APPPATH . '/libraries/BaseController.php';
class Block extends BaseController {

    public function __construct() {
        parent::__construct();
        $this->load->model('block_model');
        $this->load->helper('url');
        $this->load->model('user_model');
        $this->load->model('Comman_model');
        $this->isLoggedIn();
        $this->load->model('Log_model');
        $this->load->library('form_validation');
        $this->module = 'Block';
    }

    // Display all blocks
    public function index() {
        if(!$this->hasListAccess()) {
            $this->loadThis();
        } else {
            $data['blocks'] = $this->block_model->get_blocks();
            $this->global['pageTitle'] = 'Datacollector :block';
            $this->loadViews("block/index", $this->global, $data, NULL);
        }
    }

    // Show a form to create a new block
    public function create() {
        if(!$this->hasCreateAccess()) {
            $this->loadThis();
        } else {
            $data['districts'] = $this->block_model->get_districts();
            $this->global['pageTitle'] = 'Datacollector :block';
            $this->loadViews("block/create", $this->global, $data, NULL);
        }
    }

    // Insert a new block
    public function store() {
        if(!$this->hasCreateAccess()) {
            $this->loadThis();
        } else {
            $name = $this->input->post('name');
            $district_id = $this->input->post('district_id');
            $data = array(
                'name' => $name,
                'district_id' => $district_id
            );

            $insert_id = $this->block_model->create_block($data);
            if ($insert_id) {
                $this->logActivity('add', 'block', $insert_id, $data, null, 'Block created with ID: ' . $insert_id . ' (Name: ' . $name . ')');
            }

            redirect('block');
        }
    }

    // Show a form to edit a block
    public function edit($id) {
        if(!$this->hasUpdateAccess()) {
            $this->loadThis();
        } else {
            $data['block'] = $this->block_model->get_block($id);
            $data['districts'] = $this->block_model->get_districts();
            $this->global['pageTitle'] = 'Datacollector :block';
            $this->loadViews("block/edit", $this->global, $data, NULL);
        }
    }

    // Update a block
    public function update($id) {
        if(!$this->hasUpdateAccess()) {
            $this->loadThis();
        } else {
            $name = $this->input->post('name');
            $district_id = $this->input->post('district_id');
            $data = array(
                'name' => $name,
                'district_id' => $district_id
            );

            // Get old data before update for logging
            $oldData = $this->block_model->get_block($id);
            
            $this->block_model->update_block($id, $data);
            
            // Log activity with old and new data
            $this->logActivity('edit', 'block', $id, $data, $oldData, 'Block updated with ID: ' . $id . ' (Name: ' . $name . ')');

            redirect('block');
        }
    }

    // Delete a block
    public function delete($id) {
        if(!$this->hasDeleteAccess()) {
            $this->loadThis();
        } else {
            // Get data before delete for logging
            $blockData = $this->block_model->get_block($id);
            
            $this->block_model->delete_block($id);
            
            // Log activity
            $this->logActivity('delete', 'block', $id, $blockData, null, 'Block deleted with ID: ' . $id . ' (Name: ' . (!empty($blockData['name']) ? $blockData['name'] : 'N/A') . ')');

            redirect('block');
        }
    }
}
?>
