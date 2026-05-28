<?php
require APPPATH . '/libraries/BaseController.php';

class InDocs extends BaseController {

    public function __construct() {
        parent::__construct();
        $this->load->model('InDocs_model');
        $this->load->helper('url');
        $this->load->model('user_model');
        $this->load->model('Comman_model');
        $this->isLoggedIn();
        $this->load->library('form_validation');  
        $this->load->model('Log_model');
        $this->module = 'In-Docs';
    }

    // Display all in docs records
    public function index() {
        if (!$this->hasListAccess()) {
            $this->loadThis();
        } else {
            $data['docs'] = $this->InDocs_model->get_all_docs();
            $this->global['pageTitle'] = 'Datacollector : In Docs (Incoming Documents)';
            $this->loadViews("in_docs/index", $this->global, $data, NULL);
        }
    }

    // Show form to create new in docs record
    public function create() {
        if (!$this->hasCreateAccess()) {
            $this->loadThis();
        } else {
            $this->global['pageTitle'] = 'Datacollector : Create In Docs';
            $this->loadViews("in_docs/create", $this->global, NULL, NULL);
        }
    }

    // Store new in docs record
    public function store() {
        if (!$this->hasCreateAccess()) {
            $this->loadThis();
        } else {
            // Generate unique ID
            $unique_id = $this->generateUniqueId();

            $data = array(
                'unique_id' => $unique_id,
                'issue_no' => $this->input->post('issue_no'),
                'month_date' => date('Y-m-d', strtotime($this->input->post('month_date'))),
                'name_address' => $this->input->post('name_address'),
                'place' => $this->input->post('place'),
                'subject' => $this->input->post('subject'),
                'documents_count' => $this->input->post('documents_count'),
                'reference_issue_no' => $this->input->post('reference_issue_no'),
                'received_issue_no' => $this->input->post('received_issue_no'),
                'file_head_no' => $this->input->post('file_head_no'),
                'stamp_received' => $this->input->post('stamp_received'),
                'remarks' => $this->input->post('remarks'),
                'created_by' => $this->vendorId,
            );

            $id = $this->InDocs_model->add_doc($data);
            if ($id) {
                $this->logActivity('add', 'in_docs', $id, $data, null, 'In Doc created with ID: ' . $id . ' (Issue No: ' . $data['issue_no'] . ')');
                $this->session->set_flashdata('success', 'In Doc record created successfully');
            } else {
                $this->session->set_flashdata('error', 'Failed to create In Doc record');
            }
            redirect('indocs');
        }
    }

    // Show form to edit in docs record
    public function edit($id) {
        if (!$this->hasUpdateAccess()) {
            $this->loadThis();
        } else {
            $data['doc'] = $this->InDocs_model->get_doc_by_id($id);
            $this->global['pageTitle'] = 'Datacollector : Edit In Docs';
            $this->loadViews("in_docs/edit", $this->global, $data, NULL);
        }
    }

    // Update in docs record
    public function update($id) {
        if (!$this->hasUpdateAccess()) {
            $this->loadThis();
        } else {
            $data = array(
                'issue_no' => $this->input->post('issue_no'),
                'month_date' => date('Y-m-d', strtotime($this->input->post('month_date'))),
                'name_address' => $this->input->post('name_address'),
                'place' => $this->input->post('place'),
                'subject' => $this->input->post('subject'),
                'documents_count' => $this->input->post('documents_count'),
                'reference_issue_no' => $this->input->post('reference_issue_no'),
                'received_issue_no' => $this->input->post('received_issue_no'),
                'file_head_no' => $this->input->post('file_head_no'),
                'stamp_received' => $this->input->post('stamp_received'),
                'remarks' => $this->input->post('remarks'),
                'updated_by' => $this->vendorId,
            );

            // Get old data before update for logging
            $oldData = $this->InDocs_model->get_doc_by_id($id);

            $this->InDocs_model->update_doc($id, $data);
            
            $this->logActivity('edit', 'in_docs', $id, $data, $oldData, 'In Doc updated with ID: ' . $id . ' (Issue No: ' . $data['issue_no'] . ')');
            $this->session->set_flashdata('success', 'In Doc record updated successfully');
            
            redirect('indocs');
        }
    }

    // Delete in docs record
    public function delete($id) {
        if (!$this->hasDeleteAccess()) {
            $this->loadThis();
        } else {
            // Get data before delete for logging
            $docData = $this->InDocs_model->get_doc_by_id($id);
            
            $this->InDocs_model->delete_doc($id);
            
            $this->logActivity('delete', 'in_docs', $id, $docData, null, 'In Doc deleted with ID: ' . $id . ' (Issue No: ' . (!empty($docData->issue_no) ? $docData->issue_no : 'N/A') . ')');
            $this->session->set_flashdata('success', 'In Doc record deleted successfully');
            
            redirect('indocs');
        }
    }

    /**
     * Generate unique ID for in docs
     */
    private function generateUniqueId() {
        // Get the latest unique_id from database
        $last_record = $this->db->select('unique_id')
                               ->from('in_docs')
                               ->where('unique_id IS NOT NULL')
                               ->order_by('id', 'DESC')
                               ->limit(1)
                               ->get()
                               ->row();
        
        if ($last_record && $last_record->unique_id) {
            // Extract number from ID/X format
            $parts = explode('/', $last_record->unique_id);
            if (count($parts) == 2 && $parts[0] == 'ID') {
                $next_number = intval($parts[1]) + 1;
            } else {
                $next_number = 1;
            }
        } else {
            $next_number = 1;
        }
        
        return 'ID/' . $next_number;
    }
}
?>
