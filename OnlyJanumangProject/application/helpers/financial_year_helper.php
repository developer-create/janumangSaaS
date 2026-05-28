<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Financial Year Helper
 * Helper functions for managing financial years (2008-09 to 2026-27)
 */

/**
 * Generate financial years array
 * @param int $start_year - Starting year (default 2008)
 * @param int $end_year - Ending year (default 2027)
 * @return array - Array of financial years in format YYYY-YY
 */
if (!function_exists('get_financial_years')) {
    function get_financial_years($start_year = 2008, $end_year = 2027) {
        $financial_years = [];
        
        for ($year = $start_year; $year < $end_year; $year++) {
            $next_year = substr($year + 1, -2); // Get last 2 digits of next year
            $financial_year = $year . '-' . $next_year;
            $financial_years[$financial_year] = $financial_year;
        }
        
        return $financial_years;
    }
}

/**
 * Get current financial year
 * Financial year starts from April and ends in March
 * @return string - Current financial year in format YYYY-YY
 */
if (!function_exists('get_current_financial_year')) {
    function get_current_financial_year() {
        $current_date = new DateTime();
        $current_month = (int)$current_date->format('m');
        $current_year = (int)$current_date->format('Y');
        
        if ($current_month >= 4) {
            // April onwards - current year is start year
            $start_year = $current_year;
        } else {
            // January to March - previous year is start year
            $start_year = $current_year - 1;
        }
        
        $next_year = substr($start_year + 1, -2);
        return $start_year . '-' . $next_year;
    }
}

/**
 * Convert year and month to financial year
 * @param int $year - Year (e.g., 2025)
 * @param int $month - Month (1-12)
 * @return string - Financial year in format YYYY-YY
 */
if (!function_exists('get_financial_year_from_date')) {
    function get_financial_year_from_date($year, $month) {
        $month = (int)$month;
        $year = (int)$year;
        
        if ($month >= 4) {
            // April onwards - current year is start year
            $start_year = $year;
        } else {
            // January to March - previous year is start year
            $start_year = $year - 1;
        }
        
        $next_year = substr($start_year + 1, -2);
        return $start_year . '-' . $next_year;
    }
}

/**
 * Format amount in Indian numbering system
 * Converts amounts to readable format: Thousand, Ten Thousand, Lakh, Ten Lakh, Crore, Ten Crore
 * @param float $amount - Amount to format
 * @param int $decimals - Number of decimal places (default 2)
 * @return string - Formatted amount with unit
 */
if (!function_exists('format_amount_indian')) {
    function format_amount_indian($amount, $decimals = 2) {
        $amount = (float)$amount;
        
        if ($amount == 0) {
            return '₹0.00';
        }
        
        $abs_amount = abs($amount);
        
        // Define units in Indian numbering system
        $units = array(
            1000000000 => 'Crore',      // 10 Crore = 100 Million
            10000000 => 'Crore',        // 1 Crore = 10 Million
            100000 => 'Lakh',           // 10 Lakh = 1 Million
            10000 => 'Lakh',            // 1 Lakh = 100,000
            1000 => 'Thousand',         // 10 Thousand
            1 => ''
        );
        
        foreach ($units as $divisor => $unit) {
            if ($abs_amount >= $divisor) {
                $formatted = $amount / $divisor;
                $formatted = round($formatted, $decimals);
                
                if ($unit) {
                    return '₹' . number_format($formatted, $decimals) . ' ' . $unit;
                } else {
                    return '₹' . number_format($formatted, $decimals);
                }
            }
        }
        
        return '₹' . number_format($amount, $decimals);
    }
}

/**
 * Format amount in short Indian format
 * Converts amounts to short readable format: K, L, Cr
 * @param float $amount - Amount to format
 * @param int $decimals - Number of decimal places (default 1)
 * @return string - Formatted amount with short unit
 */
