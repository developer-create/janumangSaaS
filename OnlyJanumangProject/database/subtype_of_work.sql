CREATE TABLE IF NOT EXISTS `subtype_of_work` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `work_type_id` int(11) NOT NULL COMMENT 'Foreign key to workType table',
  `name` varchar(255) NOT NULL COMMENT 'Sub type of work name',
  `created_by` int(11) DEFAULT NULL COMMENT 'User who created this record',
  `updated_by` int(11) DEFAULT NULL COMMENT 'User who updated this record',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_work_type_id` (`work_type_id`),
  CONSTRAINT `fk_subtype_work_type` FOREIGN KEY (`work_type_id`) REFERENCES `workType` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Sub types of work linked to work types';

