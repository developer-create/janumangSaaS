-- ============================================================================
-- LIVE PROJECT VERIFICATION SCRIPT
-- Jansunwai Assembly Issue - Approved Fund & Work Agency Columns
-- ============================================================================
-- Database: mayjanumang
-- Purpose: Verify that required columns exist and contain data
-- Date: 2026-05-26
-- ============================================================================

USE mayjanumang;

-- ============================================================================
-- SECTION 1: VERIFY COLUMN EXISTENCE
-- ============================================================================

PRINT '=== SECTION 1: VERIFYING COLUMN EXISTENCE ===';

-- Check approved_fund column
SELECT 'COLUMN: approved_fund' as check_item;
SELECT 
    COLUMN_NAME,
    COLUMN_TYPE,
    IS_NULLABLE,
    COLUMN_DEFAULT,
    COLUMN_KEY
FROM INFORMATION_SCHEMA.COLUMNS 
WHERE TABLE_NAME = 'jansunwai' 
AND TABLE_SCHEMA = 'mayjanumang'
AND COLUMN_NAME = 'approved_fund';

-- Check work_agency column
SELECT 'COLUMN: work_agency' as check_item;
SELECT 
    COLUMN_NAME,
    COLUMN_TYPE,
    IS_NULLABLE,
    COLUMN_DEFAULT,
    COLUMN_KEY
FROM INFORMATION_SCHEMA.COLUMNS 
WHERE TABLE_NAME = 'jansunwai' 
AND TABLE_SCHEMA = 'mayjanumang'
AND COLUMN_NAME = 'work_agency';

-- Check current_stage column
SELECT 'COLUMN: current_stage' as check_item;
SELECT 
    COLUMN_NAME,
    COLUMN_TYPE,
    IS_NULLABLE,
    COLUMN_DEFAULT,
    COLUMN_KEY
FROM INFORMATION_SCHEMA.COLUMNS 
WHERE TABLE_NAME = 'jansunwai' 
AND TABLE_SCHEMA = 'mayjanumang'
AND COLUMN_NAME = 'current_stage';

-- ============================================================================
-- SECTION 2: DATA STATISTICS BY STAGE
-- ============================================================================

PRINT '=== SECTION 2: DATA STATISTICS BY STAGE ===';

SELECT 
    'STAGE STATISTICS' as report_type,
    current_stage as stage,
    COUNT(*) as total_records,
    SUM(CASE WHEN approved_fund IS NOT NULL AND approved_fund != '' THEN 1 ELSE 0 END) as records_with_approved_fund,
    SUM(CASE WHEN work_agency IS NOT NULL AND work_agency != '' THEN 1 ELSE 0 END) as records_with_work_agency,
    SUM(CASE WHEN (approved_fund IS NULL OR approved_fund = '') AND (work_agency IS NULL OR work_agency = '') THEN 1 ELSE 0 END) as records_with_empty_fields
FROM jansunwai
GROUP BY current_stage
ORDER BY current_stage;

-- ============================================================================
-- SECTION 3: SAMPLE DATA FROM EACH STAGE
-- ============================================================================

PRINT '=== SECTION 3: SAMPLE DATA FROM EACH STAGE ===';

-- Stage 1 Sample
SELECT 'STAGE 1 (Block-Level) - Sample Records' as stage_info;
SELECT 
    id,
    registration_no,
    approved_fund,
    work_agency,
    current_stage,
    createdAt
FROM jansunwai
WHERE current_stage = 1
LIMIT 5;

-- Stage 2 Sample
SELECT 'STAGE 2 (Bhopal-Level) - Sample Records' as stage_info;
SELECT 
    id,
    registration_no,
    approved_fund,
    work_agency,
    current_stage,
    createdAt
FROM jansunwai
WHERE current_stage = 2
LIMIT 5;

-- Stage 3 Sample
SELECT 'STAGE 3 (USS-Level) - Sample Records' as stage_info;
SELECT 
    id,
    registration_no,
    approved_fund,
    work_agency,
    current_stage,
    createdAt
FROM jansunwai
WHERE current_stage = 3
LIMIT 5;

