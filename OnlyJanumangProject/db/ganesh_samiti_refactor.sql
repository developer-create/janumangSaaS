-- Refactor Ganesh Samiti to separate groups and members
-- Similar to Block Samiti, Nirman Samiti and Tenkar Samiti structure

-- Step 1: Create ganesh_samiti_groups table
CREATE TABLE IF NOT EXISTS `ganesh_samiti_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `serial_no` varchar(50) DEFAULT NULL COMMENT 'Serial Number',
  `year` varchar(10) DEFAULT NULL COMMENT 'Year',
  `ganesh_samiti_name` varchar(200) DEFAULT NULL COMMENT 'Ganesh Samiti Name',
  `block` int(11) DEFAULT NULL COMMENT 'Block - block.id',
  `sector` varchar(200) DEFAULT NULL COMMENT 'Sector',
  `micro_sector_no` varchar(50) DEFAULT NULL COMMENT 'Micro Sector Number',
  `micro_sector_name` varchar(200) DEFAULT NULL COMMENT 'Micro Sector Name',
  `booth_name` int(11) DEFAULT NULL COMMENT 'Booth Name - booth.id',
  `booth_no` varchar(50) DEFAULT NULL COMMENT 'Booth Number',
  `gram_panchayat` varchar(200) DEFAULT NULL COMMENT 'Gram Panchayat',
  `village` varchar(200) DEFAULT NULL COMMENT 'Village Name (Gram)',
  `faliya` varchar(200) DEFAULT NULL COMMENT 'Faliya',
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `block` (`block`),
  KEY `booth_name` (`booth_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Ganesh Samiti Groups/Locations';

-- Step 2: Migrate existing location data to groups table
-- Insert unique location combinations from existing ganesh_samiti table
INSERT INTO `ganesh_samiti_groups` 
    (`serial_no`, `year`, `ganesh_samiti_name`, `block`, `sector`, `micro_sector_no`, `micro_sector_name`, 
     `booth_name`, `booth_no`, `gram_panchayat`, `village`, `faliya`, `created_by`, `created_at`)
SELECT DISTINCT 
    `serial_number`, `year`, `ganesh_samiti_name`, 
    -- Try to match block name to block.id if possible, otherwise NULL
    (SELECT b.id FROM block b WHERE b.name = ganesh_samiti.block_name LIMIT 1) as block,
    `sector`, `micro_sector_number`, `micro_sector_name`,
    -- Try to match booth name to booth.id if possible, otherwise NULL  
    (SELECT bt.id FROM booth bt WHERE bt.name = ganesh_samiti.booth_name LIMIT 1) as booth_name,
    `booth_number`, `panchayat`, `gram`, `faliya`, `created_by`, `created_on`
FROM `ganesh_samiti`
WHERE status != 'Deleted'
GROUP BY `serial_number`, `year`, `ganesh_samiti_name`, `block_name`, `sector`, `micro_sector_number`, `micro_sector_name`, 
         `booth_name`, `booth_number`, `panchayat`, `gram`, `faliya`;

-- Step 3: Rename existing ganesh_samiti table to ganesh_samiti_old (backup)
RENAME TABLE `ganesh_samiti` TO `ganesh_samiti_old`;

-- Step 4: Create new ganesh_samiti table (for members only)
CREATE TABLE `ganesh_samiti` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) NOT NULL COMMENT 'Reference to ganesh_samiti_groups.id',
  `member_name` varchar(200) NOT NULL COMMENT 'Member Name',
  `father_name` varchar(200) DEFAULT NULL COMMENT 'Father Name',
  `age` int(11) DEFAULT NULL COMMENT 'Age',
  `position` varchar(100) DEFAULT NULL COMMENT 'Position',
  `mobile_number` varchar(15) DEFAULT NULL COMMENT 'Mobile Number',
  `remark` text COMMENT 'Remark',
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `group_id` (`group_id`),
  CONSTRAINT `fk_ganesh_samiti_group` FOREIGN KEY (`group_id`) REFERENCES `ganesh_samiti_groups` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Ganesh Samiti Members';

-- Step 5: Migrate member data to new ganesh_samiti table
-- Link members to groups based on matching location fields
INSERT INTO `ganesh_samiti` 
    (`group_id`, `member_name`, `father_name`, `age`, `position`, `mobile_number`, `remark`, `created_by`, `created_at`)
SELECT 
    g.id as group_id,
    o.member_name,
    o.father_name,
    o.age,
    o.position,
    o.mobile_number,
    o.remark,
    o.created_by,
    o.created_on
FROM `ganesh_samiti_old` o
INNER JOIN `ganesh_samiti_groups` g ON (
    IFNULL(o.serial_number, '') = IFNULL(g.serial_no, '') AND
    IFNULL(o.year, '') = IFNULL(g.year, '') AND
    IFNULL(o.ganesh_samiti_name, '') = IFNULL(g.ganesh_samiti_name, '') AND
    IFNULL(o.sector, '') = IFNULL(g.sector, '') AND
    IFNULL(o.micro_sector_number, '') = IFNULL(g.micro_sector_no, '') AND
    IFNULL(o.micro_sector_name, '') = IFNULL(g.micro_sector_name, '') AND
    IFNULL(o.booth_name, '') = IFNULL((SELECT bt.name FROM booth bt WHERE bt.id = g.booth_name), '') AND
    IFNULL(o.booth_number, '') = IFNULL(g.booth_no, '') AND
    IFNULL(o.panchayat, '') = IFNULL(g.gram_panchayat, '') AND
    IFNULL(o.gram, '') = IFNULL(g.village, '') AND
    IFNULL(o.faliya, '') = IFNULL(g.faliya, '')
)
WHERE o.status != 'Deleted' 
  AND o.member_name IS NOT NULL 
  AND o.member_name != '';

-- Step 6: Verify migration
SELECT 'ganesh_samiti_groups count:' as info, COUNT(*) as count FROM ganesh_samiti_groups
UNION ALL
SELECT 'ganesh_samiti members count:' as info, COUNT(*) as count FROM ganesh_samiti
UNION ALL
SELECT 'ganesh_samiti_old count:' as info, COUNT(*) as count FROM ganesh_samiti_old;

-- Note: After verifying data, you can drop ganesh_samiti_old table:
-- DROP TABLE IF EXISTS `ganesh_samiti_old`;