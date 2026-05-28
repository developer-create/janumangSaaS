-- Complete Database Update for All Samiti Tables
-- Run these queries to add year, ac_mp_no, and file_upload fields to all samiti tables

-- 1. Block Samiti Groups (already updated, but keeping for reference)
-- ALTER TABLE `block_samiti_groups` 
-- ADD COLUMN `year` YEAR NULL DEFAULT NULL AFTER `id`,
-- ADD COLUMN `ac_mp_no` VARCHAR(50) NULL DEFAULT NULL AFTER `year`,
-- ADD COLUMN `file_upload` VARCHAR(255) NULL DEFAULT NULL;

-- 2. Nirman Samiti Groups (already updated, but keeping for reference)
-- ALTER TABLE `nirman_samiti_groups` 
-- ADD COLUMN `year` YEAR NULL DEFAULT NULL AFTER `id`,
-- ADD COLUMN `ac_mp_no` VARCHAR(50) NULL DEFAULT NULL AFTER `year`,
-- ADD COLUMN `file_upload` VARCHAR(255) NULL DEFAULT NULL;

-- 3. Booth Samiti Groups (already updated, but keeping for reference)
-- ALTER TABLE `booth_samiti_groups` 
-- ADD COLUMN `year` YEAR NULL DEFAULT NULL AFTER `id`,
-- ADD COLUMN `ac_mp_no` VARCHAR(50) NULL DEFAULT NULL AFTER `year`,
-- ADD COLUMN `file_upload` VARCHAR(255) NULL DEFAULT NULL;

-- 4. Tenkar Samiti Groups (already updated, but keeping for reference)
-- ALTER TABLE `tenkar_samiti_groups` 
-- ADD COLUMN `year` YEAR NULL DEFAULT NULL AFTER `id`,
-- ADD COLUMN `ac_mp_no` VARCHAR(50) NULL DEFAULT NULL AFTER `year`,
-- ADD COLUMN `file_upload` VARCHAR(255) NULL DEFAULT NULL;

-- 5. Ganesh Samiti Groups (already updated, but keeping for reference)
-- ALTER TABLE `ganesh_samiti_groups` 
-- ADD COLUMN `year` YEAR NULL DEFAULT NULL AFTER `id`,
-- ADD COLUMN `ac_mp_no` VARCHAR(50) NULL DEFAULT NULL AFTER `year`,
-- ADD COLUMN `file_upload` VARCHAR(255) NULL DEFAULT NULL;

-- 6. DP Samiti (already updated, but keeping for reference)
-- ALTER TABLE `dp_samiti` 
-- ADD COLUMN `year` YEAR NULL DEFAULT NULL AFTER `id`,
-- ADD COLUMN `ac_mp_no` VARCHAR(50) NULL DEFAULT NULL AFTER `year`,
-- ADD COLUMN `file_upload` VARCHAR(255) NULL DEFAULT NULL;

-- 7. Mandir Samiti (already updated, but keeping for reference)
-- ALTER TABLE `mandir_samiti` 
-- ADD COLUMN `year` YEAR NULL DEFAULT NULL AFTER `id`,
-- ADD COLUMN `ac_mp_no` VARCHAR(50) NULL DEFAULT NULL AFTER `year`,
-- ADD COLUMN `file_upload` VARCHAR(255) NULL DEFAULT NULL;

-- ========================================
-- IMPORTANT: IF YOU WANT TO KEEP serial_no FIELD ALONGSIDE ac_mp_no
-- Run these queries to ADD ac_mp_no WITHOUT removing serial_no:
-- ========================================

-- Add ac_mp_no field to tables that might not have it (keeping serial_no)
-- ALTER TABLE `block_samiti_groups` ADD COLUMN `ac_mp_no` VARCHAR(50) NULL DEFAULT NULL AFTER `serial_no`;
-- ALTER TABLE `nirman_samiti_groups` ADD COLUMN `ac_mp_no` VARCHAR(50) NULL DEFAULT NULL AFTER `serial_no`;
-- ALTER TABLE `booth_samiti_groups` ADD COLUMN `ac_mp_no` VARCHAR(50) NULL DEFAULT NULL AFTER `serial_no`;
-- ALTER TABLE `tenkar_samiti_groups` ADD COLUMN `ac_mp_no` VARCHAR(50) NULL DEFAULT NULL AFTER `serial_no`;
-- ALTER TABLE `ganesh_samiti_groups` ADD COLUMN `ac_mp_no` VARCHAR(50) NULL DEFAULT NULL AFTER `serial_no`;
-- ALTER TABLE `dp_samiti` ADD COLUMN `ac_mp_no` VARCHAR(50) NULL DEFAULT NULL AFTER `serial_no`;
-- ALTER TABLE `mandir_samiti` ADD COLUMN `ac_mp_no` VARCHAR(50) NULL DEFAULT NULL AFTER `serial_no`;

