<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

#[AllowDynamicProperties]
class MandirSamiti extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('MandirSamiti_model');
        $this->load->library('form_validation');
        $this->isLoggedIn();
        $this->module = 'Mandir-Samiti';
    }

    /**
     * This function used to load the list of groups (locations)
     */
    public function index()
    {
        if(!$this->hasListAccess()) { $this->loadThis(); return; }

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
        $data['groups'] = $this->MandirSamiti_model->get_groups($searchText, $filters);
        $data['blocks'] = $this->MandirSamiti_model->get_blocks_with_data();
        $data['years'] = $this->MandirSamiti_model->get_years();
        $data['months'] = $this->MandirSamiti_model->get_months();
        $data['days'] = $this->MandirSamiti_model->get_days();
        $data['total_members'] = $this->MandirSamiti_model->get_total_members_count($filters);
        
        $this->global['pageTitle'] = 'Mandir Samiti : Groups';
        $this->loadViews("mandirsamiti/index", $this->global, $data, NULL);
    }

    /**
     * This function is used to load the add new group form
     */
    public function create()
    {
        if(!$this->hasCreateAccess()) { $this->loadThis(); return; }
        
        $this->global['pageTitle'] = 'Mandir Samiti : Add New Location';
        
        $data['blocks'] = $this->MandirSamiti_model->getBlocks();
        
        $this->loadViews("mandirsamiti/create", $this->global, $data, NULL);
    }

    /**
     * This function is used to add new group to the system
     */
    public function store()
    {
        if(!$this->hasCreateAccess()) { $this->loadThis(); return; }
        
        $this->form_validation->set_rules('block', 'Block', 'trim|required|numeric');
        $this->form_validation->set_rules('year', 'Year', 'trim|required|numeric');
        $this->form_validation->set_rules('ac_mp_no', 'AC/MP No', 'trim|required');
        
        // Generate unique ID
        $unique_id = $this->generateUniqueId();
        
        if($this->form_validation->run() == FALSE)
        {
            $this->create();
        }
        else
        {
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
                    redirect('mandirsamiti/create');
                    return;
                }
            }

            $groupInfo = array(
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
                'created_at' => date('Y-m-d H:i:s')
            );
            
            $result = $this->MandirSamiti_model->addGroup($groupInfo);
            
            if($result > 0)
            {
                $this->logActivity('add', 'mandir_samiti_groups', $result, $groupInfo, null, 'Mandir Samiti location created with ID: ' . $result);
                $this->session->set_flashdata('success', 'Mandir Samiti location created successfully');
            }
            else
            {
                $this->session->set_flashdata('error', 'Location creation failed');
            }
            
            redirect('mandirsamiti');
        }
    }

    /**
     * This function is used to load the edit group form
     */
    public function edit($groupId = NULL)
    {
        if(!$this->hasUpdateAccess()) { $this->loadThis(); return; }
        
        if($groupId == null)
        {
            redirect('mandirsamiti');
        }
        
        $data['groupInfo'] = $this->MandirSamiti_model->getGroupInfo($groupId);
        
        if(empty($data['groupInfo']))
        {
            $this->session->set_flashdata('error', 'Location not found');
            redirect('mandirsamiti');
        }
        
        $data['blocks'] = $this->MandirSamiti_model->getBlocks();
        $data['booths'] = array();
        $data['villages'] = array();
        
        // Get booths if block is selected
        if (!empty($data['groupInfo']->block)) {
            $data['booths'] = $this->MandirSamiti_model->getBoothsByBlock($data['groupInfo']->block);
        }
        
        // Get panchayat and villages if booth is selected
        if (!empty($data['groupInfo']->booth_id)) {
            $panchayat_data = $this->MandirSamiti_model->getPanchayatByBooth($data['groupInfo']->booth_id);
            if ($panchayat_data) {
                $data['villages'] = $this->MandirSamiti_model->getVillagesByPanchayat($panchayat_data->id);
            }
        }
        
        $this->global['pageTitle'] = 'Mandir Samiti : Edit Location';
        
        $this->loadViews("mandirsamiti/edit", $this->global, $data, NULL);
    }

    /**
     * This function is used to update group information
     */
    public function update()
    {
        if(!$this->hasUpdateAccess()) { $this->loadThis(); return; }
        
        $groupId = $this->input->post('groupId');
        
        $this->form_validation->set_rules('block', 'Block', 'trim|required|numeric');
        $this->form_validation->set_rules('year', 'Year', 'trim|required|numeric');
        $this->form_validation->set_rules('ac_mp_no', 'AC/MP No', 'trim|required');
        
        if($this->form_validation->run() == FALSE)
        {
            $this->edit($groupId);
        }
        else
        {
            $oldData = $this->MandirSamiti_model->getGroupInfo($groupId);
            
            // Handle file upload
            $file_name = $oldData->file_upload; // Keep existing file by default
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
                    if (!empty($oldData->file_upload) && file_exists('./uploads/samiti_files/' . $oldData->file_upload)) {
                        unlink('./uploads/samiti_files/' . $oldData->file_upload);
                    }
                } else {
                    $this->session->set_flashdata('error', $this->upload->display_errors());
                    redirect('mandirsamiti/edit/' . $groupId);
                    return;
                }
            }
            
            $groupInfo = array(
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
                'updated_at' => date('Y-m-d H:i:s')
            );
            
            $result = $this->MandirSamiti_model->editGroup($groupInfo, $groupId);
            
            if($result == true)
            {
                $this->logActivity('edit', 'mandir_samiti_groups', $groupId, $groupInfo, (array)$oldData, 'Mandir Samiti location updated with ID: ' . $groupId);
                $this->session->set_flashdata('success', 'Location updated successfully');
            }
            else
            {
                $this->session->set_flashdata('error', 'Location update failed');
            }
            
            redirect('mandirsamiti');
        }
    }

    /**
     * This function is used to delete a group
     */
    public function delete($groupId = NULL)
    {
        if(!$this->hasDeleteAccess()) { $this->loadThis(); return; }
        
        if($groupId == null)
        {
            redirect('mandirsamiti');
        }
        
        $existingRecord = $this->MandirSamiti_model->getGroupInfo($groupId);
        
        $result = $this->MandirSamiti_model->deleteGroup($groupId);
        
        if ($result > 0) {
            if ($existingRecord) {
                $this->logActivity('delete', 'mandir_samiti_groups', $groupId, (array)$existingRecord, null, 'Mandir Samiti location deleted with ID: ' . $groupId);
            }
            $this->session->set_flashdata('success', 'Location deleted successfully');
        } else {
            $this->session->set_flashdata('error', 'Location deletion failed');
        }
        
        redirect('mandirsamiti');
    }

    /**
     * This function is used to view group details
     */
    public function view($groupId = NULL)
    {
        if(!$this->hasListAccess()) { $this->loadThis(); return; }
        
        if($groupId == null)
        {
            redirect('mandirsamiti');
        }
        
        $data['groupInfo'] = $this->MandirSamiti_model->getGroupInfo($groupId);
        
        if(empty($data['groupInfo']))
        {
            $this->session->set_flashdata('error', 'Location not found');
            redirect('mandirsamiti');
        }
        
        $this->global['pageTitle'] = 'Mandir Samiti : View Location';
        
        $this->loadViews("mandirsamiti/view", $this->global, $data, NULL);
    }

    /**
     * This function is used to load the members list for a group
     */
    public function members($groupId = NULL)
    {
        if(!$this->hasListAccess()) { $this->loadThis(); return; }
        
        if($groupId == null)
        {
            redirect('mandirsamiti');
        }
        
        $data['groupInfo'] = $this->MandirSamiti_model->getGroupInfo($groupId);
        
        if(empty($data['groupInfo']))
        {
            $this->session->set_flashdata('error', 'Location not found');
            redirect('mandirsamiti');
        }
        
        $this->global['pageTitle'] = 'Mandir Samiti : Members';
        
        $data['members'] = $this->MandirSamiti_model->getMembers($groupId);
        
        $this->loadViews("mandirsamiti/members", $this->global, $data, NULL);
    }

    /**
     * This function is used to load the add new member form
     */
    public function addMember($groupId = NULL)
    {
        if(!$this->hasCreateAccess()) { $this->loadThis(); return; }
        
        if($groupId == null)
        {
            redirect('mandirsamiti');
        }
        
        $data['groupInfo'] = $this->MandirSamiti_model->getGroupInfo($groupId);
        
        if(empty($data['groupInfo']))
        {
            $this->session->set_flashdata('error', 'Location not found');
            redirect('mandirsamiti');
        }
        
        $this->global['pageTitle'] = 'Mandir Samiti : Add Member';
        
        $this->loadViews("mandirsamiti/add_member", $this->global, $data, NULL);
    }

    /**
     * This function is used to add new member to a group
     */
    public function storeMember()
    {
        if(!$this->hasCreateAccess()) { $this->loadThis(); return; }
        
        $groupId = $this->input->post('group_id');
        
        $this->form_validation->set_rules('member_name', 'Member Name', 'trim|required|max_length[200]');
        $this->form_validation->set_rules('mobile_number', 'Mobile Number', 'trim|regex_match[/^\d{10}$/]');
        
        if($this->form_validation->run() == FALSE)
        {
            $this->addMember($groupId);
        }
        else
        {
            $memberInfo = array(
                'group_id' => $groupId,
                'member_name' => $this->input->post('member_name'),
                'father_name' => $this->input->post('father_name'),
                'age' => $this->input->post('age'),
                'position' => $this->input->post('position'),
                'mobile_number' => $this->input->post('mobile_number'),
                'remark' => $this->input->post('remark'),
                'created_by' => $this->vendorId,
                'created_at' => date('Y-m-d H:i:s')
            );
            
            $result = $this->MandirSamiti_model->addMember($memberInfo);
            
            if($result > 0)
            {
                $this->logActivity('add', 'mandir_samiti', $result, $memberInfo, null, 'Mandir Samiti member added with ID: ' . $result);
                $this->session->set_flashdata('success', 'Member added successfully');
            }
            else
            {
                $this->session->set_flashdata('error', 'Member addition failed');
            }
            
            redirect('mandirsamiti/members/'.$groupId);
        }
    }

    /**
     * This function is used to load the edit member form
     */
    public function editMember($memberId = NULL)
    {
        if(!$this->hasUpdateAccess()) { $this->loadThis(); return; }
        
        if($memberId == null)
        {
            redirect('mandirsamiti');
        }
        
        $data['memberInfo'] = $this->MandirSamiti_model->getMemberInfo($memberId);
        
        if(empty($data['memberInfo']))
        {
            $this->session->set_flashdata('error', 'Member not found');
            redirect('mandirsamiti');
        }
        
        $data['groupInfo'] = $this->MandirSamiti_model->getGroupInfo($data['memberInfo']->group_id);
        
        $this->global['pageTitle'] = 'Mandir Samiti : Edit Member';
        
        $this->loadViews("mandirsamiti/edit_member", $this->global, $data, NULL);
    }

    /**
     * This function is used to update member information
     */
    public function updateMember()
    {
        if(!$this->hasUpdateAccess()) { $this->loadThis(); return; }
        
        $memberId = $this->input->post('memberId');
        $groupId = $this->input->post('group_id');
        
        $this->form_validation->set_rules('member_name', 'Member Name', 'trim|required|max_length[200]');
        $this->form_validation->set_rules('mobile_number', 'Mobile Number', 'trim|regex_match[/^\d{10}$/]');
        
        if($this->form_validation->run() == FALSE)
        {
            $this->editMember($memberId);
        }
        else
        {
            $oldData = $this->MandirSamiti_model->getMemberInfo($memberId);
            
            $memberInfo = array(
                'member_name' => $this->input->post('member_name'),
                'father_name' => $this->input->post('father_name'),
                'age' => $this->input->post('age'),
                'position' => $this->input->post('position'),
                'mobile_number' => $this->input->post('mobile_number'),
                'remark' => $this->input->post('remark'),
                'updated_by' => $this->vendorId,
                'updated_at' => date('Y-m-d H:i:s')
            );
            
            $result = $this->MandirSamiti_model->editMember($memberInfo, $memberId);
            
            if($result == true)
            {
                $this->logActivity('edit', 'mandir_samiti', $memberId, $memberInfo, (array)$oldData, 'Mandir Samiti member updated with ID: ' . $memberId);
                $this->session->set_flashdata('success', 'Member updated successfully');
            }
            else
            {
                $this->session->set_flashdata('error', 'Member update failed');
            }
            
            redirect('mandirsamiti/members/'.$groupId);
        }
    }

    /**
     * This function is used to delete a member
     */
    public function deleteMember($memberId = NULL, $groupId = NULL)
    {
        if(!$this->hasDeleteAccess()) { $this->loadThis(); return; }
        
        if($memberId == null || $groupId == null)
        {
            redirect('mandirsamiti');
        }
        
        $existingRecord = $this->MandirSamiti_model->getMemberInfo($memberId);
        
        $result = $this->MandirSamiti_model->deleteMember($memberId);
        
        if ($result > 0) {
            if ($existingRecord) {
                $this->logActivity('delete', 'mandir_samiti', $memberId, (array)$existingRecord, null, 'Mandir Samiti member deleted with ID: ' . $memberId);
            }
            $this->session->set_flashdata('success', 'Member deleted successfully');
        } else {
            $this->session->set_flashdata('error', 'Member deletion failed');
        }
        
        redirect('mandirsamiti/members/'.$groupId);
    }
    
    /**
     * Get booths by block - AJAX
     */
    public function get_booths_by_block()
    {
        $block_id = $this->input->post('block_id');
        
        if(!$block_id) {
            echo json_encode(array('error' => true, 'message' => 'Block ID is required'));
            return;
        }
        
        $booths = $this->MandirSamiti_model->getBoothsByBlock($block_id);
        
        echo json_encode(array('error' => false, 'booths' => $booths));
    }
    
    /**
     * Get booth details - AJAX
     */
    public function get_booth_details()
    {
        $booth_id = $this->input->post('booth_id');
        
        if(!$booth_id) {
            echo json_encode(array('error' => true, 'message' => 'Booth ID is required'));
            return;
        }
        
        $booth = $this->MandirSamiti_model->getBoothDetails($booth_id);
        
        if($booth) {
            // Get panchayat by booth ID
            $panchayat = $this->MandirSamiti_model->getPanchayatByBooth($booth_id);
            
            // Get villages by panchayat ID if panchayat found
            $villages = array();
            if ($panchayat && isset($panchayat->id)) {
                $villages = $this->MandirSamiti_model->getVillagesByPanchayat($panchayat->id);
            }
            
            echo json_encode(array(
                'error' => false,
                'booth_no' => $booth->bnumber,
                'panchayat_id' => $panchayat ? $panchayat->id : '',
                'panchayat_name' => $panchayat ? $panchayat->name : '',
                'villages' => $villages
            ));
        } else {
            echo json_encode(array('error' => true, 'message' => 'Booth ID required'));
        }
    }
    
    private function generateUniqueId() {
        // Get the latest unique_id from database
        $last_record = $this->db->select('unique_id')
                               ->from('mandir_samiti_groups')
                               ->where('unique_id IS NOT NULL')
                               ->order_by('id', 'DESC')
                               ->limit(1)
                               ->get()
                               ->row();
        
        if ($last_record && $last_record->unique_id) {
            // Extract number from MS/X format
            $parts = explode('/', $last_record->unique_id);
            if (count($parts) == 2 && $parts[0] == 'MS') {
                $next_number = intval($parts[1]) + 1;
            } else {
                $next_number = 1;
            }
        } else {
            $next_number = 1;
        }
        
        return 'MS/' . $next_number;
    }
}
