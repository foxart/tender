SELECT
	`vendor_company_title`.`id` AS `company_title_id`,
	`vendor_company_type`.`id` AS `company_type_id`,
	`vendor_company`.`name` AS `company_name`
FROM
	`vendor_company`
	INNER JOIN
	`vendor_company_title`
	ON `vendor_company`.`company_title_id` = `vendor_company_title`.`id`
	INNER JOIN
	`vendor_company_type`
	ON `vendor_company`.`company_type_id` = `vendor_company_type`.`id`
WHERE
	`vendor_company`.`id` = :company_id
		AND
		`vendor_company`.`account_id` = :account_id
