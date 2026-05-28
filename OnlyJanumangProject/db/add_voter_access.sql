-- Update access matrix to include Voter module for all roles
-- This script adds Voter module to the access matrix for all existing roles

-- First, let's see what roles exist
SELECT roleId, role FROM tbl_roles WHERE isDeleted = 0;

-- Update access matrix for non-admin roles to include Voter module (default permissions)
UPDATE tbl_access_matrix 
SET access = JSON_ARRAY_APPEND(
    JSON_EXTRACT(access, '$'), 
    '$', 
    JSON_OBJECT(
        'module', 'Voter',
        'total_access', 0,
        'list', 0,
        'create_records', 0,
        'edit_records', 0,
        'delete_records', 0,
        'url', 'https://umangsinghar.in/janumang/voter'
    )
) 
WHERE isDeleted = 0 
AND roleId != 1
AND JSON_SEARCH(access, 'one', 'Voter') IS NULL;

-- Give full access to admin role (roleId = 1)
UPDATE tbl_access_matrix 
SET access = JSON_ARRAY_APPEND(
    JSON_EXTRACT(access, '$'), 
    '$', 
    JSON_OBJECT(
        'module', 'Voter',
        'total_access', 1,
        'list', 1,
        'create_records', 1,
        'edit_records', 1,
        'delete_records', 1,
        'url', 'https://umangsinghar.in/janumang/voter'
    )
) 
WHERE roleId = 1 
AND isDeleted = 0 
AND JSON_SEARCH(access, 'one', 'Voter') IS NULL;

-- To verify the changes, run this query:
-- SELECT roleId, JSON_EXTRACT(access, '$') as access_matrix FROM tbl_access_matrix WHERE isDeleted = 0;

-- To check specifically for Voter module:
-- SELECT 
--     r.roleId,
--     r.role,
--     JSON_EXTRACT(am.access, '$[*].module') as modules
-- FROM tbl_roles r
-- LEFT JOIN tbl_access_matrix am ON r.roleId = am.roleId AND am.isDeleted = 0
-- WHERE r.isDeleted = 0
-- AND JSON_SEARCH(am.access, 'one', 'Voter') IS NOT NULL;

