<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class FundSummary_model extends CI_Model {

    /** UNION subquery (jansunwai + districtpublicproblem), no outer filters. */
    private function build_union_subquery_sql()
    {
        $this->db->select("j.id, j.registration_no, j.uname, j.mobile, j.district, 'Jansunwai' as source, j.work_problem, 
                          CASE 
                            WHEN TRIM(j.approved_fund) LIKE 'MLA Swechanudan' THEN 'MLA Sweechanudan'
                            WHEN TRIM(j.approved_fund) LIKE 'MLA Sweechanudan' THEN 'MLA Sweechanudan'
                            WHEN TRIM(j.approved_fund) LIKE 'CLP %' THEN 'CLP Sweechanudan'
                            WHEN TRIM(LOWER(j.approved_fund)) LIKE 'jan%sampark%fund' THEN 'Jansampark Fund'
                            WHEN TRIM(j.approved_fund) LIKE 'जन%संपर्क%' THEN 'Jansampark Fund'
                            WHEN TRIM(j.approved_fund) LIKE 'जन%सम्पर्क%' THEN 'Jansampark Fund'
                            ELSE TRIM(j.approved_fund)
                          END as approved_fund, 
                          j.approximate_cost, j.createdAt as date, j.year, 
                          COALESCE(dist.name, j.district) as district_name, COALESCE(b.name, '') as block_name, COALESCE(p.name, '') as panchayat_name, COALESCE(v.name, '') as village_name, 
                          COALESCE(d.name, '') as department_name, j.work_status, j.booth_no, COALESCE(booth.name, j.booth_name) as booth_name, j.majra_faliya, COALESCE(j.assembly, '') as vidhan_sabha_name,
                          j.work_agency, j.remark, j.address, j.recommended_letter_no");
        $this->db->from('jansunwai j');
        $this->db->join('district dist', 'dist.id = j.district', 'left');
        $this->db->join('block b', 'b.id = j.block', 'left');
        $this->db->join('panchayat p', 'p.id = j.panchayat_name', 'left');
        $this->db->join('village v', 'v.id = j.village', 'left');
        $this->db->join('department d', 'd.id = j.department', 'left');
        $this->db->join('booth', 'booth.id = j.booth_name', 'left');
        $this->db->where('j.approved_fund !=', '');
        $this->db->where('j.approved_fund IS NOT NULL', NULL, FALSE);
        $query1 = $this->db->get_compiled_select();

        $this->db->select("dp.id, dp.registration_no, dp.uname, dp.mobile, dp.district, 'MP Public Problem' as source, dp.work_problem, 
                          CASE 
                            WHEN TRIM(dp.approved_fund) LIKE 'MLA Swechanudan' THEN 'MLA Sweechanudan'
                            WHEN TRIM(dp.approved_fund) LIKE 'MLA Sweechanudan' THEN 'MLA Sweechanudan'
                            WHEN TRIM(dp.approved_fund) LIKE 'CLP %' THEN 'CLP Sweechanudan'
                            WHEN TRIM(LOWER(dp.approved_fund)) LIKE 'jan%sampark%fund' THEN 'Jansampark Fund'
                            WHEN TRIM(dp.approved_fund) LIKE 'जन%संपर्क%' THEN 'Jansampark Fund'
                            WHEN TRIM(dp.approved_fund) LIKE 'जन%सम्पर्क%' THEN 'Jansampark Fund'
                            ELSE TRIM(dp.approved_fund)
                          END as approved_fund, 
                          dp.approximate_cost, dp.createdAt as date, dp.year, 
                          COALESCE(dist.name, dp.district) as district_name, COALESCE(b.name, '') as block_name, COALESCE(p.name, '') as panchayat_name, COALESCE(v.name, '') as village_name, 
                          COALESCE(d.name, '') as department_name, dp.work_status, dp.booth_no, dp.booth_name, dp.majra_faliya, COALESCE(dp.assembly, '') as vidhan_sabha_name,
                          dp.work_agency, dp.remark, dp.address, dp.recommended_letter_no");
        $this->db->from('districtpublicproblem dp');
        $this->db->join('district dist', 'dist.id = dp.district', 'left');
        $this->db->join('block b', 'b.id = dp.block', 'left');
        $this->db->join('panchayat p', 'p.id = dp.panchayat', 'left');
        $this->db->join('village v', 'v.id = dp.village', 'left');
        $this->db->join('department d', 'd.id = dp.department', 'left');
        $this->db->where('dp.approved_fund !=', '');
        $this->db->where('dp.approved_fund IS NOT NULL', NULL, FALSE);
        $query2 = $this->db->get_compiled_select();

        return "({$query1}) UNION ({$query2})";
    }

    /** SELECT * FROM (union) WHERE 1=1 + list filters (no ORDER/LIMIT). */
    private function build_filtered_inner_sql($filters = [])
    {
        $combined_query = $this->build_union_subquery_sql();
        $sql = "SELECT * FROM ({$combined_query}) as combined_funds WHERE 1=1";

        if (!empty($filters['fund_type'])) {
            $sql .= " AND approved_fund = " . $this->db->escape($filters['fund_type']);
        }

        if (!empty($filters['financial_year'])) {
            $fin_year = $filters['financial_year'];
            $parts = explode('-', $fin_year);
            if (count($parts) == 2) {
                $start_year = $parts[0];
                $fin_year_short = $start_year . '-' . substr($parts[1], -2);
                $sql .= " AND (year = " . $this->db->escape($start_year) .
                    " OR year = " . $this->db->escape($fin_year) .
                    " OR year = " . $this->db->escape($fin_year_short) . ")";
            }
        } elseif (!empty($filters['year'])) {
            $sql .= " AND year = " . $this->db->escape($filters['year']);
        }

        if (!empty($filters['from_date'])) {
            $sql .= " AND DATE(date) >= " . $this->db->escape($filters['from_date']);
        }

        if (!empty($filters['to_date'])) {
            $sql .= " AND DATE(date) <= " . $this->db->escape($filters['to_date']);
        }

        if (!empty($filters['work_status'])) {
            $sql .= " AND work_status = " . $this->db->escape($filters['work_status']);
        }

        if (!empty($filters['registration_no'])) {
            $sql .= " AND registration_no LIKE " . $this->db->escape('%' . $filters['registration_no'] . '%');
        }

        return $sql;
    }

    private function append_datatable_search_sql($sql, $search)
    {
        $search = trim((string) $search);
        if ($search === '') {
            return $sql;
        }
        $term = $this->db->escape('%' . $search . '%');
        $sql .= " AND (registration_no LIKE {$term} OR recommended_letter_no LIKE {$term} OR uname LIKE {$term} OR mobile LIKE {$term} OR source LIKE {$term} OR district_name LIKE {$term} OR block_name LIKE {$term} OR panchayat_name LIKE {$term} OR village_name LIKE {$term} OR department_name LIKE {$term} OR work_problem LIKE {$term} OR work_status LIKE {$term} OR approved_fund LIKE {$term} OR work_agency LIKE {$term} OR remark LIKE {$term} OR CAST(year AS CHAR) LIKE {$term} OR vidhan_sabha_name LIKE {$term})";
        return $sql;
    }

    public function count_fund_summary_total()
    {
        $inner = $this->build_filtered_inner_sql([]);
        $q = $this->db->query("SELECT COUNT(*) AS c FROM ({$inner}) AS cnt");
        $row = $q->row_array();
        return (int) ($row['c'] ?? 0);
    }

    public function count_fund_summary_filtered($filters, $search = '')
    {
        $inner = $this->build_filtered_inner_sql($filters);
        $inner = $this->append_datatable_search_sql($inner, $search);
        $q = $this->db->query("SELECT COUNT(*) AS c FROM ({$inner}) AS cnt");
        $row = $q->row_array();
        return (int) ($row['c'] ?? 0);
    }

    public function sum_fund_summary_filtered($filters, $search = '')
    {
        $inner = $this->build_filtered_inner_sql($filters);
        $inner = $this->append_datatable_search_sql($inner, $search);
        $q = $this->db->query("SELECT COALESCE(SUM(approximate_cost), 0) AS s FROM ({$inner}) AS t");
        $row = $q->row_array();
        return (float) ($row['s'] ?? 0);
    }

    public function get_fund_summary_page($filters, $search, $start, $length, $order_col, $order_dir)
    {
        $orderMap = [
            1  => 'registration_no',
            2  => 'recommended_letter_no',
            3  => 'year',
            4  => 'uname',
            5  => 'mobile',
            6  => 'source',
            7  => 'district_name',
            8  => 'block_name',
            9  => 'booth_no',
            10 => 'booth_name',
            11 => 'vidhan_sabha_name',
            12 => 'panchayat_name',
            13 => 'village_name',
            14 => 'majra_faliya',
            15 => 'department_name',
            16 => 'work_problem',
            17 => 'work_status',
            18 => 'approved_fund',
            19 => 'approximate_cost',
            20 => 'work_agency',
            21 => 'remark',
            22 => 'date',
        ];
        $col = isset($orderMap[$order_col]) ? $orderMap[$order_col] : 'date';
        $dir = strtoupper($order_dir) === 'ASC' ? 'ASC' : 'DESC';

        $inner = $this->build_filtered_inner_sql($filters);
        $inner = $this->append_datatable_search_sql($inner, $search);
        $inner .= " ORDER BY `{$col}` {$dir}";
        if ($length > 0) {
            $inner .= " LIMIT " . (int) $length . " OFFSET " . (int) $start;
        }

        $query = $this->db->query($inner);
        return $query->result_array();
    }

    public function get_funds_data($filters = [])
    {
        $sql = $this->build_filtered_inner_sql($filters);
        $sql .= " ORDER BY date DESC";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function get_fund_totals($filters = []) {
        // Shared filter building logic for the inner parts of the union
        $filter_sql = "";
        
        $financial_year = isset($filters['financial_year']) ? $filters['financial_year'] : null;
        if($financial_year) {
            $parts = explode('-', $financial_year);
            if (count($parts) == 2) {
                $start_year = $parts[0];
                $fin_year_short = $start_year . '-' . substr($parts[1], -2);
                
                $filter_sql .= " AND (year = " . $this->db->escape($start_year) . 
                               " OR year = " . $this->db->escape($financial_year) . 
                               " OR year = " . $this->db->escape($fin_year_short) . ")";
            }
        } else if (!empty($filters['year'])) {
            $filter_sql .= " AND year = " . $this->db->escape($filters['year']);
        }
        
        if (!empty($filters['from_date'])) {
            $filter_sql .= " AND DATE(createdAt) >= " . $this->db->escape($filters['from_date']);
        }
        
        if (!empty($filters['to_date'])) {
            $filter_sql .= " AND DATE(createdAt) <= " . $this->db->escape($filters['to_date']);
        }
        
        if (!empty($filters['work_status'])) {
            $filter_sql .= " AND work_status = " . $this->db->escape($filters['work_status']);
        }
        
        if (!empty($filters['registration_no'])) {
            $filter_sql .= " AND registration_no LIKE " . $this->db->escape('%' . $filters['registration_no'] . '%');
        }

        // Subquery for jansunwai with normalization
        $sql1 = "SELECT 
                    CASE 
                        WHEN TRIM(approved_fund) LIKE 'MLA Swechanudan' THEN 'MLA Sweechanudan'
                        WHEN TRIM(approved_fund) LIKE 'MLA Sweechanudan' THEN 'MLA Sweechanudan'
                        WHEN TRIM(approved_fund) LIKE 'CLP %' THEN 'CLP Sweechanudan'
                        WHEN TRIM(LOWER(approved_fund)) LIKE 'jan%sampark%fund' THEN 'Jansampark Fund'
                        WHEN TRIM(approved_fund) LIKE 'जन%संपर्क%' THEN 'Jansampark Fund'
                        WHEN TRIM(approved_fund) LIKE 'जन%सम्पर्क%' THEN 'Jansampark Fund'
                        ELSE TRIM(approved_fund)
                    END as approved_fund, 
                    COALESCE(approximate_cost, 0) as approximate_cost
                FROM jansunwai
                WHERE approved_fund IS NOT NULL AND approved_fund != ''" . $filter_sql;

        // Subquery for districtpublicproblem with normalization
        $sql2 = "SELECT 
                    CASE 
                        WHEN TRIM(approved_fund) LIKE 'MLA Swechanudan' THEN 'MLA Sweechanudan'
                        WHEN TRIM(approved_fund) LIKE 'MLA Sweechanudan' THEN 'MLA Sweechanudan'
                        WHEN TRIM(approved_fund) LIKE 'CLP %' THEN 'CLP Sweechanudan'
                        WHEN TRIM(LOWER(approved_fund)) LIKE 'jan%sampark%fund' THEN 'Jansampark Fund'
                        WHEN TRIM(approved_fund) LIKE 'जन%संपर्क%' THEN 'Jansampark Fund'
                        WHEN TRIM(approved_fund) LIKE 'जन%सम्पर्क%' THEN 'Jansampark Fund'
                        ELSE TRIM(approved_fund)
                    END as approved_fund, 
                    COALESCE(approximate_cost, 0) as approximate_cost
                FROM districtpublicproblem
                WHERE approved_fund IS NOT NULL AND approved_fund != ''" . $filter_sql;
        
        // Combined query - group by normalized names (optional fund_type matches table filter)
        $combined_sql = "SELECT approved_fund, SUM(approximate_cost) as total_used 
                        FROM (({$sql1}) UNION ALL ({$sql2})) as combined 
                        WHERE 1=1";
        if (!empty($filters['fund_type'])) {
            $combined_sql .= " AND approved_fund = " . $this->db->escape($filters['fund_type']);
        }
        $combined_sql .= " GROUP BY approved_fund";
        
        $query = $this->db->query($combined_sql);
        $results = $query->result_array();
        
        $fund_map = [];
        foreach ($results as $row) {
            if ($row['approved_fund']) {
                $fund_map[$row['approved_fund']] = $row['total_used'];
            }
        }
        
        return $fund_map;
    }
}
