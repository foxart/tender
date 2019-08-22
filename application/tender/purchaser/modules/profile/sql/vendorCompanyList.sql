SELECT
	@`row` := @`row` + 1 AS `row`,
	`records`.*
FROM
	(
		SELECT
			`purchaser_company_cross_vendor_company`.`purchaser_company_id` AS `purchaser_company_id`,
			`purchaser_company_cross_vendor_company`.`vendor_company_id` AS `vendor_company_id`,
			`vendor_company`.`name` AS `vendor_company_name`,
			`vendor_company_title`.`name` AS `vendor_company_title`,
			`vendor_company_type`.`name` AS `vendor_company_type`
		FROM
			`purchaser_company_cross_vendor_company`
			INNER JOIN
			`vendor_company`
			ON `vendor_company`.`id` = `purchaser_company_cross_vendor_company`.`vendor_company_id`
			INNER JOIN
			`vendor_company_title`
			ON `vendor_company_title`.`id` = `vendor_company`.`company_title_id`
			INNER JOIN
			`vendor_company_type`
			ON `vendor_company_type`.`id` = `vendor_company`.`company_type_id`
		WHERE
			`purchaser_company_cross_vendor_company`.`purchaser_company_id` IN (
				SELECT
					`purchaser_company_cross_account`.`purchaser_company_id`
				FROM
					`purchaser_company_cross_account`
				WHERE
					`purchaser_company_cross_account`.`account_id` = :account_id
			)
		GROUP BY
			`vendor_company`.`name`
	) AS `records`,
	(
		SELECT
			@`row` := 0
	) AS `counter`
