<?php
// Script to regenerate access matrix for all roles
// This will ensure all modules from modules.php are included

// Load CodeIgniter
require_once('index.php');

// Get CodeIgniter instance
$CI =& get_instance();

// Load required models
$CI->load->model('Role_model');
$CI->load->config('modules');

// Get all modules from config
$modules = $CI->config->item('moduleList');

echo "Found " . count($modules) . " modules in configuration.\n";

// Get all roles
$CI->load->database();
$query = $CI->db->get('tbl_roles');
$roles = $query->result();

echo "Found " . count($roles) . " roles.\n";

foreach ($roles as $role) {
    echo "Processing role: {$role->role} (ID: {$role->roleId})\n";
    
    // Check if access matrix exists
    $CI->db->where('roleId', $role->roleId);
    $CI->db->where('isDeleted', 0);
    $query = $CI->db->get('tbl_access_matrix');
    $existingMatrix = $query->row();
    
    if ($existingMatrix) {
        // Update existing matrix
        $accessMatrix = [
            'access' => json_encode($modules),
            'updatedBy' => 1,
            'updatedDtm' => date('Y-m-d H:i:s')
        ];
        
        $CI->db->where('roleId', $role->roleId);
        $CI->db->where('isDeleted', 0);
        $CI->db->update('tbl_access_matrix', $accessMatrix);
        
        echo "  ✓ Updated access matrix for role: {$role->role}\n";
    } else {
        // Create new matrix
        $accessMatrix = [
            'roleId' => $role->roleId,
            'access' => json_encode($modules),
            'isDeleted' => 0,
            'createdBy' => 1,
            'createdDtm' => date('Y-m-d H:i:s')
        ];
        
        $CI->db->insert('tbl_access_matrix', $accessMatrix);
        
        echo "  ✓ Created new access matrix for role: {$role->role}\n";
    }
}

echo "\nAccess matrix regeneration completed!\n";

// Verify Vidhan Sabha is included
echo "\nVerifying Vidhan Sabha access...\n";
$CI->db->select('roleId, JSON_EXTRACT(access, "$[*].module") as modules');
$CI->db->from('tbl_access_matrix');
$CI->db->where('isDeleted', 0);
$query = $CI->db->get();
$results = $query->result();

foreach ($results as $result) {
    $modules = json_decode($result->modules, true);
    if (in_array('Vidhan Sabha', $modules)) {
        echo "✓ Role ID {$result->roleId} has Vidhan Sabha access\n";
    } else {
        echo "✗ Role ID {$result->roleId} missing Vidhan Sabha access\n";
    }
}
?>
