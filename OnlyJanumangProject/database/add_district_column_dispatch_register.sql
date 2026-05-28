-- Add district_id column to dispatch_register table
ALTER TABLE `dispatch_register` 
ADD COLUMN `district_id` int(11) DEFAULT NULL COMMENT 'District ID from district table' AFTER `reference`;

-- Add index for district_id for better performance
ALTER TABLE `dispatch_register` 
ADD KEY `district_id` (`district_id`);
