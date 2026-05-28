-- Add Nirman Samiti module access to tbl_module_access table
-- This grants all roles access to the Nirman Samiti module

-- First, let's check what roleIds exist and add access for all of them
INSERT INTO `tbl_module_access` (`roleId`, `module`, `view`, `add`, `update`, `delete`) 
SELECT roleId, 'Nirman-Samiti', 1, 1, 1, 1 
FROM `tbl_roles` 
WHERE NOT EXISTS (
    SELECT 1 FROM `tbl_module_access` 
    WHERE `module` = 'Nirman-Samiti' AND `tbl_module_access`.roleId = `tbl_roles`.roleId
);

-- Verify the insertion
SELECT * FROM `tbl_module_access` WHERE `module` = 'Nirman-Samiti';
