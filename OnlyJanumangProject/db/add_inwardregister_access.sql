-- Add Inward-Register module to access matrix for all existing roles
-- This script adds the Inward-Register module to all roles with default permissions

-- Insert Inward-Register module for Admin role (roleId = 1) with full access
INSERT INTO `tbl_access_matrix` (`roleId`, `access`, `isDeleted`, `createdBy`, `createdDtm`)
SELECT 
    1 as roleId,
    CONCAT(
        '[',
        IFNULL(SUBSTRING(access, 1, LENGTH(access) - 1), ''),
        IF(access IS NULL OR access = '', '', ','),
        '{"module":"Inward-Register","total_access":1,"list":1,"create_records":1,"edit_records":1,"delete_records":1}]'
    ) as access,
    0 as isDeleted,
    1 as createdBy,
    NOW() as createdDtm
FROM `tbl_access_matrix`
WHERE `roleId` = 1
  AND `isDeleted` = 0
  AND NOT EXISTS (
      SELECT 1 FROM `tbl_access_matrix` t2
      WHERE t2.roleId = 1
      AND t2.isDeleted = 0
      AND t2.access LIKE '%Inward-Register%'
  )
LIMIT 1;

-- Update existing Admin access matrix to include Inward-Register
UPDATE `tbl_access_matrix`
SET `access` = CONCAT(
    '[',
    IFNULL(SUBSTRING(access, 1, LENGTH(access) - 1), ''),
    IF(access IS NULL OR access = '', '', ','),
    '{"module":"Inward-Register","total_access":1,"list":1,"create_records":1,"edit_records":1,"delete_records":1}]'
),
`updatedBy` = 1,
`updatedDtm` = NOW()
WHERE `roleId` = 1
  AND `isDeleted` = 0
  AND `access` NOT LIKE '%Inward-Register%';

-- For other roles, add Inward-Register with default permissions (no access)
-- This will add Inward-Register to each role's access matrix if it doesn't exist
INSERT INTO `tbl_access_matrix` (`roleId`, `access`, `isDeleted`, `createdBy`, `createdDtm`)
SELECT DISTINCT
    t1.roleId,
    CONCAT(
        '[',
        IFNULL(SUBSTRING(t1.access, 1, LENGTH(t1.access) - 1), ''),
        IF(t1.access IS NULL OR t1.access = '', '', ','),
        '{"module":"Inward-Register","total_access":0,"list":0,"create_records":0,"edit_records":0,"delete_records":0}]'
    ) as access,
    0 as isDeleted,
    1 as createdBy,
    NOW() as createdDtm
FROM `tbl_access_matrix` t1
WHERE t1.roleId != 1
  AND t1.isDeleted = 0
  AND NOT EXISTS (
      SELECT 1 FROM `tbl_access_matrix` t2
      WHERE t2.roleId = t1.roleId
      AND t2.isDeleted = 0
      AND t2.access LIKE '%Inward-Register%'
  );

-- Update existing access matrices for non-admin roles
UPDATE `tbl_access_matrix`
SET `access` = CONCAT(
    '[',
    IFNULL(SUBSTRING(access, 1, LENGTH(access) - 1), ''),
    IF(access IS NULL OR access = '', '', ','),
    '{"module":"Inward-Register","total_access":0,"list":0,"create_records":0,"edit_records":0,"delete_records":0}]'
),
`updatedBy` = 1,
`updatedDtm` = NOW()
WHERE `roleId` != 1
  AND `isDeleted` = 0
  AND `access` NOT LIKE '%Inward-Register%';
