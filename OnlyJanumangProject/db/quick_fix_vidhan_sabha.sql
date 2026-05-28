-- Quick fix for Vidhan Sabha access matrix
-- This will add Vidhan Sabha to all existing access matrices

-- First, let's see what we have
SELECT 'Before Update:' as status;
SELECT roleId, JSON_EXTRACT(access, '$[*].module') as modules FROM tbl_access_matrix WHERE isDeleted = 0;

-- Add Vidhan Sabha to all access matrices
-- For admin role (roleId = 1) - give full access
UPDATE tbl_access_matrix 
SET access = JSON_ARRAY_APPEND(
    access, 
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

-- For other roles - give list access only
UPDATE tbl_access_matrix 
SET access = JSON_ARRAY_APPEND(
    access, 
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

-- Check the results
SELECT 'After Update:' as status;
SELECT roleId, JSON_EXTRACT(access, '$[*].module') as modules FROM tbl_access_matrix WHERE isDeleted = 0;

-- Specifically check for Vidhan Sabha
SELECT 'Vidhan Sabha Check:' as status;
SELECT 
    roleId,
    JSON_EXTRACT(access, '$[*].module') as all_modules,
    JSON_EXTRACT(access, '$[*]') as full_access
FROM tbl_access_matrix 
WHERE isDeleted = 0 
AND JSON_SEARCH(access, 'one', 'Vidhan Sabha') IS NOT NULL;
