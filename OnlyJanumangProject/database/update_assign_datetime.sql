-- Update Call Management table to change assign_date to assign_datetime
-- This adds time component to the assignment date field

ALTER TABLE `call_management` 
CHANGE COLUMN `assign_date` `assign_datetime` DATETIME NULL DEFAULT NULL COMMENT 'Assignment Date and Time';

-- Update any existing records to set time component to current time if null
UPDATE `call_management` 
SET `assign_datetime` = CONCAT(DATE(`assign_datetime`), ' ', TIME(NOW())) 
WHERE TIME(`assign_datetime`) = '00:00:00';

-- Verify the change
SELECT 'Assignment datetime field updated successfully' as status;
DESCRIBE call_management;