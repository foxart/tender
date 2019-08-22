SELECT
	`vendor_company`.`id`,
	`vendor_company`.`name`
FROM
	`rfq`
	INNER JOIN
	`rfq_cross_vendor_company`
	ON `rfq_cross_vendor_company`.`rfq_id` = `rfq`.`id`
	INNER JOIN
	`vendor_company`
	ON `vendor_company`.`id` = `rfq_cross_vendor_company`.`vendor_company_id`
	INNER JOIN
	`vendor_company_cross_account_cross_material`
	ON `vendor_company_cross_account_cross_material`.`vendor_company_id` = `rfq_cross_vendor_company`.`vendor_company_id`
	INNER JOIN
	`material`
	ON `material`.`id` = `vendor_company_cross_account_cross_material`.`material_id`
WHERE
	`rfq`.`id` = :rfq_id
		AND
		`rfq`.`account_id` = :account_id
		AND
		`material`.`id` = :material_id
ORDER BY
	`vendor_company`.`name`,
	`vendor_company`.`id`
