/* -- Add approval system to events table

-- Step 1: Add status column if not exists
ALTER TABLE `events` 
ADD COLUMN IF NOT EXISTS `status` ENUM('pending', 'approved', 'rejected') DEFAULT 'pending' AFTER `google_event_id`,
ADD COLUMN IF NOT EXISTS `created_by` INT(11) NULL AFTER `status`,
ADD COLUMN IF NOT EXISTS `approved_by` INT(11) NULL AFTER `created_by`,
ADD COLUMN IF NOT EXISTS `approved_at` DATETIME NULL AFTER `approved_by`,
ADD COLUMN IF NOT EXISTS `rejection_reason` TEXT NULL AFTER `approved_at`;

-- Step 2: Update existing events to approved status (so they remain visible)
UPDATE `events` SET `status` = 'approved' WHERE `status` IS NULL OR `status` = '';

-- Step 3: Create notifications table if not exists
CREATE TABLE IF NOT EXISTS `event_notifications` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `event_id` INT(11) NOT NULL,
  `user_id` INT(11) NOT NULL COMMENT 'Admin user who needs to see notification',
  `is_read` TINYINT(1) DEFAULT 0,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `event_id` (`event_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
 */