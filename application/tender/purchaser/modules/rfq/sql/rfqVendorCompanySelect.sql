SELECT
	DISTINCT
	`authentication`.`id` AS `authentication_id`,
	`authentication`.`email` AS `authentication_email`,
	`vendor_company`.`id` AS `company_id`,
	`vendor_company`.`name` AS `company_name`
FROM
	`rfq`
	INNER JOIN
	`purchaser_company_cross_vendor_company`
	ON `purchaser_company_cross_vendor_company`.`purchaser_company_id` = `rfq`.`purchaser_company_id`
	INNER JOIN
	`vendor_company`
	ON `vendor_company`.`id` = `purchaser_company_cross_vendor_company`.`vendor_company_id`
	INNER JOIN
	`vendor_company_cross_account_cross_material`
	ON `vendor_company_cross_account_cross_material`.`vendor_company_id` = `purchaser_company_cross_vendor_company`.`vendor_company_id`
	INNER JOIN
	`account`
	ON `account`.`id` = `vendor_company`.`account_id`
	INNER JOIN
	`authentication`
	ON `authentication`.`id` = `account`.`authentication_id`
WHERE
	`rfq`.`id` = :rfq_id
		AND `rfq`.`account_id` = :account_id
		AND
		IF(:company_name IS NULL, 1, `vendor_company`.`name` LIKE CONCAT('%', :company_name, '%'))
		AND `vendor_company_cross_account_cross_material`.`material_id` IN
		(
			SELECT
				`rfq_cross_material`.`material_id`
			FROM
				`rfq_cross_material`
			WHERE
				`rfq_cross_material`.`rfq_id` = :rfq_id
		)
		AND `vendor_company`.`id` NOT IN
		(
			SELECT
				`rfq_cross_vendor_company`.`vendor_company_id`
			FROM
				`rfq_cross_vendor_company`
			WHERE
				`rfq_cross_vendor_company`.`rfq_id` = :rfq_id
		)
