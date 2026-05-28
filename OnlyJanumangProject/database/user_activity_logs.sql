-- Table structure for table `user_activity_logs`
-- This table stores comprehensive user activity logs for all CRUD operations

CREATE TABLE IF NOT EXISTS `user_activity_logs` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL COMMENT 'User who performed the action',
  `user_name` varchar(255) DEFAULT NULL COMMENT 'User name for quick reference',
  `action` varchar(50) NOT NULL COMMENT 'Action type: add, edit, delete, download, view',
  `module` varchar(100) NOT NULL COMMENT 'Module name where action was performed',
  `table_name` varchar(100) DEFAULT NULL COMMENT 'Database table name',
  `record_id` int(11) DEFAULT NULL COMMENT 'ID of the record that was affected',
  `record_data` text DEFAULT NULL COMMENT 'JSON data of the record (for add/edit)',
  `old_data` text DEFAULT NULL COMMENT 'JSON data of old record (for edit)',
  `details` text DEFAULT NULL COMMENT 'Additional details about the action',
  `ip_address` varchar(45) DEFAULT NULL COMMENT 'IP address of the user',
  `user_agent` text DEFAULT NULL COMMENT 'User agent string',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Timestamp when action was performed',
  PRIMARY KEY (`id`),
  KEY `idx_user_id` (`user_id`),
  KEY `idx_module` (`module`),
  KEY `idx_action` (`action`),
  KEY `idx_created_at` (`created_at`),
  KEY `idx_record_id` (`record_id`, `table_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='User activity logs for tracking all CRUD operations';


