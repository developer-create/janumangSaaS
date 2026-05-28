-- Call Management Table Structure
-- Create table for managing calls and inquiries

CREATE TABLE IF NOT EXISTS `call_management` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date_time` datetime NOT NULL COMMENT 'Call Date and Time',
  `category` varchar(50) NOT NULL COMMENT 'Call Category',
  `name` varchar(100) NOT NULL COMMENT 'Caller Name',
  `mobile_no` varchar(15) NOT NULL COMMENT 'Mobile Number',
  `address` text NOT NULL COMMENT 'Address',
  `subject` varchar(200) NOT NULL COMMENT 'Call Subject',
  `description` text NOT NULL COMMENT 'Call Description',
  `remark` text DEFAULT NULL COMMENT 'Remarks',
  `assign_date` date NOT NULL COMMENT 'Assignment Date',
  `status` enum('Active','Inactive','Deleted') NOT NULL DEFAULT 'Active',
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_date_time` (`date_time`),
  KEY `idx_category` (`category`),
  KEY `idx_mobile_no` (`mobile_no`),
  KEY `idx_assign_date` (`assign_date`),
  KEY `idx_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Call Management System';

-- Sample data (optional)
INSERT INTO `call_management` 
(`date_time`, `category`, `name`, `mobile_no`, `address`, `subject`, `description`, `remark`, `assign_date`, `status`, `created_by`, `created_at`) 
VALUES 
('2024-11-24 10:30:00', 'Complaint', 'Ramesh Kumar', '9876543210', 'Village Khargone, MP', 'Road Repair Issue', 'Road near our village is in very bad condition. Need immediate repair work.', 'High priority area', '2024-11-25', 'Active', 1, NOW()),
('2024-11-24 14:15:00', 'Inquiry', 'Sunita Sharma', '8765432109', 'Sector 5, Indore', 'Scheme Information', 'Want to know about new government schemes for women empowerment.', NULL, '2024-11-26', 'Active', 1, NOW()),
('2024-11-24 16:45:00', 'Emergency', 'Mohan Patel', '7654321098', 'Near Hospital, Bhopal', 'Water Supply Emergency', 'Water supply has been disrupted for 3 days in our area. Need urgent attention.', 'Emergency case - immediate action required', '2024-11-24', 'Active', 1, NOW());