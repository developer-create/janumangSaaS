-- Add approved_fund, approved_fund_other, and work_agency columns to districtpublicproblem table
ALTER TABLE districtpublicproblem 
ADD COLUMN approved_fund VARCHAR(100) NULL,
ADD COLUMN approved_fund_other VARCHAR(255) NULL,
ADD COLUMN work_agency VARCHAR(255) NULL;
