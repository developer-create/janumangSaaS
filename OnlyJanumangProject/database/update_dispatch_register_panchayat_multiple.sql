-- Update panchayat_id column to support multiple panchayat IDs (comma-separated)
ALTER TABLE `dispatch_register` 
MODIFY COLUMN `panchayat_id` VARCHAR(255) DEFAULT NULL;
