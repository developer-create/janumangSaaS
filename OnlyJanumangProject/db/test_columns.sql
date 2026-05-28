-- Test query to verify tenkar_samiti columns before migration
SELECT 
    serial_number, year, tenkar_samiti_name, block_name, sector, 
    micro_sector_number, micro_sector_name, booth_name, booth_number, 
    panchayat, gram, faliya, member_name, father_name, age, position, 
    mobile_number, remark, status, created_on, created_by
FROM tenkar_samiti 
LIMIT 1;

-- Test query to verify ganesh_samiti columns before migration  
SELECT 
    serial_number, year, ganesh_samiti_name, block_name, sector,
    micro_sector_number, micro_sector_name, booth_name, booth_number,
    panchayat, gram, faliya, member_name, father_name, age, position,
    mobile_number, remark, status, created_on, created_by
FROM ganesh_samiti
LIMIT 1;

-- Test booth table structure
SELECT id, name, bnumber, blockid FROM booth LIMIT 1;