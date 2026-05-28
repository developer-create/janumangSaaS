<?php
/**
 * Debug script to check village dropdown issue
 * 
 * This script helps diagnose why villages are not showing in the dropdown
 * 
 * Usage: Place this file in the root directory and access via browser:
 * http://localhost/marchjanumang/debug_village_dropdown.php
 */

// Load CodeIgniter
require_once('index.php');

// Get CI instance
$CI =& get_instance();
$CI->load->database();
$CI->load->model('Booth_model');

echo "<h1>Village Dropdown Debug Report</h1>";
echo "<hr>";

// Test 1: Check if village table has data
echo "<h2>Test 1: Village Table Data</h2>";
$village_count = $CI->db->count_all('village');
echo "<p>Total villages in database: <strong>$village_count</strong></p>";

if ($village_count > 0) {
    echo "<p style='color: green;'>✓ Village table has data</p>";
    
    // Show sample villages
    $sample_villages = $CI->db->limit(5)->get('village')->result_array();
    echo "<h3>Sample Villages (first 5):</h3>";
    echo "<table border='1' cellpadding='5' cellspacing='0'>";
    echo "<tr><th>ID</th><th>Name</th><th>Panchayat ID</th><th>Booth ID</th><th>Block ID</th></tr>";
    foreach ($sample_villages as $village) {
        echo "<tr>";
        echo "<td>{$village['id']}</td>";
        echo "<td>{$village['name']}</td>"; 
        echo "<td>{$village['panchayatid']}</td>";
        echo "<td>{$village['boothid']}</td>";
        echo "<td>{$village['blockid']}</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p style='color: red;'>✗ Village table is empty! You need to add villages to the database.</p>";
}

echo "<hr>";

// Test 2: Check panchayat table
echo "<h2>Test 2: Panchayat Table Data</h2>";
$panchayat_count = $CI->db->count_all('panchayat');
echo "<p>Total panchayats in database: <strong>$panchayat_count</strong></p>";

if ($panchayat_count > 0) {
    echo "<p style='color: green;'>✓ Panchayat table has data</p>";
    
    // Show sample panchayats
    $sample_panchayats = $CI->db->limit(5)->get('panchayat')->result_array();
    echo "<h3>Sample Panchayats (first 5):</h3>";
    echo "<table border='1' cellpadding='5' cellspacing='0'>";
    echo "<tr><th>ID</th><th>Name</th><th>Booth ID</th><th>Block ID</th></tr>";
    foreach ($sample_panchayats as $panchayat) {
        echo "<tr>";
        echo "<td>{$panchayat['id']}</td>";
        echo "<td>{$panchayat['name']}</td>";
        echo "<td>{$panchayat['boothid']}</td>";
        echo "<td>{$panchayat['blockid']}</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p style='color: red;'>✗ Panchayat table is empty!</p>";
}

echo "<hr>";

// Test 3: Check village-panchayat relationship
echo "<h2>Test 3: Village-Panchayat Relationship</h2>";

if ($panchayat_count > 0 && $village_count > 0) {
    // Get first panchayat
    $first_panchayat = $CI->db->limit(1)->get('panchayat')->row_array();
    $panchayat_id = $first_panchayat['id'];
    $panchayat_name = $first_panchayat['name'];
    
    echo "<p>Testing with Panchayat: <strong>$panchayat_name (ID: $panchayat_id)</strong></p>";
    
    // Get villages for this panchayat using the model method
    $villages = $CI->Booth_model->getvillageBypanchayat($panchayat_id);
    
    echo "<p>Villages found for this panchayat: <strong>" . count($villages) . "</strong></p>";
    
    if (count($villages) > 0) {
        echo "<p style='color: green;'>✓ Village-Panchayat relationship is working</p>";
        echo "<h3>Villages for Panchayat '$panchayat_name':</h3>";
        echo "<table border='1' cellpadding='5' cellspacing='0'>";
        echo "<tr><th>ID</th><th>Name</th><th>Panchayat ID</th></tr>";
        foreach ($villages as $village) {
            echo "<tr>";
            echo "<td>{$village['id']}</td>";
            echo "<td>{$village['name']}</td>";
            echo "<td>{$village['panchayatid']}</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p style='color: orange;'>⚠ No villages found for this panchayat. Try checking if villages have correct panchayatid values.</p>";
        
        // Check if there are any villages with NULL or 0 panchayatid
        $orphan_villages = $CI->db->where('panchayatid', 0)
                                   ->or_where('panchayatid', NULL)
                                   ->get('village')
                                   ->result_array();
        
        if (count($orphan_villages) > 0) {
            echo "<p style='color: red;'>✗ Found " . count($orphan_villages) . " villages with invalid panchayatid (0 or NULL)</p>";
        }
    }
} else {
    echo "<p style='color: red;'>✗ Cannot test relationship - missing data in panchayat or village tables</p>";
}

echo "<hr>";

// Test 4: Test AJAX endpoint directly
echo "<h2>Test 4: AJAX Endpoint Test</h2>";
echo "<p>The AJAX endpoint is: <code>panchayat/getvillageBypanchayat</code></p>";
echo "<p>You can test it manually by:</p>";
echo "<ol>";
echo "<li>Open browser console (F12)</li>";
echo "<li>Go to the Add Jansunwai page</li>";
echo "<li>Select a Block, then Booth, then Panchayat</li>";
echo "<li>Watch the console for error messages or 'No villages found' messages</li>";
echo "<li>Check the Network tab to see the AJAX request and response</li>";
echo "</ol>";

echo "<hr>";

// Test 5: Recommendations
echo "<h2>Recommendations</h2>";
echo "<ul>";

if ($village_count == 0) {
    echo "<li style='color: red;'><strong>CRITICAL:</strong> Add villages to the database. The village table is empty.</li>";
}

if ($panchayat_count == 0) {
    echo "<li style='color: red;'><strong>CRITICAL:</strong> Add panchayats to the database. The panchayat table is empty.</li>";
}

if ($village_count > 0 && $panchayat_count > 0) {
    // Check for orphan villages
    $orphan_count = $CI->db->where('panchayatid', 0)
                           ->or_where('panchayatid', NULL)
                           ->count_all_results('village');
    
    if ($orphan_count > 0) {
        echo "<li style='color: orange;'><strong>WARNING:</strong> $orphan_count villages have invalid panchayatid. Update them to link to correct panchayats.</li>";
    }
    
    // Check if all panchayats have at least one village
    $panchayats_without_villages = $CI->db->query("
        SELECT p.id, p.name 
        FROM panchayat p 
        LEFT JOIN village v ON p.id = v.panchayatid 
        WHERE v.id IS NULL 
        LIMIT 10
    ")->result_array();
    
    if (count($panchayats_without_villages) > 0) {
        echo "<li style='color: orange;'><strong>WARNING:</strong> " . count($panchayats_without_villages) . " panchayats have no villages assigned. Consider adding villages for these panchayats.</li>";
        echo "<ul>";
        foreach ($panchayats_without_villages as $p) {
            echo "<li>{$p['name']} (ID: {$p['id']})</li>";
        }
        echo "</ul>";
    }
}

echo "<li>Test the form in browser with console open (F12) to see error messages</li>";
echo "<li>Check the Network tab to see AJAX requests and responses</li>";
echo "<li>Make sure JavaScript is enabled in your browser</li>";
echo "</ul>";

echo "<hr>";
echo "<p><em>Debug script completed at " . date('Y-m-d H:i:s') . "</em></p>";
?>
