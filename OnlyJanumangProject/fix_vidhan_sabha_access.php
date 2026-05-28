<?php
// Script to fix Vidhan Sabha access in the access matrix
// Run this script from the command line or browser

// Database configuration
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'cias';

try {
    // Create connection
    $pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "Connected to database successfully.\n";
    
    // Get all roles
    $stmt = $pdo->query("SELECT roleId, role FROM tbl_roles WHERE isDeleted = 0");
    $roles = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "Found " . count($roles) . " roles.\n";
    
    foreach ($roles as $role) {
        $roleId = $role['roleId'];
        $roleName = $role['role'];
        
        echo "Processing role: $roleName (ID: $roleId)\n";
        
        // Get current access matrix
        $stmt = $pdo->prepare("SELECT access FROM tbl_access_matrix WHERE roleId = ? AND isDeleted = 0");
        $stmt->execute([$roleId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($result) {
            $accessMatrix = json_decode($result['access'], true);
            
            // Check if Vidhan Sabha already exists
            $vidhanSabhaExists = false;
            foreach ($accessMatrix as $module) {
                if ($module['module'] === 'Vidhan Sabha') {
                    $vidhanSabhaExists = true;
                    break;
                }
            }
            
            if (!$vidhanSabhaExists) {
                // Add Vidhan Sabha module
                $vidhanSabhaModule = [
                    'module' => 'Vidhan Sabha',
                    'total_access' => ($roleId == 1) ? 1 : 0, // Full access for admin
                    'list' => 1, // List access for all
                    'create_records' => ($roleId == 1) ? 1 : 0,
                    'edit_records' => ($roleId == 1) ? 1 : 0,
                    'delete_records' => ($roleId == 1) ? 1 : 0,
                    'url' => 'https://umangsinghar.in/janumang/vidhan_sabha'
                ];
                
                $accessMatrix[] = $vidhanSabhaModule;
                
                // Update the access matrix
                $stmt = $pdo->prepare("UPDATE tbl_access_matrix SET access = ?, updatedDtm = NOW() WHERE roleId = ? AND isDeleted = 0");
                $stmt->execute([json_encode($accessMatrix), $roleId]);
                
                echo "  ✓ Added Vidhan Sabha module to role: $roleName\n";
            } else {
                echo "  - Vidhan Sabha module already exists for role: $roleName\n";
            }
        } else {
            echo "  ! No access matrix found for role: $roleName\n";
        }
    }
    
    echo "\nAccess matrix update completed!\n";
    
    // Verify the changes
    echo "\nVerifying changes...\n";
    $stmt = $pdo->query("SELECT roleId, JSON_EXTRACT(access, '$[*].module') as modules FROM tbl_access_matrix WHERE isDeleted = 0");
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($results as $result) {
        $modules = json_decode($result['modules'], true);
        if (in_array('Vidhan Sabha', $modules)) {
            echo "✓ Role ID {$result['roleId']} has Vidhan Sabha access\n";
        }
    }
    
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
