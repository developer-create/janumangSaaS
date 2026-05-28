-- Fix Vidhan Sabha access in the access matrix
-- This script will add Vidhan Sabha module to existing access matrix for all roles

-- Step 1: Check current access matrix
SELECT 'Current Access Matrix:' as info;
SELECT roleId, JSON_EXTRACT(access, '$') as current_access FROM tbl_access_matrix WHERE isDeleted = 0;

-- Step 2: Add Vidhan Sabha to access matrix for all roles
-- For Admin role (roleId = 1) - Full access
UPDATE tbl_access_matrix 
SET access = JSON_ARRAY_APPEND(
    JSON_EXTRACT(access, '$'), 
    '$', 
    JSON_OBJECT(
        'module', 'Vidhan Sabha',
        'total_access', 1,
        'list', 1,
        'create_records', 1,
        'edit_records', 1,
        'delete_records', 1,
        'url', 'https://umangsinghar.in/janumang/vidhan_sabha'
    )
) 
WHERE roleId = 1 AND isDeleted = 0;

-- For other roles - List access only (you can modify as needed)
UPDATE tbl_access_matrix 
SET access = JSON_ARRAY_APPEND(
    JSON_EXTRACT(access, '$'), 
    '$', 
    JSON_OBJECT(
        'module', 'Vidhan Sabha',
        'total_access', 0,
        'list', 1,
        'create_records', 0,
        'edit_records', 0,
        'delete_records', 0,
        'url', 'https://umangsinghar.in/janumang/vidhan_sabha'
    )
) 
WHERE roleId != 1 AND isDeleted = 0;

-- Step 3: Verify the changes
SELECT 'Updated Access Matrix:' as info;
SELECT roleId, JSON_EXTRACT(access, '$') as updated_access FROM tbl_access_matrix WHERE isDeleted = 0;

-- Step 4: Check specifically for Vidhan Sabha module
SELECT 'Vidhan Sabha Access by Role:' as info;
SELECT 
    r.roleId,
    r.role,
    JSON_EXTRACT(am.access, '$[*].module') as modules,
    JSON_EXTRACT(am.access, '$[*]') as full_access
FROM tbl_roles r
LEFT JOIN tbl_access_matrix am ON r.roleId = am.roleId AND am.isDeleted = 0
WHERE r.isDeleted = 0
AND JSON_SEARCH(am.access, 'one', 'Vidhan Sabha') IS NOT NULL;
