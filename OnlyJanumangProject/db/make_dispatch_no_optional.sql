-- Make dispatch_no field optional (allow NULL values)
-- This ensures records can be saved without dispatch numbers

ALTER TABLE `dispatch_register` 
MODIFY COLUMN `dispatch_no` varchar(100) DEFAULT NULL COMMENT 'Dispatch No. (Optional)';