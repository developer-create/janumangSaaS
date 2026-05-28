<?php
require APPPATH . '/libraries/BaseController.php';

class NirmanSamiti extends BaseController {

    public function __construct() {
        parent::__construct();
        $this->load->model('NirmanSamiti_model');
        $this->load->helper('url');
        $this->load->model('user_model');
        $this->load->model('Comman_model');
        $this->isLoggedIn();
        $this->load->library('form_validation');  
        $this->load->model('Log_model');
        $this->module = 'Nirman-Samiti';
    }

    // Display all location groups with member count
    public function index() {
        if (!$this->hasListAccess()) {
            $this->loadThis();
        } else {
            $searchText = $this->input->get_post('searchText');
            $filter_block = $this->input->get_post('filter_block');
            $filter_year = $this->input->get_post('filter_year');
            $filter_month = $this->input->get_post('filter_month');
            $filter_date = $this->input->get_post('filter_date');
            
            $filters = array();
            if ($filter_block !== null && $filter_block !== '') {
                $filters['block'] = $filter_block;
            }
            if ($filter_year !== null && $filter_year !== '') {
                $filters['year'] = $filter_year;
            }
            if ($filter_month !== null && $filter_month !== '') {
                $filters['month'] = $filter_month;
            }
            if ($filter_date !== null && $filter_date !== '') {
                $filters['date'] = $filter_date;
            }
            
            $data['searchText'] = $searchText;
            $data['filter_block'] = $filter_block;
            $data['filter_year'] = $filter_year;
            $data['filter_month'] = $filter_month;
            $data['filter_date'] = $filter_date;
            $data['groups'] = $this->NirmanSamiti_model->get_groups($searchText, $filters);
            $data['blocks'] = $this->NirmanSamiti_model->get_blocks_with_data();
            $data['years'] = $this->NirmanSamiti_model->get_years();
            $data['months'] = $this->NirmanSamiti_model->get_months();
            $data['days'] = $this->NirmanSamiti_model->get_days();
            $data['total_members'] = $this->NirmanSamiti_model->get_total_members_count($filters);
            
            $this->global['pageTitle'] = 'Datacollector : Nirman Samiti';
            $this->loadViews("nirmansamiti/index", $this->global, $data, NULL);
        }
    }

    // Show form to create new location group
    public function create() {
        if (!$this->hasCreateAccess()) {
            $this->loadThis();
        } else {
            $this->global['pageTitle'] = 'Datacollector : Create Nirman Samiti Location';
            $data['blocks'] = $this->NirmanSamiti_model->get_blocks();
            // Initialize dependent lists to avoid undefined variable errors in views
            $data['booths'] = array();
            $data['villages'] = array();
            $this->loadViews("nirmansamiti/create", $this->global, $data, NULL);
        }
    }

    // Insert new location group
    public function store() {
        if (!$this->hasCreateAccess()) {
            $this->loadThis();
        } else {
            // Set validation rules
            $this->form_validation->set_rules('year', 'Year', 'required|numeric');
            $this->form_validation->set_rules('ac_mp_no', 'AC/MP No', 'required');
            
            // Generate unique ID
            $unique_id = $this->generateUniqueId();
            
            // Handle file upload
            $file_name = null;
            if (!empty($_FILES['file_upload']['name'])) {
                $config['upload_path'] = './uploads/samiti_files/';
                $config['allowed_types'] = 'pdf|doc|docx|jpg|jpeg|png';
                $config['max_size'] = 5120; // 5MB
                $config['encrypt_name'] = TRUE;
                
                if (!is_dir($config['upload_path'])) {
                    mkdir($config['upload_path'], 0777, TRUE);
                }
                
                $this->load->library('upload', $config);
                
                if ($this->upload->do_upload('file_upload')) {
                    $upload_data = $this->upload->data();
                    $file_name = $upload_data['file_name'];
                } else {
                    $this->session->set_flashdata('error', $this->upload->display_errors());
                    redirect('nirmansamiti/create');
                    return;
                }
            }

            $data = array(
                'unique_id' => $unique_id,
                'year' => $this->input->post('year'),
                'ac_mp_no' => $this->input->post('ac_mp_no'),
                'block' => $this->input->post('block'),
                'sector' => $this->input->post('sector'),
                'micro_sector_no' => $this->input->post('micro_sector_no'),
                'micro_sector_name' => $this->input->post('micro_sector_name'),
                'booth_name' => $this->input->post('booth_name'),
                'booth_no' => $this->input->post('booth_no'),
                'gram_panchayat' => $this->input->post('gram_panchayat'),
                'village' => $this->input->post('village'),
                'faliya' => $this->input->post('faliya'),
                'file_upload' => $file_name,
                'created_by' => $this->vendorId,
            );

            $id = $this->NirmanSamiti_model->create_group($data);
            if ($id) {
                $this->logActivity('add', 'nirman_samiti_groups', $id, $data, null, 'Nirman Samiti location created with ID: ' . $id);
            }
            redirect('nirmansamiti');
        }
    }

