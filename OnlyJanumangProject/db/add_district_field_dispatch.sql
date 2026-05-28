-- Add district_id field to dispatch_register table
ALTER TABLE `dispatch_register` 
ADD COLUMN `district_id` int(11) DEFAULT NULL COMMENT 'District ID from district table' 
AFTER `department_id`,
ADD KEY `district_id` (`district_id`);