if (!function_exists('format_amount_short')) {
    function format_amount_short($amount, $decimals = 1) {
        $amount = (float)$amount;
        
        if ($amount == 0) {
            return '₹0';
        }
        
        $abs_amount = abs($amount);
        
        // Define short units
        if ($abs_amount >= 10000000) {
            $formatted = $amount / 10000000;
            return '₹' . round($formatted, $decimals) . 'Cr';
        } elseif ($abs_amount >= 100000) {
            $formatted = $amount / 100000;
            return '₹' . round($formatted, $decimals) . 'L';
        } elseif ($abs_amount >= 1000) {
            $formatted = $amount / 1000;
            return '₹' . round($formatted, $decimals) . 'K';
        }
        
        return '₹' . number_format($amount, 0);
    }
}

/**
 * Format amount as numeric value only (without currency symbol and unit)
 * @param float $amount - Amount to format
 * @param int $decimals - Number of decimal places (default 2)
 * @return string - Formatted numeric amount
 */
if (!function_exists('format_amount_numeric')) {
    function format_amount_numeric($amount, $decimals = 2) {
        $amount = (float)$amount;
        
        if ($amount == 0) {
            return '0.00';
        }
        
        $abs_amount = abs($amount);
        
        // Define units in Indian numbering system
        $units = array(
            1000000000 => 1000000000,
            10000000 => 10000000,
            100000 => 100000,
            10000 => 10000,
            1000 => 1000,
            1 => 1
        );
        
        foreach ($units as $divisor => $value) {
            if ($abs_amount >= $divisor) {
                $formatted = $amount / $divisor;
                $formatted = round($formatted, $decimals);
                return number_format($formatted, $decimals);
            }
        }
        
        return number_format($amount, $decimals);
    }
}

/**
 * Get amount unit only (Lakh, Crore, etc.)
 * @param float $amount - Amount to get unit for
 * @return string - Unit name (Lakh, Crore, Thousand, or empty string)
 */
if (!function_exists('get_amount_unit')) {
    function get_amount_unit($amount) {
        $amount = (float)$amount;
        
        if ($amount == 0) {
            return '';
        }
        
        $abs_amount = abs($amount);
        
        // Define units in Indian numbering system
        $units = array(
            1000000000 => 'Crore',
            10000000 => 'Crore',
            100000 => 'Lakh',
            10000 => 'Lakh',
            1000 => 'Thousand',
            1 => ''
        );
        
        foreach ($units as $divisor => $unit) {
            if ($abs_amount >= $divisor) {
                return $unit;
            }
        }
        
        return '';
    }
}

/**
 * Format amount with word (number + unit, without currency symbol)
 * Similar to format_amount_indian but without the ₹ symbol
 * @param float $amount - Amount to format
 * @param int $decimals - Number of decimal places (default 2)
 * @return string - Formatted amount with unit (e.g., "2.50 Crore", "25.00 Lakh")
 */
if (!function_exists('format_amount_word')) {
    function format_amount_word($amount, $decimals = 2) {
        $amount = (float)$amount;
        
        if ($amount == 0) {
            return '0.00';
        }
        
        $abs_amount = abs($amount);
        
        // Define units in Indian numbering system
        $units = array(
            1000000000 => 'Crore',      // 10 Crore = 100 Million
            10000000 => 'Crore',        // 1 Crore = 10 Million
            100000 => 'Lakh',           // 10 Lakh = 1 Million
            10000 => 'Lakh',            // 1 Lakh = 100,000
            1000 => 'Thousand',         // 10 Thousand
            1 => ''
        );
        
        foreach ($units as $divisor => $unit) {
            if ($abs_amount >= $divisor) {
                $formatted = $amount / $divisor;
                $formatted = round($formatted, $decimals);
                
                if ($unit) {
                    return number_format($formatted, $decimals) . ' ' . $unit;
                } else {
                    return number_format($formatted, $decimals);
                }
            }
        }
        
        return number_format($amount, $decimals);
    }
}
?>
