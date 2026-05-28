<?php
require APPPATH . '/libraries/BaseController.php';

class DispatchRegister extends BaseController {

    public function __construct() {
        parent::__construct();
        $this->load->model('DispatchRegister_model');
        $this->load->helper('url');
        $this->load->model('Comman_model');
        $this->isLoggedIn();
        $this->load->library('form_validation');
        $this->module = 'Dispatch-Register';
    }

    /**
     * Display all dispatch register entries
     */
    public function index() {
        if (!$this->hasListAccess()) {
            $this->loadThis();
        } else {
            $data['dispatch_registers'] = $this->DispatchRegister_model->get_dispatch_registers();
            $this->global['pageTitle'] = 'Jan Umang : Dispatch Register';
            $this->loadViews("dispatchregister/index", $this->global, $data, NULL);
        }
    }

    /**
     * Show form to create new dispatch register entry
     */
    public function create() {
        if (!$this->hasCreateAccess()) {
            $this->loadThis();
        } else {
            $this->global['pageTitle'] = 'Jan Umang : Add Dispatch Register';
            $data['departments'] = $this->DispatchRegister_model->get_departments();
            $data['blocks'] = $this->DispatchRegister_model->get_blocks();
            $this->loadViews("dispatchregister/create", $this->global, $data, NULL);
        }
    }

    /**
     * Store new dispatch register entry
     */
    public function store() {
        if (!$this->hasCreateAccess()) {
            $this->loadThis();
        } else {
            $this->form_validation->set_rules('dispatch_no', 'Dispatch No', 'trim|required');
            
            if ($this->form_validation->run() == FALSE) {
                $this->create();
            } else {
                $date_input = $this->input->post('date');
                $date = !empty($date_input) ? date('Y-m-d', strtotime($date_input)) : NULL;

                // Handle file upload
                $upload_letter = '';
                if (!empty($_FILES['upload_letter']['name'])) {
                    $config['upload_path'] = './uploads/dispatch_letters/';
                    $config['allowed_types'] = 'pdf|jpg|jpeg|png|doc|docx';
                    $config['max_size'] = 5120; // 5MB
                    $config['encrypt_name'] = TRUE;
                    
                    // Create directory if not exists
                    if (!is_dir($config['upload_path'])) {
                        mkdir($config['upload_path'], 0777, TRUE);
                    }
                    
                    $this->load->library('upload', $config);
                    
                    if ($this->upload->do_upload('upload_letter')) {
                        $upload_data = $this->upload->data();
                        $upload_letter = 'uploads/dispatch_letters/' . $upload_data['file_name'];
                    } else {
                        $this->session->set_flashdata('error', $this->upload->display_errors());
                        redirect('dispatchregister/create');
                        return;
                    }
                }

                // Handle multiple village IDs
                $village_ids = $this->input->post('village_id');
                $village_id_str = NULL;
                if (!empty($village_ids) && is_array($village_ids)) {
                    $village_id_str = implode(',', $village_ids);
                }

                // Handle multiple panchayat IDs
                $panchayat_ids = $this->input->post('panchayat_id');
                $panchayat_id_str = NULL;
                if (!empty($panchayat_ids) && is_array($panchayat_ids)) {
                    $panchayat_id_str = implode(',', $panchayat_ids);
                }

                $data = array(
                    'date' => $date,
                    'year' => $this->input->post('year'),
                    'month' => $this->input->post('month'),
                    'portal_no' => $this->input->post('portal_no'),
                    'samiti_no' => $this->input->post('samiti_no'),
                    'dispatch_no' => $this->input->post('dispatch_no'),
                    'department_id' => $this->input->post('department_id') ? $this->input->post('department_id') : NULL,
                    'particular_subject' => $this->input->post('particular_subject'),
                    'reference' => $this->input->post('reference'),
                    'block_id' => $this->input->post('block_id') ? $this->input->post('block_id') : NULL,
                    'panchayat_id' => $panchayat_id_str,
                    'village_id' => $village_id_str,
                    'upload_letter' => $upload_letter,
                    'created_by' => $this->vendorId,
                    'created_at' => date('Y-m-d H:i:s')
                );

                $id = $this->DispatchRegister_model->create_dispatch_register($data);
                if ($id) {
                    $this->logActivity('add', 'dispatch_register', $id, $data, null, 'Dispatch Register entry created with ID: ' . $id . ' (Dispatch No: ' . $data['dispatch_no'] . ')');
                    $this->session->set_flashdata('success', 'Dispatch Register entry created successfully');
                } else {
                    $this->session->set_flashdata('error', 'Failed to create dispatch register entry');
                }
                redirect('dispatchregister');
            }
        }
    }

