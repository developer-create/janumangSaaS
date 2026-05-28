-- Table structure for mandir_samiti (मंदिर समिति - Members)

CREATE TABLE IF NOT EXISTS `mandir_samiti` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) DEFAULT NULL COMMENT 'Reference to mandir_samiti_groups.id',
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
  KEY `group_id` (`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Mandir Samiti Members (मंदिर समिति सदस्य)';

-- Add foreign key constraint after both tables are created
-- ALTER TABLE `mandir_samiti` 
-- ADD CONSTRAINT `fk_mandir_samiti_group` FOREIGN KEY (`group_id`) REFERENCES `mandir_samiti_groups` (`id`) ON DELETE CASCADE;
