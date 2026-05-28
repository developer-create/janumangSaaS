<?php
require APPPATH . '/libraries/BaseController.php';

class InwardRegister extends BaseController {

    public function __construct() {
        parent::__construct();
        $this->load->model('InwardRegister_model');
        $this->load->helper('url');
        $this->load->library('form_validation');
        $this->load->model('Log_model');
        $this->isLoggedIn();
        $this->module = 'Inward-Register';
    }

    // List all inward registers
    public function index() {
        if (!$this->hasListAccess()) {
            $this->loadThis();
        } else {
            $data['registers'] = $this->InwardRegister_model->get_all_registers();
            $this->global['pageTitle'] = 'Datacollector : Inward Register';
            $this->loadViews("inward_register/index", $this->global, $data, NULL);
        }
    }

    // Show create form
    public function create() {
        if (!$this->hasCreateAccess()) {
            $this->loadThis();
        } else {
            $this->global['pageTitle'] = 'Datacollector : Create Inward Register';
            $this->loadViews("inward_register/create", $this->global, NULL, NULL);
        }
    }

    // Store new inward register
    public function store() {
        if (!$this->hasCreateAccess()) {
            $this->loadThis();
        } else {
            // Set validation rules
            $this->form_validation->set_rules('issue_no', 'Issue No', 'required');
            $this->form_validation->set_rules('issue_date', 'Issue Date', 'required');
            $this->form_validation->set_rules('letter_name', 'Letter Name', 'required');
            $this->form_validation->set_rules('letter_received_date', 'Letter Received Date', 'required');
            $this->form_validation->set_rules('from_whom_received', 'From Whom Received', 'required');
            $this->form_validation->set_rules('received_letter_description', 'Letter Description', 'required');
            $this->form_validation->set_rules('subject', 'Subject', 'required');

            if ($this->form_validation->run() == FALSE) {
                $this->create();
            } else {
                $data = array(
                    'unique_id' => $this->generateUniqueId(),
                    'issue_no' => $this->input->post('issue_no'),
                    'issue_date' => $this->input->post('issue_date'),
                    'letter_name' => $this->input->post('letter_name'),
                    'letter_received_date' => $this->input->post('letter_received_date'),
                    'from_whom_received' => $this->input->post('from_whom_received'),
                    'received_letter_description' => $this->input->post('received_letter_description'),
                    'received_letter_number' => $this->input->post('received_letter_number'),
                    'received_letter_date' => $this->input->post('received_letter_date'),
                    'received_letter_attachment' => $this->input->post('received_letter_attachment'),
                    'reply_to_number' => $this->input->post('reply_to_number'),
                    'reply_to_date' => $this->input->post('reply_to_date'),
                    'our_reply_number' => $this->input->post('our_reply_number'),
                    'our_reply_date' => $this->input->post('our_reply_date'),
                    'forwarded_letter_number' => $this->input->post('forwarded_letter_number'),
                    'forwarded_letter_date' => $this->input->post('forwarded_letter_date'),
                    'subject' => $this->input->post('subject'),
                    'file_number' => $this->input->post('file_number'),
                    'section' => $this->input->post('section'),
                    'signed_date' => $this->input->post('signed_date'),
                    'sent_to' => $this->input->post('sent_to'),
                    'remarks' => $this->input->post('remarks'),
                    'created_by' => $this->vendorId
                );

                if ($this->InwardRegister_model->add_register($data)) {
                    // Log activity
                    $this->Log_model->log_activity($this->module, 'add', json_encode($data), '');
                    redirect('inwardregister');
                } else {
                    $this->session->set_flashdata('error', 'Failed to add inward register');
                    redirect('inwardregister/create');
                }
            }
        }
    }

    // Show edit form
    public function edit($id) {
        if (!$this->hasEditAccess()) {
            $this->loadThis();
        } else {
            $data['register'] = $this->InwardRegister_model->get_register_by_id($id);
            
            if (!$data['register']) {
                show_error('Register not found', 404);
            }

            $this->global['pageTitle'] = 'Datacollector : Edit Inward Register';
            $this->loadViews("inward_register/edit", $this->global, $data, NULL);
        }
    }

    // Update inward register
    public function update($id) {
        if (!$this->hasEditAccess()) {
            $this->loadThis();
        } else {
            // Set validation rules
            $this->form_validation->set_rules('issue_no', 'Issue No', 'required');
            $this->form_validation->set_rules('issue_date', 'Issue Date', 'required');
            $this->form_validation->set_rules('letter_name', 'Letter Name', 'required');
            $this->form_validation->set_rules('letter_received_date', 'Letter Received Date', 'required');
            $this->form_validation->set_rules('from_whom_received', 'From Whom Received', 'required');
            $this->form_validation->set_rules('received_letter_description', 'Letter Description', 'required');
            $this->form_validation->set_rules('subject', 'Subject', 'required');

            if ($this->form_validation->run() == FALSE) {
                $this->edit($id);
            } else {
                $old_data = $this->InwardRegister_model->get_register_by_id($id);

                $data = array(
                    'issue_no' => $this->input->post('issue_no'),
                    'issue_date' => $this->input->post('issue_date'),
                    'letter_name' => $this->input->post('letter_name'),
                    'letter_received_date' => $this->input->post('letter_received_date'),
                    'from_whom_received' => $this->input->post('from_whom_received'),
                    'received_letter_description' => $this->input->post('received_letter_description'),
                    'received_letter_number' => $this->input->post('received_letter_number'),
                    'received_letter_date' => $this->input->post('received_letter_date'),
                    'received_letter_attachment' => $this->input->post('received_letter_attachment'),
                    'reply_to_number' => $this->input->post('reply_to_number'),
                    'reply_to_date' => $this->input->post('reply_to_date'),
                    'our_reply_number' => $this->input->post('our_reply_number'),
                    'our_reply_date' => $this->input->post('our_reply_date'),
                    'forwarded_letter_number' => $this->input->post('forwarded_letter_number'),
                    'forwarded_letter_date' => $this->input->post('forwarded_letter_date'),
                    'subject' => $this->input->post('subject'),
                    'file_number' => $this->input->post('file_number'),
                    'section' => $this->input->post('section'),
                    'signed_date' => $this->input->post('signed_date'),
                    'sent_to' => $this->input->post('sent_to'),
                    'remarks' => $this->input->post('remarks')
                );

                if ($this->InwardRegister_model->update_register($id, $data)) {
                    // Log activity
                    $this->Log_model->log_activity($this->module, 'edit', json_encode($data), json_encode($old_data));
                    redirect('inwardregister');
                } else {
                    $this->session->set_flashdata('error', 'Failed to update inward register');
                    redirect('inwardregister/edit/' . $id);
                }
            }
        }
    }

    // Delete inward register
    public function delete($id) {
        if (!$this->hasDeleteAccess()) {
            $this->loadThis();
        } else {
            $register = $this->InwardRegister_model->get_register_by_id($id);
            
            if (!$register) {
                show_error('Register not found', 404);
            }

            if ($this->InwardRegister_model->delete_register($id)) {
                // Log activity
                $this->Log_model->log_activity($this->module, 'delete', '', json_encode($register));
                redirect('inwardregister');
            } else {
                $this->session->set_flashdata('error', 'Failed to delete inward register');
                redirect('inwardregister');
            }
        }
    }

    // Generate unique ID
    private function generateUniqueId() {
        $last_number = $this->InwardRegister_model->get_last_unique_id();
        $next_number = $last_number + 1;
        return 'IR/' . $next_number;
    }
}