-- ========================================
-- OR IF YOU WANT TO RENAME serial_no to ac_mp_no
-- Run these queries to RENAME serial_no fields:
-- ========================================

-- Rename serial_no to ac_mp_no in all tables
-- ALTER TABLE `block_samiti_groups` CHANGE COLUMN `serial_no` `ac_mp_no` VARCHAR(50) NULL DEFAULT NULL;
-- ALTER TABLE `nirman_samiti_groups` CHANGE COLUMN `serial_no` `ac_mp_no` VARCHAR(50) NULL DEFAULT NULL;
-- ALTER TABLE `booth_samiti_groups` CHANGE COLUMN `serial_no` `ac_mp_no` VARCHAR(50) NULL DEFAULT NULL;
-- ALTER TABLE `tenkar_samiti_groups` CHANGE COLUMN `serial_no` `ac_mp_no` VARCHAR(50) NULL DEFAULT NULL;
-- ALTER TABLE `ganesh_samiti_groups` CHANGE COLUMN `serial_no` `ac_mp_no` VARCHAR(50) NULL DEFAULT NULL;
-- ALTER TABLE `dp_samiti` CHANGE COLUMN `serial_no` `ac_mp_no` VARCHAR(50) NULL DEFAULT NULL;
-- ALTER TABLE `mandir_samiti` CHANGE COLUMN `serial_no` `ac_mp_no` VARCHAR(50) NULL DEFAULT NULL;

-- ========================================
-- VERIFY ALL TABLES HAVE REQUIRED FIELDS
-- Run this to check current structure:
-- ========================================

-- Check all samiti tables structure
SELECT 
    TABLE_NAME, 
    GROUP_CONCAT(COLUMN_NAME ORDER BY ORDINAL_POSITION) as ALL_COLUMNS
FROM INFORMATION_SCHEMA.COLUMNS 
WHERE TABLE_SCHEMA = 'janumang' 
    AND TABLE_NAME LIKE '%samiti%'
    AND TABLE_NAME NOT LIKE '%old%'
GROUP BY TABLE_NAME
ORDER BY TABLE_NAME;

-- Check specific required fields
SELECT 
    TABLE_NAME, 
    GROUP_CONCAT(COLUMN_NAME ORDER BY COLUMN_NAME) as REQUIRED_FIELDS
FROM INFORMATION_SCHEMA.COLUMNS 
WHERE TABLE_SCHEMA = 'janumang' 
    AND TABLE_NAME LIKE '%samiti%'
    AND TABLE_NAME NOT LIKE '%old%'
    AND COLUMN_NAME IN ('year', 'ac_mp_no', 'file_upload', 'serial_no')
GROUP BY TABLE_NAME
ORDER BY TABLE_NAME;

-- ========================================
-- ADD YEAR FIELD TO ALL SAMITI TABLES
-- ========================================

-- Add year field to all tables (if not exists)
ALTER TABLE `block_samiti_groups` ADD COLUMN `year` YEAR NULL DEFAULT NULL AFTER `id`;
ALTER TABLE `nirman_samiti_groups` ADD COLUMN `year` YEAR NULL DEFAULT NULL AFTER `id`;
ALTER TABLE `booth_samiti_groups` ADD COLUMN `year` YEAR NULL DEFAULT NULL AFTER `id`;
ALTER TABLE `tenkar_samiti_groups` ADD COLUMN `year` YEAR NULL DEFAULT NULL AFTER `id`;
ALTER TABLE `ganesh_samiti_groups` ADD COLUMN `year` YEAR NULL DEFAULT NULL AFTER `id`;
ALTER TABLE `dp_samiti` ADD COLUMN `year` YEAR NULL DEFAULT NULL AFTER `id`;
ALTER TABLE `mandir_samiti` ADD COLUMN `year` YEAR NULL DEFAULT NULL AFTER `id`;

-- ========================================
-- ADD FILE_UPLOAD FIELD TO ALL SAMITI TABLES  
-- ========================================

-- Add file_upload field to all tables
ALTER TABLE `block_samiti_groups` ADD COLUMN `file_upload` VARCHAR(255) NULL DEFAULT NULL;
ALTER TABLE `nirman_samiti_groups` ADD COLUMN `file_upload` VARCHAR(255) NULL DEFAULT NULL;
ALTER TABLE `booth_samiti_groups` ADD COLUMN `file_upload` VARCHAR(255) NULL DEFAULT NULL;
ALTER TABLE `tenkar_samiti_groups` ADD COLUMN `file_upload` VARCHAR(255) NULL DEFAULT NULL;
ALTER TABLE `ganesh_samiti_groups` ADD COLUMN `file_upload` VARCHAR(255) NULL DEFAULT NULL;
ALTER TABLE `dp_samiti` ADD COLUMN `file_upload` VARCHAR(255) NULL DEFAULT NULL;
ALTER TABLE `mandir_samiti` ADD COLUMN `file_upload` VARCHAR(255) NULL DEFAULT NULL;

