-- Add inward_doc_no field to dispatch_register table
ALTER TABLE `dispatch_register` 
ADD COLUMN `inward_doc_no` varchar(100) DEFAULT NULL COMMENT 'Inward Doc No.' 
AFTER `dispatch_no`;