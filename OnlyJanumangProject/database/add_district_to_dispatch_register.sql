-- SQL Query to add district_id column to dispatch_register table
-- Run this query in phpMyAdmin or MySQL client

-- Add district_id column to dispatch_register table
ALTER TABLE `dispatch_register` 
ADD COLUMN `district_id` INT(11) NULL DEFAULT NULL AFTER `block_id`;

-- Add foreign key constraint (optional but recommended)
ALTER TABLE `dispatch_register` 
ADD CONSTRAINT `fk_dispatch_district` 
FOREIGN KEY (`district_id`) REFERENCES `district`(`id`) 
ON DELETE SET NULL ON UPDATE CASCADE;

-- Create index for better query performance
ALTER TABLE `dispatch_register` 
ADD INDEX `idx_district_id` (`district_id`);


