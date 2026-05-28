-- Add year field to Vidhan Sabha, Block, and Booth tables
-- Year dropdown will range from 2013 to 2028

-- Add year field to tbl_vidhan_sabha
ALTER TABLE `tbl_vidhan_sabha` 
ADD COLUMN `year` INT(4) NOT NULL DEFAULT 2024 COMMENT 'Year (2013-2028)' AFTER `districtId`;

-- Add index for year field
ALTER TABLE `tbl_vidhan_sabha` 
ADD INDEX `idx_year` (`year`);

-- Add year field to tbl_block
ALTER TABLE `tbl_block` 
ADD COLUMN `year` INT(4) NOT NULL DEFAULT 2024 COMMENT 'Year (2013-2028)' AFTER `districtId`;

-- Add index for year field
ALTER TABLE `tbl_block` 
ADD INDEX `idx_year` (`year`);

-- Add year field to tbl_booth
ALTER TABLE `tbl_booth` 
ADD COLUMN `year` INT(4) NOT NULL DEFAULT 2024 COMMENT 'Year (2013-2028)' AFTER `villageId`;

-- Add index for year field
ALTER TABLE `tbl_booth` 
ADD INDEX `idx_year` (`year`);
