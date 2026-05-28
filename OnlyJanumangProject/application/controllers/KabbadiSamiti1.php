<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class KabbadiSamiti extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('KabbadiSamiti_model');
        $this->isLoggedIn();   
        $this->module = 'Kabbadi-Samiti';
    }

    public function index()
    {
        if (!$this->hasListAccess()) {
            $this->loadThis();
        } else {
            $searchText = $this->input->post('searchText');
            $data['searchText'] = $searchText;
            $data['records'] = $this->KabbadiSamiti_model->get_groups($searchText);
            
            $this->global['pageTitle'] = 'Datacollector : Kabbadi Samiti';
            $this->loadViews("kabbadisamiti/index", $this->global, $data, NULL);
        }
    }

    public function add()
    {
        if (!$this->hasCreateAccess()) {
            $this->loadThis();
        } else {
            $data['blocks'] = $this->KabbadiSamiti_model->get_blocks();
            $data['next_id'] = $this->generateUniqueId();
            $this->global['pageTitle'] = 'Datacollector : Add Kabbadi Samiti Location';
            $this->loadViews("kabbadisamiti/add", $this->global, $data, NULL);
        }
    }

    private function generateUniqueId()
    {
        $last_id_row = $this->KabbadiSamiti_model->get_last_unique_id();
        if ($last_id_row) {
            $last_id = $last_id_row['unique_id'];
            $parts = explode('/', $last_id);
            if (count($parts) == 2) {
                $num = intval($parts[1]) + 1;
                return 'KS/' . $num;
            }
        }
        return 'KS/1';
    }

    public function store()
    {
        if (!$this->hasCreateAccess()) {
            $this->loadThis();
        } else {
            $unique_id = $this->input->post('unique_id');
            if ($this->KabbadiSamiti_model->check_unique_id_exists($unique_id)) {
                $unique_id = $this->generateUniqueId();
            }

            $upload_path = '';
            if (!empty($_FILES['file_upload']['name'])) {
                $config['upload_path'] = './uploads/kabbadisamiti/';
                $config['allowed_types'] = 'gif|jpg|png|jpeg|pdf|doc|docx';
                $config['max_size'] = 2048;
                $config['file_name'] = time() . '_' . $_FILES['file_upload']['name'];

                if (!is_dir($config['upload_path'])) {
                    mkdir($config['upload_path'], 0777, TRUE);
                }

                $this->load->library('upload', $config);
                if ($this->upload->do_upload('file_upload')) {
                    $uploadData = $this->upload->data();
                    $upload_path = $uploadData['file_name'];
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
                'created_by' => $this->vendorId,
                'file_upload' => $upload_path
            );

            $id = $this->KabbadiSamiti_model->create_group($data);
            if ($id) {
                $this->logActivity('add', 'kabbadi_samiti_groups', $id, $data, null, 'Kabbadi Samiti location added with ID: ' . $id);
            }
            redirect('kabbadisamiti');
        }
    }

    public function edit($id)
    {
        if (!$this->hasUpdateAccess()) {
            $this->loadThis();
        } else {
            $data['record'] = $this->KabbadiSamiti_model->get_group_by_id($id);
            if (empty($data['record'])) {
                redirect('kabbadisamiti');
            }
            $data['blocks'] = $this->KabbadiSamiti_model->get_blocks();
            $data['booths'] = array();
            $data['villages'] = array();
            
            if (!empty($data['record']['block'])) {
                $data['booths'] = $this->KabbadiSamiti_model->get_booths_by_block($data['record']['block']);
            }
            
            if (!empty($data['record']['booth_id'])) {
                $panchayat_data = $this->KabbadiSamiti_model->get_panchayat_by_booth($data['record']['booth_id']);
                if ($panchayat_data) {
                    $data['villages'] = $this->KabbadiSamiti_model->get_villages_by_panchayat($panchayat_data->id);
                }
            }
            
            $this->global['pageTitle'] = 'Datacollector : Edit Kabbadi Samiti Location';
            $this->loadViews("kabbadisamiti/edit", $this->global, $data, NULL);
        }
    }

    public function update($id)
    {
        if (!$this->hasUpdateAccess()) {
            $this->loadThis();
        } else {
            $oldData = $this->KabbadiSamiti_model->get_group_by_id($id);
            $upload_path = $oldData['file_upload'];

            if (!empty($_FILES['file_upload']['name'])) {
                $config['upload_path'] = './uploads/kabbadisamiti/';
                $config['allowed_types'] = 'gif|jpg|png|jpeg|pdf|doc|docx';
                $config['max_size'] = 2048;
                $config['file_name'] = time() . '_' . $_FILES['file_upload']['name'];

                if (!is_dir($config['upload_path'])) {
                    mkdir($config['upload_path'], 0777, TRUE);
                }

                $this->load->library('upload', $config);
                if ($this->upload->do_upload('file_upload')) {
                    $uploadData = $this->upload->data();
                    $upload_path = $uploadData['file_name'];
                    
                    // Delete old file if exists
                    if (!empty($oldData['file_upload']) && file_exists('./uploads/kabbadisamiti/' . $oldData['file_upload'])) {
                        unlink('./uploads/kabbadisamiti/' . $oldData['file_upload']);
                    }
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
                'updated_by' => $this->vendorId,
                'file_upload' => $upload_path
            );

            $this->KabbadiSamiti_model->update_group($id, $data);
            $this->logActivity('edit', 'kabbadi_samiti_groups', $id, $data, $oldData, 'Kabbadi Samiti location updated with ID: ' . $id);
            redirect('kabbadisamiti');
        }
    }

    public function delete($id)
    {
        if (!$this->hasDeleteAccess()) {
            $this->loadThis();
        } else {
            $groupData = $this->KabbadiSamiti_model->get_group_by_id($id);
            $this->KabbadiSamiti_model->delete_group($id);
            
            // Delete associated file
            if (!empty($groupData['file_upload']) && file_exists('./uploads/kabbadisamiti/' . $groupData['file_upload'])) {
                unlink('./uploads/kabbadisamiti/' . $groupData['file_upload']);
            }
            
            $this->logActivity('delete', 'kabbadi_samiti_groups', $id, $groupData, null, 'Kabbadi Samiti location deleted with ID: ' . $id);
            redirect('kabbadisamiti');
        }
    }

    public function members($group_id)
    {
        if (!$this->hasListAccess()) {
            $this->loadThis();
        } else {
            $data['group'] = $this->KabbadiSamiti_model->get_group_by_id($group_id);
            $data['members'] = $this->KabbadiSamiti_model->get_members_by_group($group_id);
            $this->global['pageTitle'] = 'Datacollector : Kabbadi Samiti Members';
            $this->loadViews("kabbadisamiti/members", $this->global, $data, NULL);
        }
    }

    public function add_member($group_id)
    {
        if (!$this->hasCreateAccess()) {
            $this->loadThis();
        } else {
            $data['group'] = $this->KabbadiSamiti_model->get_group_by_id($group_id);
            $this->global['pageTitle'] = 'Datacollector : Add Kabbadi Samiti Member';
            $this->loadViews("kabbadisamiti/add_member", $this->global, $data, NULL);
        }
    }

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

            $id = $this->KabbadiSamiti_model->create_member($data);
            if ($id) {
                $this->logActivity('add', 'kabbadi_samiti', $id, $data, null, 'Kabbadi Samiti member added with ID: ' . $id);
            }
            redirect('kabbadisamiti/members/' . $group_id);
        }
    }

    public function edit_member($id)
    {
        if (!$this->hasUpdateAccess()) {
            $this->loadThis();
        } else {
            $data['member'] = $this->KabbadiSamiti_model->get_member_by_id($id);
            $data['group'] = $this->KabbadiSamiti_model->get_group_by_id($data['member']['group_id']);
            $this->global['pageTitle'] = 'Datacollector : Edit Kabbadi Samiti Member';
            $this->loadViews("kabbadisamiti/edit_member", $this->global, $data, NULL);
        }
    }

    public function update_member($id)
    {
        if (!$this->hasUpdateAccess()) {
            $this->loadThis();
        } else {
            $member = $this->KabbadiSamiti_model->get_member_by_id($id);
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

            $oldData = $this->KabbadiSamiti_model->get_member_by_id($id);
            $this->KabbadiSamiti_model->update_member($id, $data);
            $this->logActivity('edit', 'kabbadi_samiti', $id, $data, $oldData, 'Kabbadi Samiti member updated with ID: ' . $id);
            redirect('kabbadisamiti/members/' . $group_id);
        }
    }

    public function delete_member($id)
    {
        if (!$this->hasDeleteAccess()) {
            $this->loadThis();
        } else {
            $member = $this->KabbadiSamiti_model->get_member_by_id($id);
            $group_id = $member['group_id'];
            $this->KabbadiSamiti_model->delete_member($id);
            $this->logActivity('delete', 'kabbadi_samiti', $id, $member, null, 'Kabbadi Samiti member deleted with ID: ' . $id);
            redirect('kabbadisamiti/members/' . $group_id);
        }
    }

    public function get_booths_by_block()
    {
        $block_id = $this->input->post('block_id');
        if ($block_id) {
            $booths = $this->KabbadiSamiti_model->get_booths_by_block($block_id);
            echo json_encode(array('error' => false, 'booths' => $booths));
        } else {
            echo json_encode(array('error' => true, 'message' => 'Block ID required'));
        }
    }

    public function get_booth_details()
    {
        $booth_id = $this->input->post('booth_id');
        if ($booth_id) {
            $booth = $this->KabbadiSamiti_model->get_booth_details($booth_id);
            if ($booth) {
                $panchayat = $this->KabbadiSamiti_model->get_panchayat_by_booth($booth_id);
                $villages = array();
                if ($panchayat && isset($panchayat->id)) {
                    $villages = $this->KabbadiSamiti_model->get_villages_by_panchayat($panchayat->id);
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

    public function next_unique_id()
    {
        if (!$this->hasCreateAccess()) {
            echo json_encode(array('error' => true, 'message' => 'Access denied'));
            return;
        }

        $next = $this->generateUniqueId();
        echo json_encode(array('error' => false, 'next' => $next));
    }
    
    public function view($id = NULL)
    {
        if (!$this->hasListAccess()) {
            $this->loadThis();
        } else {
            $data['group'] = $this->KabbadiSamiti_model->get_group_by_id($id);
            $data['members'] = $this->KabbadiSamiti_model->get_members_by_group($id);
            $this->global['pageTitle'] = 'Datacollector : Kabbadi Samiti Details';
            $this->loadViews("kabbadisamiti/view", $this->global, $data, NULL);
        }
    }
}
