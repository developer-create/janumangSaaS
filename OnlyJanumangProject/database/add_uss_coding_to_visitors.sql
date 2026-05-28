-- Add USS Coding column to visitors table
ALTER TABLE visitors ADD COLUMN uss_coding VARCHAR(100) NULL AFTER remark;
