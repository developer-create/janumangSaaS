-- ============================================
-- Call Management Module - Complete Setup SQL
-- For Live Server Deployment
-- ============================================

-- 1. Create call_management table if not exists
CREATE TABLE IF NOT EXISTS `call_management` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date_time` datetime NOT NULL,
  `category` varchar(50) NOT NULL,
  `name` varchar(100) NOT NULL,
  `mobile_no` varchar(20) NOT NULL,
  `address` varchar(255) NOT NULL,
  `subject` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `remark` varchar(255) DEFAULT NULL,
  `assign_datetime` datetime DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_mobile_no` (`mobile_no`),
  KEY `idx_category` (`category`),
  KEY `idx_created_by` (`created_by`),
  KEY `idx_date_time` (`date_time`),
  KEY `idx_is_deleted` (`is_deleted`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 2. Check if assign_datetime column exists, if not add it
-- (This handles both fresh installs and upgrades from older schema)
SET @col_exists = (
    SELECT COUNT(*) 
    FROM INFORMATION_SCHEMA.COLUMNS 
    WHERE TABLE_SCHEMA = DATABASE()
    AND TABLE_NAME = 'call_management' 
    AND COLUMN_NAME = 'assign_datetime'
);

SET @query = IF(@col_exists = 0,
    'ALTER TABLE `call_management` ADD COLUMN `assign_datetime` datetime DEFAULT NULL AFTER `remark`;',
    'SELECT "Column assign_datetime already exists" AS Info;'
);

PREPARE stmt FROM @query;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- 3. Ensure assign_datetime is nullable (for existing installations)
ALTER TABLE `call_management` 
MODIFY COLUMN `assign_datetime` datetime DEFAULT NULL;

-- 4. Update tbl_access_matrix for Call-Management module
-- This grants access to admin role (roleId = 1)
-- If the module entry already exists for roleId 1, this will update it

-- First, check if Call-Management exists in access JSON for roleId = 1
SET @access_json = (SELECT `access` FROM `tbl_access_matrix` WHERE `roleId` = 1 LIMIT 1);

-- If the JSON doesn't contain Call-Management, we need to add it
-- Note: This is a safe operation that will only add if not exists
UPDATE `tbl_access_matrix` 
SET `access` = JSON_ARRAY_APPEND(
    `access`,
    '$',
    JSON_OBJECT(
        'module', 'Call-Management',
        'list', 1,
        'create', 1,
        'edit', 1,
        'delete', 1
    )
)
WHERE `roleId` = 1 
AND NOT JSON_CONTAINS(
    `access`,
    JSON_QUOTE('Call-Management'),
    '$[*].module'
);

-- ============================================
-- VERIFICATION QUERIES
-- Run these after the above to verify setup
-- ============================================

-- Verify table structure
SELECT 'Table structure verification:' AS Info;
DESCRIBE `call_management`;

-- Verify Call-Management access in tbl_access_matrix
SELECT 'Access matrix verification for roleId 1:' AS Info;
SELECT `roleId`, `access` 
FROM `tbl_access_matrix` 
WHERE `roleId` = 1;

-- Check if any call records exist
SELECT CONCAT('Total call records: ', COUNT(*)) AS Info 
FROM `call_management`;

-- ============================================
-- NOTES FOR DEPLOYMENT
-- ============================================
-- 1. Backup your database before running this script
-- 2. This script is idempotent - safe to run multiple times
-- 3. Update roleId in the access matrix section if you need
--    to grant access to roles other than admin (roleId = 1)
-- 4. After running this SQL:
--    - Upload updated PHP files (controllers, models, views, config/routes.php)
--    - Clear CodeIgniter cache (delete application/cache/*)
--    - Test the module while logged in as admin
-- ============================================