    /**
     * Show form to edit dispatch register entry
     */
    public function edit($id) {
        if (!$this->hasUpdateAccess()) {
            $this->loadThis();
        } else {
            $data['dispatch_register'] = $this->DispatchRegister_model->get_dispatch_register($id);
            
            if (empty($data['dispatch_register'])) {
                $this->session->set_flashdata('error', 'Dispatch Register entry not found');
                redirect('dispatchregister');
            }
            
            // Check block access permission
            if (!$this->hasBlockAccess($data['dispatch_register']->block_id)) {
                $this->session->set_flashdata('error', 'You do not have permission to edit this entry');
                redirect('dispatchregister');
            }
            
            $this->global['pageTitle'] = 'Jan Umang : Edit Dispatch Register';
            $data['departments'] = $this->DispatchRegister_model->get_departments();
            $data['blocks'] = $this->DispatchRegister_model->get_blocks();
            
            // Get panchayats if block is selected
            if (!empty($data['dispatch_register']->block_id)) {
                $data['panchayats'] = $this->DispatchRegister_model->get_panchayats_by_block($data['dispatch_register']->block_id);
            }
            
            // Get villages if panchayat is selected
            if (!empty($data['dispatch_register']->panchayat_id)) {
                $data['villages'] = $this->DispatchRegister_model->get_villages_by_panchayat($data['dispatch_register']->panchayat_id);
            }
            
            $this->loadViews("dispatchregister/edit", $this->global, $data, NULL);
        }
    }

    /**
     * Update dispatch register entry
     */
    public function update($id) {
        if (!$this->hasUpdateAccess()) {
            $this->loadThis();
        } else {
            $oldData = $this->DispatchRegister_model->get_dispatch_register($id);
            
            // Check block access permission
            if (!$this->hasBlockAccess($oldData->block_id)) {
                $this->session->set_flashdata('error', 'You do not have permission to update this entry');
                redirect('dispatchregister');
            }
            
            $this->form_validation->set_rules('dispatch_no', 'Dispatch No', 'trim|required');
            
            if ($this->form_validation->run() == FALSE) {
                $this->edit($id);
            } else {
                $date_input = $this->input->post('date');
                $date = !empty($date_input) ? date('Y-m-d', strtotime($date_input)) : NULL;
                
                // Handle file upload
                $upload_letter = $oldData->upload_letter; // Keep existing file
                if (!empty($_FILES['upload_letter']['name'])) {
                    $config['upload_path'] = './uploads/dispatch_letters/';
                    $config['allowed_types'] = 'pdf|jpg|jpeg|png|doc|docx';
                    $config['max_size'] = 5120; // 5MB
                    $config['encrypt_name'] = TRUE;
                    
                    // Create directory if not exists
                    if (!is_dir($config['upload_path'])) {
                        mkdir($config['upload_path'], 0777, TRUE);
                    }
                    
                    $this->load->library('upload', $config);
                    
                    if ($this->upload->do_upload('upload_letter')) {
                        // Delete old file if exists
                        if (!empty($oldData->upload_letter) && file_exists($oldData->upload_letter)) {
                            unlink($oldData->upload_letter);
                        }
                        
                        $upload_data = $this->upload->data();
                        $upload_letter = 'uploads/dispatch_letters/' . $upload_data['file_name'];
                    } else {
                        $this->session->set_flashdata('error', $this->upload->display_errors());
                        redirect('dispatchregister/edit/' . $id);
                        return;
                    }
                }

                // Handle multiple village IDs
                $village_ids = $this->input->post('village_id');
                $village_id_str = NULL;
                if (!empty($village_ids) && is_array($village_ids)) {
                    $village_id_str = implode(',', $village_ids);
                }

                // Handle multiple panchayat IDs
                $panchayat_ids = $this->input->post('panchayat_id');
                $panchayat_id_str = NULL;
                if (!empty($panchayat_ids) && is_array($panchayat_ids)) {
                    $panchayat_id_str = implode(',', $panchayat_ids);
                }

                $data = array(
                    'date' => $date,
                    'year' => $this->input->post('year'),
                    'month' => $this->input->post('month'),
                    'portal_no' => $this->input->post('portal_no'),
                    'samiti_no' => $this->input->post('samiti_no'),
                    'dispatch_no' => $this->input->post('dispatch_no'),
                    'department_id' => $this->input->post('department_id') ? $this->input->post('department_id') : NULL,
                    'particular_subject' => $this->input->post('particular_subject'),
                    'reference' => $this->input->post('reference'),
                    'block_id' => $this->input->post('block_id') ? $this->input->post('block_id') : NULL,
                    'panchayat_id' => $panchayat_id_str,
                    'village_id' => $village_id_str,
                    'upload_letter' => $upload_letter,
                    'updated_by' => $this->vendorId,
                    'updated_at' => date('Y-m-d H:i:s')
                );

                $result = $this->DispatchRegister_model->update_dispatch_register($id, $data);
                
                if ($result) {
                    $this->logActivity('edit', 'dispatch_register', $id, $data, (array)$oldData, 'Dispatch Register entry updated with ID: ' . $id . ' (Dispatch No: ' . $data['dispatch_no'] . ')');
                    $this->session->set_flashdata('success', 'Dispatch Register entry updated successfully');
                } else {
                    $this->session->set_flashdata('error', 'Failed to update dispatch register entry');
                }
                redirect('dispatchregister');
            }
        }
    }

