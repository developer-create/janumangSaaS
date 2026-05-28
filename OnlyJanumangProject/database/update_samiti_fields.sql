-- Update all samiti tables: rename serial_no to ac_mp_no and add year field

-- Block Samiti Groups
ALTER TABLE `block_samiti_groups` 
CHANGE COLUMN `serial_no` `ac_mp_no` VARCHAR(50) NULL DEFAULT NULL,
ADD COLUMN `year` YEAR NULL DEFAULT NULL AFTER `id`;

-- Nirman Samiti Groups
ALTER TABLE `nirman_samiti_groups` 
CHANGE COLUMN `serial_no` `ac_mp_no` VARCHAR(50) NULL DEFAULT NULL,
ADD COLUMN `year` YEAR NULL DEFAULT NULL AFTER `id`;

-- Booth Samiti Groups
ALTER TABLE `booth_samiti_groups` 
CHANGE COLUMN `serial_no` `ac_mp_no` VARCHAR(50) NULL DEFAULT NULL,
ADD COLUMN `year` YEAR NULL DEFAULT NULL AFTER `id`;

-- Tenkar Samiti Groups
ALTER TABLE `tenkar_samiti_groups` 
CHANGE COLUMN `serial_no` `ac_mp_no` VARCHAR(50) NULL DEFAULT NULL,
ADD COLUMN `year` YEAR NULL DEFAULT NULL AFTER `id`;

-- Ganesh Samiti Groups
ALTER TABLE `ganesh_samiti_groups` 
CHANGE COLUMN `serial_no` `ac_mp_no` VARCHAR(50) NULL DEFAULT NULL,
ADD COLUMN `year` YEAR NULL DEFAULT NULL AFTER `id`;

-- DP Samiti
ALTER TABLE `dp_samiti` 
CHANGE COLUMN `serial_no` `ac_mp_no` VARCHAR(50) NULL DEFAULT NULL,
ADD COLUMN `year` YEAR NULL DEFAULT NULL AFTER `id`;

-- Mandir Samiti
ALTER TABLE `mandir_samiti` 
CHANGE COLUMN `serial_no` `ac_mp_no` VARCHAR(50) NULL DEFAULT NULL,
ADD COLUMN `year` YEAR NULL DEFAULT NULL AFTER `id`;
