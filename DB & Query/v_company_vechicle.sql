SELECT
    `tbl_company`.`company_id`
    , `tbl_company`.`User_ID`
    , `tbl_company`.`company_name`
    , `tbl_company`.`phone`
    , `tbl_company`.`email`
    , `tbl_company`.`address`
    , `tbl_company`.`logo`
    , `tbl_vehicle`.`v_id`
    , `tbl_vehicle`.`code`
    , `tbl_vehicle`.`vehicle_name`
    , `tbl_vehicle`.`vehicle_type`
    , `tbl_vehicle_type`.`seats_map`
    , `tbl_vehicle_type`.`seats`
    , `tbl_amenity`.`amenity`
FROM
    `ci_bravobookus`.`tbl_company`
    , `ci_bravobookus`.`tbl_vehicle`
    , `ci_bravobookus`.`tbl_vehicle_type`
    , `ci_bravobookus`.`tbl_amenity`;