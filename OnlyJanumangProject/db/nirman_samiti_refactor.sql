-- Refactor Nirman Samiti to separate groups and members
-- Similar to Block Samiti structure

-- Step 1: Create nirman_samiti_groups table
CREATE TABLE IF NOT EXISTS `nirman_samiti_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `serial_no` varchar(50) DEFAULT NULL COMMENT 'क्र.',
  `block` int(11) DEFAULT NULL COMMENT 'ब्लॉक - block.id',
  `micro_sector_no` varchar(50) DEFAULT NULL COMMENT 'माइक्रो सेक्टर न',
  `micro_sector_name` varchar(200) DEFAULT NULL COMMENT 'माइक्रो सेक्टर नाम',
  `booth_name` int(11) DEFAULT NULL COMMENT 'बूथ का नाम - booth.id',
  `booth_no` varchar(50) DEFAULT NULL COMMENT 'बूथ क',
  `gram_panchayat` varchar(200) DEFAULT NULL COMMENT 'ग्राम पंचायत',
  `village` varchar(200) DEFAULT NULL COMMENT 'गांव का नाम',
  `faliya` varchar(200) DEFAULT NULL COMMENT 'फलिया',
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `block` (`block`),
  KEY `booth_name` (`booth_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Nirman Samiti Groups/Locations (निर्माण समिति)';

-- Step 2: Migrate existing location data to groups table
INSERT INTO `nirman_samiti_groups` 
    (`serial_no`, `block`, `micro_sector_no`, `micro_sector_name`, 
     `booth_name`, `booth_no`, `gram_panchayat`, `village`, `faliya`, `created_by`, `created_at`)
SELECT DISTINCT 
    `serial_no`, `block`, `micro_sector_no`, `micro_sector_name`,
    `booth_name`, `booth_no`, `gram_panchayat`, `village`, `faliya`, `created_by`, `created_at`
FROM `nirman_samiti`
GROUP BY `serial_no`, `block`, `micro_sector_no`, `micro_sector_name`, 
         `booth_name`, `booth_no`, `gram_panchayat`, `village`, `faliya`;

-- Step 3: Rename existing nirman_samiti table to nirman_samiti_old (backup)
RENAME TABLE `nirman_samiti` TO `nirman_samiti_old`;

-- Step 4: Create new nirman_samiti table (for members only)
CREATE TABLE `nirman_samiti` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) NOT NULL COMMENT 'Reference to nirman_samiti_groups.id',
  `member_name` varchar(200) NOT NULL COMMENT 'सदस्य का नाम',
  `father_name` varchar(200) DEFAULT NULL COMMENT 'पिता का नाम',
  `age` int(11) DEFAULT NULL COMMENT 'उम्र',
  `position` varchar(100) DEFAULT NULL COMMENT 'पद',
  `mobile_number` varchar(15) DEFAULT NULL COMMENT 'मोबाइल नम्बर',
  `remark` text COMMENT 'रिमार्क',
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `group_id` (`group_id`),
  CONSTRAINT `fk_nirman_samiti_group` FOREIGN KEY (`group_id`) REFERENCES `nirman_samiti_groups` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Nirman Samiti Members (निर्माण समिति सदस्य)';

-- Step 5: Migrate member data to new nirman_samiti table
-- Link members to groups based on matching location fields
INSERT INTO `nirman_samiti` 
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
    o.created_at
FROM `nirman_samiti_old` o
INNER JOIN `nirman_samiti_groups` g ON (
    IFNULL(o.serial_no, '') = IFNULL(g.serial_no, '') AND
    IFNULL(o.block, 0) = IFNULL(g.block, 0) AND
    IFNULL(o.micro_sector_no, '') = IFNULL(g.micro_sector_no, '') AND
    IFNULL(o.micro_sector_name, '') = IFNULL(g.micro_sector_name, '') AND
    IFNULL(o.booth_name, 0) = IFNULL(g.booth_name, 0) AND
    IFNULL(o.booth_no, '') = IFNULL(g.booth_no, '') AND
    IFNULL(o.gram_panchayat, '') = IFNULL(g.gram_panchayat, '') AND
    IFNULL(o.village, '') = IFNULL(g.village, '') AND
    IFNULL(o.faliya, '') = IFNULL(g.faliya, '')
);

-- Step 6: Verify migration
SELECT 'nirman_samiti_groups count:' as info, COUNT(*) as count FROM nirman_samiti_groups
UNION ALL
SELECT 'nirman_samiti members count:' as info, COUNT(*) as count FROM nirman_samiti
UNION ALL
SELECT 'nirman_samiti_old count:' as info, COUNT(*) as count FROM nirman_samiti_old;

-- Note: After verifying data, you can drop nirman_samiti_old table:
-- DROP TABLE IF EXISTS `nirman_samiti_old`;
