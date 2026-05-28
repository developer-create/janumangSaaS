-- Add type field to dispatch_register table
ALTER TABLE `dispatch_register` 
ADD COLUMN `type` tinyint(1) DEFAULT NULL COMMENT 'Type: 1=Dispatch(Outward), 2=Inward, 3=Miscellaneous' 
AFTER `id`;

-- Update existing records to have default type as Dispatch (Outward)
UPDATE `dispatch_register` SET `type` = 1 WHERE `type` IS NULL;