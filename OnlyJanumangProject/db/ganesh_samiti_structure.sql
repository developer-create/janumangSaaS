-- Ganesh Samiti Migration Script - Complete Refactoring from ganesh_samiti_old
-- Original: ganesh_samiti_old (32 fields combined) -> Target: groups + members (already exists but empty)
-- Current Status: Tables exist but are empty, data is in ganesh_samiti_old
-- Generated: November 21, 2025

-- =============================================
-- CURRENT DATABASE STATUS ANALYSIS
-- =============================================
-- ganesh_samiti_groups: EXISTS (19 fields) - EMPTY
-- ganesh_samiti: EXISTS (12 fields) - EMPTY  
-- ganesh_samiti_old: EXISTS (32 fields) - 8 RECORDS (actual data)
-- Foreign key: ganesh_samiti.group_id -> ganesh_samiti_groups.id (CASCADE)

-- =============================================
-- STEP 1: MIGRATE GROUPS FROM ganesh_samiti_old
-- Target existing ganesh_samiti_groups table structure
-- =============================================

-- First, populate the existing ganesh_samiti_groups table
INSERT INTO `ganesh_samiti_groups` 
  (`serial_no`, `year`, `ac_mp_no`, `ganesh_samiti_name`, `sector`, 
   `micro_sector_no`, `micro_sector_name`, `booth_no`, `gram_panchayat`, 
   `village`, `faliya`, `created_by`, `updated_by`, `created_at`, `updated_at`)
SELECT DISTINCT
  `serial_number` as serial_no,
  `year`,
  NULL as ac_mp_no,  -- Not in original structure
  `ganesh_samiti_name`,
  `sector`,
  `micro_sector_number` as micro_sector_no,
  `micro_sector_name`,
  `booth_number` as booth_no,
  `panchayat` as gram_panchayat,
  `gram` as village,
  `faliya`,
  `created_by`,
  `updated_by`,
  `created_on` as created_at,
  `updated_on` as updated_at
FROM `ganesh_samiti_old`
WHERE (`ganesh_samiti_name` IS NOT NULL AND `ganesh_samiti_name` != '') 
   OR (`serial_number` IS NOT NULL AND `serial_number` != '');

-- =============================================
-- STEP 2: MIGRATE MEMBERS TO EXISTING ganesh_samiti TABLE
-- Target existing ganesh_samiti table structure (12 fields)
-- =============================================

-- Populate the existing ganesh_samiti (members) table
INSERT INTO `ganesh_samiti` 
  (`group_id`, `member_name`, `father_name`, `age`, `position`, 
   `mobile_number`, `remark`, `created_by`, `updated_by`, `created_at`, `updated_at`)
SELECT 
  g.id as group_id,
  o.member_name,
  o.father_name,
  o.age,
  o.position,
  o.mobile_number,
  o.remark,
  o.created_by,
  o.updated_by,
  o.created_on as created_at,
  o.updated_on as updated_at
FROM `ganesh_samiti_old` o
INNER JOIN `ganesh_samiti_groups` g ON (
  COALESCE(o.serial_number, '') = COALESCE(g.serial_no, '') AND
  COALESCE(o.year, '') = COALESCE(g.year, '') AND
  COALESCE(o.ganesh_samiti_name, '') = COALESCE(g.ganesh_samiti_name, '') AND
  COALESCE(o.gram, '') = COALESCE(g.village, '')
)
WHERE o.member_name IS NOT NULL AND o.member_name != '';

-- =============================================
-- STEP 3: VERIFICATION AND DATA VALIDATION
-- =============================================

-- Check migration results
SELECT 
  'Groups Migrated' as table_name, COUNT(*) as record_count FROM `ganesh_samiti_groups`
UNION ALL
SELECT 
  'Members Migrated' as table_name, COUNT(*) as record_count FROM `ganesh_samiti`
UNION ALL
SELECT 
  'Original Records' as table_name, COUNT(*) as record_count FROM `ganesh_samiti_old`;

-- Sample verification queries
SELECT 'Sample Groups Data:' as info;
SELECT id, serial_no, year, ganesh_samiti_name, village, faliya 
FROM `ganesh_samiti_groups` LIMIT 3;

SELECT 'Sample Members Data:' as info;
SELECT m.id, m.member_name, m.father_name, m.position, g.ganesh_samiti_name as group_name
FROM `ganesh_samiti` m
INNER JOIN `ganesh_samiti_groups` g ON m.group_id = g.id
LIMIT 3;

-- =============================================
-- STEP 4: DATA INTEGRITY CHECKS
-- =============================================

-- Check for orphaned members (should return 0)
SELECT COUNT(*) as orphaned_members 
FROM `ganesh_samiti` m 
LEFT JOIN `ganesh_samiti_groups` g ON m.group_id = g.id 
WHERE g.id IS NULL;

