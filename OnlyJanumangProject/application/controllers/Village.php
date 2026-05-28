<?php
require APPPATH . '/libraries/BaseController.php';
class Village extends BaseController {

    public function __construct() {
        parent::__construct();
        $this->load->model('village_model');
        $this->load->helper('url');
        $this->load->model('user_model');
        $this->load->model('booth_model');
        $this->load->model('Comman_model');
        $this->load->model('Block_model');
        $this->isLoggedIn();
        $this->load->library('form_validation');
        $this->load->model('Log_model');
        $this->module ='Village';
    }
    
    public function getBoothsByBlock() {
    $blockId = $this->input->post('blockid');
    $booths = $this->booth_model->getBoothsByBlock($blockId);
    echo json_encode($booths);
}



    // Display all villages
    public function index() {
        if(!$this->hasListAccess())
        {
            $this->loadThis();
        }
        else
        {  
        $data['villages'] = $this->village_model->get_villages();
        $this->global['pageTitle'] = 'Datacollector :village';
        $this->loadViews("village/index", $this->global, $data, NULL);
        }
    }

    // Show a form to create a new village
    public function create() {
        if(!$this->hasCreateAccess())
        {
            $this->loadThis();
        }
        else
        { 
        $this->global['pageTitle'] = 'Datacollector :village';
        $data['blocks'] = $this->Block_model->get_blocks();
        $this->global['pageTitle'] = 'Datacollector :village';
        $this->loadViews("village/create", $this->global, $data,  NULL);
        }
    }

    // Insert a new village
    public function store() {
         if(!$this->hasCreateAccess())
        {
            $this->loadThis();
        }
        else
        { 
        $name = $this->input->post('name');
        $blockid = $this->input->post('blockid');
        $boothid = $this->input->post('boothid');
        $panchayatid = $this->input->post('panchayatid');
        $data = array(
            'name' => $name,
            'boothid' => $boothid,
            'blockid' => $blockid,
            'panchayatid' => $panchayatid,
            );
            
     $insert_id=   $this->village_model->create_village($data);
        if ($insert_id) {
            $this->logActivity('add', 'village', $insert_id, $data, null, 'Village created with ID: ' . $insert_id . ' (Name: ' . $name . ')');
        }

        redirect('village');
        }
    }

    // Show a form to edit a village
    public function edit($id) {
         if(!$this->hasUpdateAccess())
        {
            $this->loadThis();
        }
        else
        { 
        $data['village'] = $this->village_model->get_village($id);
        $data['blocks'] = $this->Block_model->get_blocks();
        $this->global['pageTitle'] = 'Datacollector :village';
        $this->loadViews("village/edit", $this->global, $data, NULL);
        }
    }

    // Update a village
    public function update($id) {
         if(!$this->hasUpdateAccess())
        {
            $this->loadThis();
        }
        else
        { 
       $name = $this->input->post('name');
        $blockid = $this->input->post('blockid');
        $boothid = $this->input->post('boothid');
        $panchayatid = $this->input->post('panchayatid');
      $data = array(
            'name' => $name,
            'boothid' => $boothid,
            'blockid' => $blockid,
            'panchayatid' => $panchayatid,
            );
            
        // Get old data before update for logging
        $oldData = $this->village_model->get_village($id);
        
        $this->village_model->update_village($id, $data);
        
        // Log activity with old and new data
        $this->logActivity('edit', 'village', $id, $data, $oldData, 'Village updated with ID: ' . $id . ' (Name: ' . $name . ')');

        redirect('village');
    }
}

    // Delete a village
    public function delete($id) {
         if(!$this->hasDeleteAccess())
        {
            $this->loadThis();
        }
        else
        { 
        // Get data before delete for logging
        $villageData = $this->village_model->get_village($id);
        
        $this->village_model->delete_village($id);
        
        // Log activity
        $this->logActivity('delete', 'village', $id, $villageData, null, 'Village deleted with ID: ' . $id . ' (Name: ' . (!empty($villageData['name']) ? $villageData['name'] : 'N/A') . ')');

        redirect('village');
        }
    }
}
?>
