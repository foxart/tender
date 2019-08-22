SELECT
	@`row` := @`row` + 1 AS `row`,
	`records`.*
FROM
	(
		SELECT
			`rfq`.`purchaser_company_id` AS `purchaser_company_id`,
			concat_ws(' ', `vendor_account`.`surname`, `vendor_account`.`name`, `vendor_account`.`patronymic`) AS `vendor_account`,
			`vendor_company`.`id` AS `vendor_company_id`,
			`vendor_company`.`name` AS `vendor_company_name`,
			`vendor_company_title`.`name` AS `vendor_company_title_name`,
			`vendor_company_type`.`name` AS `vendor_company_type_name`
		FROM
			`rfq`
			INNER JOIN
			`rfq_cross_vendor_company`
			ON `rfq_cross_vendor_company`.`rfq_id` = `rfq`.`id`
			INNER JOIN
			`vendor_company`
			ON `vendor_company`.`id` = `rfq_cross_vendor_company`.`vendor_company_id`
			INNER JOIN
			`vendor_company_title`
			ON `vendor_company_title`.`id` = `vendor_company`.`company_title_id`
			INNER JOIN
			`vendor_company_type`
			ON `vendor_company_type`.`id` = `vendor_company`.`company_type_id`
			INNER JOIN
			`account` AS `vendor_account`
			ON `vendor_company`.`account_id` = `vendor_account`.`id`
		WHERE
			`rfq`.`id` = :rfq_id
				AND
				`rfq`.`account_id` = :account_id
		ORDER BY
			`vendor_company`.`name`,
			`vendor_account`
	) AS `records`,
	(
		SELECT
			@`row` := 0
	) AS `counter`