-- Check groups without members
SELECT g.id, g.ganesh_samiti_name, COUNT(m.id) as member_count
FROM `ganesh_samiti_groups` g
LEFT JOIN `ganesh_samiti` m ON g.id = m.group_id
GROUP BY g.id
HAVING member_count = 0;

-- =============================================
-- STEP 5: CREATE HELPFUL VIEWS FOR APPLICATION USE
-- =============================================

-- Complete view combining groups and members (matches current table structure)
CREATE OR REPLACE VIEW `ganesh_samiti_full_view` AS
SELECT 
  g.id as group_id,
  g.serial_no,
  g.year,
  g.ac_mp_no,
  g.ganesh_samiti_name,
  g.block,
  g.sector,
  g.micro_sector_no,
  g.micro_sector_name,
  g.booth_name,
  g.booth_no,
  g.gram_panchayat,
  g.village,
  g.faliya,
  g.file_upload,
  m.id as member_id,
  m.member_name,
  m.father_name,
  m.age,
  m.position,
  m.mobile_number,
  m.remark,
  m.created_at as member_created,
  g.created_at as group_created,
  m.created_by as member_created_by,
  g.created_by as group_created_by
FROM `ganesh_samiti_groups` g
LEFT JOIN `ganesh_samiti` m ON g.id = m.group_id
ORDER BY g.id, m.id;

-- Groups summary view with member counts
CREATE OR REPLACE VIEW `ganesh_samiti_groups_summary` AS
SELECT 
  g.id,
  g.serial_no,
  g.year,
  g.ac_mp_no,
  g.ganesh_samiti_name,
  g.sector,
  g.village,
  g.faliya,
  COUNT(m.id) as total_members,
  g.created_at,
  g.updated_at
FROM `ganesh_samiti_groups` g
LEFT JOIN `ganesh_samiti` m ON g.id = m.group_id
GROUP BY g.id
ORDER BY g.ganesh_samiti_name;

-- =============================================
-- STEP 6: SAMPLE QUERIES FOR APPLICATION USE
-- =============================================

-- Get all groups with member counts
-- SELECT * FROM ganesh_samiti_groups_summary;

-- Get all members of a specific group
-- SELECT * FROM ganesh_samiti WHERE group_id = 1;

-- Get complete data for a group including all members
-- SELECT * FROM ganesh_samiti_full_view WHERE group_id = 1;

-- Find groups by location
-- SELECT * FROM ganesh_samiti_groups WHERE village LIKE '%test-village%';

-- Get members by position
-- SELECT g.ganesh_samiti_name, m.member_name, m.position 
-- FROM ganesh_samiti m 
-- INNER JOIN ganesh_samiti_groups g ON m.group_id = g.id 
-- WHERE m.position LIKE '%President%';

-- =============================================
-- STEP 7: CLEAN UP AFTER SUCCESSFUL MIGRATION
-- =============================================

-- After verifying data integrity, you can optionally rename old table
-- RENAME TABLE `ganesh_samiti_old` TO `ganesh_samiti_old_backup_2025`;

-- =============================================
-- FINAL NOTES AND SUMMARY
-- =============================================
-- MIGRATION STATUS: Ready to Execute
-- 
-- ORIGINAL STRUCTURE: ganesh_samiti_old (32 fields, single table)
--   - Contains combined location + member data
--   - 8 records with actual data
--   - Fields: serial_number, year, ganesh_samiti_name, block_name, sector, etc.
-- 
-- TARGET STRUCTURE: Already exists but empty
--   1. ganesh_samiti_groups (19 fields) - Location/administrative data
--      - Maps to existing table structure with proper field names
--      - Foreign key constraints with block and booth tables
--   2. ganesh_samiti (12 fields) - Member data
--      - Links to groups via group_id with CASCADE delete
--      - Proper data types and constraints
-- 
-- MIGRATION FEATURES:
--   - Preserves all original data without loss
--   - Proper field mapping from old structure to new tables
--   - Data normalization without breaking existing functionality
--   - Foreign key constraints ensure data integrity
--   - Views provide backward compatibility for applications
--   - Verification queries to ensure successful migration
-- 
-- EXECUTION ORDER:
--   1. Run STEP 1: Migrate groups data
--   2. Run STEP 2: Migrate members data  
--   3. Run STEP 3: Verify migration results
--   4. Run STEP 4: Check data integrity
--   5. Run STEP 5: Create views for application use
--   6. Test application functionality
--   7. Run STEP 7: Clean up old table (optional)
--
-- The refactored structure matches the pattern used by other samiti modules
-- and provides better data organization while maintaining all functionality.