<?php
require APPPATH . '/libraries/BaseController.php';

class BhagoriaSamiti extends BaseController {

    public function __construct() {
        parent::__construct();
        $this->load->model('BhagoriaSamiti_model');
        $this->load->helper('url');
        $this->load->model('user_model');
        $this->load->model('Comman_model');
        $this->isLoggedIn();
        $this->load->library('form_validation');  
        $this->load->model('Log_model');
        $this->module = 'Bhagoria-Samiti';
    }

    // Display all records
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
            $data['records'] = $this->BhagoriaSamiti_model->get_records($searchText, $filters);
            $data['blocks'] = $this->BhagoriaSamiti_model->get_blocks_with_data();
            $data['years'] = $this->BhagoriaSamiti_model->get_years();
            $data['months'] = $this->BhagoriaSamiti_model->get_months();
            $data['days'] = $this->BhagoriaSamiti_model->get_days();
            $data['total_members'] = $this->BhagoriaSamiti_model->get_total_members_count($filters);
            
            $this->global['pageTitle'] = 'Datacollector : Bhagoria Samiti';
            $this->loadViews("bhagoriasamiti/index", $this->global, $data, NULL);
        }
    }

    // Show form to create new record
    public function create() {
        if (!$this->hasCreateAccess()) {
            $this->loadThis();
        } else {
            $this->global['pageTitle'] = 'Datacollector : Create Bhagoria Samiti';
            $query = $this->db->get('block');
            $data['blocks'] = $query->result();
            $this->loadViews("bhagoriasamiti/create", $this->global, $data, NULL);
        }
    }

    // Insert new record
    public function store() {
        if (!$this->hasCreateAccess()) {
            $this->loadThis();
        } else {
            $file_name = null;
            if (!empty($_FILES['file_upload']['name'])) {
                $config['upload_path'] = './uploads/samiti_files/';
                $config['allowed_types'] = 'pdf|doc|docx|jpg|jpeg|png';
                $config['max_size'] = 5120;
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
                    redirect('bhagoriasamiti/create');
                    return;
                }
            }

            $data = array(
                'serial_no' => $this->input->post('serial_no'),
                'block' => $this->input->post('block'),
                'date' => !empty($this->input->post('date')) ? date('Y-m-d', strtotime($this->input->post('date'))) : NULL,
                'var' => $this->input->post('var'),
                'bhagoria_hat' => $this->input->post('bhagoria_hat'),
                'dol_ki_sankhya' => $this->input->post('dol_ki_sankhya'),
                'prabhari_ka_naam' => $this->input->post('prabhari_ka_naam'),
                'mobile_number' => $this->input->post('mobile_number'),
                'remark' => $this->input->post('remark'),
                'file_upload' => $file_name,
                'created_by' => $this->vendorId,
            );

            $id = $this->BhagoriaSamiti_model->create($data);
            if ($id) {
                $this->logActivity('add', 'bhagoria_samiti', $id, $data, null, 'Bhagoria Samiti record created with ID: ' . $id);
            }
            redirect('bhagoriasamiti');
        }
    }

    // Show form to edit record
    public function edit($id) {
        if (!$this->hasUpdateAccess()) {
            $this->loadThis();
        } else {
            $data['record'] = $this->BhagoriaSamiti_model->get_by_id($id);
            $this->global['pageTitle'] = 'Datacollector : Edit Bhagoria Samiti';
            $query = $this->db->get('block');
            $data['blocks'] = $query->result();
            $this->loadViews("bhagoriasamiti/edit", $this->global, $data, NULL);
        }
    }

    // Update record
    public function update($id) {
        if (!$this->hasUpdateAccess()) {
            $this->loadThis();
        } else {
            $oldData = $this->BhagoriaSamiti_model->get_by_id($id);
            $file_name = isset($oldData['file_upload']) ? $oldData['file_upload'] : null;
            if (!empty($_FILES['file_upload']['name'])) {
                $config['upload_path'] = './uploads/samiti_files/';
                $config['allowed_types'] = 'pdf|doc|docx|jpg|jpeg|png';
                $config['max_size'] = 5120;
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
                    redirect('bhagoriasamiti/edit/' . $id);
                    return;
                }
            }

            $data = array(
                'serial_no' => $this->input->post('serial_no'),
                'block' => $this->input->post('block'),
                'date' => !empty($this->input->post('date')) ? date('Y-m-d', strtotime($this->input->post('date'))) : NULL,
                'var' => $this->input->post('var'),
                'bhagoria_hat' => $this->input->post('bhagoria_hat'),
                'dol_ki_sankhya' => $this->input->post('dol_ki_sankhya'),
                'prabhari_ka_naam' => $this->input->post('prabhari_ka_naam'),
                'mobile_number' => $this->input->post('mobile_number'),
                'remark' => $this->input->post('remark'),
                'file_upload' => $file_name,
                'updated_by' => $this->vendorId,
            );

            $this->BhagoriaSamiti_model->update($id, $data);
            $this->logActivity('edit', 'bhagoria_samiti', $id, $data, $oldData, 'Bhagoria Samiti record updated with ID: ' . $id);
            redirect('bhagoriasamiti');
        }
    }

    // View record details (redirects to members page like Booth Samiti)
    public function view($id) {
        redirect('bhagoriasamiti/members/' . $id);
    }

    // Members list for a samiti (record details + file + members + Add Member)
    public function members($id) {
        if (!$this->hasListAccess()) {
            $this->loadThis();
        } else {
            $record = $this->BhagoriaSamiti_model->get_by_id($id);
            if (empty($record)) {
                $this->session->set_flashdata('error', 'Record not found');
                redirect('bhagoriasamiti');
                return;
            }
            $data['record'] = $record;
            $data['members'] = $this->BhagoriaSamiti_model->get_members_by_samiti($id);
            $data['block_name'] = '';
            if (!empty($record['block'])) {
                $b = $this->db->get_where('block', array('id' => $record['block']))->row();
                $data['block_name'] = $b ? $b->name : '';
            }
            $this->global['pageTitle'] = 'Datacollector : भगोरिया समिति View / Members';
            $this->loadViews("bhagoriasamiti/members", $this->global, $data, NULL);
        }
    }

    public function add_member($id) {
        if (!$this->hasCreateAccess()) {
            $this->loadThis();
        } else {
            $data['record'] = $this->BhagoriaSamiti_model->get_by_id($id);
            if (empty($data['record'])) {
                $this->session->set_flashdata('error', 'Record not found');
                redirect('bhagoriasamiti');
                return;
            }
            $this->global['pageTitle'] = 'Datacollector : Add Bhagoria Samiti Member';
            $this->loadViews("bhagoriasamiti/add_member", $this->global, $data, NULL);
        }
    }

    public function store_member() {
        if (!$this->hasCreateAccess()) {
            $this->loadThis();
        } else {
            $samiti_id = (int) $this->input->post('samiti_id');
            $data = array(
                'samiti_id' => $samiti_id,
                'member_name' => $this->input->post('member_name'),
                'father_name' => $this->input->post('father_name'),
                'age' => $this->input->post('age') ? (int) $this->input->post('age') : null,
                'position' => $this->input->post('position'),
                'mobile_number' => $this->input->post('mobile_number'),
                'remark' => $this->input->post('remark'),
                'created_by' => $this->vendorId,
            );
            $mid = $this->BhagoriaSamiti_model->create_member($data);
            if ($mid) {
                $this->logActivity('add', 'bhagoria_samiti_members', $mid, $data, null, 'Bhagoria Samiti member added');
            }
            redirect('bhagoriasamiti/members/' . $samiti_id);
        }
    }

    public function edit_member($member_id) {
        if (!$this->hasUpdateAccess()) {
            $this->loadThis();
        } else {
            $data['member'] = $this->BhagoriaSamiti_model->get_member_by_id($member_id);
            if (empty($data['member'])) {
                $this->session->set_flashdata('error', 'Member not found');
                redirect('bhagoriasamiti');
                return;
            }
            $data['record'] = $this->BhagoriaSamiti_model->get_by_id($data['member']['samiti_id']);
            $this->global['pageTitle'] = 'Datacollector : Edit Bhagoria Samiti Member';
            $this->loadViews("bhagoriasamiti/edit_member", $this->global, $data, NULL);
        }
    }

    public function update_member($member_id) {
        if (!$this->hasUpdateAccess()) {
            $this->loadThis();
        } else {
            $member = $this->BhagoriaSamiti_model->get_member_by_id($member_id);
            $samiti_id = $member['samiti_id'];
            $data = array(
                'member_name' => $this->input->post('member_name'),
                'father_name' => $this->input->post('father_name'),
                'age' => $this->input->post('age') ? (int) $this->input->post('age') : null,
                'position' => $this->input->post('position'),
                'mobile_number' => $this->input->post('mobile_number'),
                'remark' => $this->input->post('remark'),
                'updated_by' => $this->vendorId,
            );
            $this->BhagoriaSamiti_model->update_member($member_id, $data);
            $this->logActivity('edit', 'bhagoria_samiti_members', $member_id, $data, $member, 'Bhagoria Samiti member updated');
            redirect('bhagoriasamiti/members/' . $samiti_id);
        }
    }

    public function delete_member($member_id) {
        if (!$this->hasDeleteAccess()) {
            $this->loadThis();
        } else {
            $member = $this->BhagoriaSamiti_model->get_member_by_id($member_id);
            $samiti_id = $member['samiti_id'];
            $this->BhagoriaSamiti_model->delete_member($member_id);
            $this->logActivity('delete', 'bhagoria_samiti_members', $member_id, $member, null, 'Bhagoria Samiti member deleted');
            redirect('bhagoriasamiti/members/' . $samiti_id);
        }
    }

    // Delete record
    public function delete($id) {
        if (!$this->hasDeleteAccess()) {
            $this->loadThis();
        } else {
            $recordData = $this->BhagoriaSamiti_model->get_by_id($id);
            $this->BhagoriaSamiti_model->delete($id);
            $this->logActivity('delete', 'bhagoria_samiti', $id, $recordData, null, 'Bhagoria Samiti record deleted with ID: ' . $id);
            redirect('bhagoriasamiti');
        }
    }
}
