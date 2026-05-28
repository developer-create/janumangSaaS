<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

/**
 * Class : DpSamiti (DpSamitiController)
 * DpSamiti Class to manage DP Samiti operations with groups and members.
 * @author : Your Name
 * @version : 1.0
 * @since : November 2025
 */
class DpSamiti extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('DpSamiti_model');
        $this->load->library('form_validation');
        $this->isLoggedIn();
        $this->module = 'DP-Samiti';
    }
    
    /**
     * This function is used to load the groups list
     */
    function index()
    {
        if(!$this->hasListAccess())
        {
            $this->loadThis();
        }
        else
        {
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
            $data['groups'] = $this->DpSamiti_model->get_groups($searchText, $filters);
            $data['blocks'] = $this->DpSamiti_model->get_blocks_with_data();
            $data['years'] = $this->DpSamiti_model->get_years();
            $data['months'] = $this->DpSamiti_model->get_months();
            $data['days'] = $this->DpSamiti_model->get_days();
            $data['total_members'] = $this->DpSamiti_model->get_total_members_count($filters);
            
            $this->global['pageTitle'] = 'DP Samiti';
            
            $this->loadViews("dpsamiti/index", $this->global, $data, NULL);
        }
    }
    
    /**
     * This function is used to load the add new group form
     */
    function create()
    {
        if(!$this->hasCreateAccess())
        {
            $this->loadThis();
        }
        else
        {
            $data['blocks'] = $this->DpSamiti_model->getBlocks();
            
            $this->global['pageTitle'] = 'Add DP Samiti Location';
            
            $this->loadViews("dpsamiti/create", $this->global, $data, NULL);
        }
    }
    
    /**
     * This function is used to add new group to the system
     */
    function store()
    {
        if(!$this->hasCreateAccess())
        {
            $this->loadThis();
        }
        else
        {
            $this->form_validation->set_rules('block','Block','required');
            $this->form_validation->set_rules('booth_name','Booth Name','required');
            $this->form_validation->set_rules('year','Year','required|numeric');
            $this->form_validation->set_rules('ac_mp_no','AC/MP No','required');

            // Generate unique ID for DP Samiti (DS/X)
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
                        redirect('dpsamiti/create');
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
                
                $result = $this->DpSamiti_model->addGroup($groupInfo);
                
                if($result > 0)
                {
                    $this->logActivity('DP Samiti', 'CREATE', 'Created new DP Samiti location', $result);
                    $this->session->set_flashdata('success', 'New location created successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', 'Location creation failed');
                }
                
                redirect('dpsamiti');
            }
        }
    }
    
    /**
     * This function is used to load the edit group form
     */
    function edit($groupId = NULL)
    {
        if(!$this->hasUpdateAccess())
        {
            $this->loadThis();
        }
        else
        {
            if($groupId == NULL)
            {
                redirect('dpsamiti');
            }
            
            $data['groupInfo'] = $this->DpSamiti_model->getGroupInfo($groupId);
            
            if(empty($data['groupInfo']))
            {
                redirect('dpsamiti');
            }
            
            $data['blocks'] = $this->DpSamiti_model->getBlocks();
            $data['booths'] = array();
            $data['villages'] = array();
            
            // Get booths if block is selected
            if (!empty($data['groupInfo']->block)) {
                $data['booths'] = $this->DpSamiti_model->getBoothsByBlock($data['groupInfo']->block);
            }
            
            // Get panchayat and villages if booth is selected
            if (!empty($data['groupInfo']->booth_name)) {
                $panchayat_data = $this->DpSamiti_model->getPanchayatByBooth($data['groupInfo']->booth_name);
                if ($panchayat_data) {
                    $data['villages'] = $this->DpSamiti_model->getVillagesByPanchayat($panchayat_data->id);
                }
            }
            
            $this->global['pageTitle'] = 'Edit DP Samiti Location';
            
            $this->loadViews("dpsamiti/edit", $this->global, $data, NULL);
        }
    }
    
    /**
     * This function is used to update group information
     */
    function update()
    {
        if(!$this->hasUpdateAccess())
        {
            $this->loadThis();
        }
        else
        {
            $groupId = $this->input->post('id');
            
            $this->form_validation->set_rules('block','Block','required');
            $this->form_validation->set_rules('booth_name','Booth Name','required');
            $this->form_validation->set_rules('year','Year','required|numeric');
            $this->form_validation->set_rules('ac_mp_no','AC/MP No','required');
            
            if($this->form_validation->run() == FALSE)
            {
                $this->edit($groupId);
            }
            else
            {
                $oldData = $this->DpSamiti_model->getGroupInfo($groupId);
                
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
                        redirect('dpsamiti/edit/' . $groupId);
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
                    'updated_by' => $this->vendorId
                );
                
                $result = $this->DpSamiti_model->editGroup($groupInfo, $groupId);
                
                if($result == true)
                {
                    $this->logActivity('DP Samiti', 'UPDATE', 'Updated DP Samiti location', $groupId);
                    $this->session->set_flashdata('success', 'Location updated successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', 'Location update failed');
                }
                
                redirect('dpsamiti');
            }
        }
    }
    
    /**
     * This function is used to delete group
     */
    function delete($groupId = NULL)
    {
        if(!$this->hasDeleteAccess())
        {
            $this->loadThis();
        }
        else
        {
            if($groupId == NULL)
            {
                redirect('dpsamiti');
            }
            
            $result = $this->DpSamiti_model->deleteGroup($groupId);
            
            if ($result > 0)
            {
                $this->logActivity('DP Samiti', 'DELETE', 'Deleted DP Samiti location', $groupId);
                $this->session->set_flashdata('success', 'Location deleted successfully');
            }
            else
            {
                $this->session->set_flashdata('error', 'Location deletion failed');
            }
            
            redirect('dpsamiti');
        }
    }
    
    /**
     * This function is used to view group details
     */
    function view($groupId = NULL)
    {
        if(!$this->hasListAccess())
        {
            $this->loadThis();
        }
        else
        {
            if($groupId == NULL)
            {
                redirect('dpsamiti');
            }
            
            $data['groupInfo'] = $this->DpSamiti_model->getGroupInfo($groupId);
            
            $this->global['pageTitle'] = 'View DP Samiti Location';
            
            $this->loadViews("dpsamiti/view", $this->global, $data, NULL);
        }
    }
    
    /**
     * This function is used to load members list for a group
     */
    function members($groupId = NULL)
    {
        if(!$this->hasListAccess())
        {
            $this->loadThis();
        }
        else
        {
            if($groupId == NULL)
            {
                redirect('dpsamiti');
            }
            
            $data['groupInfo'] = $this->DpSamiti_model->getGroupInfo($groupId);
            $data['members'] = $this->DpSamiti_model->getMembers($groupId);
            
            $this->global['pageTitle'] = 'DP Samiti Members';
            
            $this->loadViews("dpsamiti/members", $this->global, $data, NULL);
        }
    }
    
    /**
     * This function is used to load add member form
     */
    function addMember($groupId = NULL)
    {
        if(!$this->hasCreateAccess())
        {
            $this->loadThis();
        }
        else
        {
            if($groupId == NULL)
            {
                redirect('dpsamiti');
            }
            
            $data['groupInfo'] = $this->DpSamiti_model->getGroupInfo($groupId);
            
            $this->global['pageTitle'] = 'Add DP Samiti Member';
            
            $this->loadViews("dpsamiti/add_member", $this->global, $data, NULL);
        }
    }
    
    /**
     * This function is used to add new member
     */
    function storeMember()
    {
        if(!$this->hasCreateAccess())
        {
            $this->loadThis();
        }
        else
        {
            $this->load->library('form_validation');
            
            $groupId = $this->input->post('group_id');
            
            $this->form_validation->set_rules('member_name','Member Name','required');
            
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
                    'updated_by' => $this->vendorId
                );
                
                $result = $this->DpSamiti_model->addMember($memberInfo);
                
                if($result > 0)
                {
                    $this->logActivity('DP Samiti', 'CREATE', 'Added new member to DP Samiti', $result);
                    $this->session->set_flashdata('success', 'New member added successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', 'Member addition failed');
                }
                
                redirect('dpsamiti/members/'.$groupId);
            }
        }
    }
    
    /**
     * This function is used to load edit member form
     */
    function editMember($memberId = NULL)
    {
        if(!$this->hasUpdateAccess())
        {
            $this->loadThis();
        }
        else
        {
            if($memberId == NULL)
            {
                redirect('dpsamiti');
            }
            
            $data['memberInfo'] = $this->DpSamiti_model->getMemberInfo($memberId);
            $data['groupInfo'] = $this->DpSamiti_model->getGroupInfo($data['memberInfo']->group_id);
            
            $this->global['pageTitle'] = 'Edit DP Samiti Member';
            
            $this->loadViews("dpsamiti/edit_member", $this->global, $data, NULL);
        }
    }
    
    /**
     * This function is used to update member information
     */
    function updateMember()
    {
        if(!$this->hasUpdateAccess())
        {
            $this->loadThis();
        }
        else
        {
            $this->load->library('form_validation');
            
            $memberId = $this->input->post('id');
            $groupId = $this->input->post('group_id');
            
            $this->form_validation->set_rules('member_name','Member Name','required');
            
            if($this->form_validation->run() == FALSE)
            {
                $this->editMember($memberId);
            }
            else
            {
                $memberInfo = array(
                    'member_name' => $this->input->post('member_name'),
                    'father_name' => $this->input->post('father_name'),
                    'age' => $this->input->post('age'),
                    'position' => $this->input->post('position'),
                    'mobile_number' => $this->input->post('mobile_number'),
                    'remark' => $this->input->post('remark'),
                    'updated_by' => $this->vendorId
                );
                
                $result = $this->DpSamiti_model->editMember($memberInfo, $memberId);
                
                if($result == true)
                {
                    $this->logActivity('DP Samiti', 'UPDATE', 'Updated DP Samiti member', $memberId);
                    $this->session->set_flashdata('success', 'Member updated successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', 'Member update failed');
                }
                
                redirect('dpsamiti/members/'.$groupId);
            }
        }
    }
    
    /**
     * This function is used to delete member
     */
    function deleteMember($memberId = NULL, $groupId = NULL)
    {
        if(!$this->hasDeleteAccess())
        {
            $this->loadThis();
        }
        else
        {
            if($memberId == NULL || $groupId == NULL)
            {
                redirect('dpsamiti');
            }
            
            $result = $this->DpSamiti_model->deleteMember($memberId);
            
            if ($result > 0)
            {
                $this->logActivity('DP Samiti', 'DELETE', 'Deleted DP Samiti member', $memberId);
                $this->session->set_flashdata('success', 'Member deleted successfully');
            }
            else
            {
                $this->session->set_flashdata('error', 'Member deletion failed');
            }
            
            redirect('dpsamiti/members/'.$groupId);
        }
    }
    
    /**
     * This function is used to get booths by block via AJAX
     */
    function get_booths_by_block()
    {
        $blockId = $this->input->post('block_id');
        $booths = $this->DpSamiti_model->getBoothsByBlock($blockId);
        
        echo json_encode(array('error' => false, 'booths' => $booths));
    }
    
    /**
     * This function is used to get booth details via AJAX
     */
    function get_booth_details()
    {
        $booth_id = $this->input->post('booth_id');
        if ($booth_id) {
            $booth = $this->DpSamiti_model->getBoothDetails($booth_id);
            if ($booth) {
                // Get panchayat by booth ID
                $panchayat = $this->DpSamiti_model->getPanchayatByBooth($booth_id);
                
                // Get villages by panchayat ID if panchayat found
                $villages = array();
                if ($panchayat && isset($panchayat->id)) {
                    $villages = $this->DpSamiti_model->getVillagesByPanchayat($panchayat->id);
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
    
    /**
     * Generate next unique ID for DP Samiti in DS/X format
     */
    private function generateUniqueId()
    {
        // Get the last unique_id from database
        $this->db->select('unique_id');
        $this->db->from('dp_samiti_groups');
        $this->db->where('unique_id IS NOT NULL');
        $this->db->where('unique_id !=', '');
        $this->db->order_by('id', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $last_id = $query->row()->unique_id;
            // Extract number from DS/X format
            if (preg_match('/DS\/(\d+)/', $last_id, $matches)) {
                $next_number = intval($matches[1]) + 1;
            } else {
                $next_number = 1;
            }
        } else {
            $next_number = 1;
        }

        return 'DS/' . $next_number;
    }

}

?>