-- ========================================
-- COMPLETE UPDATE: ADD ALL THREE FIELDS AT ONCE
-- ========================================

-- If you want to add all three fields (year, ac_mp_no, file_upload) in one go:
-- Use these queries for tables that don't have any of these fields:

/*
ALTER TABLE `block_samiti_groups` 
ADD COLUMN `year` YEAR NULL DEFAULT NULL AFTER `id`,
ADD COLUMN `ac_mp_no` VARCHAR(50) NULL DEFAULT NULL AFTER `year`,
ADD COLUMN `file_upload` VARCHAR(255) NULL DEFAULT NULL;

ALTER TABLE `nirman_samiti_groups` 
ADD COLUMN `year` YEAR NULL DEFAULT NULL AFTER `id`,
ADD COLUMN `ac_mp_no` VARCHAR(50) NULL DEFAULT NULL AFTER `year`,
ADD COLUMN `file_upload` VARCHAR(255) NULL DEFAULT NULL;

ALTER TABLE `booth_samiti_groups` 
ADD COLUMN `year` YEAR NULL DEFAULT NULL AFTER `id`,
ADD COLUMN `ac_mp_no` VARCHAR(50) NULL DEFAULT NULL AFTER `year`,
ADD COLUMN `file_upload` VARCHAR(255) NULL DEFAULT NULL;

ALTER TABLE `tenkar_samiti_groups` 
ADD COLUMN `year` YEAR NULL DEFAULT NULL AFTER `id`,
ADD COLUMN `ac_mp_no` VARCHAR(50) NULL DEFAULT NULL AFTER `year`,
ADD COLUMN `file_upload` VARCHAR(255) NULL DEFAULT NULL;

ALTER TABLE `ganesh_samiti_groups` 
ADD COLUMN `year` YEAR NULL DEFAULT NULL AFTER `id`,
ADD COLUMN `ac_mp_no` VARCHAR(50) NULL DEFAULT NULL AFTER `year`,
ADD COLUMN `file_upload` VARCHAR(255) NULL DEFAULT NULL;

ALTER TABLE `dp_samiti` 
ADD COLUMN `year` YEAR NULL DEFAULT NULL AFTER `id`,
ADD COLUMN `ac_mp_no` VARCHAR(50) NULL DEFAULT NULL AFTER `year`,
ADD COLUMN `file_upload` VARCHAR(255) NULL DEFAULT NULL;

ALTER TABLE `mandir_samiti` 
ADD COLUMN `year` YEAR NULL DEFAULT NULL AFTER `id`,
ADD COLUMN `ac_mp_no` VARCHAR(50) NULL DEFAULT NULL AFTER `year`,
ADD COLUMN `file_upload` VARCHAR(255) NULL DEFAULT NULL;
*/

-- ========================================
-- FINAL VERIFICATION QUERIES
-- ========================================

-- Check if all required fields exist in all tables
SELECT 
    t.TABLE_NAME,
    CASE WHEN c1.COLUMN_NAME IS NOT NULL THEN 'YES' ELSE 'NO' END as HAS_YEAR,
    CASE WHEN c2.COLUMN_NAME IS NOT NULL THEN 'YES' ELSE 'NO' END as HAS_AC_MP_NO,
    CASE WHEN c3.COLUMN_NAME IS NOT NULL THEN 'YES' ELSE 'NO' END as HAS_FILE_UPLOAD,
    CASE WHEN c4.COLUMN_NAME IS NOT NULL THEN 'YES' ELSE 'NO' END as HAS_SERIAL_NO
FROM 
    (SELECT DISTINCT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'janumang' AND TABLE_NAME LIKE '%samiti%' AND TABLE_NAME NOT LIKE '%old%') t
LEFT JOIN 
    (SELECT TABLE_NAME, COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = 'janumang' AND COLUMN_NAME = 'year') c1 ON t.TABLE_NAME = c1.TABLE_NAME
LEFT JOIN 
    (SELECT TABLE_NAME, COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = 'janumang' AND COLUMN_NAME = 'ac_mp_no') c2 ON t.TABLE_NAME = c2.TABLE_NAME
LEFT JOIN 
    (SELECT TABLE_NAME, COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = 'janumang' AND COLUMN_NAME = 'file_upload') c3 ON t.TABLE_NAME = c3.TABLE_NAME
LEFT JOIN 
    (SELECT TABLE_NAME, COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = 'janumang' AND COLUMN_NAME = 'serial_no') c4 ON t.TABLE_NAME = c4.TABLE_NAME
ORDER BY t.TABLE_NAME;