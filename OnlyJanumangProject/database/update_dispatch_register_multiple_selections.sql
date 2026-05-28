-- Update dispatch_register table to support multiple panchayat and village IDs
-- Run this script to enable multiple selection for both fields

-- Update panchayat_id column
ALTER TABLE `dispatch_register` 
MODIFY COLUMN `panchayat_id` VARCHAR(255) DEFAULT NULL;

-- Update village_id column (if not already done)
ALTER TABLE `dispatch_register` 
MODIFY COLUMN `village_id` VARCHAR(255) DEFAULT NULL;
