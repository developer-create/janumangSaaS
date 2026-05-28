-- Add Dispatch-Register module access to all roles
-- This script adds access control entries for the Dispatch Register module

-- Insert module access for all existing roles
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
WHERE NOT EXISTS (
    SELECT 1 FROM tbl_access_matrix am 
    WHERE am.roleId = r.roleId 
    AND am.module_name = 'Dispatch-Register'
);

-- Verify the insertion
SELECT * FROM tbl_access_matrix WHERE module_name = 'Dispatch-Register';
