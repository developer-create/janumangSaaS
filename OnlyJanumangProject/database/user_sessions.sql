-- Table structure for table `user_sessions`
-- This table tracks user login/logout sessions for accurate time calculation

CREATE TABLE IF NOT EXISTS `user_sessions` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL COMMENT 'User ID from tbl_users',
  `user_name` varchar(255) DEFAULT NULL COMMENT 'User name for quick reference',
  `session_id` varchar(128) DEFAULT NULL COMMENT 'PHP session ID',
  `login_time` datetime NOT NULL COMMENT 'When user logged in',
  `logout_time` datetime DEFAULT NULL COMMENT 'When user logged out (null if still active)',
  `session_duration_minutes` int(11) DEFAULT NULL COMMENT 'Session duration in minutes (calculated on logout)',
  `ip_address` varchar(45) DEFAULT NULL COMMENT 'IP address of the user',
  `user_agent` text DEFAULT NULL COMMENT 'User agent string',
  `is_active` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1 = active session, 0 = ended session',
  `last_activity` datetime DEFAULT NULL COMMENT 'Last activity timestamp',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_user_id` (`user_id`),
  KEY `idx_login_time` (`login_time`),
  KEY `idx_is_active` (`is_active`),
  KEY `idx_session_id` (`session_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='User session tracking for accurate time calculation';

-- Indexes for better performance
CREATE INDEX idx_user_session_date ON user_sessions (user_id, DATE(login_time));
CREATE INDEX idx_active_sessions ON user_sessions (is_active, user_id);

-- Insert some sample data to demonstrate the structure
-- Note: This is optional and should be removed in production
/*
INSERT INTO user_sessions (user_id, user_name, session_id, login_time, logout_time, session_duration_minutes, ip_address, user_agent, is_active) VALUES
(1, 'Admin User', 'session_123', '2024-01-01 09:00:00', '2024-01-01 17:30:00', 510, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36', 0),
(2, 'Test User', 'session_124', '2024-01-01 10:15:00', '2024-01-01 16:45:00', 390, '192.168.1.100', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36', 0);
*/