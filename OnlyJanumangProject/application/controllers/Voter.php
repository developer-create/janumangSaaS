<?php
require APPPATH . '/libraries/BaseController.php';

class Voter extends BaseController {

    public function __construct() {
        parent::__construct();
        $this->load->model('Voter_model');
        $this->load->helper('url');
        $this->load->model('user_model');
        $this->load->model('Comman_model');
        $this->isLoggedIn();
        $this->load->library('form_validation');
        $this->module = 'Voter';
    }

    // Display all voters
    public function index() {
        if (!$this->hasListAccess()) {
            $this->loadThis(); // Redirect to the unauthorized access page
        } else {
            $data['voters'] = $this->Voter_model->get_voters();
            $this->global['pageTitle'] = 'Datacollector : Voter Management';
            $this->loadViews("voter/index", $this->global, $data, NULL);
        }
    }

    // Show a form to create a new voter
    public function create() {
        if (!$this->hasCreateAccess()) {
            $this->loadThis(); // Redirect to the unauthorized access page
        } else {
            $this->global['pageTitle'] = 'Datacollector : Create Voter';
            $query = $this->db->get('block');
            $data['blocks'] = $query->result();
            
            // Get cast options
            $data['cast_options'] = $this->Voter_model->get_cast_options();
            $data['sub_cast_options'] = $this->Voter_model->get_sub_cast_options();
            
            $this->loadViews("voter/create", $this->global, $data, NULL);
        }
    }

    // Insert a new voter
    public function store() {
        if (!$this->hasCreateAccess()) {
            $this->loadThis(); // Redirect to the unauthorized access page
        } else {
            // Validate required fields
            $this->form_validation->set_rules('name', 'Name', 'required');
            $this->form_validation->set_rules('father_name', 'Father Name', 'required');
            $this->form_validation->set_rules('mobile_no', 'Mobile No', 'required|regex_match[/^\d{10}$/]');
            $this->form_validation->set_rules('age', 'Age', 'required|numeric');
            $this->form_validation->set_rules('full_address', 'Full Address', 'required');
            $this->form_validation->set_rules('block_id', 'Block Name', 'required|numeric');
            $this->form_validation->set_rules('booth_id', 'Booth Name', 'required|numeric');
            $this->form_validation->set_rules('booth_no', 'Booth No', 'required');
            $this->form_validation->set_rules('panchayat_id', 'Panchayat', 'required|numeric');
            $this->form_validation->set_rules('village_id', 'Village', 'required|numeric');
            $this->form_validation->set_rules('voter_id_epic', 'Voter ID (Epic) No', 'required');

            if ($this->form_validation->run() == FALSE) {
                $this->create();
                return;
            }

            // Handle file upload
            $imagePath = '';
            if (!empty($_FILES['voter_image']['name'])) {
                $config['upload_path'] = './uploads/voters/';
                $config['allowed_types'] = 'gif|jpg|jpeg|png';
                $config['max_size'] = 2048; // 2MB
                $config['encrypt_name'] = TRUE;

                $this->load->library('upload', $config);

                if (!$this->upload->do_upload('voter_image')) {
                    $this->session->set_flashdata('error', $this->upload->display_errors());
                    redirect('voter/create');
                    return;
                } else {
                    $fileData = $this->upload->data();
                    $imagePath = $fileData['file_name'];
                }
            }

            $data = array(
                'name' => $this->input->post('name'),
                'father_name' => $this->input->post('father_name'),
                'mobile_no' => $this->input->post('mobile_no'),
                'age' => $this->input->post('age'),
                'full_address' => $this->input->post('full_address'),
                'block_id' => $this->input->post('block_id'),
                'booth_id' => $this->input->post('booth_id'),
                'booth_no' => $this->input->post('booth_no'),
                'panchayat_id' => $this->input->post('panchayat_id'),
                'village_id' => $this->input->post('village_id'),
                'falia_majra' => $this->input->post('falia_majra'),
                'cast' => $this->input->post('cast'),
                'sub_cast' => $this->input->post('sub_cast'),
                'voter_id_epic' => $this->input->post('voter_id_epic'),
                'voter_image' => $imagePath,
                'created_by' => $this->vendorId,
                'created_on' => date('Y-m-d H:i:s')
            );

            $id = $this->Voter_model->create_voter($data);
            if ($id) {
                // Log activity
                $this->logActivity('add', 'voter', $id, $data, null, 'Voter record created with ID: ' . $id);
                $this->session->set_flashdata('success', 'Voter created successfully');
            } else {
                $this->session->set_flashdata('error', 'Failed to create voter');
            }
            redirect('voter');
        }
    }

