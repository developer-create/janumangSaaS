-- Add Block, Year, Month columns to samiti table
ALTER TABLE `samiti` 
ADD COLUMN `block_id` INT(11) DEFAULT NULL COMMENT 'Block ID from block table' AFTER `name`,
ADD COLUMN `year` INT(4) DEFAULT NULL COMMENT 'Year' AFTER `block_id`,
ADD COLUMN `month` INT(2) DEFAULT NULL COMMENT 'Month (1-12)' AFTER `year`;

-- Add indexes for better query performance
ALTER TABLE `samiti` 
ADD INDEX `idx_block_id` (`block_id`),
ADD INDEX `idx_year` (`year`),
ADD INDEX `idx_month` (`month`);
