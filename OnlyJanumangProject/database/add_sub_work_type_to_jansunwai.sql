-- Add sub_work_type_id field to jansunwai table
ALTER TABLE `jansunwai` 
ADD COLUMN `sub_work_type_id` INT(11) NULL DEFAULT NULL AFTER `type_of_work`,
ADD INDEX `idx_sub_work_type_id` (`sub_work_type_id`),
ADD CONSTRAINT `fk_jansunwai_sub_work_type` 
FOREIGN KEY (`sub_work_type_id`) REFERENCES `subtype_of_work` (`id`) 
ON DELETE SET NULL ON UPDATE CASCADE;

