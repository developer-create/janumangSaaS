<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Fund_budget_model extends CI_Model {

    /** Keys used in fund summary / DB (must match FundSummary_model normalization). */
    public $tracked_fund_keys = [
        'MLA FUND',
        'MLA Sweechanudan',
        'CLP Sweechanudan',
        'Jansampark Fund',
    ];

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('fund_budget');
    }

    public function get_all_rows()
    {
        $this->db->order_by('financial_year', 'DESC');
        $this->db->order_by('fund_key', 'ASC');
        return $this->db->get('fund_budget_limits')->result_array();
    }

    public function get_by_id($id)
    {
        return $this->db->get_where('fund_budget_limits', ['id' => (int) $id])->row_array();
    }

    public function get_limit_row($financial_year, $fund_key)
    {
        return $this->db->get_where('fund_budget_limits', [
            'financial_year' => $financial_year,
            'fund_key' => $fund_key,
        ])->row_array();
    }

    /**
     * Map fund_key => total_amount for one FY (only rows that exist).
     */
    public function get_limits_map_for_fy($financial_year)
    {
        $this->db->where('financial_year', $financial_year);
        $q = $this->db->get('fund_budget_limits');
        $map = [];
        foreach ($q->result_array() as $row) {
            $map[$row['fund_key']] = (float) $row['total_amount'];
        }
        return $map;
    }

    public function insert_row($data)
    {
        $data['created_at'] = date('Y-m-d H:i:s');
        return $this->db->insert('fund_budget_limits', $data);
    }

    public function update_row($id, $data)
    {
        $data['updated_at'] = date('Y-m-d H:i:s');
        $this->db->where('id', (int) $id);
        return $this->db->update('fund_budget_limits', $data);
    }

    public function delete_row($id)
    {
        $this->db->where('id', (int) $id);
        return $this->db->delete('fund_budget_limits');
    }

    private function fund_case_expr($col)
    {
        return "CASE 
            WHEN TRIM($col) LIKE 'MLA Swechanudan' THEN 'MLA Sweechanudan'
            WHEN TRIM($col) LIKE 'MLA Sweechanudan' THEN 'MLA Sweechanudan'
            WHEN TRIM($col) LIKE 'CLP %' THEN 'CLP Sweechanudan'
            WHEN TRIM(LOWER($col)) LIKE 'jan%sampark%fund' THEN 'Jansampark Fund'
            WHEN TRIM($col) LIKE 'जन%संपर्क%' THEN 'Jansampark Fund'
            WHEN TRIM($col) LIKE 'जन%सम्पर्क%' THEN 'Jansampark Fund'
            ELSE TRIM($col)
        END";
    }

    private function year_where_sql($tableAlias, $financial_year)
    {
        $parts = explode('-', $financial_year);
        if (count($parts) !== 2) {
            return '';
        }
        $start_year = $parts[0];
        $fin_year_short = $start_year . '-' . substr($parts[1], -2);
        $y = $tableAlias . '.year';
        return " AND ({$y} = " . $this->db->escape($start_year) .
            " OR {$y} = " . $this->db->escape($financial_year) .
            " OR {$y} = " . $this->db->escape($fin_year_short) . ')';
    }

    /**
     * Sum approximate_cost for normalized fund across jansunwai + districtpublicproblem.
     *
     * @param string|null $exclude_table 'jansunwai' or 'districtpublicproblem'
     */
    public function sum_spent_for_fund_year($normalized_fund, $financial_year, $exclude_table = null, $exclude_id = null)
    {
        $case_j = $this->fund_case_expr('j.approved_fund');
        $yw_j = $this->year_where_sql('j', $financial_year);
        $ex_j = '';
        if ($exclude_table === 'jansunwai' && $exclude_id) {
            $ex_j = ' AND j.id != ' . (int) $exclude_id;
        }

        $case_dp = $this->fund_case_expr('dp.approved_fund');
        $yw_dp = $this->year_where_sql('dp', $financial_year);
        $ex_dp = '';
        if ($exclude_table === 'districtpublicproblem' && $exclude_id) {
            $ex_dp = ' AND dp.id != ' . (int) $exclude_id;
        }

        $nf = $this->db->escape($normalized_fund);

        $sql = "SELECT COALESCE(SUM(s.approximate_cost), 0) AS s FROM (
            SELECT j.approximate_cost, {$case_j} AS nf
            FROM jansunwai j
            WHERE j.approved_fund IS NOT NULL AND TRIM(j.approved_fund) != ''{$yw_j}{$ex_j}
            UNION ALL
            SELECT dp.approximate_cost, {$case_dp} AS nf
            FROM districtpublicproblem dp
            WHERE dp.approved_fund IS NOT NULL AND TRIM(dp.approved_fund) != ''{$yw_dp}{$ex_dp}
        ) s WHERE s.nf = {$nf}";

        $q = $this->db->query($sql);
        $row = $q->row_array();
        return (float) ($row['s'] ?? 0);
    }

    /**
     * @return array{ok:bool,message:string,spent:float,limit:float|null}
     */
    public function check_budget($normalized_fund, $financial_year_canonical, $new_amount, $exclude_table = null, $exclude_id = null)
    {
        $row = $this->get_limit_row($financial_year_canonical, $normalized_fund);
        if (empty($row)) {
            return [
                'ok' => true,
                'message' => '',
                'spent' => $this->sum_spent_for_fund_year($normalized_fund, $financial_year_canonical, $exclude_table, $exclude_id),
                'limit' => null,
                'skipped' => true,
            ];
        }

        $limit = (float) $row['total_amount'];
        $spent = $this->sum_spent_for_fund_year($normalized_fund, $financial_year_canonical, $exclude_table, $exclude_id);
        $remaining = $limit - $spent;

        if ($spent + (float) $new_amount > $limit + 0.00001) {
            return [
                'ok' => false,
                'message' => 'इस वित्तीय वर्ष के लिए कुल बजट ₹' . number_format($limit, 2) . ' है। पहले से उपयोग: ₹' . number_format($spent, 2) . '। शेष धनराशि: ₹' . number_format($remaining, 2) . '। नई राशि ₹' . number_format((float) $new_amount, 2) . ' जोड़ने पर सीमा पार हो जाएगी। कृपया राशि कम करें या मास्टर में बजट बढ़ाएं।',
                'spent' => $spent,
                'limit' => $limit,
                'remaining' => $remaining,
                'skipped' => false,
            ];
        }

        return [
            'ok' => true,
            'message' => '',
            'spent' => $spent,
            'limit' => $limit,
            'skipped' => false,
        ];
    }
}
