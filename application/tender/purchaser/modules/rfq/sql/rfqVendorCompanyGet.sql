SELECT
	`vendor_company`.`name` AS `company_name`,
	`vendor_company_title`.`name` AS `company_title_name`,
	`vendor_company_type`.`name` AS `company_type_name`
FROM
	`rfq_cross_vendor_company`
	INNER JOIN
	`rfq`
	ON `rfq`.`id` = `rfq_cross_vendor_company`.`rfq_id`
	INNER JOIN
	`vendor_company`
	ON `vendor_company`.`id` = `rfq_cross_vendor_company`.`vendor_company_id`
	INNER JOIN
	`vendor_company_title`
	ON `vendor_company_title`.`id` = `vendor_company`.`company_title_id`
	INNER JOIN
	`vendor_company_type`
	ON `vendor_company_type`.`id` = `vendor_company`.`company_type_id`
WHERE
	`rfq`.`id` = :rfq_id
		AND
		`rfq`.`account_id` = :account_id
		AND `vendor_company`.`id` = :company_id
