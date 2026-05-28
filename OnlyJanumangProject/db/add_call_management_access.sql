-- Add Call Management module to access matrix
-- This script adds the Call Management module to the access control system

-- Insert Call Management module into access_matrix table
INSERT INTO `access_matrix` (`module`, `add`, `edit`, `delete`, `list`, `total_access`) 
VALUES ('Call-Management', 0, 0, 0, 0, 0);

-- Get the ID of the newly inserted module
SET @call_mgmt_module_id = LAST_INSERT_ID();

-- Give admin user (ID=1) full access to Call Management
INSERT INTO `user_access` (`user_id`, `module_id`, `add`, `edit`, `delete`, `list`, `total_access`)
SELECT 1, @call_mgmt_module_id, 1, 1, 1, 1, 1
WHERE NOT EXISTS (
    SELECT 1 FROM `user_access` 
    WHERE `user_id` = 1 AND `module_id` = @call_mgmt_module_id
);

-- Optionally, you can add access for other users by repeating the above INSERT for different user_ids
-- For example, to give user ID 2 limited access (list and view only):
-- INSERT INTO `user_access` (`user_id`, `module_id`, `add`, `edit`, `delete`, `list`, `total_access`)
-- SELECT 2, @call_mgmt_module_id, 0, 0, 0, 1, 0
-- WHERE NOT EXISTS (
--     SELECT 1 FROM `user_access` 
--     WHERE `user_id` = 2 AND `module_id` = @call_mgmt_module_id
-- );

-- Verify the insertion
SELECT 'Call Management module added successfully' as status;
SELECT * FROM `access_matrix` WHERE `module` = 'Call-Management';
SELECT ua.*, u.name as user_name FROM `user_access` ua 
JOIN `users` u ON ua.user_id = u.userId 
WHERE ua.module_id = @call_mgmt_module_id;