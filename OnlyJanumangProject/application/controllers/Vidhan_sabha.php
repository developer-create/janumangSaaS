<?php
require APPPATH . '/libraries/BaseController.php';

class Vidhan_sabha extends BaseController {

    public function __construct() {
        parent::__construct();
        $this->load->model('vidhan_sabha_model');
        $this->load->helper('url');
        $this->load->model('user_model');
        $this->load->model('Comman_model');
        $this->isLoggedIn();
        $this->load->model('Log_model');
        $this->load->library('form_validation');
        $this->module = 'Vidhan-Sabha'; // Fixed: Changed from space to hyphen to match config
    }

    // Display all vidhan sabha records
    public function index() {
        if(!$this->hasListAccess()) {
            $this->loadThis();
        } else {
            $data['vidhan_sabhas'] = $this->vidhan_sabha_model->get_vidhan_sabhas();
            $this->global['pageTitle'] = 'Datacollector : Vidhan Sabha';
            $this->loadViews("vidhan_sabha/index", $this->global, $data, NULL);
        }
    }

    // Show a form to create a new vidhan sabha
    public function create() {
        if(!$this->hasCreateAccess()) {
            $this->loadThis();
        } else {
            $this->load->model('District_model');
            $data['districts'] = $this->District_model->get_districts();
            $this->global['pageTitle'] = 'Datacollector : Add Vidhan Sabha';
            $this->loadViews("vidhan_sabha/create", $this->global, $data, NULL);
        }
    }

    // Insert a new vidhan sabha
    public function store() {
        if(!$this->hasCreateAccess()) {
            $this->loadThis();
        } else {
            $this->form_validation->set_rules('vidhan_sabha_name', 'Vidhan Sabha Name', 'required|trim');

            if ($this->form_validation->run() == FALSE) {
                $this->create();
            } else {
                $vidhan_sabha_name = $this->input->post('vidhan_sabha_name');

                $district_id = $this->input->post('district_id');
                $data = array(
                    'vidhan_sabha_name' => $vidhan_sabha_name,
                    'district_id' => !empty($district_id) ? (int)$district_id : null,
                    'created_by' => $this->session->userdata('userId'),
                    'added_by' => $this->session->userdata('userId')
                );

                $insert_id = $this->vidhan_sabha_model->create_vidhan_sabha($data);
                if ($insert_id) {
                    // Log activity
                    $this->logActivity('add', 'vidhan_sabha', $insert_id, $data, null, 'Vidhan Sabha created with ID: ' . $insert_id . ' (Name: ' . $data['vidhan_sabha_name'] . ')');
                    $this->session->set_flashdata('success', 'Vidhan Sabha created successfully.');
                } else {
                    $this->session->set_flashdata('error', 'Failed to create Vidhan Sabha.');
                }

                redirect('vidhan_sabha');
            }
        }
    }

    // Show a form to edit a vidhan sabha
    public function edit($id) {
        if(!$this->hasUpdateAccess()) {
            $this->loadThis();
        } else {
            $data['vidhan_sabha'] = $this->vidhan_sabha_model->get_vidhan_sabha($id);
            if (empty($data['vidhan_sabha'])) {
                $this->session->set_flashdata('error', 'Vidhan Sabha not found.');
                redirect('vidhan_sabha');
            }
            $this->load->model('District_model');
            $data['districts'] = $this->District_model->get_districts();
            $this->global['pageTitle'] = 'Datacollector : Edit Vidhan Sabha';
            $this->loadViews("vidhan_sabha/edit", $this->global, $data, NULL);
        }
    }

    // Update a vidhan sabha
    public function update($id) {
        if(!$this->hasUpdateAccess()) {
            $this->loadThis();
        } else {
            $this->form_validation->set_rules('vidhan_sabha_name', 'Vidhan Sabha Name', 'required|trim');

            if ($this->form_validation->run() == FALSE) {
                $this->edit($id);
            } else {
                $vidhan_sabha_name = $this->input->post('vidhan_sabha_name');

                $district_id = $this->input->post('district_id');
                $data = array(
                    'vidhan_sabha_name' => $vidhan_sabha_name,
                    'district_id' => !empty($district_id) ? (int)$district_id : null,
                    'updated_time' => date('Y-m-d H:i:s')
                );

                // Get old data before update for logging
                $oldData = $this->vidhan_sabha_model->get_vidhan_sabha($id);
                
                $result = $this->vidhan_sabha_model->update_vidhan_sabha($id, $data);
                if ($result) {
                    // Log activity with old and new data
                    $this->logActivity('edit', 'vidhan_sabha', $id, $data, (array)$oldData, 'Vidhan Sabha updated with ID: ' . $id . ' (Name: ' . $data['vidhan_sabha_name'] . ')');
                    $this->session->set_flashdata('success', 'Vidhan Sabha updated successfully.');
                } else {
                    $this->session->set_flashdata('error', 'Failed to update Vidhan Sabha.');
                }

                redirect('vidhan_sabha');
            }
        }
    }

    // Delete a vidhan sabha
    public function delete($id) {
        if(!$this->hasDeleteAccess()) {
            $this->loadThis();
        } else {
            $vidhan_sabha = $this->vidhan_sabha_model->get_vidhan_sabha($id);
            if (empty($vidhan_sabha)) {
                $this->session->set_flashdata('error', 'Vidhan Sabha not found.');
            } else {
                $result = $this->vidhan_sabha_model->delete_vidhan_sabha($id);
                if ($result) {
                    // Log activity
                    $this->logActivity('delete', 'vidhan_sabha', $id, (array)$vidhan_sabha, null, 'Vidhan Sabha deleted with ID: ' . $id . ' (Name: ' . (!empty($vidhan_sabha->vidhan_sabha_name) ? $vidhan_sabha->vidhan_sabha_name : 'N/A') . ')');
                    $this->session->set_flashdata('success', 'Vidhan Sabha deleted successfully.');
                } else {
                    $this->session->set_flashdata('error', 'Failed to delete Vidhan Sabha.');
                }
            }
            redirect('vidhan_sabha');
        }
    }
}
?>
