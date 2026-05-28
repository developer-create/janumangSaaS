-- Update dispatch_register table to support multiple village IDs
-- Change village_id from INT to VARCHAR to store comma-separated IDs

ALTER TABLE `dispatch_register` 
MODIFY COLUMN `village_id` VARCHAR(255) DEFAULT NULL COMMENT 'Comma-separated village IDs';
