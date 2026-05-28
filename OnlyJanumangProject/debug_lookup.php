<?php
// Load CodeIgniter
define('BASEPATH', dirname(__FILE__) . '/system/');
require_once 'system/core/CodeIgniter.php';

$CI =& get_instance();

echo "=== PANCHAYAT LOOKUP TEST ===\n";
$panchayat_name = "चाकलपया";
$query = $CI->db->where('name', $panchayat_name)->get('panchayat');
echo "Exact match for '$panchayat_name': " . $query->num_rows() . " rows\n";
if ($query->num_rows() > 0) {
    $row = $query->row();
    echo "Found ID: " . $row->id . "\n";
}

echo "\n=== VILLAGE LOOKUP TEST ===\n";
$village_name = "देसाई";
$query = $CI->db->where('name', $village_name)->get('village');
echo "Exact match for '$village_name': " . $query->num_rows() . " rows\n";
if ($query->num_rows() > 0) {
    $row = $query->row();
    echo "Found ID: " . $row->id . ", panchayatid: " . $row->panchayatid . "\n";
}

echo "\n=== ALL PANCHAYATS (first 10) ===\n";
$query = $CI->db->limit(10)->get('panchayat');
foreach ($query->result() as $row) {
    echo "ID: " . $row->id . " - Name: " . $row->name . "\n";
}

echo "\n=== ALL VILLAGES (first 10) ===\n";
$query = $CI->db->limit(10)->get('village');
foreach ($query->result() as $row) {
    echo "ID: " . $row->id . " - Name: " . $row->name . " - panchayatid: " . $row->panchayatid . "\n";
}
?>
