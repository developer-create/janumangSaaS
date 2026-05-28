<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class GaneshSamiti extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('GaneshSamiti_model');
        $this->load->helper('url');
        $this->load->model('user_model');
        $this->load->model('Comman_model');
        $this->isLoggedIn();
        $this->load->library('form_validation');  
        $this->load->model('Log_model');
        $this->module = 'Ganesh-Samiti';
    }

    /**
     * Generate next unique ID for Ganesh Samiti in GS/X format
     */
    private function generateUniqueId()
    {
        $this->db->select('unique_id');
        $this->db->from('ganesh_samiti_groups');
        $this->db->where('unique_id IS NOT NULL');
        $this->db->where('unique_id !=', '');
        $this->db->order_by('id', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $last_id = $query->row()->unique_id;
            if (preg_match('/GS\/(\d+)/', $last_id, $matches)) {
                $next_number = intval($matches[1]) + 1;
            } else {
                $next_number = 1;
            }
        } else {
            $next_number = 1;
        }

        return 'GS/' . $next_number;
    }
    // Display all location groups with member count
    public function index()
    {
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
            $data['groups'] = $this->GaneshSamiti_model->get_groups($searchText, $filters);
            $data['blocks'] = $this->GaneshSamiti_model->get_blocks_with_data();
            $data['years'] = $this->GaneshSamiti_model->get_years();
            $data['months'] = $this->GaneshSamiti_model->get_months();
            $data['days'] = $this->GaneshSamiti_model->get_days();
            $data['total_members'] = $this->GaneshSamiti_model->get_total_members_count($filters);
            
            $this->global['pageTitle'] = 'Datacollector : Ganesh Samiti';
            $this->loadViews("ganeshsamiti/index", $this->global, $data, NULL);
        }
    }

    // Show form to create new location group
    public function create()
    {
        if (!$this->hasCreateAccess()) {
            $this->loadThis();
        } else {
            $this->global['pageTitle'] = 'Datacollector : Create Ganesh Samiti Location';
            $data['blocks'] = $this->GaneshSamiti_model->get_blocks();
            // Initialize dependent lists to avoid undefined variable errors in views
            $data['booths'] = array();
            $data['villages'] = array();
            $this->loadViews("ganeshsamiti/create", $this->global, $data, NULL);
        }
    }

    // Alias for create (backward compatibility)
    function add()
    {
        $this->create();
    }

    // Alias for create (backward compatibility)
    function addNew()
    {
        $this->create();
    }

    // Insert new location group
    public function store()
    {
        if (!$this->hasCreateAccess()) {
            $this->loadThis();
        } else {
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
                    redirect('ganeshsamiti/create');
                    return;
                }
            }

            $data = array(
                'unique_id' => $this->generateUniqueId(),
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

            $id = $this->GaneshSamiti_model->create_group($data);
            if ($id) {
                $this->logActivity('add', 'ganesh_samiti_groups', $id, $data, null, 'Ganesh Samiti location created with ID: ' . $id);
            }
            redirect('ganeshsamiti');
        }
    }

    // Update location group
    public function update($id)
    {
        if (!$this->hasUpdateAccess()) {
            $this->loadThis();
        } else {
            $oldData = $this->GaneshSamiti_model->get_group_by_id($id);
            
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
                    redirect('ganeshsamiti');
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

            $this->GaneshSamiti_model->update_group($id, $data);
            $this->logActivity('edit', 'ganesh_samiti_groups', $id, $data, $oldData, 'Ganesh Samiti location updated with ID: ' . $id);
            redirect('ganeshsamiti');
        }
    }

    // Delete location group
    public function delete($id)
    {
        if (!$this->hasDeleteAccess()) {
            $this->loadThis();
        } else {
            $groupData = $this->GaneshSamiti_model->get_group_by_id($id);
            $this->GaneshSamiti_model->delete_group($id);
            $this->logActivity('delete', 'ganesh_samiti_groups', $id, $groupData, null, 'Ganesh Samiti location deleted with ID: ' . $id);
            redirect('ganeshsamiti');
        }
    }

    // View members list for a specific group/location
    public function members($group_id)
    {
        if (!$this->hasListAccess()) {
            $this->loadThis();
        } else {
            $data['group'] = $this->GaneshSamiti_model->get_group_by_id($group_id);
            $data['members'] = $this->GaneshSamiti_model->get_members_by_group($group_id);
            $this->global['pageTitle'] = 'Datacollector : Ganesh Samiti Members';
            $this->loadViews("ganeshsamiti/members", $this->global, $data, NULL);
        }
    }

    // Show form to add member to a group
    public function add_member($group_id)
    {
        if (!$this->hasCreateAccess()) {
            $this->loadThis();
        } else {
            $data['group'] = $this->GaneshSamiti_model->get_group_by_id($group_id);
            $this->global['pageTitle'] = 'Datacollector : Add Ganesh Samiti Member';
            $this->loadViews("ganeshsamiti/add_member", $this->global, $data, NULL);
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

            $id = $this->GaneshSamiti_model->create_member($data);
            if ($id) {
                $this->logActivity('add', 'ganesh_samiti', $id, $data, null, 'Ganesh Samiti member added with ID: ' . $id);
            }
            redirect('ganeshsamiti/members/' . $group_id);
        }
    }

    // Edit member
    public function edit_member($id)
    {
        if (!$this->hasUpdateAccess()) {
            $this->loadThis();
        } else {
            $data['member'] = $this->GaneshSamiti_model->get_member_by_id($id);
            $data['group'] = $this->GaneshSamiti_model->get_group_by_id($data['member']['group_id']);
            $this->global['pageTitle'] = 'Datacollector : Edit Ganesh Samiti Member';
            $this->loadViews("ganeshsamiti/edit_member", $this->global, $data, NULL);
        }
    }

    // Update member
    public function update_member($id)
    {
        if (!$this->hasUpdateAccess()) {
            $this->loadThis();
        } else {
            $member = $this->GaneshSamiti_model->get_member_by_id($id);
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

            $oldData = $this->GaneshSamiti_model->get_member_by_id($id);
            $this->GaneshSamiti_model->update_member($id, $data);
            $this->logActivity('edit', 'ganesh_samiti', $id, $data, $oldData, 'Ganesh Samiti member updated with ID: ' . $id);
            redirect('ganeshsamiti/members/' . $group_id);
        }
    }

    // Delete member
    public function delete_member($id)
    {
        if (!$this->hasDeleteAccess()) {
            $this->loadThis();
        } else {
            $member = $this->GaneshSamiti_model->get_member_by_id($id);
            $group_id = $member['group_id'];
            $this->GaneshSamiti_model->delete_member($id);
            $this->logActivity('delete', 'ganesh_samiti', $id, $member, null, 'Ganesh Samiti member deleted with ID: ' . $id);
            redirect('ganeshsamiti/members/' . $group_id);
        }
    }

    // AJAX: Get booths by block
    public function get_booths_by_block()
    {
        $block_id = $this->input->post('block_id');
        if ($block_id) {
            $booths = $this->GaneshSamiti_model->get_booths_by_block($block_id);
            echo json_encode(array('error' => false, 'booths' => $booths));
        } else {
            echo json_encode(array('error' => true, 'message' => 'Block ID required'));
        }
    }

    // AJAX: Get booth details (booth no, panchayat, village)
    public function get_booth_details()
    {
        $booth_id = $this->input->post('booth_id');
        if ($booth_id) {
            $booth = $this->GaneshSamiti_model->get_booth_details($booth_id);
            if ($booth) {
                // Get panchayat by booth ID (panchayat table has boothid column)
                $panchayat = $this->GaneshSamiti_model->get_panchayat_by_booth($booth_id);
                
                // Get villages by panchayat ID if panchayat found
                $villages = array();
                if ($panchayat && isset($panchayat->id)) {
                    $villages = $this->GaneshSamiti_model->get_villages_by_panchayat($panchayat->id);
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

    // AJAX: return next generated unique id for GS/X
    public function next_unique_id()
    {
        if (!$this->hasCreateAccess()) {
            echo json_encode(array('error' => true, 'message' => 'Access denied'));
            return;
        }

        $next = $this->generateUniqueId();
        echo json_encode(array('error' => false, 'next' => $next));
    }

    // Backward compatibility aliases removed - full implementations exist below

    // Show form to edit location group
    public function edit($id)
    {
        if (!$this->hasUpdateAccess()) {
            $this->loadThis();
        } else {
            $data['record'] = $this->GaneshSamiti_model->get_group_by_id($id);
            $this->global['pageTitle'] = 'Datacollector : Edit Ganesh Samiti Location';
            $data['blocks'] = $this->GaneshSamiti_model->get_blocks();
            // Initialize dependent lists so views can iterate safely
            $data['booths'] = array();
            $data['villages'] = array();
            
            // Get booths if block is selected
            if (!empty($data['record']['block'])) {
                $data['booths'] = $this->GaneshSamiti_model->get_booths_by_block($data['record']['block']);
            }
            
            // Get panchayat and villages if booth is selected
            if (!empty($data['record']['booth_id'])) {
                $panchayat_data = $this->GaneshSamiti_model->get_panchayat_by_booth($data['record']['booth_id']);
                if ($panchayat_data) {
                    $data['villages'] = $this->GaneshSamiti_model->get_villages_by_panchayat($panchayat_data->id);
                }
            }
            
            $this->loadViews("ganeshsamiti/edit", $this->global, $data, NULL);
        }
    }

    // Backward compatibility method for old form validation
    function editGaneshSamiti() 
    { 
        if (isset($_POST['ganeshSamitiId'])) {
            $this->update($_POST['ganeshSamitiId']); 
        } else {
            redirect('ganeshsamiti');
        }
    }

    // View details (backward compatibility)
    function view($id = NULL)
    {
        if (!$this->hasListAccess()) {
            $this->loadThis();
        } else {
            $data['group'] = $this->GaneshSamiti_model->get_group_by_id($id);
            $data['members'] = $this->GaneshSamiti_model->get_members_by_group($id);
            $this->global['pageTitle'] = 'Datacollector : Ganesh Samiti Details';
            $this->loadViews("ganeshsamiti/view", $this->global, $data, NULL);
        }
    }

    // Backward compatibility method for old AJAX delete
    function deleteGaneshSamiti()
    {
        if (isset($_POST['ganeshSamitiId'])) {
            $this->delete($_POST['ganeshSamitiId']);
        } else {
            echo json_encode(array('status' => false, 'message' => 'ID not provided'));
        }
    }

    // Page not found redirect
    function pageNotFound()
    {
        redirect('ganeshsamiti');
    }
    
    // AJAX redirect
    public function ganeshsamitiajax()
    {
        redirect('ganeshsamiti');
    }
}

?>