    // Show a form to edit a voter
    public function edit($id) {
        if (!$this->hasUpdateAccess()) {
            $this->loadThis(); // Redirect to the unauthorized access page
        } else {
            $data['voter'] = $this->Voter_model->get_voter($id);
            if (empty($data['voter'])) {
                $this->session->set_flashdata('error', 'Voter not found');
                redirect('voter');
                return;
            }
            $this->global['pageTitle'] = 'Datacollector : Edit Voter';
            $query = $this->db->get('block');
            $data['blocks'] = $query->result();
            
            // Get cast options
            $data['cast_options'] = $this->Voter_model->get_cast_options();
            $data['sub_cast_options'] = $this->Voter_model->get_sub_cast_options();
            
            // Load related data for dropdowns
            if (!empty($data['voter']['block_id'])) {
                $data['booths'] = $this->Comman_model->get_data_where('booth', ['blockid' => $data['voter']['block_id']]);
            }
            if (!empty($data['voter']['booth_id'])) {
                $data['panchayats'] = $this->Comman_model->get_data_where('panchayat', ['boothid' => $data['voter']['booth_id']]);
            }
            if (!empty($data['voter']['panchayat_id'])) {
                $data['villages'] = $this->Comman_model->get_data_where('village', ['panchayatid' => $data['voter']['panchayat_id']]);
            }
            
            $this->loadViews("voter/edit", $this->global, $data, NULL);
        }
    }

    // Update a voter
    public function update($id) {
        if (!$this->hasUpdateAccess()) {
            $this->loadThis(); // Redirect to the unauthorized access page
        } else {
            // Validate required fields
            $this->form_validation->set_rules('name', 'Name', 'required');
            $this->form_validation->set_rules('father_name', 'Father Name', 'required');
            $this->form_validation->set_rules('mobile_no', 'Mobile No', 'required|regex_match[/^\d{10}$/]');
            $this->form_validation->set_rules('age', 'Age', 'required|numeric');
            $this->form_validation->set_rules('full_address', 'Full Address', 'required');
            $this->form_validation->set_rules('block_id', 'Block Name', 'required|numeric');
            $this->form_validation->set_rules('booth_id', 'Booth Name', 'required|numeric');
            $this->form_validation->set_rules('booth_no', 'Booth No', 'required');
            $this->form_validation->set_rules('panchayat_id', 'Panchayat', 'required|numeric');
            $this->form_validation->set_rules('village_id', 'Village', 'required|numeric');
            $this->form_validation->set_rules('voter_id_epic', 'Voter ID (Epic) No', 'required');

            if ($this->form_validation->run() == FALSE) {
                $this->edit($id);
                return;
            }

            $data = array(
                'name' => $this->input->post('name'),
                'father_name' => $this->input->post('father_name'),
                'mobile_no' => $this->input->post('mobile_no'),
                'age' => $this->input->post('age'),
                'full_address' => $this->input->post('full_address'),
                'block_id' => $this->input->post('block_id'),
                'booth_id' => $this->input->post('booth_id'),
                'booth_no' => $this->input->post('booth_no'),
                'panchayat_id' => $this->input->post('panchayat_id'),
                'village_id' => $this->input->post('village_id'),
                'falia_majra' => $this->input->post('falia_majra'),
                'cast' => $this->input->post('cast'),
                'sub_cast' => $this->input->post('sub_cast'),
                'voter_id_epic' => $this->input->post('voter_id_epic'),
                'updated_by' => $this->vendorId,
                'updated_on' => date('Y-m-d H:i:s')
            );

            // Handle file upload if new image is provided
            if (!empty($_FILES['voter_image']['name'])) {
                $config['upload_path'] = './uploads/voters/';
                $config['allowed_types'] = 'gif|jpg|jpeg|png';
                $config['max_size'] = 2048; // 2MB
                $config['encrypt_name'] = TRUE;

                $this->load->library('upload', $config);

                if (!$this->upload->do_upload('voter_image')) {
                    $this->session->set_flashdata('error', $this->upload->display_errors());
                    redirect('voter/edit/' . $id);
                    return;
                } else {
                    // Delete old image if exists
                    $oldVoter = $this->Voter_model->get_voter($id);
                    if (!empty($oldVoter['voter_image'])) {
                        $oldImagePath = './uploads/voters/' . $oldVoter['voter_image'];
                        if (file_exists($oldImagePath)) {
                            unlink($oldImagePath);
                        }
                    }
                    $fileData = $this->upload->data();
                    $data['voter_image'] = $fileData['file_name'];
                }
            }

            // Get old data before update for logging
            $oldData = $this->Voter_model->get_voter($id);
            
            $result = $this->Voter_model->update_voter($id, $data);
            if ($result) {
                // Log activity with old and new data
                $this->logActivity('edit', 'voter', $id, $data, $oldData, 'Voter record updated with ID: ' . $id);
                $this->session->set_flashdata('success', 'Voter updated successfully');
            } else {
                $this->session->set_flashdata('error', 'Failed to update voter');
            }
            redirect('voter');
        }
    }

