-- Add Google Calendar fields to events table
ALTER TABLE `events` ADD COLUMN `google_event_id` VARCHAR(255) NULL DEFAULT NULL AFTER `remark`;

-- Add Google Calendar fields to tbl_users table
ALTER TABLE `tbl_users` ADD COLUMN `google_refresh_token` TEXT NULL DEFAULT NULL AFTER `isDeleted`;
ALTER TABLE `tbl_users` ADD COLUMN `google_calendar_enabled` TINYINT(1) NOT NULL DEFAULT 0 AFTER `google_refresh_token`;

