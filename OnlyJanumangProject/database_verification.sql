-- ============================================================================
-- Database Verification Script for Jansunwai Assembly Issue Fix
-- ============================================================================
-- This script verifies that the required columns exist in the jansunwai table
-- No data modifications are made - this is read-only verification
-- ============================================================================

-- Check if approved_fund column exists
SELECT 'Checking approved_fund column...' as status;
SELECT COLUMN_NAME, COLUMN_TYPE, IS_NULLABLE, COLUMN_DEFAULT 
FROM INFORMATION_SCHEMA.COLUMNS 
WHERE TABLE_NAME = 'jansunwai' AND COLUMN_NAME = 'approved_fund';

-- Check if work_agency column exists
SELECT 'Checking work_agency column...' as status;
SELECT COLUMN_NAME, COLUMN_TYPE, IS_NULLABLE, COLUMN_DEFAULT 
FROM INFORMATION_SCHEMA.COLUMNS 
WHERE TABLE_NAME = 'jansunwai' AND COLUMN_NAME = 'work_agency';

-- Check if current_stage column exists
SELECT 'Checking current_stage column...' as status;
SELECT COLUMN_NAME, COLUMN_TYPE, IS_NULLABLE, COLUMN_DEFAULT 
FROM INFORMATION_SCHEMA.COLUMNS 
WHERE TABLE_NAME = 'jansunwai' AND COLUMN_NAME = 'current_stage';

-- Show summary of all columns in jansunwai table
SELECT 'Complete jansunwai table structure:' as status;
SELECT COLUMN_NAME, COLUMN_TYPE, IS_NULLABLE, COLUMN_DEFAULT, COLUMN_KEY
FROM INFORMATION_SCHEMA.COLUMNS 
WHERE TABLE_NAME = 'jansunwai'
ORDER BY ORDINAL_POSITION;

-- Count records by stage
SELECT 'Record count by stage:' as status;
SELECT 
    current_stage,
    COUNT(*) as record_count,
    SUM(CASE WHEN approved_fund IS NOT NULL AND approved_fund != '' THEN 1 ELSE 0 END) as with_approved_fund,
    SUM(CASE WHEN work_agency IS NOT NULL AND work_agency != '' THEN 1 ELSE 0 END) as with_work_agency
FROM jansunwai
GROUP BY current_stage
ORDER BY current_stage;

-- ============================================================================
-- Summary: No database schema changes were made
-- All changes were made in the application code:
-- 1. User.php Controller - jansunwai2data() and jansunwai3data() methods
-- 2. jansunwailiststage2ajax.php View - Added columns and updated DataTable
-- 3. jansunwailiststage3ajax.php View - Added columns and updated DataTable
-- ============================================================================
