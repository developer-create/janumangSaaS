<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class FundBudget extends BaseController {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Fund_budget_model');
        $this->load->helper(['form', 'url', 'financial_year', 'fund_budget']);
        $this->load->library('form_validation');
        $this->isLoggedIn();
        $this->module = 'Fund-Budget-Limits';
    }

    public function index()
    {
        if (!$this->hasListAccess()) {
            $this->loadThis();
            return;
        }
        $data['rows'] = $this->Fund_budget_model->get_all_rows();
        $data['fund_labels'] = [
            'MLA FUND' => 'MLA FUND',
            'MLA Sweechanudan' => 'Swecha Nidhi',
            'CLP Sweechanudan' => 'CLP Fund',
            'Jansampark Fund' => 'Jansampark Fund',
        ];
        $this->global['pageTitle'] = 'Jan Umang : Fund Budget Limits';
        $this->loadViews('fund_budget/index', $this->global, $data, null);
    }

    public function add()
    {
        if (!$this->hasCreateAccess()) {
            $this->loadThis();
            return;
        }
        $data['financial_years'] = get_financial_years(2008, 2035);
        $data['fund_keys'] = $this->Fund_budget_model->tracked_fund_keys;
        $data['fund_labels'] = [
            'MLA FUND' => 'MLA FUND',
            'MLA Sweechanudan' => 'Swecha Nidhi (MLA Swechanudan)',
            'CLP Sweechanudan' => 'CLP Fund (CLP Swechanudan)',
            'Jansampark Fund' => 'Jansampark Fund',
        ];
        $this->global['pageTitle'] = 'Jan Umang : Add Fund Budget Limit';
        $this->loadViews('fund_budget/add', $this->global, $data, null);
    }

    public function save()
    {
        if (!$this->hasCreateAccess()) {
            $this->loadThis();
            return;
        }
        $this->form_validation->set_rules('financial_year', 'Financial Year', 'required|trim');
        $this->form_validation->set_rules('fund_key', 'Fund', 'required|trim');
        $this->form_validation->set_rules('total_amount', 'Total Amount', 'required|numeric');

        if ($this->form_validation->run() === false) {
            $this->add();
            return;
        }

        $fy = canonicalize_financial_year_for_budget($this->input->post('financial_year'));
        $fund_key = $this->input->post('fund_key');
        if (!in_array($fund_key, $this->Fund_budget_model->tracked_fund_keys, true)) {
            $this->session->set_flashdata('error', 'Invalid fund.');
            redirect('fundBudget/add');
            return;
        }

        $existing = $this->Fund_budget_model->get_limit_row($fy, $fund_key);
        if (!empty($existing)) {
            $this->session->set_flashdata('error', 'इस वित्तीय वर्ष और फंड के लिए पहले से रिकॉर्ड है। एडिट करें।');
            redirect('fundBudget/add');
            return;
        }

        $insert = [
            'financial_year' => $fy,
            'fund_key' => $fund_key,
            'total_amount' => (float) $this->input->post('total_amount'),
        ];

        if ($this->Fund_budget_model->insert_row($insert)) {
            $id = $this->db->insert_id();
            $this->logActivity('add', 'fund_budget_limits', $id, $insert, null, 'Fund budget limit created');
            $this->session->set_flashdata('success', 'बजट सीमा सेव हो गई।');
        } else {
            $this->session->set_flashdata('error', 'सेव करने में त्रुटि।');
        }
        redirect('fundBudget');
    }

    public function edit($id)
    {
        if (!$this->hasUpdateAccess()) {
            $this->loadThis();
            return;
        }
        $row = $this->Fund_budget_model->get_by_id($id);
        if (empty($row)) {
            $this->session->set_flashdata('error', 'रिकॉर्ड नहीं मिला।');
            redirect('fundBudget');
            return;
        }
        $data['row'] = $row;
        $data['financial_years'] = get_financial_years(2008, 2035);
        $data['fund_keys'] = $this->Fund_budget_model->tracked_fund_keys;
        $data['fund_labels'] = [
            'MLA FUND' => 'MLA FUND',
            'MLA Sweechanudan' => 'Swecha Nidhi (MLA Swechanudan)',
            'CLP Sweechanudan' => 'CLP Fund (CLP Swechanudan)',
            'Jansampark Fund' => 'Jansampark Fund',
        ];
        $this->global['pageTitle'] = 'Jan Umang : Edit Fund Budget Limit';
        $this->loadViews('fund_budget/edit', $this->global, $data, null);
    }

    public function update()
    {
        if (!$this->hasUpdateAccess()) {
            $this->loadThis();
            return;
        }
        $id = (int) $this->input->post('id');
        $this->form_validation->set_rules('id', 'ID', 'required|integer');
        $this->form_validation->set_rules('financial_year', 'Financial Year', 'required|trim');
        $this->form_validation->set_rules('fund_key', 'Fund', 'required|trim');
        $this->form_validation->set_rules('total_amount', 'Total Amount', 'required|numeric');

        if ($this->form_validation->run() === false) {
            $this->edit($id);
            return;
        }

        $old = $this->Fund_budget_model->get_by_id($id);
        if (empty($old)) {
            $this->session->set_flashdata('error', 'रिकॉर्ड नहीं मिला।');
            redirect('fundBudget');
            return;
        }

        $fy = canonicalize_financial_year_for_budget($this->input->post('financial_year'));
        $fund_key = $this->input->post('fund_key');
        if (!in_array($fund_key, $this->Fund_budget_model->tracked_fund_keys, true)) {
            $this->session->set_flashdata('error', 'Invalid fund.');
            redirect('fundBudget/edit/' . $id);
            return;
        }

        $dup = $this->Fund_budget_model->get_limit_row($fy, $fund_key);
        if (!empty($dup) && (int) $dup['id'] !== $id) {
            $this->session->set_flashdata('error', 'यह वित्तीय वर्ष + फंड पहले से मौजूद है।');
            redirect('fundBudget/edit/' . $id);
            return;
        }

        $data = [
            'financial_year' => $fy,
            'fund_key' => $fund_key,
            'total_amount' => (float) $this->input->post('total_amount'),
        ];

        if ($this->Fund_budget_model->update_row($id, $data)) {
            $this->logActivity('edit', 'fund_budget_limits', $id, $data, $old, 'Fund budget limit updated');
            $this->session->set_flashdata('success', 'अपडेट सफल।');
        } else {
            $this->session->set_flashdata('error', 'अपडेट विफल।');
        }
        redirect('fundBudget');
    }

    public function delete($id)
    {
        if (!$this->hasDeleteAccess()) {
            $this->loadThis();
            return;
        }
        $id = (int) $id;
        $old = $this->Fund_budget_model->get_by_id($id);
        if (empty($old)) {
            $this->session->set_flashdata('error', 'रिकॉर्ड नहीं मिला।');
            redirect('fundBudget');
            return;
        }
        if ($this->Fund_budget_model->delete_row($id)) {
            $this->logActivity('delete', 'fund_budget_limits', $id, null, $old, 'Fund budget limit deleted');
            $this->session->set_flashdata('success', 'डिलीट हो गया।');
        } else {
            $this->session->set_flashdata('error', 'डिलीट विफल।');
        }
        redirect('fundBudget');
    }
}
