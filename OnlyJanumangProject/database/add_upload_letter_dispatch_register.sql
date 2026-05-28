-- Add upload_letter field to dispatch_register table
ALTER TABLE `dispatch_register` 
ADD COLUMN `upload_letter` varchar(255) DEFAULT NULL COMMENT 'Uploaded letter file path' AFTER `village_id`;
