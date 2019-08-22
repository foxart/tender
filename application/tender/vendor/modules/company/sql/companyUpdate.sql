UPDATE
	`vendor_company`
SET
	`vendor_company`.`company_title_id` = :company_title_id,
	`vendor_company`.`company_type_id` = :company_type_id,
	`vendor_company`.`name` = :company_name
WHERE
	`vendor_company`.`id` = :company_id
		AND
		`vendor_company`.`account_id` = :account_id

