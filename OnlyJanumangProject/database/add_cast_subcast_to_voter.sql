-- Add Cast and Sub-cast fields to voter table
-- Run this SQL to add the new fields to the existing voter table

ALTER TABLE `voter` 
ADD COLUMN `cast` VARCHAR(100) NULL DEFAULT NULL COMMENT 'Voter cast/caste' AFTER `falia_majra`,
ADD COLUMN `sub_cast` VARCHAR(100) NULL DEFAULT NULL COMMENT 'Voter sub-cast/sub-caste' AFTER `cast`;

-- Add indexes for better performance if needed
CREATE INDEX idx_voter_cast ON voter (cast);
CREATE INDEX idx_voter_sub_cast ON voter (sub_cast);

-- Optional: Create a separate table for cast management (if you want predefined cast options)
-- This is optional and can be used for dropdown options

CREATE TABLE IF NOT EXISTS `cast_master` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cast_name` varchar(100) NOT NULL,
  `cast_code` varchar(20) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1 = Active, 0 = Inactive',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_cast_name` (`cast_name`),
  KEY `idx_cast_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Master table for cast/caste options';

CREATE TABLE IF NOT EXISTS `sub_cast_master` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cast_id` int(11) NOT NULL,
  `sub_cast_name` varchar(100) NOT NULL,
  `sub_cast_code` varchar(20) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1 = Active, 0 = Inactive',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_sub_cast_cast_id` (`cast_id`),
  KEY `idx_sub_cast_status` (`status`),
  CONSTRAINT `fk_sub_cast_cast_id` FOREIGN KEY (`cast_id`) REFERENCES `cast_master` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Master table for sub-cast options linked to cast';

-- Insert basic cast data
INSERT INTO `cast_master` (`cast_name`, `cast_code`, `status`) VALUES
('General', 'GEN', 1),
('OBC', 'OBC', 1),
('SC', 'SC', 1),
('ST', 'ST', 1),
('EWS', 'EWS', 1),
('Brahmin', 'BRAH', 1),
('Kshatriya', 'KSHA', 1),
('Vaishya', 'VAIS', 1),
('Jat', 'JAT', 1),
('Rajput', 'RAJP', 1),
('Yadav', 'YAD', 1),
('Patel', 'PAT', 1),
('Kurmi', 'KUR', 1),
('Ahir', 'AHI', 1),
('Gujjar', 'GUJ', 1),
('Muslim', 'MUS', 1),
('Sikh', 'SIKH', 1),
('Christian', 'CHR', 1),
('Buddhist', 'BUD', 1),
('Jain', 'JAI', 1);

-- Insert sub-cast data - each cast also appears as its own sub-cast
INSERT INTO `sub_cast_master` (`cast_id`, `sub_cast_name`, `sub_cast_code`, `status`) VALUES
-- General (ID: 1)
(1, 'General', 'GEN', 1),

-- OBC (ID: 2) 
(2, 'OBC', 'OBC', 1),

-- SC (ID: 3)
(3, 'SC', 'SC', 1),

-- ST (ID: 4)
(4, 'ST', 'ST', 1),

-- EWS (ID: 5)
(5, 'EWS', 'EWS', 1),

-- Brahmin (ID: 6)
(6, 'Brahmin', 'BRAH', 1),

-- Kshatriya (ID: 7)
(7, 'Kshatriya', 'KSHA', 1),

-- Vaishya (ID: 8)
(8, 'Vaishya', 'VAIS', 1),

-- Jat (ID: 9)
(9, 'Jat', 'JAT', 1),

-- Rajput (ID: 10)
(10, 'Rajput', 'RAJP', 1),

-- Yadav (ID: 11)
(11, 'Yadav', 'YAD', 1),

-- Patel (ID: 12)
(12, 'Patel', 'PAT', 1),

-- Kurmi (ID: 13)
(13, 'Kurmi', 'KUR', 1),

-- Ahir (ID: 14)
(14, 'Ahir', 'AHI', 1),

-- Gujjar (ID: 15)
(15, 'Gujjar', 'GUJ', 1),

-- Muslim (ID: 16)
(16, 'Muslim', 'MUS', 1),

-- Sikh (ID: 17)
(17, 'Sikh', 'SIKH', 1),

-- Christian (ID: 18)
(18, 'Christian', 'CHR', 1),

-- Buddhist (ID: 19)
(19, 'Buddhist', 'BUD', 1),

-- Jain (ID: 20)
(20, 'Jain', 'JAI', 1);