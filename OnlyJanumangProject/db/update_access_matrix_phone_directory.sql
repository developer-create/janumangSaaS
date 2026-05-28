-- Comprehensive script to add Phone Directory module to access matrix
-- This script will regenerate access matrix for all roles to include Phone Directory

-- Step 1: Check current roles
SELECT 'Current Roles:' as info;
SELECT roleId, role, isDeleted FROM tbl_roles WHERE isDeleted = 0;

-- Step 2: Check current access matrix
SELECT 'Current Access Matrix:' as info;
SELECT roleId, JSON_EXTRACT(access, '$') as current_access FROM tbl_access_matrix WHERE isDeleted = 0;

-- Step 3: Delete existing access matrix entries (optional - uncomment if you want to regenerate completely)
-- DELETE FROM tbl_access_matrix WHERE isDeleted = 0;

-- Step 4: Insert/Update access matrix for each role with Phone Directory module included
-- This will add Phone Directory with default permissions (all 0) for all roles

-- For Admin role (roleId = 1) - Full access
INSERT INTO tbl_access_matrix (roleId, access, isDeleted, createdBy, createdDtm) 
VALUES (1, '[
    {"module":"Dashboard","total_access":1,"list":1,"create_records":1,"edit_records":1,"delete_records":1,"url":"https://umangsinghar.in/janumang/dashboard"},
    {"module":"Users","total_access":1,"list":1,"create_records":1,"edit_records":1,"delete_records":1,"url":"https://umangsinghar.in/janumang/userListing"},
    {"module":"Roles","total_access":1,"list":1,"create_records":1,"edit_records":1,"delete_records":1,"url":"https://umangsinghar.in/janumang/roles/roleListing"},
    {"module":"UserCount","total_access":1,"list":1,"create_records":1,"edit_records":1,"delete_records":1,"url":"https://umangsinghar.in/janumang/Usercount?date="},
    {"module":"MemberList","total_access":1,"list":1,"create_records":1,"edit_records":1,"delete_records":1,"url":"https://umangsinghar.in/janumang/ServayListing"},
    {"module":"MP-publicproblem","total_access":1,"list":1,"create_records":1,"edit_records":1,"delete_records":1,"url":"https://umangsinghar.in/janumang/Districtpublicproblem/Disctrictproblem"},
    {"module":"PublicProblems0","total_access":1,"list":1,"create_records":1,"edit_records":1,"delete_records":1,"url":"https://umangsinghar.in/janumang/user/jansunwai"},
    {"module":"PublicProblems2","total_access":1,"list":1,"create_records":1,"edit_records":1,"delete_records":1,"url":"https://umangsinghar.in/janumang/user/jansunwai2"},
    {"module":"PublicProblems3","total_access":1,"list":1,"create_records":1,"edit_records":1,"delete_records":1,"url":"https://umangsinghar.in/janumang/user/jansunwai3"},
    {"module":"Gandhwani-Project-Summary","total_access":1,"list":1,"create_records":1,"edit_records":1,"delete_records":1,"url":"https://umangsinghar.in/janumang/projectSummary"},
    {"module":"Visitors","total_access":1,"list":1,"create_records":1,"edit_records":1,"delete_records":1,"url":"https://umangsinghar.in/janumang/Visitors"},
    {"module":"Events","total_access":1,"list":1,"create_records":1,"edit_records":1,"delete_records":1,"url":"https://umangsinghar.in/janumang/Events"},
    {"module":"Samiti","total_access":1,"list":1,"create_records":1,"edit_records":1,"delete_records":1,"url":"https://umangsinghar.in/janumang/samiti"},
    {"module":"District","total_access":1,"list":1,"create_records":1,"edit_records":1,"delete_records":1,"url":"https://umangsinghar.in/janumang/district"},
    {"module":"Vidhan Sabha","total_access":1,"list":1,"create_records":1,"edit_records":1,"delete_records":1,"url":"https://umangsinghar.in/janumang/vidhan_sabha"},
    {"module":"Block","total_access":1,"list":1,"create_records":1,"edit_records":1,"delete_records":1,"url":"https://umangsinghar.in/janumang/block"},
    {"module":"Booth","total_access":1,"list":1,"create_records":1,"edit_records":1,"delete_records":1,"url":"https://umangsinghar.in/janumang/booth"},
    {"module":"Panchayat","total_access":1,"list":1,"create_records":1,"edit_records":1,"delete_records":1,"url":"https://umangsinghar.in/janumang/panchayat"},
    {"module":"Village","total_access":1,"list":1,"create_records":1,"edit_records":1,"delete_records":1,"url":"https://umangsinghar.in/janumang/village"},
    {"module":"Party","total_access":1,"list":1,"create_records":1,"edit_records":1,"delete_records":1,"url":"https://umangsinghar.in/janumang/user/party"},
    {"module":"Department","total_access":1,"list":1,"create_records":1,"edit_records":1,"delete_records":1,"url":"https://umangsinghar.in/janumang/user/department"},
    {"module":"Worktype","total_access":1,"list":1,"create_records":1,"edit_records":1,"delete_records":1,"url":"https://umangsinghar.in/janumang/worktype"},
    {"module":"Phone Directory","total_access":1,"list":1,"create_records":1,"edit_records":1,"delete_records":1,"url":"https://umangsinghar.in/janumang/phonedirectory"}
]', 0, 1, NOW())
ON DUPLICATE KEY UPDATE 
    access = VALUES(access),
    updatedBy = 1,
    updatedDtm = NOW();

-- For other roles - Limited access (you can customize permissions as needed)
-- Replace roleId values with actual role IDs from your system

-- Example for roleId = 2 (if exists)
INSERT INTO tbl_access_matrix (roleId, access, isDeleted, createdBy, createdDtm) 
VALUES (2, '[
    {"module":"Dashboard","total_access":0,"list":1,"create_records":0,"edit_records":0,"delete_records":0,"url":"https://umangsinghar.in/janumang/dashboard"},
    {"module":"Phone Directory","total_access":0,"list":1,"create_records":1,"edit_records":0,"delete_records":0,"url":"https://umangsinghar.in/janumang/phonedirectory"}
]', 0, 1, NOW())
ON DUPLICATE KEY UPDATE 
    access = VALUES(access),
    updatedBy = 1,
    updatedDtm = NOW();

-- Step 5: Verify the changes
SELECT 'Updated Access Matrix:' as info;
SELECT roleId, JSON_EXTRACT(access, '$') as updated_access FROM tbl_access_matrix WHERE isDeleted = 0;

-- Step 6: Check specifically for Phone Directory module
SELECT 'Phone Directory Access by Role:' as info;
SELECT 
    r.roleId,
    r.role,
    JSON_EXTRACT(am.access, '$[*].module') as modules,
    JSON_EXTRACT(am.access, '$[*]') as full_access
FROM tbl_roles r
LEFT JOIN tbl_access_matrix am ON r.roleId = am.roleId AND am.isDeleted = 0
WHERE r.isDeleted = 0
AND JSON_SEARCH(am.access, 'one', 'Phone Directory') IS NOT NULL;
