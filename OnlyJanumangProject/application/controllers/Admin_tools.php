<?php
require APPPATH . '/libraries/BaseController.php';

class Admin_tools extends BaseController {

    public function __construct() {
        parent::__construct();
        $this->load->model('Role_model');
        $this->load->config('modules');
        $this->isLoggedIn();
    }

    public function regenerate_access_matrix() {
        // Only allow admin access
        if($this->isAdmin != 1) {
            echo "Access denied. Admin only.";
            return;
        }

        echo "<h2>Regenerating Access Matrix</h2>";
        
        // Get all modules from config
        $modules = $this->config->item('moduleList');
        echo "<p>Found " . count($modules) . " modules in configuration.</p>";
        
        // Get all roles
        $this->load->database();
        $query = $this->db->get('tbl_roles');
        $roles = $query->result();
        
        echo "<p>Found " . count($roles) . " roles.</p>";
        
        foreach ($roles as $role) {
            echo "<p>Processing role: {$role->role} (ID: {$role->roleId})</p>";
            
            // Check if access matrix exists
            $this->db->where('roleId', $role->roleId);
            $this->db->where('isDeleted', 0);
            $query = $this->db->get('tbl_access_matrix');
            $existingMatrix = $query->row();
            
            if ($existingMatrix) {
                // Update existing matrix
                $accessMatrix = [
                    'access' => json_encode($modules),
                    'updatedBy' => $this->vendorId,
                    'updatedDtm' => date('Y-m-d H:i:s')
                ];
                
                $this->db->where('roleId', $role->roleId);
                $this->db->where('isDeleted', 0);
                $this->db->update('tbl_access_matrix', $accessMatrix);
                
                echo "<p style='color: green;'>✓ Updated access matrix for role: {$role->role}</p>";
            } else {
                // Create new matrix
                $accessMatrix = [
                    'roleId' => $role->roleId,
                    'access' => json_encode($modules),
                    'isDeleted' => 0,
                    'createdBy' => $this->vendorId,
                    'createdDtm' => date('Y-m-d H:i:s')
                ];
                
                $this->db->insert('tbl_access_matrix', $accessMatrix);
                
                echo "<p style='color: green;'>✓ Created new access matrix for role: {$role->role}</p>";
            }
        }
        
        echo "<h3>Access matrix regeneration completed!</h3>";
        
        // Verify Vidhan Sabha is included
        echo "<h3>Verifying Vidhan Sabha access...</h3>";
        $this->db->select('roleId, JSON_EXTRACT(access, "$[*].module") as modules');
        $this->db->from('tbl_access_matrix');
        $this->db->where('isDeleted', 0);
        $query = $this->db->get();
        $results = $query->result();
        
        foreach ($results as $result) {
            $modules = json_decode($result->modules, true);
            if (in_array('Vidhan Sabha', $modules)) {
                echo "<p style='color: green;'>✓ Role ID {$result->roleId} has Vidhan Sabha access</p>";
            } else {
                echo "<p style='color: red;'>✗ Role ID {$result->roleId} missing Vidhan Sabha access</p>";
            }
        }
        
        echo "<p><a href='" . base_url() . "'>Go to Dashboard</a></p>";
    }
}
?>