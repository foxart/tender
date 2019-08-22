SELECT
	COUNT(*) AS `count`
FROM
	`vendor_company`
WHERE

	`vendor_company`.`account_id` = :account_id
		AND
		`vendor_company`.`name` = :company_name