    /**
     * View dispatch register entry details
     */
    public function view($id) {
        if (!$this->hasListAccess()) {
            $this->loadThis();
        } else {
            $dispatch_register = $this->DispatchRegister_model->get_dispatch_register($id);
            
            if (empty($dispatch_register)) {
                $this->session->set_flashdata('error', 'Dispatch Register entry not found');
                redirect('dispatchregister');
            }
            
            // Check block access permission
            if (!$this->hasBlockAccess($dispatch_register->block_id)) {
                $this->session->set_flashdata('error', 'You do not have permission to view this entry');
                redirect('dispatchregister');
            }
            
            // Convert to array for view
            $data['record'] = (array)$dispatch_register;
            $this->global['pageTitle'] = 'Jan Umang : View Dispatch Register';
            $this->loadViews("dispatchregister/view", $this->global, $data, NULL);
        }
    }

    /**
     * Delete dispatch register entry
     */
    public function delete($id) {
        if (!$this->hasDeleteAccess()) {
            $this->loadThis();
        } else {
            $dispatchData = $this->DispatchRegister_model->get_dispatch_register($id);
            
            if (empty($dispatchData)) {
                $this->session->set_flashdata('error', 'Dispatch Register entry not found');
                redirect('dispatchregister');
            }
            
            // Check block access permission
            if (!$this->hasBlockAccess($dispatchData->block_id)) {
                $this->session->set_flashdata('error', 'You do not have permission to delete this entry');
                redirect('dispatchregister');
            }
            
            $result = $this->DispatchRegister_model->delete_dispatch_register($id);
            
            if ($result) {
                $this->logActivity('delete', 'dispatch_register', $id, (array)$dispatchData, null, 'Dispatch Register entry deleted with ID: ' . $id . ' (Dispatch No: ' . (!empty($dispatchData->dispatch_no) ? $dispatchData->dispatch_no : 'N/A') . ')');
                $this->session->set_flashdata('success', 'Dispatch Register entry deleted successfully');
            } else {
                $this->session->set_flashdata('error', 'Failed to delete dispatch register entry');
            }
            
            redirect('dispatchregister');
        }
    }

    /**
     * AJAX: Get panchayats by block
     */
    public function get_panchayats_by_block() {
        $block_id = $this->input->post('block_id');
        if ($block_id) {
            $panchayats = $this->DispatchRegister_model->get_panchayats_by_block($block_id);
            echo json_encode(array('error' => false, 'panchayats' => $panchayats));
        } else {
            echo json_encode(array('error' => true, 'message' => 'Block ID required'));
        }
    }

    /**
     * AJAX: Get villages by panchayat
     */
    public function get_villages_by_panchayat() {
        $panchayat_id = $this->input->post('panchayat_id');
        if ($panchayat_id) {
            $villages = $this->DispatchRegister_model->get_villages_by_panchayat($panchayat_id);
            echo json_encode(array('error' => false, 'villages' => $villages));
        } else {
            echo json_encode(array('error' => true, 'message' => 'Panchayat ID required'));
        }
    }

    /**
     * AJAX: Get villages by block (NEW - for independent village loading)
     */
    public function get_villages_by_block() {
        header('Content-Type: application/json');
        $block_id = $this->input->post('block_id');
        
        if ($block_id) {
            try {
                $villages = $this->DispatchRegister_model->get_villages_by_block($block_id);
                echo json_encode(array('error' => false, 'villages' => $villages));
            } catch (Exception $e) {
                echo json_encode(array('error' => true, 'message' => 'Database error: ' . $e->getMessage()));
            }
        } else {
            echo json_encode(array('error' => true, 'message' => 'Block ID required'));
        }
        exit;
    }

    /**
     * Check if user has access to a specific block
     */
    private function hasBlockAccess($block_id) {
        $userBlockId = $this->session->userdata('blockId');
        
        // If blockId is 0 or empty, user has access to all blocks
        if ($userBlockId == 0 || empty($userBlockId)) {
            return true;
        }
        
        // Check if the block_id is in user's allowed blocks
        $blockid_array = explode(',', $userBlockId);
        return in_array($block_id, $blockid_array);
    }
}
