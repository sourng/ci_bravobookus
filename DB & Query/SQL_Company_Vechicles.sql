SELECT
p.company_id,p.company_name,v.v_id,v.code,
v.vehicle_name,v.drivers, u.uid, u.name
FROM
    tbl_company as p INNER JOIN  tbl_vehicle as v ON p.company_id=v.company_id
    INNER JOIN users as u ON p.company_id=u.company_id
;