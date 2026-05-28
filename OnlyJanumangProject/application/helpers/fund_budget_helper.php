<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Normalize approved_fund text to the same labels used in FundSummary_model (SQL CASE).
 * Returns one of the four tracked keys, or null if not a tracked fund.
 */
if (!function_exists('normalize_approved_fund_name')) {
    function normalize_approved_fund_name($raw)
    {
        $t = trim((string) $raw);
        if ($t === '') {
            return null;
        }
        $lt = strtolower($t);
        if (preg_match('/^MLA\s*FUND$/i', $t)) {
            return 'MLA FUND';
        }
        if (stripos($t, 'MLA Swechanudan') !== false || stripos($t, 'MLA Sweechanudan') !== false) {
            return 'MLA Sweechanudan';
        }
        if (preg_match('/^CLP\s/i', $t)) {
            return 'CLP Sweechanudan';
        }
        if (strpos($lt, 'jansampark') !== false && strpos($lt, 'fund') !== false) {
            return 'Jansampark Fund';
        }
        if (preg_match('/जन.*संपर्क/u', $t) || preg_match('/जन.*सम्पर्क/u', $t)) {
            return 'Jansampark Fund';
        }
        return null;
    }
}

/**
 * Financial year as YYYY-YY (matches get_financial_years / jansunwai form).
 */
if (!function_exists('canonicalize_financial_year_for_budget')) {
    function canonicalize_financial_year_for_budget($y)
    {
        $y = trim((string) $y);
        if ($y === '') {
            return '';
        }
        if (preg_match('/^(\d{4})-(\d{2})$/', $y, $m)) {
            return $m[1] . '-' . $m[2];
        }
        if (preg_match('/^(\d{4})-(\d{4})$/', $y, $m)) {
            return $m[1] . '-' . substr($m[2], -2);
        }
        if (preg_match('/^(\d{4})$/', $y, $m)) {
            $sy = (int) $m[1];
            return $sy . '-' . substr((string) ($sy + 1), -2);
        }
        return $y;
    }
}

if (!function_exists('resolve_approved_fund_post')) {
    function resolve_approved_fund_post($approved_fund, $approved_fund_other)
    {
        $approved_fund = trim((string) $approved_fund);
        if ($approved_fund === 'others') {
            $o = trim((string) $approved_fund_other);
            return $o !== '' ? $o : 'others';
        }
        return $approved_fund;
    }
}