-- ============================================================================
-- SECTION 4: DETAILED STAGE 2 DATA (Bhopal-Level)
-- ============================================================================

PRINT '=== SECTION 4: DETAILED STAGE 2 DATA (Bhopal-Level) ===';

SELECT 
    'ALL STAGE 2 RECORDS' as report_type,
    id,
    registration_no,
    approved_fund,
    work_agency,
    current_stage,
    createdAt
FROM jansunwai
WHERE current_stage = 2
ORDER BY id DESC;

-- ============================================================================
-- SECTION 5: DETAILED STAGE 3 DATA (USS-Level) - First 20 Records
-- ============================================================================

PRINT '=== SECTION 5: DETAILED STAGE 3 DATA (USS-Level) - First 20 Records ===';

SELECT 
    'STAGE 3 RECORDS (First 20)' as report_type,
    id,
    registration_no,
    approved_fund,
    work_agency,
    current_stage,
    createdAt
FROM jansunwai
WHERE current_stage = 3
ORDER BY id DESC
LIMIT 20;

-- ============================================================================
-- SECTION 6: SUMMARY REPORT
-- ============================================================================

PRINT '=== SECTION 6: SUMMARY REPORT ===';

SELECT 
    'OVERALL SUMMARY' as report_type,
    COUNT(*) as total_records,
    COUNT(DISTINCT current_stage) as total_stages,
    SUM(CASE WHEN approved_fund IS NOT NULL AND approved_fund != '' THEN 1 ELSE 0 END) as total_with_approved_fund,
    SUM(CASE WHEN work_agency IS NOT NULL AND work_agency != '' THEN 1 ELSE 0 END) as total_with_work_agency,
    SUM(CASE WHEN (approved_fund IS NULL OR approved_fund = '') AND (work_agency IS NULL OR work_agency = '') THEN 1 ELSE 0 END) as total_with_empty_fields
FROM jansunwai;

-- ============================================================================
-- SECTION 7: VERIFICATION CHECKLIST
-- ============================================================================

PRINT '=== SECTION 7: VERIFICATION CHECKLIST ===';

SELECT 
    'approved_fund column exists' as check_item,
    CASE WHEN COUNT(*) > 0 THEN 'YES ✓' ELSE 'NO ✗' END as status
FROM INFORMATION_SCHEMA.COLUMNS 
WHERE TABLE_NAME = 'jansunwai' 
AND TABLE_SCHEMA = 'mayjanumang'
AND COLUMN_NAME = 'approved_fund'

UNION ALL

SELECT 
    'work_agency column exists' as check_item,
    CASE WHEN COUNT(*) > 0 THEN 'YES ✓' ELSE 'NO ✗' END as status
FROM INFORMATION_SCHEMA.COLUMNS 
WHERE TABLE_NAME = 'jansunwai' 
AND TABLE_SCHEMA = 'mayjanumang'
AND COLUMN_NAME = 'work_agency'

UNION ALL

SELECT 
    'current_stage column exists' as check_item,
    CASE WHEN COUNT(*) > 0 THEN 'YES ✓' ELSE 'NO ✗' END as status
FROM INFORMATION_SCHEMA.COLUMNS 
WHERE TABLE_NAME = 'jansunwai' 
AND TABLE_SCHEMA = 'mayjanumang'
AND COLUMN_NAME = 'current_stage'

UNION ALL

SELECT 
    'Stage 2 records exist' as check_item,
    CASE WHEN COUNT(*) > 0 THEN 'YES ✓ (' + CAST(COUNT(*) AS VARCHAR) + ' records)' ELSE 'NO ✗' END as status
FROM jansunwai
WHERE current_stage = 2

UNION ALL

SELECT 
    'Stage 3 records exist' as check_item,
    CASE WHEN COUNT(*) > 0 THEN 'YES ✓ (' + CAST(COUNT(*) AS VARCHAR) + ' records)' ELSE 'NO ✗' END as status
FROM jansunwai
WHERE current_stage = 3;

-- ============================================================================
-- END OF VERIFICATION SCRIPT
-- ============================================================================
-- NOTE: This script performs READ-ONLY operations only
-- No data modifications are made
-- Safe to run on production database
-- ============================================================================
