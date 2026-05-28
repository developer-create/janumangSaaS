-- Fix Dispatch Register access using JSON format in tbl_access_matrix
-- This script adds Dispatch-Register module access to Manager and other roles using the correct JSON format

-- First check current access for Manager role
SELECT 'Current Manager Access:' as info, roleId, access 
FROM tbl_access_matrix 
WHERE roleId IN (SELECT roleId FROM tbl_roles WHERE role = 'Manager')
AND isDeleted = 0;

-- Add Dispatch-Register module for Manager role (assuming Manager roleId = 2, adjust if different)
UPDATE `tbl_access_matrix`
SET `access` = CASE 
    WHEN access IS NULL OR access = '' THEN 
        '[{"module":"Dispatch-Register","total_access":1,"list":1,"create_records":1,"edit_records":1,"delete_records":1}]'
    WHEN access LIKE '%Dispatch-Register%' THEN 
        access -- Already exists, keep as is
    ELSE 
        CONCAT(
            SUBSTRING(access, 1, LENGTH(access) - 1), -- Remove closing ]
            ',{"module":"Dispatch-Register","total_access":1,"list":1,"create_records":1,"edit_records":1,"delete_records":1}]'
        )
END,
`updatedDtm` = NOW()
WHERE roleId IN (SELECT roleId FROM tbl_roles WHERE role = 'Manager')
AND isDeleted = 0;

-- Add for all other roles that don't have it (excluding Manager since we handled it above)
UPDATE `tbl_access_matrix`
SET `access` = CASE 
    WHEN access IS NULL OR access = '' THEN 
        '[{"module":"Dispatch-Register","total_access":1,"list":1,"create_records":1,"edit_records":1,"delete_records":1}]'
    WHEN access LIKE '%Dispatch-Register%' THEN 
        access -- Already exists, keep as is
    ELSE 
        CONCAT(
            SUBSTRING(access, 1, LENGTH(access) - 1), -- Remove closing ]
            ',{"module":"Dispatch-Register","total_access":1,"list":1,"create_records":1,"edit_records":1,"delete_records":1}]'
        )
END,
`updatedDtm` = NOW()
WHERE roleId NOT IN (SELECT roleId FROM tbl_roles WHERE role = 'Manager')
AND isDeleted = 0;

-- Verify the final result
SELECT 'Final Manager Access:' as info, r.role, am.access 
FROM tbl_access_matrix am 
JOIN tbl_roles r ON am.roleId = r.roleId 
WHERE r.role = 'Manager' AND am.isDeleted = 0;

-- Show all roles with Dispatch-Register access
SELECT 'All Roles with Dispatch-Register:' as info, r.role, am.roleId
FROM tbl_access_matrix am 
JOIN tbl_roles r ON am.roleId = r.roleId 
WHERE am.access LIKE '%Dispatch-Register%' 
AND am.isDeleted = 0
ORDER BY r.role;