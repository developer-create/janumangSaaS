<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class FundSummary extends BaseController {

    public function __construct() {
        parent::__construct();
        $this->load->model('FundSummary_model');
        $this->load->model('Fund_budget_model');
        $this->load->helper(['financial_year', 'fund_budget']);
        $this->isLoggedIn();
    }

    public function index() {
        // First visit with no query string: default to current FY so cards/table match (YYYY-YYYY like dropdown)
        $fy = $this->input->get('financial_year');
        if (empty($fy)) {
            $default_fy = '2026-2027';
            redirect('fundSummary?financial_year=' . rawurlencode($default_fy));
            return;
        }

        $filters = [
            'fund_type' => trim((string) $this->input->get('fund_type')),
            'financial_year' => trim((string) $this->input->get('financial_year')),
            'from_date' => trim((string) $this->input->get('from_date')),
            'to_date' => trim((string) $this->input->get('to_date')),
            'work_status' => trim((string) $this->input->get('work_status')),
            'registration_no' => trim((string) $this->input->get('registration_no')),
        ];

        // Get current financial year (April to March) — full year end for display (YYYY-YYYY)
        $current_month = date('n');
        $current_year = (int) date('Y');
        if ($current_month < 4) {
            $current_fy = ($current_year - 1) . '-' . $current_year;
        } else {
            $current_fy = $current_year . '-' . ($current_year + 1);
        }

        // Table rows load via AJAX (fundSummary/data); keep optional full data for exports if needed
        $data['funds_data'] = [];

        // Get totals for the selected filters (summary cards) — same FY + fund_type as table
        $data['used_totals'] = $this->FundSummary_model->get_fund_totals($filters);
        
        if (!empty($filters['financial_year'])) {
            $fy_canonical = canonicalize_financial_year_for_budget($filters['financial_year']);
            $db_limits = $this->Fund_budget_model->get_limits_map_for_fy($fy_canonical);
            $defaults = [
                'MLA FUND' => 25000000,
                'MLA Sweechanudan' => 7500000,
                'CLP Sweechanudan' => 10000000,
                'Jansampark Fund' => 200000,
            ];
            $data['fund_limits'] = [];
            foreach ($defaults as $k => $def) {
                $data['fund_limits'][$k] = isset($db_limits[$k]) ? $db_limits[$k] : $def;
            }
            $data['card_mode_all_fy'] = false;
        } else {
            $data['fund_limits'] = null;
            $data['card_mode_all_fy'] = true;
        }

        $data['filters'] = $filters;
        $data['current_fy'] = $current_fy;
        $data['display_fy_title'] = !empty($filters['financial_year']) ? $filters['financial_year'] : 'All FY';
        $data['card_subtitle'] = !empty($filters['financial_year'])
            ? 'Cards and table use the same filters'
            : 'Used amounts are across all years; select a financial year to compare with budget';
        $this->global['pageTitle'] = 'Jan Umang : Approved Fund Summary';
        
        $this->loadViews("fund_summary/index", $this->global, $data, NULL);
    }

    public function data()
    {
        $request = $_REQUEST;
        $filters = [
            'fund_type' => isset($request['filter_fund_type']) ? trim((string) $request['filter_fund_type']) : '',
            'financial_year' => isset($request['filter_financial_year']) ? trim((string) $request['filter_financial_year']) : '',
            'from_date' => isset($request['filter_from_date']) ? trim((string) $request['filter_from_date']) : '',
            'to_date' => isset($request['filter_to_date']) ? trim((string) $request['filter_to_date']) : '',
            'work_status' => isset($request['filter_work_status']) ? trim((string) $request['filter_work_status']) : '',
            'registration_no' => isset($request['filter_registration_no']) ? trim((string) $request['filter_registration_no']) : '',
        ];

        $search = isset($request['search']['value']) ? $request['search']['value'] : '';
        $start = isset($request['start']) ? (int) $request['start'] : 0;
        $length = isset($request['length']) ? (int) $request['length'] : 20;

        $orderCol = 22;
        $orderDir = 'desc';
        if (!empty($request['order'][0])) {
            $orderCol = (int) $request['order'][0]['column'];
            $orderDir = isset($request['order'][0]['dir']) ? $request['order'][0]['dir'] : 'desc';
        }
        if ($orderCol === 0) {
            $orderCol = 22;
        }

        $recordsTotal = $this->FundSummary_model->count_fund_summary_total();
        $recordsFiltered = $this->FundSummary_model->count_fund_summary_filtered($filters, $search);
        $sumFiltered = $this->FundSummary_model->sum_fund_summary_filtered($filters, $search);

        $pageLen = $length > 0 ? $length : 1000000;
        $rows = $this->FundSummary_model->get_fund_summary_page($filters, $search, $start, $pageLen, $orderCol, $orderDir);

        $out = [];
        $i = $start + 1;
        foreach ($rows as $row) {
            $display_year = $row['year'] ?? '';
            if (strlen((string) $display_year) === 4 && is_numeric($display_year)) {
                $next_year = (int) $display_year + 1;
                $display_year = $display_year . '-' . substr((string) $next_year, -2);
            }

            $ws = (string) ($row['work_status'] ?? '');
            if ($ws === 'Reject') {
                $statusHtml = '<span class="label label-default" style="background-color:#d73925;color:white;">' . htmlspecialchars($ws) . '</span>';
            } else {
                $status_class = 'label-default';
                if ($ws === 'Complete') {
                    $status_class = 'label-success';
                } elseif ($ws === 'In progress') {
                    $status_class = 'label-warning';
                } elseif ($ws === 'Incomplete') {
                    $status_class = 'label-danger';
                }
                $statusHtml = '<span class="label ' . $status_class . '">' . htmlspecialchars($ws) . '</span>';
            }

            $src = $row['source'] ?? '';
            $srcClass = ($src === 'Jansunwai') ? 'label-info' : 'label-warning';
            $sourceHtml = '<span class="label ' . $srcClass . '">' . htmlspecialchars((string) $src) . '</span>';

            $dateStr = '';
            if (!empty($row['date'])) {
                $dateStr = date('d-m-Y', strtotime($row['date']));
            }

            $cost = isset($row['approximate_cost']) ? (float) $row['approximate_cost'] : 0;

            $out[] = [
                $i++,
                htmlspecialchars((string) ($row['registration_no'] ?? '')),
                htmlspecialchars((string) (($row['recommended_letter_no'] ?? '') !== '' ? $row['recommended_letter_no'] : '-')),
                htmlspecialchars((string) $display_year),
                htmlspecialchars((string) ($row['uname'] ?? '')),
                htmlspecialchars((string) ($row['mobile'] ?? '')),
                $sourceHtml,
                htmlspecialchars((string) (($row['district_name'] ?? '') !== '' ? $row['district_name'] : '-')),
                htmlspecialchars((string) (($row['block_name'] ?? '') !== '' ? $row['block_name'] : '-')),
                htmlspecialchars((string) (($row['booth_no'] ?? '') !== '' ? $row['booth_no'] : '-')),
                htmlspecialchars((string) (($row['booth_name'] ?? '') !== '' ? $row['booth_name'] : '-')),
                htmlspecialchars((string) (($row['vidhan_sabha_name'] ?? '') !== '' ? $row['vidhan_sabha_name'] : '-')),
                htmlspecialchars((string) (($row['panchayat_name'] ?? '') !== '' ? $row['panchayat_name'] : '-')),
                htmlspecialchars((string) (($row['village_name'] ?? '') !== '' ? $row['village_name'] : '-')),
                htmlspecialchars((string) (($row['majra_faliya'] ?? '') !== '' ? $row['majra_faliya'] : '-')),
                htmlspecialchars((string) (($row['department_name'] ?? '') !== '' ? $row['department_name'] : '-')),
                htmlspecialchars((string) (($row['work_problem'] ?? '') !== '' ? $row['work_problem'] : '-')),
                $statusHtml,
                htmlspecialchars((string) ($row['approved_fund'] ?? '')),
                '₹' . number_format($cost, 2),
                htmlspecialchars((string) (($row['work_agency'] ?? '') !== '' ? $row['work_agency'] : '-')),
                htmlspecialchars((string) (($row['remark'] ?? '') !== '' ? $row['remark'] : '-')),
                $dateStr,
            ];
        }

        $this->output->set_content_type('application/json')->set_output(json_encode([
            'draw' => (int) ($request['draw'] ?? 0),
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data' => $out,
            'sumFiltered' => $sumFiltered,
        ]));
    }
}
