-- Fix Manager role access for Dispatch Register module
-- This ensures the Manager role has proper access to Dispatch-Register module

-- First, check if the module access exists for Manager role
SELECT 'Before Update:' as status, am.* 
FROM tbl_access_matrix am 
JOIN tbl_roles r ON am.roleId = r.roleId 
WHERE r.role = 'Manager' AND am.module_name = 'Dispatch-Register';

-- Update or Insert access for Manager role specifically
INSERT INTO tbl_access_matrix (roleId, module_name, list_access, create_access, edit_access, delete_access, created_at, updated_at)
SELECT 
    r.roleId,
    'Dispatch-Register' as module_name,
    1 as list_access,
    1 as create_access,
    1 as edit_access,
    1 as delete_access,
    NOW() as created_at,
    NOW() as updated_at
FROM tbl_roles r
WHERE r.role = 'Manager'
AND NOT EXISTS (
    SELECT 1 FROM tbl_access_matrix am 
    WHERE am.roleId = r.roleId 
    AND am.module_name = 'Dispatch-Register'
);

-- If record exists but permissions are 0, update them
UPDATE tbl_access_matrix 
SET 
    list_access = 1,
    create_access = 1,
    edit_access = 1,
    delete_access = 1,
    updated_at = NOW()
WHERE module_name = 'Dispatch-Register' 
AND roleId IN (SELECT roleId FROM tbl_roles WHERE role = 'Manager');

-- Verify the final result
SELECT 'After Update:' as status, am.*, r.role 
FROM tbl_access_matrix am 
JOIN tbl_roles r ON am.roleId = r.roleId 
WHERE r.role = 'Manager' AND am.module_name = 'Dispatch-Register';

-- Also check all roles to see the current state
SELECT 'All Roles Status:' as info, r.role, am.list_access, am.create_access, am.edit_access, am.delete_access
FROM tbl_access_matrix am 
JOIN tbl_roles r ON am.roleId = r.roleId 
WHERE am.module_name = 'Dispatch-Register'
ORDER BY r.role;