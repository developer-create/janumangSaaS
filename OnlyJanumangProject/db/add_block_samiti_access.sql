-- Add Block Samiti module access to access_matrix table

-- Insert access for Block-Samiti module
INSERT INTO `access_matrix` (`roleId`, `module`, `read`, `create`, `update`, `delete`) VALUES
(1, 'Block-Samiti', 1, 1, 1, 1),  -- Admin - full access
(2, 'Block-Samiti', 1, 1, 1, 0),  -- Manager - read, create, update
(3, 'Block-Samiti', 1, 0, 0, 0);  -- User - read only

-- Note: Adjust roleId values according to your system's role structure
-- Run this query after creating the block_samiti table
