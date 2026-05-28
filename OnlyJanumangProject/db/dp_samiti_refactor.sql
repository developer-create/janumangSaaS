-- Migration script to refactor existing dp_samiti table into groups + members structure
-- Based on actual database structure: dp_samiti table

-- Step 1: Create the groups table matching actual dp_samiti structure
CREATE TABLE IF NOT EXISTS `dp_samiti_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `unique_id` varchar(50) DEFAULT NULL COMMENT 'Auto-generated unique ID like DS/1, DS/2',
  `serial_number` varchar(50) DEFAULT NULL,
  `year` varchar(10) DEFAULT NULL,
  `ac_mp_no` varchar(50) DEFAULT NULL,
  `dp_samiti_name` varchar(150) DEFAULT NULL,
  `block_name` varchar(150) DEFAULT NULL,
  `sector` varchar(100) DEFAULT NULL,
  `micro_sector_number` varchar(50) DEFAULT NULL,
  `micro_sector_name` varchar(150) DEFAULT NULL,
  `booth_number` varchar(50) DEFAULT NULL,
  `booth_name` varchar(150) DEFAULT NULL,
  `panchayat` varchar(150) DEFAULT NULL,
  `gram` varchar(150) DEFAULT NULL,
  `faliya` varchar(150) DEFAULT NULL,
  `file_upload` varchar(255) DEFAULT NULL COMMENT 'Uploaded File Path',
  `status` enum('Active','Deleted') NOT NULL DEFAULT 'Active',
  `created_on` datetime DEFAULT current_timestamp(),
  `updated_on` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_year` (`year`),
  KEY `idx_block` (`block_name`),
  KEY `idx_name` (`dp_samiti_name`),
  KEY `idx_unique_id` (`unique_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Step 2: Extract distinct locations from existing dp_samiti table into groups table
INSERT INTO `dp_samiti_groups` 
  (`serial_number`, `year`, `ac_mp_no`, `dp_samiti_name`, `block_name`, 
   `sector`, `micro_sector_number`, `micro_sector_name`, `booth_number`, 
   `booth_name`, `panchayat`, `gram`, `faliya`, `file_upload`,
   `status`, `created_on`, `updated_on`, `created_by`, `updated_by`)
SELECT DISTINCT
  `serial_number`, `year`, `ac_mp_no`, `dp_samiti_name`, `block_name`,
  `sector`, `micro_sector_number`, `micro_sector_name`, `booth_number`,
  `booth_name`, `panchayat`, `gram`, `faliya`, `file_upload`,
  `status`, `created_on`, `updated_on`, `created_by`, `updated_by`
FROM `dp_samiti`
WHERE `serial_number` IS NOT NULL OR `dp_samiti_name` IS NOT NULL OR `block_name` IS NOT NULL;

-- Step 3: Generate unique IDs for groups (DS/1, DS/2, etc.)
SET @row_number = 0;
UPDATE `dp_samiti_groups` 
SET `unique_id` = CONCAT('DS/', (@row_number := @row_number + 1))
WHERE `unique_id` IS NULL
ORDER BY `id`;

-- Step 4: Rename old table as backup
RENAME TABLE `dp_samiti` TO `dp_samiti_old_backup`;

-- Step 5: Create new members table
CREATE TABLE IF NOT EXISTS `dp_samiti` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) NOT NULL,
  `member_name` varchar(150) DEFAULT NULL,
  `father_name` varchar(150) DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `position` varchar(100) DEFAULT NULL,
  `mobile_number` varchar(20) DEFAULT NULL,
  `remark` text DEFAULT NULL,
  `status` enum('Active','Deleted') NOT NULL DEFAULT 'Active',
  `created_on` datetime DEFAULT current_timestamp(),
  `updated_on` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `group_id` (`group_id`),
  KEY `idx_member_name` (`member_name`),
  CONSTRAINT `dp_samiti_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `dp_samiti_groups` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Step 6: Migrate member data to new table with group_id linkage
INSERT INTO `dp_samiti` 
  (`group_id`, `member_name`, `father_name`, `age`, `position`, `mobile_number`, 
   `remark`, `status`, `created_on`, `updated_on`, `created_by`, `updated_by`)
SELECT 
  g.id as group_id,
  o.member_name, o.father_name, o.age, o.position, o.mobile_number,
  o.remark, o.status, o.created_on, o.updated_on, o.created_by, o.updated_by
FROM `dp_samiti_old_backup` o
INNER JOIN `dp_samiti_groups` g ON (
  COALESCE(o.serial_number, '') = COALESCE(g.serial_number, '') AND
  COALESCE(o.year, '') = COALESCE(g.year, '') AND
  COALESCE(o.dp_samiti_name, '') = COALESCE(g.dp_samiti_name, '') AND
  COALESCE(o.block_name, '') = COALESCE(g.block_name, '') AND
  COALESCE(o.booth_name, '') = COALESCE(g.booth_name, '')
)
WHERE o.member_name IS NOT NULL AND o.member_name != '';

-- Step 7: Verify migration
SELECT 
  'Groups' as table_name, COUNT(*) as record_count FROM `dp_samiti_groups`
UNION ALL
SELECT 
  'Members' as table_name, COUNT(*) as record_count FROM `dp_samiti`
UNION ALL
SELECT 
  'Old Backup' as table_name, COUNT(*) as record_count FROM `dp_samiti_old_backup`;

-- Step 8: Check sample data from migration
SELECT 'Sample Groups:' as info;
SELECT id, unique_id, dp_samiti_name, block_name, booth_name, created_on 
FROM `dp_samiti_groups` 
LIMIT 5;

SELECT 'Sample Members:' as info;  
SELECT m.id, g.unique_id as group_ref, m.member_name, m.father_name, m.position
FROM `dp_samiti` m
INNER JOIN `dp_samiti_groups` g ON m.group_id = g.id
LIMIT 5;

-- Step 9: After verifying data integrity, you can drop the backup table (optional)
-- DROP TABLE IF EXISTS `dp_samiti_old_backup`;

-- Step 10: Create views for easier data access (optional)
CREATE OR REPLACE VIEW `dp_samiti_full_view` AS
SELECT 
  g.id as group_id,
  g.unique_id,
  g.serial_number,
  g.year,
  g.ac_mp_no,
  g.dp_samiti_name,
  g.block_name,
  g.sector,
  g.micro_sector_number,
  g.micro_sector_name,
  g.booth_number,
  g.booth_name,
  g.panchayat,
  g.gram,
  g.faliya,
  g.file_upload,
  m.id as member_id,
  m.member_name,
  m.father_name,
  m.age,
  m.position,
  m.mobile_number,
  m.remark,
  m.status as member_status,
  g.status as group_status,
  m.created_on as member_created,
  g.created_on as group_created
FROM `dp_samiti_groups` g
LEFT JOIN `dp_samiti` m ON g.id = m.group_id
WHERE g.status = 'Active'
ORDER BY g.id, m.id;
