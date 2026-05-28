-- Phone Directory Table Creation
CREATE TABLE IF NOT EXISTS `phone_directory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `post` varchar(255) DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL,
  `district_id` int(11) DEFAULT NULL,
  `vs_block_id` int(11) DEFAULT NULL,
  `number` varchar(20) NOT NULL,
  `alternate_number` varchar(20) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `party_id` int(11) DEFAULT NULL,
  `remark` text DEFAULT NULL,
  `status` enum('Active','Inactive') DEFAULT 'Active',
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `department_id` (`department_id`),
  KEY `district_id` (`district_id`),
  KEY `vs_block_id` (`vs_block_id`),
  KEY `party_id` (`party_id`),
  KEY `created_by` (`created_by`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Add foreign key constraints if related tables exist
-- ALTER TABLE `phone_directory` ADD CONSTRAINT `fk_phone_directory_department` FOREIGN KEY (`department_id`) REFERENCES `department` (`id`);
-- ALTER TABLE `phone_directory` ADD CONSTRAINT `fk_phone_directory_district` FOREIGN KEY (`district_id`) REFERENCES `district` (`id`);
-- ALTER TABLE `phone_directory` ADD CONSTRAINT `fk_phone_directory_block` FOREIGN KEY (`vs_block_id`) REFERENCES `block` (`id`);
-- ALTER TABLE `phone_directory` ADD CONSTRAINT `fk_phone_directory_party` FOREIGN KEY (`party_id`) REFERENCES `party` (`id`);
-- ALTER TABLE `phone_directory` ADD CONSTRAINT `fk_phone_directory_created_by` FOREIGN KEY (`created_by`) REFERENCES `tbl_users` (`userId`);

-- Insert Phone Directory module into tbl_modules table
INSERT INTO `tbl_modules` (`module`, `url`, `icon`) VALUES 
('Phone Directory', 'phonedirectory', 'fa-phone');

-- Get the module ID for Phone Directory (assuming it will be the last inserted ID)
-- You'll need to run this after inserting the module above
-- INSERT INTO `tbl_user_access` (`userId`, `moduleId`, `list`, `create_records`, `edit_records`, `delete_records`, `total_access`) 
-- VALUES (1, LAST_INSERT_ID(), 1, 1, 1, 1, 1);  -- Grant full access to admin user