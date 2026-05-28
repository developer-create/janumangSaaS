-- ============================================
-- In Docs (Incoming Documents) CRUD Setup
-- ============================================

CREATE TABLE IF NOT EXISTS `in_docs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `unique_id` varchar(50) DEFAULT NULL,
  `issue_no` varchar(100) NOT NULL COMMENT 'जावक क्रमांक',
  `month_date` date NOT NULL COMMENT 'माह / तारीख',
  `name_address` text NOT NULL COMMENT 'जिसको पत्र भेजा गया उसका नाम व पता',
  `place` varchar(255) DEFAULT NULL COMMENT 'स्थान',
  `subject` varchar(255) NOT NULL COMMENT 'पत्र का नाम',
  `documents_count` int(11) DEFAULT NULL COMMENT 'पत्र के साथ जाने वाले काग़ज़ात की संख्या',
  `reference_issue_no` varchar(255) DEFAULT NULL COMMENT 'जिस पत्र के उत्तर में यह भेजा गया उसका क्रमांक व विवरण',
  `received_issue_no` varchar(255) DEFAULT NULL COMMENT 'जो पत्र उस में आया उसका क्रमांक व विवरण',
  `file_head_no` varchar(100) DEFAULT NULL COMMENT 'फाइल हेड एवं नंबर',
  `stamp_received` decimal(10,2) DEFAULT NULL COMMENT 'स्टाम्प प्राप्त - रुपये / पैसे',
  `remarks` text COMMENT 'टिप्पणी',
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_id` (`unique_id`),
  KEY `idx_issue_no` (`issue_no`),
  KEY `idx_month_date` (`month_date`),
  KEY `idx_created_by` (`created_by`),
  KEY `idx_is_deleted` (`is_deleted`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Verification
SELECT 'in_docs table created successfully' AS Info;
DESCRIBE `in_docs`;
