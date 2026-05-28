-- Add Booth Samiti module access to access_matrix table

-- First, get the role IDs (adjust these based on your actual role IDs)
-- Assuming: 1=Admin, 2=Manager, 3=User (adjust as needed)

-- Insert access for Booth-Samiti module
INSERT INTO `access_matrix` (`roleId`, `module`, `read`, `create`, `update`, `delete`) VALUES
(1, 'Booth-Samiti', 1, 1, 1, 1),  -- Admin - full access
(2, 'Booth-Samiti', 1, 1, 1, 0),  -- Manager - read, create, update
(3, 'Booth-Samiti', 1, 0, 0, 0);  -- User - read only

-- Note: Adjust roleId values according to your system's role structure
-- Run this query after creating the booth_samiti table
