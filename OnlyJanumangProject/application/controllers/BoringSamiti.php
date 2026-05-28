<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class BoringSamiti extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('BoringSamiti_model');
        $this->load->helper('url');
        $this->load->model('user_model');
        $this->load->model('Comman_model');
        $this->isLoggedIn();
        $this->load->library('form_validation');  
        $this->load->model('Log_model');
        $this->module = 'Boring-Samiti';
    }

    /**
     * Generate next unique ID for Boring Samiti in BS/X format
     */
    private function generateUniqueId()
    {
        $this->db->select('unique_id');
        $this->db->from('boring_samiti_groups');
        $this->db->where('unique_id IS NOT NULL');
        $this->db->where('unique_id !=', '');
        $this->db->order_by('id', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $last_id = $query->row()->unique_id;
            if (preg_match('/BS\/(\d+)/', $last_id, $matches)) {
                $next_number = intval($matches[1]) + 1;
            } else {
                $next_number = 1;
            }
        } else {
            $next_number = 1;
        }

        return 'BS/' . $next_number;
    }

    // Display all location groups with member count
    public function index()
    {
        if (!$this->hasListAccess()) {
            $this->loadThis();
        } else {
            $data['groups'] = $this->BoringSamiti_model->get_all_groups();
            $this->global['pageTitle'] = 'Datacollector : Boring Samiti';
            $this->loadViews("boringsamiti/index", $this->global, $data, NULL);
        }
    }

    // Show form to create new location group
    public function create()
    {
        if (!$this->hasCreateAccess()) {
            $this->loadThis();
        } else {
            $this->global['pageTitle'] = 'Datacollector : Create Boring Samiti Location';
            $data['blocks'] = $this->BoringSamiti_model->get_blocks();
            $data['booths'] = array();
            $data['villages'] = array();
            $this->loadViews("boringsamiti/create", $this->global, $data, NULL);
        }
    }

    // Insert new location group
    public function store()
    {
        if (!$this->hasCreateAccess()) {
            $this->loadThis();
        } else {
            $this->form_validation->set_rules('year', 'Year', 'required|numeric');
            $this->form_validation->set_rules('ac_mp_no', 'AC/MP No', 'required');

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
                    redirect('boringsamiti/create');
                    return;
                }
            }

            if ($this->form_validation->run() == FALSE) {
                $data['blocks'] = $this->BoringSamiti_model->get_blocks();
                $this->global['pageTitle'] = 'Datacollector : Create Boring Samiti Location';
                $this->loadViews("boringsamiti/create", $this->global, $data, NULL);
                return;
            }

            $data = array(
                'unique_id' => $this->generateUniqueId(),
                'year' => $this->input->post('year'),
                'ac_mp_no' => $this->input->post('ac_mp_no'),
                'boring_samiti_name' => $this->input->post('boring_samiti_name'),
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

            $id = $this->BoringSamiti_model->create_group($data);
            if ($id) {
                $this->logActivity('add', 'boring_samiti_groups', $id, $data, null, 'Boring Samiti location created with ID: ' . $id);
            }
            redirect('boringsamiti');
        }
    }

    // Show form to edit location group
    public function edit($id)
    {
        if (!$this->hasUpdateAccess()) {
            $this->loadThis();
        } else {
            $data['record'] = $this->BoringSamiti_model->get_group_by_id($id);
            $data['row'] = $data['record'];
            $this->global['pageTitle'] = 'Datacollector : Edit Boring Samiti Location';
            $data['blocks'] = $this->BoringSamiti_model->get_blocks();
            $data['booths'] = array();
            $data['villages'] = array();
            
            if (!empty($data['record']['block'])) {
                $data['booths'] = $this->BoringSamiti_model->get_booths_by_block($data['record']['block']);
            }
            
            if (!empty($data['record']['booth_id'])) {
                $panchayat_data = $this->BoringSamiti_model->get_panchayat_by_booth($data['record']['booth_id']);
                if ($panchayat_data) {
                    $data['villages'] = $this->BoringSamiti_model->get_villages_by_panchayat($panchayat_data->id);
                }
            }
            
            $this->loadViews("boringsamiti/edit", $this->global, $data, NULL);
        }
    }

    // Update location group
    public function update($id)
    {
        if (!$this->hasUpdateAccess()) {
            $this->loadThis();
        } else {
            $this->form_validation->set_rules('year', 'Year', 'required|numeric');
            $this->form_validation->set_rules('ac_mp_no', 'AC/MP No', 'required');

            $oldData = $this->BoringSamiti_model->get_group_by_id($id);
            
            $file_name = $oldData['file_upload']; 
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
                    
                    if (!empty($oldData['file_upload']) && file_exists('./uploads/samiti_files/' . $oldData['file_upload'])) {
                        unlink('./uploads/samiti_files/' . $oldData['file_upload']);
                    }
                } else {
                    $this->session->set_flashdata('error', $this->upload->display_errors());
                    redirect('boringsamiti');
                    return;
                }
            }
            
            if ($this->form_validation->run() == FALSE) {
                $this->edit($id);
                return;
            }

            $data = array(
                'year' => $this->input->post('year'),
                'ac_mp_no' => $this->input->post('ac_mp_no'),
                'boring_samiti_name' => $this->input->post('boring_samiti_name'),
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

            $this->BoringSamiti_model->update_group($id, $data);
            $this->logActivity('edit', 'boring_samiti_groups', $id, $data, $oldData, 'Boring Samiti location updated with ID: ' . $id);
            redirect('boringsamiti');
        }
    }

    // Delete location group
    public function delete($id)
    {
        if (!$this->hasDeleteAccess()) {
            $this->loadThis();
        } else {
            $groupData = $this->BoringSamiti_model->get_group_by_id($id);
            $this->BoringSamiti_model->delete_group($id);
            $this->logActivity('delete', 'boring_samiti_groups', $id, $groupData, null, 'Boring Samiti location deleted with ID: ' . $id);
            redirect('boringsamiti');
        }
    }

    // View members list for a specific group/location
    public function members($group_id)
    {
        if (!$this->hasListAccess()) {
            $this->loadThis();
        } else {
            $data['group'] = $this->BoringSamiti_model->get_group_by_id($group_id);
            $data['members'] = $this->BoringSamiti_model->get_members_by_group($group_id);
            $this->global['pageTitle'] = 'Datacollector : Boring Samiti Members';
            $this->loadViews("boringsamiti/members", $this->global, $data, NULL);
        }
    }

    // Show form to add member to a group
    public function add_member($group_id)
    {
        if (!$this->hasCreateAccess()) {
            $this->loadThis();
        } else {
            $data['group'] = $this->BoringSamiti_model->get_group_by_id($group_id);
            $this->global['pageTitle'] = 'Datacollector : Add Boring Samiti Member';
            $this->loadViews("boringsamiti/add_member", $this->global, $data, NULL);
        }
    }

    // Store new member
    public function store_member()
    {
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

            $id = $this->BoringSamiti_model->create_member($data);
            if ($id) {
                $this->logActivity('add', 'boring_samiti', $id, $data, null, 'Boring Samiti member added with ID: ' . $id);
            }
            redirect('boringsamiti/members/' . $group_id);
        }
    }

    // Edit member
    public function edit_member($id)
    {
        if (!$this->hasUpdateAccess()) {
            $this->loadThis();
        } else {
            $data['member'] = $this->BoringSamiti_model->get_member_by_id($id);
            $data['group'] = $this->BoringSamiti_model->get_group_by_id($data['member']['group_id']);
            $this->global['pageTitle'] = 'Datacollector : Edit Boring Samiti Member';
            $this->loadViews("boringsamiti/edit_member", $this->global, $data, NULL);
        }
    }

    // Update member
    public function update_member($id)
    {
        if (!$this->hasUpdateAccess()) {
            $this->loadThis();
        } else {
            $member = $this->BoringSamiti_model->get_member_by_id($id);
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

            $oldData = $this->BoringSamiti_model->get_member_by_id($id);
            $this->BoringSamiti_model->update_member($id, $data);
            $this->logActivity('edit', 'boring_samiti', $id, $data, $oldData, 'Boring Samiti member updated with ID: ' . $id);
            redirect('boringsamiti/members/' . $group_id);
        }
    }

    // Delete member
    public function delete_member($id)
    {
        if (!$this->hasDeleteAccess()) {
            $this->loadThis();
        } else {
            $member = $this->BoringSamiti_model->get_member_by_id($id);
            $group_id = $member['group_id'];
            $this->BoringSamiti_model->delete_member($id);
            $this->logActivity('delete', 'boring_samiti', $id, $member, null, 'Boring Samiti member deleted with ID: ' . $id);
            redirect('boringsamiti/members/' . $group_id);
        }
    }

    // AJAX: Get booths by block
    public function get_booths_by_block()
    {
        $block_id = $this->input->post('block_id');
        if ($block_id) {
            $booths = $this->BoringSamiti_model->get_booths_by_block($block_id);
            echo json_encode(array('error' => false, 'booths' => $booths));
        } else {
            echo json_encode(array('error' => true, 'message' => 'Block ID required'));
        }
    }

    // AJAX: Get booth details
    public function get_booth_details()
    {
        $booth_id = $this->input->post('booth_id');
        if ($booth_id) {
            $booth = $this->BoringSamiti_model->get_booth_details($booth_id);
            if ($booth) {
                $panchayat = $this->BoringSamiti_model->get_panchayat_by_booth($booth_id);
                $villages = array();
                if ($panchayat && isset($panchayat->id)) {
                    $villages = $this->BoringSamiti_model->get_villages_by_panchayat($panchayat->id);
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

    // AJAX: return next generated unique id for BS/X
    public function next_unique_id()
    {
        if (!$this->hasCreateAccess()) {
            echo json_encode(array('error' => true, 'message' => 'Access denied'));
            return;
        }

        $next = $this->generateUniqueId();
        echo json_encode(array('error' => false, 'next' => $next));
    }
}