    // Show form to edit location group
    public function edit($id) {
        if (!$this->hasUpdateAccess()) {
            $this->loadThis();
        } else {
            $data['record'] = $this->NirmanSamiti_model->get_group_by_id($id);
            $this->global['pageTitle'] = 'Datacollector : Edit Nirman Samiti Location';
            $data['blocks'] = $this->NirmanSamiti_model->get_blocks();
            // Initialize dependent lists so views can iterate safely
            $data['booths'] = array();
            $data['villages'] = array();
            
            // Get booths if block is selected
            if (!empty($data['record']['block'])) {
                $data['booths'] = $this->NirmanSamiti_model->get_booths_by_block($data['record']['block']);
            }
            
            // Get panchayat and villages if booth is selected
            if (!empty($data['record']['booth_id'])) {
                $panchayat_data = $this->NirmanSamiti_model->get_panchayat_by_booth($data['record']['booth_id']);
                if ($panchayat_data) {
                    $data['villages'] = $this->NirmanSamiti_model->get_villages_by_panchayat($panchayat_data->id);
                }
            }
            
            $this->loadViews("nirmansamiti/edit", $this->global, $data, NULL);
        }
    }

    // Update location group
    public function update($id) {
        if (!$this->hasUpdateAccess()) {
            $this->loadThis();
        } else {
            // Set validation rules
            $this->form_validation->set_rules('year', 'Year', 'required|numeric');
            $this->form_validation->set_rules('ac_mp_no', 'AC/MP No', 'required');
            
            $oldData = $this->NirmanSamiti_model->get_group_by_id($id);
            
            // Handle file upload
            $file_name = $oldData['file_upload']; // Keep existing file by default
            if (!empty($_FILES['file_upload']['name'])) {
                $config['upload_path'] = './uploads/samiti_files/';
                $config['allowed_types'] = 'pdf|doc|docx|jpg|jpeg|png';
                $config['max_size'] = 5120; // 5MB
                $config['encrypt_name'] = TRUE;
                
                if (!is_dir($config['upload_path'])) {
                    mkdir($config['upload_path'], 0777, TRUE);
                }
                
                $this->load->library('upload', $config);
                
                if ($this->upload->do_upload('file_upload')) {
                    $upload_data = $this->upload->data();
                    $file_name = $upload_data['file_name'];
                    
                    // Delete old file if exists
                    if (!empty($oldData['file_upload']) && file_exists('./uploads/samiti_files/' . $oldData['file_upload'])) {
                        unlink('./uploads/samiti_files/' . $oldData['file_upload']);
                    }
                } else {
                    $this->session->set_flashdata('error', $this->upload->display_errors());
                    redirect('nirmansamiti');
                    return;
                }
            }
            
            $data = array(
                'year' => $this->input->post('year'),
                'ac_mp_no' => $this->input->post('ac_mp_no'),
                'block' => $this->input->post('block'),
                'sector' => $this->input->post('sector'),
                'micro_sector_no' => $this->input->post('micro_sector_no'),
                'micro_sector_name' => $this->input->post('micro_sector_name'),
                'booth_name' => $this->input->post('booth_name'),
                'booth_no' => $this->input->post('booth_no'),
                'gram_panchayat' => $this->input->post('gram_panchayat'),
                'village' => $this->input->post('village'),
                'faliya' => $this->input->post('faliya'),
                'file_upload' => $file_name,
                'updated_by' => $this->vendorId,
            );

            $this->NirmanSamiti_model->update_group($id, $data);
            $this->logActivity('edit', 'nirman_samiti_groups', $id, $data, $oldData, 'Nirman Samiti location updated with ID: ' . $id);
            redirect('nirmansamiti');
        }
    }

    // Delete location group
    public function delete($id) {
        if (!$this->hasDeleteAccess()) {
            $this->loadThis();
        } else {
            $groupData = $this->NirmanSamiti_model->get_group_by_id($id);
            $this->NirmanSamiti_model->delete_group($id);
            $this->logActivity('delete', 'nirman_samiti_groups', $id, $groupData, null, 'Nirman Samiti location deleted with ID: ' . $id);
            redirect('nirmansamiti');
        }
    }

    // View members list for a specific group/location
    public function members($group_id) {
        if (!$this->hasListAccess()) {
            $this->loadThis();
        } else {
            $data['group'] = $this->NirmanSamiti_model->get_group_by_id($group_id);
            $data['members'] = $this->NirmanSamiti_model->get_members_by_group($group_id);
            $this->global['pageTitle'] = 'Datacollector : Nirman Samiti Members';
            $this->loadViews("nirmansamiti/members", $this->global, $data, NULL);
        }
    }

    // Show form to add member to a group
    public function add_member($group_id) {
        if (!$this->hasCreateAccess()) {
            $this->loadThis();
        } else {
            $data['group'] = $this->NirmanSamiti_model->get_group_by_id($group_id);
            $this->global['pageTitle'] = 'Datacollector : Add Nirman Samiti Member';
            $this->loadViews("nirmansamiti/add_member", $this->global, $data, NULL);
        }
    }

