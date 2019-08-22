SELECT
	@`row` := @`row` + 1 AS `row`,
	`records`.*
FROM
	(
		SELECT
			`purchaser_company`.`id` AS `legal_id`,
			`purchaser_company`.`name` AS `legal_name`
		FROM
			`vendor_company`
			INNER JOIN
			`purchaser_company_cross_vendor_company`
			ON `purchaser_company_cross_vendor_company`.`vendor_company_id` = `vendor_company`.`id`
			INNER JOIN
			`purchaser_company`
			ON `purchaser_company_cross_vendor_company`.`purchaser_company_id` = `purchaser_company`.`id`
		WHERE
			`vendor_company`.`id` = :company_id
				AND `vendor_company`.`account_id` = :account_id
	) AS `records`,
	(
		SELECT
			@`row` := 0
	) AS `counter`
