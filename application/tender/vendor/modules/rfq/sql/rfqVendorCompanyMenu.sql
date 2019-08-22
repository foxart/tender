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
WHERE
	`rfq`.`id` = :rfq_id
		AND
		`vendor_company`.`account_id` = :account_id
ORDER BY
	`vendor_company`.`name` ASC
