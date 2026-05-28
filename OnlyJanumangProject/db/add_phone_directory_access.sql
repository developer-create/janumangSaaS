-- Update access matrix to include Phone Directory module for all roles
-- This script adds Phone Directory module to the access matrix for all existing roles

-- First, let's see what roles exist
SELECT roleId, role FROM tbl_roles WHERE isDeleted = 0;

-- Update access matrix for all roles to include Phone Directory module
UPDATE tbl_access_matrix 
SET access = JSON_ARRAY_APPEND(
    JSON_EXTRACT(access, '$'), 
    '$', 
    JSON_OBJECT(
        'module', 'Phone Directory',
        'total_access', 0,
        'list', 0,
        'create_records', 0,
        'edit_records', 0,
        'delete_records', 0,
        'url', 'https://umangsinghar.in/janumang/phonedirectory'
    )
) 
WHERE isDeleted = 0;

-- Alternative approach: If you want to give full access to admin role (roleId = 1)
UPDATE tbl_access_matrix 
SET access = JSON_ARRAY_APPEND(
    JSON_EXTRACT(access, '$'), 
    '$', 
    JSON_OBJECT(
        'module', 'Phone Directory',
        'total_access', 1,
        'list', 1,
        'create_records', 1,
        'edit_records', 1,
        'delete_records', 1,
        'url', 'https://umangsinghar.in/janumang/phonedirectory'
    )
) 
WHERE roleId = 1 AND isDeleted = 0;

-- To verify the changes, run this query:
-- SELECT roleId, JSON_EXTRACT(access, '$') as access_matrix FROM tbl_access_matrix WHERE isDeleted = 0;