    // Delete a voter
    public function delete($id) {
        if (!$this->hasDeleteAccess()) {
            $this->loadThis(); // Redirect to the unauthorized access page
        } else {
            // Delete image if exists
            $voter = $this->Voter_model->get_voter($id);
            if (!empty($voter['voter_image'])) {
                $imagePath = './uploads/voters/' . $voter['voter_image'];
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }
            
            // Get data before delete for logging
            $voterData = $this->Voter_model->get_voter($id);
            
            $this->Voter_model->delete_voter($id);
            
            // Log activity
            $this->logActivity('delete', 'voter', $id, $voterData, null, 'Voter record deleted with ID: ' . $id . ' (Name: ' . (!empty($voterData['name']) ? $voterData['name'] : 'N/A') . ')');
            
            $this->session->set_flashdata('success', 'Voter deleted successfully');
            redirect('voter');
        }
    }
    
    // View a single voter (read-only)
    public function view($id) {
        // Reuse list access check (adjust if a dedicated view permission exists)
        if (!$this->hasListAccess()) {
            $this->loadThis();
            return;
        }
        $voter = $this->Voter_model->get_voter($id);
        if (empty($voter)) {
            $this->session->set_flashdata('error', 'Voter not found');
            redirect('voter');
            return;
        }
        // Load joined/display names similar to index (optional lightweight fetch for names)
        $this->db->select('voter.*, block.name as block_name, booth.name as booth_name, booth.bnumber as booth_number, panchayat.name as panchayat_name, village.name as village_name');
        $this->db->from('voter');
        $this->db->join('block', 'block.id = voter.block_id', 'left');
        $this->db->join('booth', 'booth.id = voter.booth_id', 'left');
        $this->db->join('panchayat', 'panchayat.id = voter.panchayat_id', 'left');
        $this->db->join('village', 'village.id = voter.village_id', 'left');
        $this->db->where('voter.id', $id);
        $detailQuery = $this->db->get();
        $detail = $detailQuery->row_array();
        if (!empty($detail)) {
            $voter = $detail; // use enriched data
        }
        $data['voter'] = $voter;
        $this->global['pageTitle'] = 'Datacollector : View Voter';
        $this->loadViews('voter/view', $this->global, $data, NULL);
    }
    
    // AJAX method to get sub-cast options based on selected cast
    public function get_sub_cast_options() {
        $cast_id = $this->input->post('cast_id');
        $sub_cast_options = $this->Voter_model->get_sub_cast_options($cast_id);
        
        echo json_encode($sub_cast_options);
    }
}