    // Store new member
    public function store_member() {
        if (!$this->hasCreateAccess()) {
            $this->loadThis();
        } else {
            $group_id = $this->input->post('group_id');
            $data = array(
                'group_id' => $group_id,
                'member_name' => $this->input->post('member_name'),
                'father_name' => $this->input->post('father_name'),
                'age' => $this->input->post('age'),
                'position' => $this->input->post('position'),
                'mobile_number' => $this->input->post('mobile_number'),
                'remark' => $this->input->post('remark'),
                'created_by' => $this->vendorId,
            );

            $id = $this->NirmanSamiti_model->create_member($data);
            if ($id) {
                $this->logActivity('add', 'nirman_samiti', $id, $data, null, 'Nirman Samiti member added with ID: ' . $id);
            }
            redirect('nirmansamiti/members/' . $group_id);
        }
    }

    // Edit member
    public function edit_member($id) {
        if (!$this->hasUpdateAccess()) {
            $this->loadThis();
        } else {
            $data['member'] = $this->NirmanSamiti_model->get_member_by_id($id);
            $data['group'] = $this->NirmanSamiti_model->get_group_by_id($data['member']['group_id']);
            $this->global['pageTitle'] = 'Datacollector : Edit Nirman Samiti Member';
            $this->loadViews("nirmansamiti/edit_member", $this->global, $data, NULL);
        }
    }

    // Update member
    public function update_member($id) {
        if (!$this->hasUpdateAccess()) {
            $this->loadThis();
        } else {
            $member = $this->NirmanSamiti_model->get_member_by_id($id);
            $group_id = $member['group_id'];
            
            $data = array(
                'member_name' => $this->input->post('member_name'),
                'father_name' => $this->input->post('father_name'),
                'age' => $this->input->post('age'),
                'position' => $this->input->post('position'),
                'mobile_number' => $this->input->post('mobile_number'),
                'remark' => $this->input->post('remark'),
                'updated_by' => $this->vendorId,
            );

            $oldData = $this->NirmanSamiti_model->get_member_by_id($id);
            $this->NirmanSamiti_model->update_member($id, $data);
            $this->logActivity('edit', 'nirman_samiti', $id, $data, $oldData, 'Nirman Samiti member updated with ID: ' . $id);
            redirect('nirmansamiti/members/' . $group_id);
        }
    }

    // Delete member
    public function delete_member($id) {
        if (!$this->hasDeleteAccess()) {
            $this->loadThis();
        } else {
            $member = $this->NirmanSamiti_model->get_member_by_id($id);
            $group_id = $member['group_id'];
            $this->NirmanSamiti_model->delete_member($id);
            $this->logActivity('delete', 'nirman_samiti', $id, $member, null, 'Nirman Samiti member deleted with ID: ' . $id);
            redirect('nirmansamiti/members/' . $group_id);
        }
    }

    // AJAX: Get booths by block
    public function get_booths_by_block() {
        $block_id = $this->input->post('block_id');
        if ($block_id) {
            $booths = $this->NirmanSamiti_model->get_booths_by_block($block_id);
            echo json_encode(array('error' => false, 'booths' => $booths));
        } else {
            echo json_encode(array('error' => true, 'message' => 'Block ID required'));
        }
    }

    // AJAX: Get booth details (booth no, panchayat, village)
    public function get_booth_details() {
        $booth_id = $this->input->post('booth_id');
        if ($booth_id) {
            $booth = $this->NirmanSamiti_model->get_booth_details($booth_id);
            if ($booth) {
                // Get panchayat by booth ID (panchayat table has boothid column)
                $panchayat = $this->NirmanSamiti_model->get_panchayat_by_booth($booth_id);
                
                // Get villages by panchayat ID if panchayat found
                $villages = array();
                if ($panchayat && isset($panchayat->id)) {
                    $villages = $this->NirmanSamiti_model->get_villages_by_panchayat($panchayat->id);
                }
                
                echo json_encode(array(
                    'error' => false,
                    'booth_no' => $booth->bnumber,
                    'panchayat_id' => $panchayat ? $panchayat->id : '',
                    'panchayat_name' => $panchayat ? $panchayat->name : '',
                    'villages' => $villages
                ));
            } else {
                echo json_encode(array('error' => true, 'message' => 'Booth not found'));
            }
        } else {
            echo json_encode(array('error' => true, 'message' => 'Booth ID required'));
        }
    }
    
    private function generateUniqueId() {
        // Get the latest unique_id from database
        $last_record = $this->db->select('unique_id')
                               ->from('nirman_samiti_groups')
                               ->where('unique_id IS NOT NULL')
                               ->order_by('id', 'DESC')
                               ->limit(1)
                               ->get()
                               ->row();
        
        if ($last_record && $last_record->unique_id) {
            // Extract number from NS/X format
            $parts = explode('/', $last_record->unique_id);
            if (count($parts) == 2 && $parts[0] == 'NS') {
                $next_number = intval($parts[1]) + 1;
            } else {
                $next_number = 1;
            }
        } else {
            $next_number = 1;
        }
        
        return 'NS/' . $next_number;
    }
}
