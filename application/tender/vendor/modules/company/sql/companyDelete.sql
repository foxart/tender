DELETE FROM
	`vendor_company`
WHERE
	`vendor_company`.`id` = :company_id
		AND
		`vendor_company`.`account_id` = :account_id
