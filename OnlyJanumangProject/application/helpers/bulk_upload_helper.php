<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Parse CSV file and return array of rows
 */
function parse_csv_file($file_path) {
    $rows = array();
    
    // Set locale to handle UTF-8 characters correctly with fgetcsv
    setlocale(LC_ALL, 'en_US.UTF-8');
    
    // Read file content to detect and convert encoding
    $content = file_get_contents($file_path);
    if ($content === FALSE) return $rows;

    // Check for UTF-8 BOM and remove it
    if (substr($content, 0, 3) === "\xEF\xBB\xBF") {
        $content = substr($content, 3);
    }
    
    // Detect encoding
    $encoding = mb_detect_encoding($content, 'UTF-8, ISO-8859-1, Windows-1252, ASCII', true);
    
    if ($encoding && $encoding !== 'UTF-8') {
        $content = mb_convert_encoding($content, 'UTF-8', $encoding);
    } elseif (!$encoding) {
        // Fallback for cases where detection fails - try to convert from Windows-1252 to UTF-8
        // as it's the most common non-UTF8 encoding from Excel
        $content = mb_convert_encoding($content, 'UTF-8', 'Windows-1252');
    }
    
    // Use a temporary stream to parse the converted content
    $handle = fopen('php://temp', 'r+');
    fwrite($handle, $content);
    rewind($handle);
    
    if ($handle !== FALSE) {
        while (($data = fgetcsv($handle, 0, ',')) !== FALSE) {
            $rows[] = $data;
        }
        fclose($handle);
    }
    
    return $rows;
}

/**
 * Parse XLSX file using built-in XML parsing
 * This extracts cell values from Excel's XML structure
 * Requires ZipArchive extension
 */
function parse_xlsx_file($file_path) {
    $rows = array();
    
    try {
        // Check if ZipArchive is available
        if (!class_exists('ZipArchive')) {
            // Fallback: Try to read as CSV (Excel files saved as CSV)
            return parse_csv_file($file_path);
        }
        
        $zip = new ZipArchive();
        if ($zip->open($file_path) !== TRUE) {
            return array();
        }
        
        // Read the shared strings file (contains all text values)
        $shared_strings = array();
        if ($zip->locateName('xl/sharedStrings.xml') !== false) {
            $xml_data = $zip->getFromName('xl/sharedStrings.xml');
            $xml = simplexml_load_string($xml_data);
            foreach ($xml->si as $string) {
                $shared_strings[] = (string)$string->t;
            }
        }
        
        // Read the worksheet
        $xml_data = $zip->getFromName('xl/worksheets/sheet1.xml');
        $xml = simplexml_load_string($xml_data);
        
        foreach ($xml->sheetData->row as $row) {
            $row_data = array();
            foreach ($row->c as $cell) {
                $value = '';
                
                // Check if it's a shared string reference
                if ((string)$cell['t'] === 's') {
                    $index = (int)$cell->v;
                    $value = isset($shared_strings[$index]) ? $shared_strings[$index] : '';
                } else {
                    // Direct value (number, date, etc.)
                    $value = (string)$cell->v;
                }
                
                $row_data[] = $value;
            }
            $rows[] = $row_data;
        }
        
        $zip->close();
        return $rows;
        
    } catch (Exception $e) {
        // If XLSX parsing fails, return empty
        return array();
    }
}

/**
 * Parse XLS file (older Excel format)
 * For XLS files, we recommend converting to CSV
 */
function parse_xls_file($file_path) {
    // XLS files require additional libraries
    // For now, return empty and ask user to convert to CSV
    return array();
}

/**
 * Detect file type and parse accordingly
 */
function parse_bulk_upload_file($file_path) {
    $file_ext = strtolower(pathinfo($file_path, PATHINFO_EXTENSION));
    
    if ($file_ext === 'csv') {
        return parse_csv_file($file_path);
    } elseif ($file_ext === 'xlsx') {
        return parse_xlsx_file($file_path);
    } elseif ($file_ext === 'xls') {
        return parse_xls_file($file_path);
    }
    
    return array();
}

/**
 * Get ID from name by looking up in database
 * Supports exact match, case-insensitive, and partial match
 * @param $CI CodeIgniter instance
 * @param $table Table name
 * @param $name_field Field name to search
 * @param $name Value to search for
 * @param $filter_field Optional filter field (e.g., panchayatid for village lookup)
 * @param $filter_value Optional filter value
 * @return int|null ID if found, null otherwise
 */
function get_id_by_name(&$CI, $table, $name_field, $name, $filter_field = null, $filter_value = null) {
    if (empty($name)) {
        return null;
    }
    
    $name = trim($name);
    
    // Try exact match first
    $CI->db->reset_query();
    if ($filter_field && $filter_value) {
        $CI->db->where($filter_field, $filter_value);
    }
    $query = $CI->db->where($name_field, $name)->get($table);
    if ($query->num_rows() > 0) {
        $row = $query->row();
        return $row->id;
    }
    
    // Try case-insensitive match
    $CI->db->reset_query();
    if ($filter_field && $filter_value) {
        $CI->db->where($filter_field, $filter_value);
    }
    $query = $CI->db->where("LOWER($name_field) = LOWER('" . $CI->db->escape_str($name) . "')")->get($table);
    if ($query->num_rows() > 0) {
        $row = $query->row();
        return $row->id;
    }
    
    // Try partial match (contains)
    $CI->db->reset_query();
    if ($filter_field && $filter_value) {
        $CI->db->where($filter_field, $filter_value);
    }
    $query = $CI->db->like($name_field, $name, 'both')->get($table);
    if ($query->num_rows() > 0) {
        $row = $query->row();
        return $row->id;
    }
    
    // If still not found and no filter, try without filter (fallback)
    if ($filter_field && $filter_value) {
        $CI->db->reset_query();
        $query = $CI->db->where($name_field, $name)->get($table);
        if ($query->num_rows() > 0) {
            $row = $query->row();
            return $row->id;
        }
    }
    
    return null;
}
?>
